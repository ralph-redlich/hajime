<?php

namespace App\Support;

use App\Models\Club;
use App\Models\Coach;
use App\Models\Personnel;
use App\Models\Volunteer;
use Illuminate\Support\Collection;

/**
 * Rows for the consolidated Invalid Club Personnel report (CR26-001 R6a):
 * personnel, coaches and volunteers at active clubs with an expired or
 * missing certificate, using the same rules as the club compliance indicator.
 */
class InvalidClubPersonnel
{
    /** Roles held by one person per club; the Compliance Status report shows only the first record. */
    public const SINGLE_HOLDER_ROLES = ['Head Coach', 'Secretary', 'Designated Person', 'Childrens Officer'];

    /** Safeguarding level each role must hold. Coaches, Assistant Coaches, Secretaries and Volunteers need L1. */
    public const REQUIRED_SAFEGUARDING_LEVEL = [
        'Childrens Officer' => 2,
        'Designated Person' => 3,
    ];

    public static function requiredLevel(?string $role): int
    {
        return self::REQUIRED_SAFEGUARDING_LEVEL[$role] ?? 1;
    }

    public static function rows(): Collection
    {
        $activeClubs = Club::where('status', 'Active')->pluck('name', 'id');

        $personnel = Personnel::whereIn('club_id', $activeClubs->keys())->orderBy('id')->get();

        // A club's single-holder role may have stale duplicate records (R6c);
        // keep the first record per club and role, as the Compliance Status report does.
        $personnel = $personnel->filter(fn ($p) => ! in_array($p->role, self::SINGLE_HOLDER_ROLES))
            ->merge(
                $personnel->filter(fn ($p) => in_array($p->role, self::SINGLE_HOLDER_ROLES))
                    ->unique(fn ($p) => $p->club_id.'|'.$p->role)
            );

        $coaches = Coach::whereIn('club_id', $activeClubs->keys())->get()->each(fn ($c) => $c->role = 'Coach');
        $volunteers = Volunteer::whereIn('club_id', $activeClubs->keys())->get()->each(fn ($v) => $v->role = 'Volunteer');

        return $personnel->concat($coaches)->concat($volunteers)
            ->map(function ($person) use ($activeClubs) {
                $reasons = [];
                $level = self::requiredLevel($person->role);

                // Safeguarding is tracked per level; the legacy single date counts
                // as the role's required level until a level date is entered.
                $levels = [];
                foreach ([1, 2, 3] as $n) {
                    $levels[$n] = $person->{'safeguarding_l'.$n.'_expiry'};
                }
                $levels[$level] = $person->safeguarding_expiry; // required level, legacy fallback

                foreach (CertificateExpiry::expiredCertificates($person) as $label) {
                    if ($label !== 'Safeguarding') {
                        $reasons[] = $label.' expired';
                    }
                }
                foreach (CertificateExpiry::missingCertificates($person) as $label) {
                    if ($label !== 'Safeguarding') {
                        $reasons[] = $label.' not set';
                    }
                }

                foreach ([1, 2, 3] as $n) {
                    if (CertificateExpiry::isExpired($levels[$n])) {
                        $reasons[] = 'Safeguarding L'.$n.' expired';
                    }
                }
                if (empty($levels[$level]) && array_key_exists('safeguarding_expiry', $person->getAttributes())) {
                    $reasons[] = 'Safeguarding L'.$level.' not set';
                }

                return [
                    'club' => $activeClubs[$person->club_id],
                    'club_id' => $person->club_id,
                    'name' => $person->name,
                    'role' => $person->role,
                    'reason' => implode(' / ', $reasons),
                    'vetting_expiry' => $person->vetting_expiry,
                    'safeguarding_l1_expiry' => $levels[1],
                    'safeguarding_l2_expiry' => $levels[2],
                    'safeguarding_l3_expiry' => $levels[3],
                    'first_aid_expiry' => $person->first_aid_expiry ?? null,
                    'invalid' => $reasons !== [],
                ];
            })
            ->where('invalid', true)
            ->sortBy([['club', 'asc'], ['role', 'asc'], ['name', 'asc']])
            ->values();
    }
}
