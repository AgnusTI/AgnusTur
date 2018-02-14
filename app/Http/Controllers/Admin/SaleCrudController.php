<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SaleRequest as StoreRequest;
use App\Http\Requests\SaleRequest as UpdateRequest;
use App\Models\Entity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class SaleCrudController extends CrudController
{
    public function setup()
    {
        //$this->crud->child_resource_included = ['select' => false, 'number' => false];

        $this->crud->setModel('App\Models\Sale');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sale');
        $this->crud->setEntityNameStrings(trans('app.sale'), trans('app.sales'));
        $this->crud->enableAjaxTable();



        $this->crud->addFields([

            [
                'name' => 'entity_id',
                'type' => 'hidden',

            ],
            [
                'name' => 'name',
                'label' => trans('app.name'),
                'type' => 'entity_auto_complete',
                'key' => 'entity_id',
                'wrapperAttributes' => ['class' => 'form-group col-md-8'],

            ],
            [
                'name' => 'dt_sale',
                'label' => trans('app.dt_sale'),
                'type' => 'date_picker',
                'date_picker_options' =>
                [
                     'todayBtn' => 'linked',
                     'format' => 'dd/mm/yyyy',
                     'language' => 'pt-BR',
                     'todayHighlight' => 'true',
                 ],
                 'default' => Carbon::now()->format('Y-m-d'),
                 'wrapperAttributes' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'email',
                'label' => trans('app.email'),
                'type' => 'email',
                'wrapperAttributes' => ['class' => 'form-group col-md-8'],
            ],
            [
                'name' => 'phone',
                'label' => trans('app.phone'),
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'hotel_id',
                'label' => trans('app.hotel'),
                'type' => 'select2_from_ajax',
                'entity' => 'hotel',
                'attribute' => 'description',
                'model' => 'App\Models\Hotel',
                'data_source' => url('/admin/api/hotel/list'),
                'placeholder' => trans('app.hotel_placeholder'),
                'minimum_input_length' => 2,
                'wrapperAttributes' => ['class' => 'form-group col-md-5'],
            ],
            [
                'name' => 'address',
                'label' => trans('app.address'),
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-5'],
            ],
            [
                'name' => 'room_number',
                'label' => trans('app.room_number'),
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-2'],
            ],
            [
                'name' => 'out_point',
                'label' => trans('app.out_point'),
                'type' => 'address',
            ],
            [
                'name' => 'separator',
                'type' => 'custom_html',
                'value' => '<hr><h4>'.trans('app.items').'</h4>',
            ]
        ]);


        $itemsColumns = array(
            ['label' => '',
             'type' => 'child_hidden',
             'name' => 'id'
            ],
            ['label' => trans('app.item'),
             'type' => 'child_select',
             'name' => 'item_id',
             'entity' => 'items',
             'attribute' => 'name',
             'dataAttributes' => ['vl_adult', 'vl_child'],
             'size' => '2',
             'model' => "App\Models\Item",
             'attributes' => ['convert-to-number' => '']
             ],
             ['label' => trans('app.dt_tour'),
              'type' => 'child_date_picker',
              'name' => 'dt_tour',
              'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format' => 'dd/mm/yyyy',
                    'language' => 'pt-BR',
                    'todayHighlight' => 'true',
                 ],
              'attributes' => ['convert-to-date' => ''],
              ]
        );

        if (Auth::user()->profile == User::USER_PROFILE__ADMIN) {
            array_push($itemsColumns,
                ['label' => trans('app.hr_tour'),
                 'type' => 'child_time',
                 'name' => 'hr_tour',
                 'size' => '1'
                 // 'attributes' => ['convert-to-date' => ''],
                 ]
             );
        }

        array_push($itemsColumns,
            ['label' => trans('app.adults'),
             'type' => 'child_integer_number',
             'name' => 'adults',
             'size' => '1',
             'attributes' => ['convert-to-integer' => '']
            ],
            ['label' => trans('app.childs'),
             'type' => 'child_integer_number',
             'name' => 'childs',
             'size' => '1',
             'attributes' => ['convert-to-integer' => '']
            ],
            ['label' => trans('app.subtotal'),
             'type' => 'child_integer_number',
             'name' => 'vl_subtotal',
             //'prefix' => "$",
             //'size' => '3',
             'attributes' => ['convert-to-integer' => '', 'readonly' => '', 'tabindex' => '-1']
            ],
            ['label' => trans('app.discount'),
             'type' => 'child_integer_number',
             'name' => 'vl_discount',
             //'prefix' => "$",
             //'size' => '3',
             'attributes' => ['convert-to-integer' => '']
            ],
            ['label' => trans('app.percent_discount'),
             'type' => 'child_integer_number',
             'name' => 'vl_percent_discount',
             //'suffix' => "%",
             'size' => '1',
             'attributes' => ['convert-to-integer' => '']
            ],
            ['label' => trans('app.total'),
             'type' => 'child_integer_number',
             'name' => 'vl_total',
             'attributes' => ['convert-to-integer' => '']
            ]
         );

        $this->crud->addField(
            [
                'name' => 'items',
                'label' =>  trans('app.items'),
                'type' => 'sales_items_child',
                'entity_singular' => trans('app.item'), // used on the "Add X" button
                'columns' => $itemsColumns,
                'max' => -1, // maximum rows allowed in the table
                'min' => 0 // minimum rows allowed in the table
            ]
        );

        $this->crud->addFields([
            [
                'name' => 'note',
                'label' => trans('app.note'),
            ],
            [
                'name' => 'separator2',
                'type' => 'custom_html',
                'value' => '<hr><h4>'.trans('app.total_and_payment').'</h4>',
            ],
            [
                'name' => 'vl_subtotal',
                'label' => trans('app.subtotal'),
                'type' => 'integer_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'prefix' => "$",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes' => ['readonly' => '', 'tabindex' => '-1']
            ],
            [
                'name' => 'vl_discount',
                'label' => trans('app.discount'),
                'type' => 'integer_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'prefix' => "$",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2',
                ],
                'attributes' => ['readonly' => '', 'tabindex' => '-1']
            ],
            [
                'name' => 'vl_percent_discount',
                'label' => trans('app.percent_discount'),
                'type' => 'integer_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'sufix' => "%",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2',
                ],
                'attributes' => ['readonly' => '', 'tabindex' => '-1']
            ],
            [
                'name' => 'vl_total',
                'label' => trans('app.total'),
                'type' => 'integer_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'prefix' => "$",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes' => ['readonly' => '', 'tabindex' => '-1']
            ],
            [
                'name' => 'vl_pay',
                'label' => trans('app.pay'),
                'type' => 'integer_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'prefix' => "$",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'vl_rest',
                'label' => trans('app.rest'),
                'type' => 'integer_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'prefix' => "$",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
                'attributes' => ['readonly' => '', 'tabindex' => '-1']
            ],
        ]);

        if (Auth::user()->profile == User::USER_PROFILE__ADMIN) {
            $this->crud->addField(
                [
                    'name' => 'separator3',
                    'type' => 'custom_html',
                    'value' => '<hr><h4>'.trans('app.vendor_and_comission').'</h4>',
                ]
            );
            $this->crud->addField(
                [
                    'name' => 'user_id',
                    'label' => trans('app.vendor'),
                    'type' => 'select2',
                    'entity' => 'user',
                    'attribute' => 'name',
                    'model' => 'App\Models\User',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4',
                    ],
                    'value' => Auth::user()->id,
                ],
                'create'
            );
            $this->crud->addField(
                [
                    'name' => 'user_id',
                    'label' => trans('app.vendor'),
                    'type' => 'select2',
                    'entity' => 'user',
                    'attribute' => 'name',
                    'model' => 'App\Models\User',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4',
                    ]
                ],
                'update'
            );
            $this->crud->addFields([
                [
                    'name' => 'vl_percent_commission',
                    'label' => trans('app.percent_commission'),
                    'type' => 'integer_number',
                    'prefix' => "%",
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4',
                    ],
                ],
                [
                    'name' => 'vl_commission',
                    'label' => trans('app.commission'),
                    'type' => 'integer_number',
                    'prefix' => "$",
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-4',
                    ],
                ],
            ]);
        }

        //
        // Columns
        //
        $this->crud->addColumn([
            'name' => 'dt_sale',
            'label' => trans('app.dt_sale'),
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('app.name'),
            'type' => 'text',
            // 'searchLogic' => function ($query, $column, $searchTerm) {
            //     $query->orWhere('name', 'ilike', '%'.$searchTerm.'%');
            //     return false;
            // }
        ]);
        $this->crud->addColumn([
            'name' => 'vl_subtotal',
            'label' => trans('app.subtotal'),
            'type' => 'integer_number',
        ]);
        $this->crud->addColumn([
            'name' => 'vl_discount',
            'label' => trans('app.discount'),
            'type' => 'integer_number',
        ]);
        $this->crud->addColumn([
            'name' => 'vl_percent_discount',
            'label' => trans('app.percent_discount'),
            'type' => 'integer_number',
        ]);
        $this->crud->addColumn([
            'name' => 'vl_total',
            'label' => trans('app.total'),
            'type' => 'integer_number',
        ]);
        $this->crud->addColumn([
            'name' => 'vl_pay',
            'label' => trans('app.pay'),
            'type' => 'integer_number',
        ]);
        $this->crud->addColumn([
            'name' => 'vl_rest',
            'label' => trans('app.rest'),
            'type' => 'integer_number',
        ]);

        if (Auth::user()->profile == User::USER_PROFILE__ADMIN) {
            $this->crud->addColumn([
                'name' => 'user_id',
                'label' => trans('app.vendor'),
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => 'App\Models\User',
            ]);
        }


        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        //$this->setDetailsRowView('sale_details_row');


        // $this->crud->addButtonFromModelFunction('line', 'sale', 'openEntityRegister', 'beginning'); // add a button whose HTML is returned by a method in the CRUD model

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore


        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        $this->crud->enableExportButtons();
        //$this->crud->allowAccess('show');


        if (Auth::user()->profile == User::USER_PROFILE__VENDOR) {
            $this->crud->addClause('where', 'user_id', '=', Auth::user()->id);
        }

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();



         $this->crud->addFilter([ // select2 filter
              'name' => 'user_id',
              'type' => 'select2',
              'label'=> trans('app.vendor')
            ], function() {
                return \App\Models\User::all()->pluck('name', 'id')->toArray();
            }, function($value) { // if the filter is active
                $this->crud->addClause('where', 'user_id', $value);
        });
        $this->crud->addFilter([ // daterange filter
               'type' => 'date_range',
               'name' => 'dt_sale',
               'label'=> trans('app.dt_sale')
             ],
             false,
             function($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'dt_sale', '>=', $dates->from);
                $this->crud->addClause('where', 'dt_sale', '<=', $dates->to);
         });
    }

    public function store(StoreRequest $request)
    {
        $this->handleSale($request);

        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $this->handleSale($request);

        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }


    protected function handleSale(CrudRequest $request)
    {
        if (!$request->input('user_id')) {
            $request->request->set('user_id', Auth::user()->id);
        }



        if (!$request->input('entity_id') || $request->input('entity_id') == "") {
            $this->client = new Entity();
            $this->type = array(Entity::ENTITY_TYPE__CLIENT);
        } else {
            $this->client = Entity::find($request->input('entity_id'));
        }

        $this->client->name = $request->input('name');
        $this->client->phone = $request->input('phone');
        $this->client->hotel_id = $request->input('hotel_id');
        $this->client->address = $request->input('address');
        $this->client->email = $request->input('email');
        $this->client->room_number = $request->input('room_number');
        $this->client->out_point = $request->input('out_point');
        $this->client->save();

        $request->request->set('entity_id', $this->client->id);
    }


    public function openEntityRegister($crud = false)
    {
        return '<a class="btn btn-xs btn-default" target="_blank" href="http://google.com?q='.urlencode($this->text).'" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i> Google it</a>';
    }

    public function showDetailsRow($id)
    {
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('crud::sale_details_row', $this->data);
    }
}
