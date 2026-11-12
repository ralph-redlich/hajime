<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory, \App\Models\Concerns\HasRequiredSafeguardingExpiry;

    protected $guarded = [];

    public function club()
    {
        return $this->belongsTo('App\Models\Club');
    }

    public function scopeHeadcoach($query) {
        return $query->where([
            ['role','=', 'Head Coach'],
        ]);
    }

    public function scopeSecretary($query) {
        return $query->where([
            ['role','=', 'Secretary'],
        ]);
    }

    public function scopeDesignatedofficer($query) {
        return $query->where([
            ['role','=', 'Designated Person'],
        ]);
    }

    public function scopeChildrenofficer($query) {
        return $query->where([
            ['role','=', "Childrens Officer"],
        ]);
    }
    public function scopeCoach($query) {
        return $query->where([
            ['role','=', "Coach"],
        ]);
    }
    public function scopeVolunteer($query) {
        return $query->where([
            ['role','=', "Volunteer"],
        ]);
    }

}
