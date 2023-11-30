<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function warehouseLocations()
    {
        return $this->belongsToMany(WarehouseLocation::class, 'item_warehouse_location');
    }

    public function warehouse()
    {
        return $this->warehouseLocation->warehouse;
    }

    public function dimensions()
    {
        return $this->hasOne(ItemDimensions::class);
    }
}
