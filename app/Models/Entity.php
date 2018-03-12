<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Entity extends Model
{
    use CrudTrait;

    protected $table = 'entities';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = implode(",", $value);
    }

    public function getTypeAttribute()
    {
        return explode(',', $this->attributes['type']);
    }

    public function typeComma()
    {
        if (isset($this->attributes['type'])) {
            $allowed = $this->type;//unserialize($this->attributes['type']);

            if (is_array($allowed)) {
                $entityTypes = Entity::getEntitiesTypes();
                $returnValue = '';

                $filtered = array_filter($entityTypes, function($k) use ($allowed) {
                    return isset($k) && in_array($k, $allowed);
                }, ARRAY_FILTER_USE_KEY);

                return implode(" | ", array_values($filtered));
            }
        }

        return '';
    }

    public function hotel() {
        return $this->hasOne('App\Models\Hotel', 'id', 'hotel_id');
    }

    const ENTITY_TYPE__CLIENT = '[CLI]';
    const ENTITY_TYPE__PROVIDER = '[PRO]';
    const ENTITY_TYPE__PARTNER = '[PAR]';
    const ENTITY_TYPE__VENDOR = '[VEN]';

    public static function getEntitiesTypes() {
        return array(
            self::ENTITY_TYPE__CLIENT => trans('app.client'),
            self::ENTITY_TYPE__PROVIDER => trans('app.provider'),
            self::ENTITY_TYPE__PARTNER => trans('app.partner'),
            self::ENTITY_TYPE__VENDOR => trans('app.vendor')
        );
    }


}
