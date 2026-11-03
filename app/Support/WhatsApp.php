<?php

namespace App\Support;

class WhatsApp
{
    /**
     * Fixed consultation numbers that must be offered on generated articles.
     * These never override the configurable global WhatsApp settings.
     */
    public const ARTICLE_CONSULTATION_NUMBERS = [
        '08118500177',
        '081399810272',
        '087894580806',
        '087894580649',
    ];

    /**
     * Normalize a phone number to standard international digit format (E.164 without leading +).
     * Returns null if missing, empty, or structurally invalid.
     */
    /**
     * Normalize a phone number passed explicitly.
     *
     * The method no longer falls back to the global configuration when the
     * argument is null – callers must decide if they want to use the configured
     * default. This allows a clear distinction between “no phone supplied” and
     * “use the application‑wide configured phone”.
     */
    public static function normalizePhone(?string $phone = null): ?string
    {
        // When $phone is null we treat it as an explicit “no phone”.
        if ($phone === null) {
            return null;
        }

        $raw = $phone;

        if (empty($raw) || ! is_string($raw)) {
            return null;
        }

        // Strip non‑digit characters
        $digits = preg_replace('/[^0-9]/', '', trim($raw));

        if (empty($digits)) {
            return null;
        }

        // Normalize common Indonesian typo "6208..." -> "628..."
        if (str_starts_with($digits, '620')) {
            $digits = '62'.substr($digits, 3);
        }
        // Normalize Indonesian national format "08..." -> "628..."
        elseif (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        // Validate international phone number length (E.164 limits)
        if (strlen($digits) < 8 || strlen($digits) > 15) {
            return null;
        }

        return $digits;
    }

    /**
     * Determine if a valid phone number is currently configured.
     */
    public static function hasValidPhone(?string $phone = null): bool
    {
        return static::normalizePhone($phone) !== null;
    }

    /**
     * Get the fallback contact text used when no valid phone is configured.
     */
    public static function fallbackText(): string
    {
        return (string) config(
            'services.whatsapp.fallback_text',
            'Hubungi admin untuk informasi konsultasi.'
        );
    }

    /**
     * Get the default WhatsApp inquiry message from configuration.
     */
    public static function defaultMessage(): string
    {
        return (string) config(
            'services.whatsapp.default_message',
            'Halo, saya ingin konsultasi mengenai program pelatihan dan sertifikasi yang tersedia.'
        );
    }

    /**
     * Build a secure, URL-encoded WhatsApp direct link (wa.me).
     *
     * Returns null when no valid phone is configured or supplied: callers must
     * then render non-link contact text instead — never a clickable
     * wa.me link without a recipient, and never a legacy hardcoded number.
     */
    public static function url(?string $message = null, ?string $phone = null): ?string
    {
        // If a phone is explicitly passed we normalize it directly; otherwise we
        // fall back to the configured phone value.
        $normalizedPhone = $phone !== null
            ? static::normalizePhone($phone)
            : static::normalizePhone(config('services.whatsapp.phone'));

        if ($normalizedPhone === null) {
            return null;
        }

        $rawMessage = ! empty($message) ? $message : static::defaultMessage();
        $encodedMessage = rawurlencode($rawMessage);

        return "https://wa.me/{$normalizedPhone}?text={$encodedMessage}";
    }

    /**
     * The fixed consultation numbers rendered for generated articles.
     *
     * @return array<int, string>
     */
    public static function consultationNumbers(): array
    {
        return self::ARTICLE_CONSULTATION_NUMBERS;
    }

    /**
     * Build a recipient-only wa.me URL for one of the consultation numbers.
     */
    public static function consultationUrl(string $phone): ?string
    {
        $normalized = static::normalizePhone($phone);

        return $normalized === null ? null : "https://wa.me/{$normalized}";
    }
}
