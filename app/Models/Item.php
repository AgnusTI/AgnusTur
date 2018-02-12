<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Item extends Model
{
    use CrudTrait;

    protected $table = 'items';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    
}
