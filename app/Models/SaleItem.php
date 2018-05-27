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

    public function partner() {
        return $this->hasOne('App\Models\Partner', 'id', 'partner_id');
    }

    public function setDtTourAttribute($value) {
        
        if (substr($value, 2, 1) == "/") {
            $this->attributes['dt_tour'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['dt_tour'] = $value;
        }
    }

    public function getAdultsAttribute() {
        if (!isset($this->attributes['adults'])) {
            return 0;
        } else {
            return $this->attributes['adults'];
        }
    }

    public function getChildsAttribute() {
        if (!isset($this->attributes['childs'])) {
            return 0;
        } else {
            return $this->attributes['childs'];
        }
    }

    public function getVlDiscountAttribute() {
        if (!isset($this->attributes['vl_discount'])) {
            return 0;
        } else {
            return $this->attributes['vl_discount'];
        }
    }

    public function getVlExpenseAttribute() {
        if (!isset($this->attributes['vl_expense'])) {
            return 0.00;
        } else {
            return $this->attributes['vl_expense'];
        }
    }

    public function getVlCommissionAttribute() {
        if (!isset($this->attributes['vl_commission'])) {
            return 0.00;
        } else {
            return $this->attributes['vl_commission'];
        }
    }

    public function getVlPartnerAttribute() {
        if (!isset($this->attributes['vl_partner'])) {
            return 0.00;
        } else {
            return $this->attributes['vl_partner'];
        }
    }
}
