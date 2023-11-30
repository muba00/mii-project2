<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function parentLocation()
    {
        return $this->belongsTo(WarehouseLocation::class, 'parent_id');
    }

    public function locations()
    {
        return $this->hasMany(WarehouseLocation::class, 'parent_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_warehouse_location');
    }

    public function dimensions()
    {
        return $this->hasOne(LocationDimensions::class);
    }

    public function getLongNameAttribute()
    {
        $longName = $this->name;

        $parent = $this->parentLocation;

        while ($parent) {
            if($this->id == $parent->id) return "Error: Recursive Parent";
            $longName = $parent->name . ' > ' . $longName;
            $parent = $parent->parentLocation;
        }

        return $longName;
    }
}
