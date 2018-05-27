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
                            <input type="hidden" id="filter_date" name="filter_date" value="{{ (new \DateTime())->format('Y-m-d') }}" >
                            <label>{{ trans('app.dt_tour') }}</label>
                            <div class="input-group date">


                                <input type="text" data-bs-datepicker="{'todayBtn':'linked','format':'dd\/mm\/yyyy','language':'pt-BR','todayHighlight':'true'}"
                                       class="form-control" id="salesDtFilter">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group col-md-4">
                            <label> </label>
                            <div class="input-group">
                                <a href="#" class="btn btn-success" id="btnUpdate"><i class="fa fa-refresh"></i> {{ trans('app.refresh')  }}</a>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="logisticsReportBox">

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

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker/datepicker3.css') }}">

    <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        /*
        .table-sortable tr td { cursor: move; color: #000;  }
        */
        .table-sortable tr td { color: #000; font-size: 1.0em; font-weight: 600;  }
        .table-group-item td { background-color: #3c8dbc !important; color: #fff !important; }


    </style>

@endpush

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('after_scripts_stack')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{ asset('vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script charset="UTF-8" src="{{ asset('vendor/adminlte/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') }}"></script>

    <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script>
        if (jQuery.ui) {
            var datepicker = $.fn.datepicker.noConflict();
            $.fn.bootstrapDP = datepicker;
        } else {
            $.fn.bootstrapDP = $.fn.datepicker;
        }

        var dateFormat=function(){var a=/d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,b=/\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,c=/[^-+\dA-Z]/g,d=function(a,b){for(a=String(a),b=b||2;a.length<b;)a="0"+a;return a};return function(e,f,g){var h=dateFormat;if(1!=arguments.length||"[object String]"!=Object.prototype.toString.call(e)||/\d/.test(e)||(f=e,e=void 0),e=e?new Date(e):new Date,isNaN(e))throw SyntaxError("invalid date");f=String(h.masks[f]||f||h.masks.default),"UTC:"==f.slice(0,4)&&(f=f.slice(4),g=!0);var i=g?"getUTC":"get",j=e[i+"Date"](),k=e[i+"Day"](),l=e[i+"Month"](),m=e[i+"FullYear"](),n=e[i+"Hours"](),o=e[i+"Minutes"](),p=e[i+"Seconds"](),q=e[i+"Milliseconds"](),r=g?0:e.getTimezoneOffset(),s={d:j,dd:d(j),ddd:h.i18n.dayNames[k],dddd:h.i18n.dayNames[k+7],m:l+1,mm:d(l+1),mmm:h.i18n.monthNames[l],mmmm:h.i18n.monthNames[l+12],yy:String(m).slice(2),yyyy:m,h:n%12||12,hh:d(n%12||12),H:n,HH:d(n),M:o,MM:d(o),s:p,ss:d(p),l:d(q,3),L:d(q>99?Math.round(q/10):q),t:n<12?"a":"p",tt:n<12?"am":"pm",T:n<12?"A":"P",TT:n<12?"AM":"PM",Z:g?"UTC":(String(e).match(b)||[""]).pop().replace(c,""),o:(r>0?"-":"+")+d(100*Math.floor(Math.abs(r)/60)+Math.abs(r)%60,4),S:["th","st","nd","rd"][j%10>3?0:(j%100-j%10!=10)*j%10]};return f.replace(a,function(a){return a in s?s[a]:a.slice(1,a.length-1)})}}();dateFormat.masks={default:"ddd mmm dd yyyy HH:MM:ss",shortDate:"m/d/yy",mediumDate:"mmm d, yyyy",longDate:"mmmm d, yyyy",fullDate:"dddd, mmmm d, yyyy",shortTime:"h:MM TT",mediumTime:"h:MM:ss TT",longTime:"h:MM:ss TT Z",isoDate:"yyyy-mm-dd",isoTime:"HH:MM:ss",isoDateTime:"yyyy-mm-dd'T'HH:MM:ss",isoUtcDateTime:"UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"},dateFormat.i18n={dayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],monthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","January","February","March","April","May","June","July","August","September","October","November","December"]},Date.prototype.format=function(a,b){return dateFormat(this,a,b)};

        jQuery(document).ready(function($){
            $('[data-bs-datepicker]').each(function(){

                var $fake = $(this),
                    $field = $fake.parents('.form-group').find('input[type="hidden"]'),
                    $customConfig = $.extend({
                        format: 'dd/mm/yyyy'
                    }, $fake.data('bs-datepicker'));
                $picker = $fake.bootstrapDP($customConfig);

                var $existingVal = $field.val();

                if( $existingVal.length ){
                    // Passing an ISO-8601 date string (YYYY-MM-DD) to the Date constructor results in
                    // varying behavior across browsers. Splitting and passing in parts of the date
                    // manually gives us more defined behavior.
                    // See https://stackoverflow.com/questions/2587345/why-does-date-parse-give-incorrect-results
                    var parts = $existingVal.split('-')
                    var year = parts[0]
                    var month = parts[1] - 1 // Date constructor expects a zero-indexed month
                    var day = parts[2]
                    preparedDate = new Date(year, month, day).format($customConfig.format);
                    $fake.val(preparedDate);
                    $picker.bootstrapDP('update', preparedDate);
                }

                $fake.on('keydown', function(e){
                    e.preventDefault();
                    return false;
                });

                $picker.on('changeDate', function(e){
                    updateLogisticsReport();
                    $picker.close();

                });

                $picker.on('show hide change', function(e){
                    if( e.date ){
                        var sqlDate = e.format('yyyy-mm-dd');
                    } else {
                        try {
                            var sqlDate = $fake.val();

                            if( $customConfig.format === 'dd/mm/yyyy' ){
                                sqlDate = new Date(sqlDate.split('/')[2], sqlDate.split('/')[1] - 1, sqlDate.split('/')[0]).format('yyyy-mm-dd');
                            }
                        } catch(e){
                            if( $fake.val() ){
                                PNotify.removeAll();
                                new PNotify({
                                    title: 'Whoops!',
                                    text: 'Sorry we did not recognise that date format, please make sure it uses a yyyy mm dd combination',
                                    type: 'error',
                                    icon: false
                                });
                            }
                        }
                    }

                    $field.val(sqlDate);
                });
            });
        });

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

            $("#btnUpdate").click(function() {
                updateLogisticsReport();
            });

            updateLogisticsReport();

        });

        function updateLogisticsReport() {

            $.ajax({
                url: 'logistics',
                dataType: 'text',
                type: 'post',
                data: $("#salesFilterForm").serialize(),
                success: function (data, textStatus, jQxhr) {
                    $('#logisticsReportBox').html(data);



                    $('#logisticsReportBox a[name=btnSaveLogistics]').click(function () {

                        saveLogistics($(this).parents('form:first'));

                    });

                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }


        function saveLogistics(form) {
            console.log(form.serialize());

            $.ajax({
                url: 'logistics/save_logistic',
                dataType: 'text',
                type: 'post',
                data: form.serialize(),
                success: function (data, textStatus, jQxhr) {

                    if (data == 'ok') {
                        updateLogisticsReport();
                    }

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