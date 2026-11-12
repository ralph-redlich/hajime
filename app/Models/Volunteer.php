<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $guarded = [];
    /**
     * @var mixed
     */

    use HasFactory, \App\Models\Concerns\HasRequiredSafeguardingExpiry;

    protected function safeguardingRole(): ?string
    {
        return 'Volunteer';
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
