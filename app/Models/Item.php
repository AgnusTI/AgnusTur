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



    public static function all($columns = ['*'])
    {
        return (new static)->newQuery()
            ->orderBy('name')
            ->get(
                is_array($columns) ? $columns : func_get_args()
            );
    }
}
