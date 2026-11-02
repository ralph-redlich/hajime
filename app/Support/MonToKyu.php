<?php

namespace App\Support;

/**
 * Mon-to-Kyu legend for the automatic grade transfer at age 14 (CR26-001 R3).
 * Grade names match the options in member/grading-modal.blade.php.
 */
class MonToKyu
{
    public const AGE = 14;

    /** Mon number => Kyu grade. 1st Mon (White) is deliberately not mapped. */
    private const MON_MAP = [
        2 => '5th Kyu Yellow', 3 => '5th Kyu Yellow', 4 => '5th Kyu Yellow', 5 => '5th Kyu Yellow',
        6 => '4th Kyu Orange', 7 => '4th Kyu Orange', 8 => '4th Kyu Orange', 9 => '4th Kyu Orange', 10 => '4th Kyu Orange',
        11 => '3rd Kyu Green', 12 => '3rd Kyu Green',
    ];

    /** Kyu grade a grade_level transfers to, or null when it does not transfer. */
    public static function kyuFor(?string $gradeLevel): ?string
    {
        if ($gradeLevel === null) {
            return null;
        }

        if (preg_match('/^[123](st|nd|rd) Shamrock$/i', trim($gradeLevel))) {
            return '5th Kyu Yellow';
        }

        if (preg_match('/^(\d+)(st|nd|rd|th) Mon\b/i', trim($gradeLevel), $m)) {
            return self::MON_MAP[(int) $m[1]] ?? null;
        }

        return null;
    }

    public static function isKyu(?string $gradeLevel): bool
    {
        return $gradeLevel !== null && stripos($gradeLevel, 'Kyu') !== false;
    }
}
