<!-- number input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label for="{{ $field['name'] }}">{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
        	type="integer_number"
        	name="{{ $field['name'] }}"
            id="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::inc.field_attributes')
        	>
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif

    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

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
        <style>
            input[type=integer_number] { text-align: right !important; }
        </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            /**
            * Number.prototype.format(n, x, s, c)
            *
            * @param integer n: length of decimal
            * @param integer x: length of whole part
            * @param mixed   s: sections delimiter
            * @param mixed   c: decimal delimiter
            */
            Number.prototype.format = function(n, x, s, c) {
                var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                    num = this.toFixed(Math.max(0, ~~n));

                return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
            };

            $(function() {
                initIntegerNumber();

                $("input[type='integer_number']").closest("form").submit(function(e) {
                    $("input[type='integer_number']").each(function() {

                        var val = Number($(this).val().replace('.', ''));

                        $(this).val(val);

                    });
                });
            });
            $.fn.extend({
                formatInteger: function() {
                    var val = Number($(this).val().replace('.', ''));
                    if (val == "") {
                        val = 0;
                    }
                    $(this).val(val.format(0, 3, '.', ','));
                }
            });


            function initIntegerNumber() {
                $("input[type='integer_number']").each(function (i, obj) {
                    if (!$(obj).data('integer_number')) {

                        $(obj).focusin(function() {
                            var val = Number($(this).val().replace('.', ''));
                            $(this).val(val.format(0, 3, '.', ',').replace('.', ''));
                            $(this).select();
                        }).focusout(function() {
                            $(this).formatInteger();
                        })
                        .formatInteger();

                        $(obj).data('integer_number', true);
                    }
                });

                return $("input[type='integer_number']");
            }

        </script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
