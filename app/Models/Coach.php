<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory, \App\Models\Concerns\HasRequiredSafeguardingExpiry;

    protected function safeguardingRole(): ?string
    {
        return 'Coach';
    }

    protected $guarded = [];

    public function club()
    {
        return $this->belongsTo('App\Models\Club');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member');
    }
}
