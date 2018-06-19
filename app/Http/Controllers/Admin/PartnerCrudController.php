<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\EntityRequest as StoreRequest;
use App\Http\Requests\EntityRequest as UpdateRequest;
use App\Models\Entity as Entity;
use App\Http\Controllers\Admin\EntityCrudController;

class PartnerCrudController extends EntityCrudController
{
    public function setup()
    {
        parent::setup();

        $this->defaultEntityType = Entity::ENTITY_TYPE__PARTNER;

        $this->crud->setRoute(config('backpack.base.route_prefix') . '/partner');
        $this->crud->setEntityNameStrings(trans('app.partner'), trans('app.partners'));


        $this->crud->removeFields(['type', 'hotel_id', 'room_number', 'out_point'], 'both');
        $this->crud->removeColumns(['type_comma', 'hotel_id']);
    
        $this->crud->addField([
            'name' => 'vl_percent_partner',
            'label' => trans('app.percent_partner'),
            'type' => 'integer_number',
            'suffix' => "%",
            'wrapperAttributes' => ['class' => 'form-group col-md-4'],
        ]);

        $this->crud->addColumn([
            'name' => 'vl_percent_partner',
            'label' => trans('app.percent_partner'),
            'type' => 'integer_number',
        ]);

        $this->crud->addClause('where', 'type', 'like', '%'.Entity::ENTITY_TYPE__PARTNER.'%');
    }
}
