<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;

class SaleItem extends Model
{
    use CrudTrait;

    protected $table = 'sales_items';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];


    public function item() {
        return $this->hasOne('App\Models\Item', 'id', 'item_id');
    }

    public function getDtTourAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    // public function setDtSaleAttribute($value) {
    //     if ()
    // }
}
