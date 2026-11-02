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
                foreach (CertificateExpiry::expiredCertificates($person) as $label) {
                    $reasons[] = $label.' expired';
                }
                foreach (CertificateExpiry::missingCertificates($person) as $label) {
                    $reasons[] = $label.' not set';
                }

                return [
                    'club' => $activeClubs[$person->club_id],
                    'club_id' => $person->club_id,
                    'name' => $person->name,
                    'role' => $person->role,
                    'reason' => implode(' / ', $reasons),
                    'vetting_expiry' => $person->vetting_expiry,
                    'safeguarding_expiry' => $person->safeguarding_expiry,
                    'first_aid_expiry' => $person->first_aid_expiry ?? null,
                    'invalid' => $reasons !== [],
                ];
            })
            ->where('invalid', true)
            ->sortBy([['club', 'asc'], ['role', 'asc'], ['name', 'asc']])
            ->values();
    }
}
