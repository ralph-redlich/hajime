<?php

namespace App\Models\Concerns;

use App\Support\InvalidClubPersonnel;

/**
 * `safeguarding_expiry` is read from the Safeguarding level column the record's
 * role requires (L1 / L2 / L3). The legacy column is only a fallback for records
 * not yet transferred (app:transfer-safeguarding-expiry) and is never written.
 */
trait HasRequiredSafeguardingExpiry
{
    protected function safeguardingRole(): ?string
    {
        return $this->attributes['role'] ?? null;
    }

    public function getSafeguardingExpiryAttribute($value)
    {
        $level = InvalidClubPersonnel::requiredLevel($this->safeguardingRole());

        return $this->getAttribute('safeguarding_l'.$level.'_expiry') ?: $value;
    }
}
