<!-- html5 time input -->
<div @include('crud::inc.field_wrapper_attributes') >

    @include('crud::inc.field_translatable_icon')
    <input
    	type="child_time"
    	ng-model="item.{{ $field['name'] }}"
        @include('crud::inc.field_attributes')
    	>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
<?php
    $include_resource = true;
    if (isset($crud->child_resource_included)) {
        if (is_array($crud->child_resource_included)) {
            if (in_array($crud->child_resource_included, 'child_time')) {
                if ($crud->child_resource_included['child_time']) {
                    $include_resource = false;
                }
            }
        }
    }
?>
@if ($include_resource)
    @push('crud_fields_scripts')

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

        </script>
    @endpush


    <?php $crud->child_resource_included['child_time'] = true; ?>
@endif
