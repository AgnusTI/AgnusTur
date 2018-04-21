@extends('backpack::layout')


@section('header')
    <section class="content-header">
        <h1>
            {{ trans('app.reports') }}
            <small>{{ trans('app.control_panel')  }}</small>
        </h1>

    </section>

@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('app.logistics') }}</h3>
                </div>


                <div class="box-body">
                    <form id="salesFilterForm">
                        <div class="form-group col-md-4">
                            <input class="datepicker-range-start" type="hidden" id="begin_date" name="begin_date" value="{{ (new \DateTime())->format('Y-m-01') }}" >
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

                    <div id="logisticsReportBox">
                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="editSaleItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('app.item')  }}</h4>
                </div>
                <div class="modal-body row display-flex-wrap" >
                    <form id="saleItemForm" method="POST" action="logistics/update">
                        {{ csrf_field() }}

                        <input type="hidden" id="sale_item_id" name="sale_item_id"/>

                        <div class="form-group col-md-3">
                            <label>{{ trans('app.hr_tour') }}</label>
                            <input id="hr_tour" name="hr_tour" type="child_time" class="form-control"/>
                        </div>
                        <div class="form-group col-md-8">
                            <label>{{ trans('app.partner') }}</label>

                            <select id="partner_id" name="partner_id" class="form-control select2_field">
                                <option value="">{{ trans('app.none')  }}</option>
                                @foreach(\App\Models\Partner::all() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('backpack::crud.cancel')  }}</button>
                    <button type="button" class="btn btn-primary" id="btnSaveItem">{{ trans('backpack::crud.save')  }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('after_styles_stack')

    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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
    <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $('.select2_field').each(function (i, obj) {
                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    $(obj).select2({
                        theme: "bootstrap",
                        width: '100%'
                    });
                }
            });
        });
    </script>
    <script>
        $(function($) {
            $('[data-bs-daterangepicker]').each(function () {

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

                $fake.on('keydown', function (e) {
                    e.preventDefault();
                    return false;
                });

                console.log($(this).attr("id"));

                if ($(this).attr("id") == "salesDtFilter") {

                    $fake.on('apply.daterangepicker hide.daterangepicker', function (e, picker) {
                        $start.val(picker.startDate.format('YYYY-MM-DD'));
                        $end.val(picker.endDate.format('YYYY-MM-DD'));

                        updateLogisticsReport();

                    });
                }

            });

            updateLogisticsReport();

        });

        function updateLogisticsReport() {

            console.log($("#salesFilterForm").serialize());

            $.ajax({
                url: 'logistics',
                dataType: 'text',
                type: 'post',
                data: $("#salesFilterForm").serialize(),
                success: function (data, textStatus, jQxhr) {
                    $('#logisticsReportBox').html(data);

                    // $("#logisticsReportBox tbody").sortable( {
                    //     update: function( event, ui ) {
                    //         $(this).children().each(function(index) {
                    //             $(this).find('td').last().html(index + 1)
                    //         });
                    //     }
                    // });
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    </script>

    <script src="{{ asset('vendor/adminlte/plugins/input-mask/jquery.inputmask.js') }}"></script>

    <script>

        $(function() {
            initTime();
        });

        function initTime() {
            $("input[type='child_time']").each(function (i, obj) {
                if (!$(obj).data('child_time')) {

                    $(obj).inputmask("99:99");  //static mask

                    $(obj).data('child_time', true);
                }
            });

            return $("input[type='child_time']");
        }



        $('#editSaleItem').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal

            $('#sale_item_id').val(button.data('sale-item-id'));
            $('#hr_tour').val(button.data('hr-tour'));
            $('#partner_id').val(button.data('partner-id')).trigger('change');

        });

        $("#btnSaveItem").click(function(){



            $.ajax({
                url: 'logistics/update',
                dataType: 'text',
                type: 'post',
                data: $("#saleItemForm").serialize(),
                success: function( data, textStatus, jQxhr ){
                    console.log(data);

                    if (data == "ok") {
                        updateLogisticsReport();
                        $("#editSaleItem").modal('hide');
                    } else {

                    }
                    //$('#logisticsReportBox').html( data );

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
        });

    </script>
@endpush