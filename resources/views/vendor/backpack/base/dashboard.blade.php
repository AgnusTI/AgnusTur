@extends('backpack::layout')

@section('header')

@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('app.items') }}</div>
                </div>

                <div class="box-body">
                    <form id="salesFilterForm">
                        <div class="form-group col-md-4">
                            <input class="datepicker-range-start" type="hidden" id="begin_date" name="begin_date" value="{{ (new \DateTime())->format('Y-m-d') }} " >
                            <input class="datepicker-range-end" type="hidden" id="end_date" name="end_date" value="{{ (new \DateTime())->format('Y-m-d') }} ">
                            <label>{{ trans('app.dt_tour') }}</label>
                            <div class="input-group date">
                                <input type="text" data-bs-daterangepicker="{}" class="form-control">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>

                        </div>
                    </form>


                    <div id="salesBox">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('logistics') }}</div>
                </div>

                <div class="box-body">

                    <div id="logisticsReportBox">
                    </div>

                </div>
            </div>
        </div>
    </div>
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

                $fake.on('apply.daterangepicker hide.daterangepicker', function(e, picker){
                    $start.val( picker.startDate.format('YYYY-MM-DD') );
                    $end.val( picker.endDate.format('YYYY-MM-DD') );
                    updateSales();
                    updateLogisticsReport();
                });

            });


            updateSales();

            updateLogisticsReport();


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

        function updateLogisticsReport() {

            console.log($("#salesFilterForm").serialize());

            $.ajax({
                url: 'home/logistics',
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
    </script>
@endpush