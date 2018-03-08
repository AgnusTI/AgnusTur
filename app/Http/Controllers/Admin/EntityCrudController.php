<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use App\Http\Requests\EntityRequest as StoreRequest;
use App\Http\Requests\EntityRequest as UpdateRequest;
use App\Models\Entity as Entity;

class EntityCrudController extends CrudController
{

    public function setup()
    {
        $this->defaultEntityType = Entity::ENTITY_TYPE__CLIENT;

        $this->crud->setModel('App\Models\Entity');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/entity');
        $this->crud->setEntityNameStrings(trans('app.entity'), trans('app.entities'));


        $this->crud->addField([
            'name'      => 'type',
            'label'     => trans('app.type'),
            'type'      => 'select2_from_array',
            'options'   => Entity::getEntitiesTypes(),
            'allows_null' => false,
            'allows_multiple' => true,
            // 'default' => $this->defaultEntityType,
        ]);
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('app.name'),
            'type' => 'text',
            'wrapperAttributes' => ['class' => 'col-md-8'],
        ]);
        $this->crud->addField([
            'name' => 'phone',
            'label' => trans('app.phone'),
            'type' => 'text',
            'wrapperAttributes' => ['class' => 'col-md-4'],
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => trans('app.email'),
            'type' => 'email',
            //'wrapperAttributes' => ['class' => 'col-md-8'],
        ]);
        $this->crud->addField([  // Select2
            'name' => 'hotel_id',
            'label' => trans('app.hotel'),
            'type' => 'select2_from_ajax',
            'entity' => 'hotel',
            'attribute' => 'description',
            'model' => 'App\Models\Hotel',
            'data_source' => url('/admin/api/hotel/list'),
            'placeholder' => trans('app.hotel_placeholder'),
            'minimum_input_length' => 2,
        ]);
        $this->crud->addField([
            'name' => 'address',
            'label' => trans('app.address'),
            'type' => 'text',
            'wrapperAttributes' => ['class' => 'col-md-8'],
        ]);
        $this->crud->addField([
            'name' => 'room_number',
            'label' => trans('app.room_number'),
            'type' => 'text',
            'wrapperAttributes' => ['class' => 'col-md-4'],
        ]);
        $this->crud->addField([
            'name' => 'out_point',
            'label' => trans('app.out_point'),
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'type' => "model_function",
            'name' => 'type_comma',
            'function_name' => 'typeComma',
            'label'     => trans('app.type'),
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('app.name')
        ]);
        $this->crud->addColumn([
            'name' => 'phone',
            'label' => trans('app.phone')
        ]);
        $this->crud->addColumn([
            'name' => 'email',
            'label' => trans('app.email')
        ]);
        $this->crud->addColumn([
            'name' => 'hotel_id',
            'label' => trans('app.hotel'),
            'type' => 'select',
            'entity' => 'hotel',
            'attribute' => 'name',
            'model' => 'App\Models\Hotel',
        ]);
        $this->crud->addColumn([
            'name' => 'address',
            'label' => trans('app.address')
        ]);

        $this->crud->orderBy('name');

    }

    public function store(StoreRequest $request)
    {
        $this->handleTypeEntity($request);

        $redirect_location = parent::storeCrud($request);

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $this->handleTypeEntity($request);

        $redirect_location = parent::updateCrud($request);

        // $this->data['entry']->typeComma();

        return $redirect_location;
    }

    public function handleTypeEntity(CrudRequest $request)
    {
        // dd($request->input('type'));

        if (!$request->input('type')) {
            $request->request->set('type', [$this->defaultEntityType]);
        } else if (!in_array($this->defaultEntityType, $request->input('type'))) {
            array_push($request->input('type'), $this->defaultEntityType);
        }
    }


    public function clientOptions() 
    {
        $term = $this->request->input('term');
        
        $options = \App\Models\Entity::
            where('type', 'like', '%'.\App\Models\Entity::ENTITY_TYPE__CLIENT.'%')
            ->where('name', 'ilike', '%'.$term.'%')->get();
        
        return $options->pluck('name', 'id');
    }
}
