<?php

use Illuminate\Support\Facades\Auth;

?>

@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('app.home') }}
            <small>{{ trans('app.control_panel')  }}</small>
        </h1>

    </section>

@endsection


@section('content')

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ \App\Http\Controllers\Admin\HomeController::salesCountByStatus(\App\Models\Sale::SALE_STATUS__OPENED) }}</h3>

                    <p>{{ trans('app.opened_sales')  }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale')  }}" class="small-box-footer">{{ trans('app.manage_sales')  }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ \App\Http\Controllers\Admin\HomeController::salesCountByStatus(\App\Models\Sale::SALE_STATUS__CONFIRMED) }}</h3>

                    <p>{{ trans('app.confirmed_sales')  }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale')  }}" class="small-box-footer">{{ trans('app.manage_sales')  }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ \App\Http\Controllers\Admin\HomeController::salesCountByStatus(\App\Models\Sale::SALE_STATUS__CANCELED) }}</h3>

                    <p>{{ trans('app.canceled_sales')  }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale')  }}" class="small-box-footer">{{ trans('app.manage_sales')  }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ \App\Http\Controllers\Admin\HomeController::salesCountByStatus(\App\Models\Sale::SALE_STATUS__CLOSED) }}</h3>

                    <p>{{ trans('app.closed_sales')  }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale')  }}" class="small-box-footer">{{ trans('app.manage_sales')  }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('app.items') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>


                <div class="box-body">
                    <form id="salesFilterForm">
                        <div class="form-group col-md-4">
                            <input class="datepicker-range-start" type="hidden" id="begin_date" name="begin_date" value="{{ (new \DateTime())->format('Y-m-d') }}" >
                            <input class="datepicker-range-end" type="hidden" id="end_date" name="end_date" value="{{ (new \DateTime())->format('Y-m-d') }}">
                            <label>{{ trans('app.dt_tour') }}</label>
                            <div class="input-group date">
                                <input type="text" data-bs-daterangepicker="{}" class="form-control" id="salesDtFilter">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>

                        </div>
                    </form>


                    <div id="salesBox">
                    </div>

                </div>

                <div class="box-footer clearfix">
                    <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale/create') }}" class="btn btn-primary btn-flat pull-left"><i class="fa fa-plus"></i> {{ trans('app.create_sale') }}</a>
                    <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/sale') }}" class="btn btn-default btn-flat pull-right">{{ trans('app.manage_sales') }}</a>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->isAdmin())




    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('logistics') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>


                <div class="box-body">

                    <div id="logisticsReportBox">
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('app.opened_sales')  }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>

                </div>
                <div class="box-body">

                    @include('backpack::home.inc.opened_sales')

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('app.vendor_sales')  }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <form id="vendorSalesFilterForm">
                        <div class="form-group col-md-12">

                                <input class="datepicker-range-start" type="hidden" id="begin_date" name="begin_date" value="{{ (new \DateTime())->format('Y-m-d') }} " >
                                <input class="datepicker-range-end" type="hidden" id="end_date" name="end_date" value="{{ (new \DateTime())->format('Y-m-d') }} ">
                                <label>{{ trans('app.dt_sale') }}</label>
                                <div class="input-group date">
                                    <input type="text" data-bs-daterangepicker="{}" class="form-control" id="vendorSalesDtFilter">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </div>
                                </div>


                        </div>
                    </form>

                    <div id="vendorSalesBox"></div>


                </div>

            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @endif
@endsection


    @push('after_styles_stack')
    
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <style>
        /*
        .table-sortable tr td { cursor: move; color: #000;  }
        */
        .table-sortable tr td { color: #000; font-size: 1.0em; font-weight: 600;  }

    </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('after_scripts_stack')
    
    <script src="{{ asset('/vendor/adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('/vendor/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function($){
            $('[data-bs-daterangepicker]').each(function(){

                var $fake = $(this),
                $start = $fake.parents('.form-group').find('.datepicker-range-start'),
                $end = $fake.parents('.form-group').find('.datepicker-range-end');

                console.log($start.val());

                var $customConfig = $.extend({
                    autoApply: true,
                    startDate: moment($start.val()),
                    endDate: moment($end.val()),
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                }, $fake.data('bs-daterangepicker'));

                $fake.daterangepicker($customConfig);
                $picker = $fake.data('daterangepicker');

                $fake.on('keydown', function(e){
                    e.preventDefault();
                    return false;
                });

                console.log($(this).attr("id"));

                if ($(this).attr("id") == "salesDtFilter") {

                    $fake.on('apply.daterangepicker hide.daterangepicker', function (e, picker) {
                        $start.val(picker.startDate.format('YYYY-MM-DD'));
                        $end.val(picker.endDate.format('YYYY-MM-DD'));

                        updateSales();

                        @if (Auth::user()->isAdmin())
                        updateLogisticsReport();
                        @endif
                    });
                }

                @if (Auth::user()->isAdmin())
                    if ($(this).attr("id") == "vendorSalesDtFilter") {

                        $fake.on('apply.daterangepicker hide.daterangepicker', function (e, picker) {
                            $start.val(picker.startDate.format('YYYY-MM-DD'));
                            $end.val(picker.endDate.format('YYYY-MM-DD'));

                            updateVendorSales();
                        });
                    }
                @endif
            });

            
            updateSales();

            @if (Auth::user()->isAdmin())
            updateLogisticsReport();
            updateVendorSales();
            @endif

            
        });



        function updateSales()
        {
            console.log($("#salesFilterForm").serialize());

            $.ajax({
                url: 'home/sales',
                dataType: 'text',
                type: 'post',
                data: $("#salesFilterForm").serialize(),
                success: function( data, textStatus, jQxhr ){
                    $('#salesBox').html( data );
                    
                    // $("#salesBox tbody").sortable( {
                    //     update: function( event, ui ) {
                    //     $(this).children().each(function(index) {
                    //             $(this).find('td').last().html(index + 1)
                    //     });
                    // }
                    // });
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });
        }

        @if (Auth::user()->isAdmin())
        function updateLogisticsReport() {

            console.log($("#salesFilterForm").serialize());

            $.ajax({
                url: 'home/logistics_report',
                dataType: 'text',
                type: 'post',
                data: $("#salesFilterForm").serialize(),
                success: function( data, textStatus, jQxhr ){
                    $('#logisticsReportBox').html( data );

                    // $("#logisticsReportBox tbody").sortable( {
                    //     update: function( event, ui ) {
                    //         $(this).children().each(function(index) {
                    //             $(this).find('td').last().html(index + 1)
                    //         });
                    //     }
                    // });
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });
        }
        function updateVendorSales() {
            console.log($("#vendorSalesFilterForm").serialize());

            $.ajax({
                url: 'home/vendor_sales',
                dataType: 'text',
                type: 'post',
                data: $("#vendorSalesFilterForm").serialize(),
                success: function( data, textStatus, jQxhr ){
                    $('#vendorSalesBox').html( data );

                    // $("#logisticsReportBox tbody").sortable( {
                    //     update: function( event, ui ) {
                    //         $(this).children().each(function(index) {
                    //             $(this).find('td').last().html(index + 1)
                    //         });
                    //     }
                    // });
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });
        }
        @endif
    </script>
    @endpush