<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Throwable;

/**
 * Petits formateurs d'affichage partagés par les vues (dates « Y-m-d »
 * stockées en chaîne, montants en F CFA).
 */
class Format
{
    public static function date($value, string $format = 'd/m/Y'): string
    {
        if (blank($value)) {
            return '—';
        }

        try {
            return Carbon::parse($value)->format($format);
        } catch (Throwable) {
            return (string) $value;
        }
    }

    public static function money($value, string $suffix = 'F'): string
    {
        return number_format((float) ($value ?? 0), 0, ',', ' ').($suffix ? " $suffix" : '');
    }

    public static function person($client): string
    {
        if (! $client) {
            return '—';
        }

        return trim(ucfirst((string) $client->prenom).' '.mb_strtoupper((string) $client->nom));
    }
}
