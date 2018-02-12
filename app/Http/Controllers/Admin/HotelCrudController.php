<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\HotelRequest as StoreRequest;
use App\Http\Requests\HotelRequest as UpdateRequest;

class HotelCrudController extends CrudController
{
    public function setup()
    {

        $this->crud->setModel('App\Models\Hotel');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/hotel');
        $this->crud->setEntityNameStrings(trans('app.hotel'), trans('app.hotels'));

        
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('app.name'),
            'type' => 'text',
        ]);
        
        $this->crud->addField([
            'name' => 'address',
            'label' => trans('app.address'),
            'type' => 'text',
        ]);
        
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('app.name')
        ]);
        $this->crud->addColumn([
            'name' => 'address',
            'label' => trans('app.address')
        ]);
        
        $this->crud->orderBy('name');

    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud($request);
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }
}
