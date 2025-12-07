<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Region extends Model
{
    public $timestamps = false;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'parent_code', 'code');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Region::class, 'parent_code', 'code');
    }

    public function scopeProvince($query)
    {
        return $query->where('type', 'province');
    }
    public function scopeRegency($query)
    {
        return $query->where('type', 'regency');
    }
    public function scopeDistrict($query)
    {
        return $query->where('type', 'disctrict');
    }
    public function scopeVillage($query)
    {
        return $query->where('type', 'village');
    }
}
