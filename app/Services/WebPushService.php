<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebPushService
{
    private const VAPID_FILE = 'biolab_vapid.json';
    private const SUBS_FILE = 'biolab_push_subscriptions.json';
    private const VAPID_CACHE_KEY = 'biolab_vapid_keys_v1';
    private const SUBS_CACHE_KEY = 'biolab_push_subscriptions_v1';

    /**
     * Obtiene o genera el par de llaves VAPID (P-256) persistido en Storage + Cache.
     */
    public static function getVapidKeys(): array
    {
        $cached = Cache::get(self::VAPID_CACHE_KEY);
        if (is_array($cached) && !empty($cached['publicKey']) && !empty($cached['privatePem'])) {
            return $cached;
        }

        try {
            if (Storage::disk('local')->exists(self::VAPID_FILE)) {
                $stored = json_decode(Storage::disk('local')->get(self::VAPID_FILE), true);
                if (is_array($stored) && !empty($stored['publicKey']) && !empty($stored['privatePem'])) {
                    Cache::forever(self::VAPID_CACHE_KEY, $stored);
                    return $stored;
                }
            }
        } catch (\Throwable $e) {
            Log::warning('WebPush: error leyendo VAPID file: ' . $e->getMessage());
        }

        $res = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);

        if (!$res) {
            throw new \RuntimeException('No se pudo generar llave VAPID P-256 con OpenSSL.');
        }

        openssl_pkey_export($res, $privatePem);
        $details = openssl_pkey_get_details($res);
        $x = str_pad($details['ec']['x'], 32, "\x00", STR_PAD_LEFT);
        $y = str_pad($details['ec']['y'], 32, "\x00", STR_PAD_LEFT);
        $publicRaw = "\x04" . $x . $y;

        $keys = [
            'publicKey' => self::base64UrlEncode($publicRaw),
            'privatePem' => $privatePem,
            'created_at' => now()->toIso8601String(),
        ];

        try {
            Storage::disk('local')->put(self::VAPID_FILE, json_encode($keys, JSON_PRETTY_PRINT));
            Cache::forever(self::VAPID_CACHE_KEY, $keys);
        } catch (\Throwable $e) {
            Log::warning('WebPush: no se pudo persistir VAPID file: ' . $e->getMessage());
        }

        return $keys;
    }

    /**
     * Guarda o actualiza una suscripción Push del navegador.
     */
    public static function saveSubscription(array $subscription): void
    {
        $endpoint = $subscription['endpoint'] ?? '';
        $p256dh = $subscription['keys']['p256dh'] ?? '';
        $auth = $subscription['keys']['auth'] ?? '';

        if (empty($endpoint) || empty($p256dh) || empty($auth)) {
            return;
        }

        $subs = self::getSubscriptions();
        $subs = array_values(array_filter($subs, fn ($s) => ($s['endpoint'] ?? '') !== $endpoint));
        array_unshift($subs, [
            'endpoint' => $endpoint,
            'keys' => [
                'p256dh' => $p256dh,
                'auth' => $auth,
            ],
            'user_agent' => $subscription['user_agent'] ?? '',
            'updated_at' => now()->toIso8601String(),
        ]);

        // Mantener máximo 20 dispositivos suscritos
        $subs = array_slice($subs, 0, 20);
        self::persistSubscriptions($subs);
    }

    public static function getSubscriptions(): array
    {
        $subs = Cache::get(self::SUBS_CACHE_KEY, []);
        if (!empty($subs)) {
            return $subs;
        }

        try {
            if (Storage::disk('local')->exists(self::SUBS_FILE)) {
                $subs = json_decode(Storage::disk('local')->get(self::SUBS_FILE), true) ?? [];
                if (!empty($subs)) {
                    Cache::forever(self::SUBS_CACHE_KEY, $subs);
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return is_array($subs) ? $subs : [];
    }

    private static function persistSubscriptions(array $subs): void
    {
        try {
            Storage::disk('local')->put(self::SUBS_FILE, json_encode($subs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            Cache::forever(self::SUBS_CACHE_KEY, $subs);
        } catch (\Throwable $e) {
            Log::warning('WebPush: error guardando suscripciones: ' . $e->getMessage());
        }
    }

    /**
     * Envía una notificación Web Push cifrada (RFC 8291 aes128gcm + VAPID) a todos los dispositivos suscritos.
     */
    public static function sendToAll(array $payload): array
    {
        $subs = self::getSubscriptions();
        if (empty($subs)) {
            return ['sent' => 0, 'failed' => 0, 'total' => 0];
        }

        $vapid = self::getVapidKeys();
        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $client = new Client(['timeout' => 6, 'http_errors' => false]);

        $sent = 0;
        $failed = 0;
        $validSubs = [];

        foreach ($subs as $sub) {
            $endpoint = $sub['endpoint'] ?? '';
            $p256dh = $sub['keys']['p256dh'] ?? '';
            $auth = $sub['keys']['auth'] ?? '';

            if (!$endpoint || !$p256dh || !$auth) {
                continue;
            }

            try {
                $encryptedBody = self::encryptPayload($jsonPayload, $p256dh, $auth);
                $parsedUrl = parse_url($endpoint);
                $audience = ($parsedUrl['scheme'] ?? 'https') . '://' . ($parsedUrl['host'] ?? '');
                if (!empty($parsedUrl['port'])) {
                    $audience .= ':' . $parsedUrl['port'];
                }

                $jwt = self::createVapidJwt($audience, 'mailto:contacto@avipetapp.com', $vapid['privatePem']);

                $response = $client->post($endpoint, [
                    'headers' => [
                        'Authorization' => "vapid t={$jwt}, k={$vapid['publicKey']}",
                        'Content-Encoding' => 'aes128gcm',
                        'Content-Type' => 'application/octet-stream',
                        'TTL' => '86400',
                        'Urgency' => 'high',
                    ],
                    'body' => $encryptedBody,
                ]);

                $status = $response->getStatusCode();
                if ($status >= 200 && $status < 300) {
                    $sent++;
                    $validSubs[] = $sub;
                } elseif (in_array($status, [404, 410], true)) {
                    // Suscripción expirada/revocada: eliminarla automáticamente
                    $failed++;
                    Log::info("WebPush: suscripción expirada ({$status}) removida.");
                } else {
                    $failed++;
                    $validSubs[] = $sub;
                    Log::warning("WebPush: respuesta HTTP {$status} de {$audience}: " . $response->getBody());
                }
            } catch (\Throwable $e) {
                $failed++;
                $validSubs[] = $sub;
                Log::warning('WebPush: error enviando push: ' . $e->getMessage());
            }
        }

        if (count($validSubs) !== count($subs)) {
            self::persistSubscriptions($validSubs);
        }

        return ['sent' => $sent, 'failed' => $failed, 'total' => count($subs)];
    }

    /**
     * Cifrado RFC 8291 (aes128gcm) para Web Push.
     */
    private static function encryptPayload(string $payload, string $clientPubB64, string $clientAuthB64): string
    {
        $clientPubRaw = self::base64UrlDecode($clientPubB64);
        $clientAuthRaw = self::base64UrlDecode($clientAuthB64);

        if (strlen($clientPubRaw) !== 65 || strlen($clientAuthRaw) !== 16) {
            throw new \InvalidArgumentException('Llaves de suscripción Web Push inválidas.');
        }

        // Generar llave efímera P-256 local
        $localKey = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);
        $localDetails = openssl_pkey_get_details($localKey);
        $lx = str_pad($localDetails['ec']['x'], 32, "\x00", STR_PAD_LEFT);
        $ly = str_pad($localDetails['ec']['y'], 32, "\x00", STR_PAD_LEFT);
        $localPubRaw = "\x04" . $lx . $ly;

        // Convertir llave pública cruda del cliente a PEM SubjectPublicKeyInfo (P-256)
        $spkiPrefix = hex2bin('3059301306072a8648ce3d020106082a8648ce3d030107034200');
        $clientPem = "-----BEGIN PUBLIC KEY-----\n"
            . chunk_split(base64_encode($spkiPrefix . $clientPubRaw), 64, "\n")
            . "-----END PUBLIC KEY-----\n";
        $clientPubKey = openssl_pkey_get_public($clientPem);

        $sharedSecret = openssl_pkey_derive($clientPubKey, $localKey, 32);
        if ($sharedSecret === false) {
            throw new \RuntimeException('Fallo al derivar secreto ECDH.');
        }
        $sharedSecret = str_pad($sharedSecret, 32, "\x00", STR_PAD_LEFT);

        $salt = random_bytes(16);

        // RFC 8291 HKDF
        $prkKey = hash_hmac('sha256', $sharedSecret, $clientAuthRaw, true);
        $keyInfo = "WebPush: info\x00" . $clientPubRaw . $localPubRaw;
        $ikm = substr(hash_hmac('sha256', $keyInfo . "\x01", $prkKey, true), 0, 32);

        $prk = hash_hmac('sha256', $ikm, $salt, true);
        $cek = substr(hash_hmac('sha256', "Content-Encoding: aes128gcm\x00\x01", $prk, true), 0, 16);
        $nonce = substr(hash_hmac('sha256', "Content-Encoding: nonce\x00\x01", $prk, true), 0, 12);

        // Delimitador de último registro (0x02)
        $plaintext = $payload . "\x02";
        $tag = '';
        $ciphertext = openssl_encrypt($plaintext, 'aes-128-gcm', $cek, OPENSSL_RAW_DATA, $nonce, $tag, '', 16);
        if ($ciphertext === false) {
            throw new \RuntimeException('Fallo en cifrado AES-128-GCM.');
        }

        // Cabecera aes128gcm: salt (16) | rs (4) | idlen (1) | keyid (65)
        $header = $salt . pack('N', 4096) . chr(strlen($localPubRaw)) . $localPubRaw;

        return $header . $ciphertext . $tag;
    }

    /**
     * Genera JWT ES256 para VAPID (RFC 8292).
     */
    private static function createVapidJwt(string $audience, string $subject, string $privatePem): string
    {
        $header = self::base64UrlEncode(json_encode(['typ' => 'JWT', 'alg' => 'ES256']));
        $claims = self::base64UrlEncode(json_encode([
            'aud' => $audience,
            'exp' => time() + 43200,
            'sub' => $subject,
        ]));

        $signingInput = $header . '.' . $claims;
        $derSignature = '';
        if (!openssl_sign($signingInput, $derSignature, $privatePem, OPENSSL_ALGO_SHA256)) {
            throw new \RuntimeException('Error firmando JWT VAPID.');
        }

        $rawSignature = self::derToRawSignature($derSignature);

        return $signingInput . '.' . self::base64UrlEncode($rawSignature);
    }

    private static function derToRawSignature(string $der): string
    {
        $offset = 2;
        if (ord($der[1]) & 0x80) {
            $offset += (ord($der[1]) & 0x7f);
        }

        // Leer R
        if (ord($der[$offset]) !== 0x02) {
            throw new \RuntimeException('Firma DER inválida (R).');
        }
        $rLen = ord($der[$offset + 1]);
        $r = substr($der, $offset + 2, $rLen);
        $offset += 2 + $rLen;

        // Leer S
        if (ord($der[$offset]) !== 0x02) {
            throw new \RuntimeException('Firma DER inválida (S).');
        }
        $sLen = ord($der[$offset + 1]);
        $s = substr($der, $offset + 2, $sLen);

        $r = str_pad(ltrim($r, "\x00"), 32, "\x00", STR_PAD_LEFT);
        $s = str_pad(ltrim($s, "\x00"), 32, "\x00", STR_PAD_LEFT);

        return substr($r, -32) . substr($s, -32);
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
