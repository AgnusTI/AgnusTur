<!-- bootstrap datepicker input -->

<?php
    // if the column has been cast to Carbon or Date (using attribute casting)
    // get the value as a date string
    if (isset($field['value']) && ( $field['value'] instanceof \Carbon\Carbon || $field['value'] instanceof \Jenssegers\Date\Date )) {
        $field['value'] = $field['value']->format('Y-m-d');
    }

    $field_language = isset($field['date_picker_options']['language'])?$field['date_picker_options']['language']:\App::getLocale();
?>

<div @include('crud::inc.field_wrapper_attributes') >
    <div class="datepicker-box">
        <input
            type="hidden"
            >

        @include('crud::inc.field_translatable_icon')
        <div class="input-group date">
            <input
                data-bs-datepicker="{{ isset($field['date_picker_options']) ? json_encode($field['date_picker_options']) : '{}'}}"
                type="text"
                ng-model="item.{{ $field['name'] }}"
                @include('crud::inc.field_attributes')
                >
                <!--
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </div>
        -->
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
