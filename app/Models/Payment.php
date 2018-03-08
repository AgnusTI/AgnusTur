<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Payment extends Model
{
    use CrudTrait;

    protected $table = 'payments';
    protected $primaryKey = 'id';
    
    protected $guarded = ['id'];
    
}
