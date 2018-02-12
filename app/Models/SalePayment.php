<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class SalePayment extends Model
{
    use CrudTrait;

    protected $table = 'sales_payments';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
}
