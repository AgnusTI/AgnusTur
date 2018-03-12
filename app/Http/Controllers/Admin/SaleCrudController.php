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


        /**
         * 
         * FIELDS DEFINITIONS
         * 
         */
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
                'type' => 'text',
            ],
            [
                'name' => 'separator',
                'type' => 'custom_html',
                'value' => '<hr><h4>'.trans('app.items').'</h4>',
            ]
        ]);


        /**
         * 
         * ITENS
         * 
         */
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
             'dataAttributes' => ['vl_adult', 'vl_child', 'vl_adult_expense', 'vl_child_expense'],
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
                 'wrapperAttributes' => ['style' => 'width: 110px']
              ]
        );

        if (Auth::user()->profile == User::USER_PROFILE__ADMIN) {
            array_push($itemsColumns,
                ['label' => trans('app.hr_tour'),
                 'type' => 'child_time',
                 'name' => 'hr_tour',

                    'wrapperAttributes' => ['style' => 'width: 70px']
                 ]
             );
        }

        array_push($itemsColumns,
            ['label' => trans('app.adults'),
             'type' => 'child_integer_number',
             'name' => 'adults',
                'wrapperAttributes' => ['style' => 'width: 70px'],
             'attributes' => ['convert-to-integer' => '']
            ],
            ['label' => trans('app.childs'),
             'type' => 'child_integer_number',
             'name' => 'childs',
                'wrapperAttributes' => ['style' => 'width: 70px'],
             'attributes' => ['convert-to-integer' => '']
            ],
            ['label' => trans('app.subtotal'),
             'type' => 'child_integer_number',
             'name' => 'vl_subtotal',
             //'prefix' => "$",
             //'size' => '3'
             'size' => '1',
             'attributes' => ['convert-to-integer' => '', 'readonly' => '', 'tabindex' => '-1']
            ],
            ['label' => trans('app.discount'),
             'type' => 'child_integer_number',
             'name' => 'vl_discount',
             //'prefix' => "$",
             //'size' => '3',
             'size' => '1',
             'attributes' => ['convert-to-integer' => '']
            ],
            ['label' => trans('app.percent_discount'),
             'type' => 'child_float_number',
             'name' => 'vl_percent_discount',
             //'suffix' => "%",
             'size' => '1',
             'attributes' => ['convert-to-float' => '', 'tabindex' => '-1']
            ],
            ['label' => trans('app.total'),
             'type' => 'child_integer_number',
             'name' => 'vl_total',
             'size' => '1',
             'attributes' => ['convert-to-integer' => '']
            ]
         );

        if (Auth::user()->profile == User::USER_PROFILE__ADMIN) {
            array_push($itemsColumns,

                ['label' => trans('app.expense'),
                    'type' => 'child_integer_number',
                    'name' => 'vl_expense',
                    'size' => '1',
                    'attributes' => ['convert-to-integer' => '']
                ],
                ['label' => trans('app.percent_commission'),
                    'type' => 'child_float_number',
                    'name' => 'vl_percent_commission',
                    //'suffix' => "%",
                    'size' => '1',
                    'attributes' => ['convert-to-float' => '']
                ],
                ['label' => trans('app.commission'),
                    'type' => 'child_integer_number',
                    'name' => 'vl_commission',
                    'size' => '1',
                    'attributes' => ['convert-to-integer' => '']
                ],
                ['label' => trans('app.partner'),
                    'type' => 'child_select',
                    'name' => 'partner_id',
                    'entity' => 'partner',
                    'attribute' => 'name',
                    'size' => '2',
                    'model' => "App\Models\Partner",
                    'attributes' => ['convert-to-number' => ''],
                    'allow_null' => true,
                    'dataAttributes' => ['vl_percent_partner'],
                ],
                ['label' => trans('app.vl_partner'),
                    'type' => 'child_integer_number',
                    'name' => 'vl_partner',
                    'size' => '1',
                    'attributes' => ['convert-to-integer' => '']
                ]
            );
        }

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
                'type' => 'float_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'suffix' => "%",
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
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'vl_rest',
                'label' => trans('app.rest'),
                'type' => 'integer_number',
                //'attributes' => ["step" => "any"], // allow decimals
                'prefix' => "$",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes' => ['readonly' => '', 'tabindex' => '-1']
            ],
            [
                'name' => 'payment_id',
                'label' => trans('app.payment'),
                'type' => 'select2',
                'entity' => 'payment',
                'attribute' => 'description',
                'model' => 'App\Models\Payment',
                // 'data_source' => url('/admin/api/hotel/list'),
                // 'placeholder' => trans('app.hotel_placeholder'),
                // 'minimum_input_length' => 2,
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
            ],
        ]);


        /**
         * ADMIN FIELDS (VENDOR)
         */
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
                    'name' => 'vl_expense',
                    'label' => trans('app.expense'),
                    'type' => 'integer_number',
                    'prefix' => "$",
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2',
                    ],
                    'attributes' => ['readonly' => '', 'tabindex' => '-1']
                ],
                [
                    'name' => 'vl_net_total',
                    'label' => trans('app.net_total'),
                    'type' => 'integer_number',
                    'prefix' => "$",
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2',
                    ],
                    'attributes' => ['readonly' => '', 'tabindex' => '-1']
                ],
                [
                    'name' => 'vl_commission',
                    'label' => trans('app.commission'),
                    'type' => 'integer_number',
                    'prefix' => "$",
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2',
                    ],
                    'attributes' => ['readonly' => '', 'tabindex' => '-1']
                ],
                [
                    'name' => 'vl_percent_commission',
                    'label' => trans('app.percent_commission'),
                    'type' => 'float_number',
                    'suffix' => "%",
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2',
                    ],
                    'attributes' => ['readonly' => '', 'tabindex' => '-1']
                ],

            ]);
        }

        /**
         * 
         * COLUMNS
         * 
         */
        $this->crud->addColumn([
            'name' => 'dt_sale',
            'label' => trans('app.dt_sale'),
            'type' => 'date',
            'searchLogic' => function ($query, $column, $searchTerm) {
                //$query->orWhere('name', 'ilike', '%'.$searchTerm.'%');
                return false;
            }
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
            'type' => 'float_number',
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
        $this->crud->enableExportButtons();
        
        
        
        if (Auth::user()->profile == User::USER_PROFILE__VENDOR) {
            $this->crud->addClause('where', 'user_id', '=', Auth::user()->id);
        }


        /**
         * 
         * FILTERS
         * 
         */
        if (Auth::user()->profile == User::USER_PROFILE__ADMIN) {
            $this->crud->addFilter([ // select2 filter
                'name' => 'user_id',
                'type' => 'select2',
                'label'=> trans('app.vendor')
            ], function() {
                return \App\Models\User::all()->pluck('name', 'id')->toArray();
            }, function($value) { // if the filter is active
                $this->crud->addClause('where', 'user_id', $value);
            });
        }


        $this->crud->addFilter([ // select2_ajax filter
            'name' => 'entity_id',
            'type' => 'select2_ajax',
            'label'=> trans('app.client'),
            'placeholder' => trans('app.entity_client_placeholder')
            ],
            url('/admin/entity/ajax-client-options'), // the ajax route
            function($value) { // if the filter is active
                $this->crud->addClause('where', 'entity_id', $value);
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


        $this->crud->orderBy("dt_sale");
         
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
