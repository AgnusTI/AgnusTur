<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\EntityRequest as StoreRequest;
use App\Http\Requests\EntityRequest as UpdateRequest;
use App\Models\Entity as Entity;
use App\Http\Controllers\Admin\EntityCrudController;

class ClientCrudController extends EntityCrudController
{
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute(config('backpack.base.route_prefix') . '/client');
        $this->crud->setEntityNameStrings(trans('app.client'), trans('app.clients'));


        $this->crud->removeField('type', 'both');
        $this->crud->removeColumn('type_comma');

        $this->crud->addClause('where', 'type', 'like', '%'.Entity::ENTITY_TYPE__CLIENT.'%');
    }
}
