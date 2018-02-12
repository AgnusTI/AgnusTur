<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Hotel extends Model
{
    use CrudTrait;

    protected $table = 'hotels';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function getDescriptionAttribute() {
        return $this->attributes['name'] . ' (' . $this->attributes['address'] . ')';
    }
}
