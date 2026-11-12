<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Single source of truth for "has this certificate expired?".
 * Reused by the club compliance indicator (CR26-001 R4a) and expiry emails (R4b).
 */
class CertificateExpiry
{
    /** Certificate types checked on Personnel, Coach and Volunteer records. */
    public const CERTIFICATES = [
        'safeguarding' => 'Safeguarding',
        'vetting' => 'Vetting',
        'first_aid' => 'First Aid',
    ];

    /** Certificates that must have an expiry date recorded (First Aid is optional). */
    public const REQUIRED = ['safeguarding', 'vetting'];

    /**
     * A certificate is valid for the whole of its expiry date and expired
     * from the start of the following day. A missing date is "not recorded",
     * which is not treated as expired.
     */
    public static function isExpired($expiry, ?CarbonInterface $today = null): bool
    {
        if (empty($expiry)) {
            return false;
        }

        $today = ($today ?? Carbon::today())->copy()->startOfDay();

        return Carbon::parse($expiry)->startOfDay()->lt($today);
    }

    /**
     * Labels of the expired certificates on a record that has
     * safeguarding_expiry / vetting_expiry / first_aid_expiry attributes.
     *
     * @return string[]
     */
    public static function expiredCertificates($record, ?CarbonInterface $today = null): array
    {
        $expired = [];

        foreach (self::CERTIFICATES as $key => $label) {
            if (self::isExpired($record->{$key.'_expiry'}, $today)) {
                $expired[] = $label;
            }
        }

        return $expired;
    }

    /**
     * Labels of required certificates with no expiry date recorded on a record.
     * Only columns the record actually has are checked (volunteers have no
     * First Aid, for example).
     *
     * @return string[]
     */
    public static function missingCertificates($record): array
    {
        $attributes = method_exists($record, 'getAttributes')
            ? $record->getAttributes()
            : (array) $record;

        $missing = [];

        foreach (self::REQUIRED as $key) {
            if (array_key_exists($key.'_expiry', $attributes)
                && empty(method_exists($record, 'getAttribute') ? $record->getAttribute($key.'_expiry') : $attributes[$key.'_expiry'])) {
                $missing[] = self::CERTIFICATES[$key];
            }
        }

        return $missing;
    }
}
