<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;

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

    public function children()
    {
        return $this->hasMany(WarehouseLocation::class, 'parent_id');
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

    public function getLongCodeAttribute()
    {
        $longCode = $this->code;

        $parent = $this->parentLocation;

        while ($parent) {
            if($this->id == $parent->id) return "Error: Recursive Parent";
            $longCode = $parent->code . '-' . $longCode;
            $parent = $parent->parentLocation;
        }

        return $longCode;
    }

    public static function findByCode($code)
    {
        $codeParts = explode('-', $code);

        $location = null;

        foreach ($codeParts as $part) {
            if ($location) {
                $location = $location->children()->where('code', $part)->first();
            } else {
                $location = self::where('code', $part)->whereNull('parent_id')->first();
            }

            if (!$location) {
                // not found
                throw new Exception("Location not found: $code");
            }
        }

        return $location;
    }
}
