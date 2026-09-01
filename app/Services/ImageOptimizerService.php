<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Optimiza y convierte cualquier imagen (PNG, JPG, HEIC, etc.) a WebP ultra-ligero.
     *
     * @param string $disk
     * @param string $filePath
     * @param int $maxWidth
     * @param int $quality
     * @return string Ruta del archivo optimizado .webp
     */
    public static function optimizeToWebp(string $disk, string $filePath, int $maxWidth = 1200, int $quality = 80): string
    {
        try {
            $storage = Storage::disk($disk);

            if (!$storage->exists($filePath)) {
                return $filePath;
            }

            $content = $storage->get($filePath);
            if (empty($content)) {
                return $filePath;
            }

            // Crear recurso de imagen desde binario
            $srcImage = @imagecreatefromstring($content);
            if (!$srcImage) {
                return $filePath; // Si no es procesable por GD (ej. SVG o video), retornar original
            }

            $origWidth = imagesx($srcImage);
            $origHeight = imagesy($srcImage);

            // Calcular nuevo tamaño manteniendo proporción
            if ($origWidth > $maxWidth) {
                $targetWidth = $maxWidth;
                $targetHeight = (int) round(($origHeight / $origWidth) * $maxWidth);
            } else {
                $targetWidth = $origWidth;
                $targetHeight = $origHeight;
            }

            // Crear lienzo de destino con soporte de transparencia (RGBA)
            $dstImage = imagecreatetruecolor($targetWidth, $targetHeight);
            imagealphablending($dstImage, false);
            imagesavealpha($dstImage, true);
            $transparent = imagecolorallocatealpha($dstImage, 255, 255, 255, 127);
            imagefilledrectangle($dstImage, 0, 0, $targetWidth, $targetHeight, $transparent);

            // Redimensionar con interpolación de alta calidad
            imagecopyresampled(
                $dstImage,
                $srcImage,
                0, 0, 0, 0,
                $targetWidth,
                $targetHeight,
                $origWidth,
                $origHeight
            );

            // Generar buffer en formato WebP comprimido
            ob_start();
            imagewebp($dstImage, null, $quality);
            $webpData = ob_get_clean();

            imagedestroy($srcImage);
            imagedestroy($dstImage);

            if (empty($webpData)) {
                return $filePath;
            }

            // Determinar nueva ruta con extensión .webp
            $dir = dirname($filePath);
            $filename = pathinfo($filePath, PATHINFO_FILENAME);
            $webpPath = ($dir !== '.' ? $dir . '/' : '') . $filename . '.webp';

            // Guardar WebP optimizado
            $storage->put($webpPath, $webpData, 'public');

            // Si la ruta cambió (ej. de .png o .jpg a .webp), eliminar el archivo original pesado
            if ($webpPath !== $filePath) {
                $storage->delete($filePath);
            }

            return $webpPath;
        } catch (\Throwable $e) {
            // En caso de cualquier excepción, conservar la imagen original sin romper el flujo
            report($e);
            return $filePath;
        }
    }
}
