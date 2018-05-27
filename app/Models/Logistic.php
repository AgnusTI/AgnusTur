<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    protected $table = 'logistics';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
}
