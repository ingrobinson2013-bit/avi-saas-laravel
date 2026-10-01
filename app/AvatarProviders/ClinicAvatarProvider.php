<?php

namespace App\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ClinicAvatarProvider implements AvatarProvider
{
    public function get(Model | Authenticatable $record): string
    {
        $name = $record->name ?? 'Usuario';
        $initials = collect(explode(' ', trim($name)))
            ->filter()
            ->take(2)
            ->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        if (empty($initials)) {
            $initials = 'VN';
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">'
            . '<defs>'
            . '<linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">'
            . '<stop offset="0%" stop-color="#2563eb" />'
            . '<stop offset="100%" stop-color="#4f46e5" />'
            . '</linearGradient>'
            . '</defs>'
            . '<circle cx="20" cy="20" r="20" fill="url(#grad)" />'
            . '<text x="50%" y="54%" text-anchor="middle" dominant-baseline="middle" fill="#ffffff" font-family="Plus Jakarta Sans, system-ui, sans-serif" font-size="15" font-weight="800">' . e($initials) . '</text>'
            . '</svg>';

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }
}
