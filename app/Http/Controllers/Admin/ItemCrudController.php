<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ItemRequest as StoreRequest;
use App\Http\Requests\ItemRequest as UpdateRequest;

class ItemCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\Item');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/item');
        $this->crud->setEntityNameStrings(trans('app.item'), trans('app.items'));

        $this->crud->addField([
            'name' => 'name',
            'label' => trans('app.name'),
            'type' => 'text',
        ]);
        $this->crud->addField([
            'name' => 'vl_adult',
            'label' => trans('app.vl_adult'),
            'type' => 'integer_number',
            //'attributes' => ["step" => "any"], // allow decimals
            'prefix' => "$",
            'wrapperAttributes' => [
                'class' => 'form-group image col-md-6',
            ],
        ]);
        $this->crud->addField([
            'name' => 'vl_child',
            'label' => trans('app.vl_child'),
            'type' => 'integer_number',
            //'attributes' => ["step" => "any"], // allow decimals
            'prefix' => "$",
            'wrapperAttributes' => [
                'class' => 'form-group image col-md-6',
            ],
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => trans('app.description'),
            'type' => 'simplemde',
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('app.name')
        ]);
        $this->crud->addColumn([
            'name' => 'vl_adult',
            'label' => trans('app.vl_adult'),
            'type' => 'integer_number',
        ]);
        $this->crud->addColumn([
            'name' => 'vl_child',
            'label' => trans('app.vl_child'),
            'type' => 'integer_number',
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
