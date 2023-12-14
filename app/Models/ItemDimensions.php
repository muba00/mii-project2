<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDimensions extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getVolumeAttribute()
    {
        return $this->width * $this->height * $this->depth;
    }
}
