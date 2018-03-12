<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Partner extends Entity
{
    use CrudTrait;

    public static function all($columns = ['*'])
    {
        return (new static)->newQuery()
            ->where('type', 'like', '%'.Entity::ENTITY_TYPE__PARTNER.'%')
            ->get(
                is_array($columns) ? $columns : func_get_args()
        );
    }
}