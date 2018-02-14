<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;


class Sale extends Model
{
    use CrudTrait;

    protected $table = 'sales';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function entity() {
        return $this->hasOne('App\Models\Entity', 'id', 'entity_id');
    }

    public function hotel() {
        return $this->hasOne('App\Models\Hotel', 'id', 'hotel_id');
    }

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function items() {
        return $this->hasMany('App\Models\SaleItem', 'sale_id', 'id');
    }


    public function payments() {
        return $this->hasMany('App\Models\SalePayment', 'sale_id', 'id');
    }

    public function openEntityRegister($crud = false)
    {
        return '<a class="btn btn-xs btn-default" target="_blank" href="http://google.com?q='.urlencode($this->text).'" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i> Google it</a>';
    }



    public $hidden = ['items', 'payments'];
    protected $items;
    protected $payments;

    public function getItemsAttribute($value) {
        return $this->items()->orderBy('id')->get()->toJson();
    }

    public function setItemsAttribute($value) {
        $__items = json_decode($value, true);

        $items = [];

        $i = 0;

        if (isset($__items)) {
            foreach ($__items as $item) {

                if (isset($item['item_id'])) {

                    if (isset($item['id'])) {
                        $entityItem = $this->items()->find($item['id']);
                    } else {
                        $entityItem = new SaleItem();
                    }

                    $entityItem->fill($item);

                    //$entityItem->posicao = $i;

                    array_push($items, $entityItem);

                    $i++;
                }
            }
        }

        $this->items = $items;
    }

    protected function finishSave(array $options) {
        parent::finishSave($options);

        $ids = [];

        foreach ($this->items as $item) {
            if ($item->exists) {
                array_push($ids, $item->id);
            }
        }

        $this->items()->whereNotIn('id', $ids)->delete();



        $this->items()->saveMany($this->items);
    }
}
