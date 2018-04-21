<!-- array input -->
<?php
    $max = isset($field['max']) && (int) $field['max'] > 0 ? $field['max'] : -1;
    $min = isset($field['min']) && (int) $field['min'] > 0 ? $field['min'] : -1;
    $item_name = strtolower(isset($field['entity_singular']) && !empty($field['entity_singular']) ? $field['entity_singular'] : $field['label']);

    $items = old($field['name']) ? (old($field['name'])) : (isset($field['value']) ? ($field['value']) : (isset($field['default']) ? ($field['default']) : '' ));

    // make sure not matter the attribute casting
    // the $items variable contains a properly defined JSON
    if (is_array($items)) {
        if (count($items)) {
            $items = json_encode($items);
        } else {
            $items = '[]';
        }
    } elseif (is_string($items) && !is_array(json_decode($items))) {
        $items = '[]';
    }

?>
<!--
</div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! $field['label'] !!}</h3>
    </div>
    <div class="box-body row">

-->
<div
    ng-app="backPackTableApp"
    ng-controller="tableController"
    @include('crud::inc.field_wrapper_attributes')
    >


    @include('crud::inc.field_translatable_icon')

    <input class="array-json" type="hidden" id="{{ $field['name'] }}" name="{{ $field['name'] }}">

    <div class="array-container form-group child-table-container" >
        <div class="table-wrapper">
            <table
                id="{{ $field['name'] }}"
                class="table table-bordered table-striped m-b-0"



                ng-init="field = '#{{ $field['name'] }}'; items = {{ $items }}; max = {{$max}}; min = {{$min}}; maxErrorTitle = '{{trans('backpack::crud.table_cant_add', ['entity' => $item_name])}}'; maxErrorMessage = '{{trans('backpack::crud.table_max_reached', ['max' => $max])}}'"
                >

                <thead>
                    <tr>
                        @foreach( $field['columns'] as $column )
                            <th
                                style="font-weight: 600!important;"
                                class="@if ($column['type'] == 'child_hidden') hidden @endif ">
                                {{ $column['label'] }}
                            </th>
                        @endforeach
                        <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-sort"></i> --}} </th>
                        <th class="text-center" ng-if="max == -1 || max > 1"> {{-- <i class="fa fa-trash"></i> --}} </th>
                    </tr>
                </thead>

                <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped">

                    <tr post-render ng-repeat="item in items" class="array-row" >


                        @foreach ($field['columns'] as $column)
                            <td
                                 class="
                                    @if(isset($column['size']))
                                        col-md-{{ $column['size'] }}
                                    @endif
                                    @if ($column['type'] == 'child_hidden')
                                        hidden
                                    @endif
                                    "
                                >

                            @if(view()->exists('vendor.backpack.crud.fields.'.$column['type']))
                                @include('vendor.backpack.crud.fields.'.$column['type'], array('field' => $column))
                            @else
                                @include('crud::fields.'.$column['type'], array('field' => $column))
                            @endif
                            </td>
                        @endforeach


                        <td ng-if="max == -1 || max > 1">
                            <button ng-hide="min > -1 && $index < min" class="btn btn-sm btn-danger" type="button" ng-click="removeItem(item);"><span class="sr-only">delete item</span><i class="fa fa-trash" role="presentation" aria-hidden="true"></i></button>
                        </td>
                        <td ng-if="max == -1 || max > 1">
                            <span class="btn btn-sm btn-default sort-handle"><span class="sr-only">sort item</span><i class="fa fa-sort" role="presentation" aria-hidden="true"></i></span>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

        <div class="array-controls btn-group m-t-10">
            <button ng-if="max == -1 || items.length < max" class="btn btn-primary" type="button" ng-click="addItem()"><i class="fa fa-plus"></i> {{ trans('app.add') }} {{ $item_name }}</button>
        </div>

    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    {{-- @push('crud_fields_styles')
        {{-- YOUR CSS HERE --}}
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- YOUR JS HERE --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-sortable/0.14.3/sortable.min.js"></script>
        <script>


            window.angularApp = window.angularApp || angular.module('backPackTableApp', ['ui.sortable'], function($interpolateProvider){
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });


            window.angularApp.controller('tableController', function($scope){

                $scope.sortableOptions = {
                    handle: '.sort-handle'
                };

                $scope.addItem = function(){

                    if( $scope.max > -1 ){
                        if( $scope.items.length < $scope.max ){
                            var item = {};

                            $scope.items.push(item);
                        } else {
                            new PNotify({
                                title: $scope.maxErrorTitle,
                                text: $scope.maxErrorMessage,
                                type: 'error'
                            });
                        }
                    }
                    else {
                        var item = {};

                        $scope.items.push(item);
                    }
                }

                $scope.removeItem = function(item){
                    var index = $scope.items.indexOf(item);
                    $scope.items.splice(index, 1);
                }

                $scope.$watch('items', function(a, b){

                    if( $scope.min > -1 ){
                        while($scope.items.length < $scope.min){
                            $scope.addItem();
                        }
                    }

                    if( typeof $scope.items != 'undefined' && $scope.items.length ){

                        if( typeof $scope.field != 'undefined'){
                            if( typeof $scope.field == 'string' ){
                                $scope.field = $($scope.field);
                            }
                            $scope.field.val( angular.toJson($scope.items) );
                        }
                    }

                }, true);

                if( $scope.min > -1 ){
                    for (var i = 0; i < $scope.min; i++){
                        $scope.addItem();

                    }
                }
            });
            window.angularApp.directive('postRender', function($timeout) {
                return {
                    link: function(scope, element, attr) {
                        $timeout(function() {
                            if (window['initIntegerNumber'] != null) {
                                initIntegerNumber();
                            }
                            if (window['initFloatNumber'] != null) {
                                initFloatNumber();
                            }
                            if (window['initDatePicker'] != null) {
                                initDatePicker();
                            }
                            if (window['initTime'] != null) {
                                initTime();
                            }

                            $("#{{ $field['name'] }} .child_select2_field").each(function (i, obj) {
                                if (!$(obj).hasClass("select2-hidden-accessible")) {
                                    $(obj).select2({
                                        theme: "bootstrap",
                                        width: "auto"

                                    });
                                }
                            });

                        });
                    }
                }
            });
            window.angularApp.directive('convertToNumber', function() {
                return {
                  require: 'ngModel',
                  link: function(scope, element, attrs, ngModel) {
                    ngModel.$parsers.push(function(val) {
                        return parseInt(val, 10);
                    });
                    ngModel.$formatters.push(function(val) {
                        return '' + val +  '';
                    });
                  }
                };
            });
            window.angularApp.directive('convertToInteger', function() {
                return {
                  require: 'ngModel',
                  link: function(scope, element, attrs, ngModel) {
                    ngModel.$parsers.push(function(val) {
                        return val.replace('.', '');
                    });
                    ngModel.$formatters.push(function(val) {
                        var aux = '' + val + '';
                        return aux.replace('.', '');
                    });
                  }
                };
            });
            window.angularApp.directive('convertToDate', function() {
                return {
                  require: 'ngModel',
                  link: function(scope, element, attrs, ngModel) {
                    ngModel.$parsers.push(function(val) {
                        return val;
                    });
                    ngModel.$formatters.push(function(val) {
                        if (val != null && val != "") {
                            return val.substr(8, 2) + '/' + val.substr(5, 2) + '/' + val.substr(0, 4);
                        } else {
                            return "";
                        }

                    });
                  }
                };
            });

            window.angularApp.directive('convertToFloat', function() {
                  return {
                    require: 'ngModel',
                    link: function(scope, element, attrs, ngModel) {
                      ngModel.$parsers.push(function(val) {
                        return val.replace('.', '').replace(',', '.');
                      });
                      ngModel.$formatters.push(function(val) {
                        return val.replace('.', ',');
                      });
                    }
                  };
            });

            angular.element(document).ready(function(){
                angular.forEach(angular.element('[ng-app]'), function(ctrl){
                    var ctrlDom = angular.element(ctrl);
                    if( !ctrlDom.hasClass('ng-scope') ){
                        angular.bootstrap(ctrl, [ctrlDom.attr('ng-app')]);
                    }
                });
            });

        </script>

        @stack('child_after_scripts')

    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
