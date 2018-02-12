<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
//use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
//use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;

use App\Models\User;

class UserCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/user');
        $this->crud->setEntityNameStrings(trans('app.user'), trans('app.users'));
        //$this->crud->enableAjaxTable();

        // Columns.
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => trans('app.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('app.email'),
                'type'  => 'email',
            ],
        ]);

        // Fields
        $this->crud->addFields([
            [
                'name'      => 'profile',
                'label'     => trans('app.profile'),
                'type'      => 'select2_from_array',
                'options'   => User::getUserProfiles(),
                'allows_null' => false,
                'allows_multiple' => false,
            ],
            [
                'name'  => 'name',
                'label' => trans('app.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('app.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'password',
                'label' => trans('app.password'),
                'type'  => 'password',
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('app.password_confirmation'),
                'type'  => 'password',
            ],

        ]);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $this->handlePasswordInput($request);

        return parent::storeCrud($request);
    }

    /**
     * Update the specified resource in the database.
     *
     * @param UpdateRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->handlePasswordInput($request);

        return parent::updateCrud($request);
    }

    /**
     * Handle password input fields.
     *
     * @param CrudRequest $request
     */
    protected function handlePasswordInput(CrudRequest $request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', bcrypt($request->input('password')));
        } else {
            $request->request->remove('password');
        }
    }
}
