<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function locations()
    {
        return $this->hasMany(WarehouseLocation::class);
    }

    public function items()
    {
        return $this->hasManyThrough(Item::class, WarehouseLocation::class);
    }
}
