<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationDimensions extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(WarehouseLocation::class);
    }

    public function getVolumeAttribute()
    {
        return $this->width * $this->height * $this->depth;
    }
}
