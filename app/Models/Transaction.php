<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;

class Transaction extends Model
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

    // update the inventory after a transaction is created
    public static function boot()
    {
        parent::boot();

        static::created(function ($transaction) {
            $transaction->updateInventory();
        });
    }

    public function updateInventory()
    {
        // get the inventory for the item at the warehouse location
        $inventory = Inventory::firstOrCreate([
            'warehouse_location_id' => $this->warehouse_location_id,
            'item_id' => $this->item_id,
        ]);

        // update the inventory quantity
        $new_quantity = $inventory->quantity + $this->quantity;
        // throw an exception if the inventory quantity is negative
        if($new_quantity < 0) {
            throw new Exception('Inventory quantity cannot be negative');
        }
        // delete the inventory if the quantity is 0
        else if($new_quantity === 0) {
            $inventory->delete();
        }
        // update the inventory quantity
        else {
            $inventory->quantity = $new_quantity;
            $inventory->save();
        }

        // update transaction synced
        $this->synced = true;
        $this->save();
    }
}
