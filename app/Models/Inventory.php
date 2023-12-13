<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function warehouseLocation()
    {
        return $this->belongsTo(WarehouseLocation::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
