<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\PaymentRequest as StoreRequest;
use App\Http\Requests\PaymentRequest as UpdateRequest;

class PaymentCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\Payment');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/payment');
        $this->crud->setEntityNameStrings(trans('app.payment'), trans('app.payments'));

        $this->crud->addField([
            'name' => 'description',
            'label' => trans('app.description'),
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'description',
            'label' => trans('app.description')
        ]);
        
        $this->crud->orderBy('description');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
