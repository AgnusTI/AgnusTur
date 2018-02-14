<!-- number input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label for="{{ $field['name'] }}">{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <div class="input-group">
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif

        <?php
            if (isset($connected_entity_entry)) {
                $field['key_value'] = $connected_entity_entry->{$field['key']};
            }
        ?>

        <div class="input-group-addon" id="stat__{{ $field['key'] }}"><i class="fa fa-check"></i></div>

        <input
        	type="text"
        	name="{{ $field['name'] }}"
            id="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::inc.field_attributes')
        	>

        <div class="input-group-btn" id="remove__{{ $field['key'] }}">
            <button type="button" class="btn btn-default btn-flat" disabled> <i class="fa fa-close"></i> </button>
        </div>
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif

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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')

        <script>
            $(function() {
                $("#{{ $field['name'] }}").autocomplete({
                  source: function( request, response ) {
                    $.ajax( {
                      url: "{{ url('/admin/api/entity/list/'.App\Models\Entity::ENTITY_TYPE__CLIENT) }}",
                      dataType: "json",
                      data: {
                        q: request.term
                      },
                      success: function (data) {
                            response($.map(data.data, function (item) {
                                return {
                                    label: item.name + ' (' + item.phone + ')',
                                    value: item.id,

                                    name: item.name,
                                    phone: item.phone,
                                    email: item.email,
                                    address: item.address,
                                    hotel_id: item.hotel_id,
                                    hotel_name: item.hotel_name,
                                    hotel_address: item.hotel_address,
                                    room_number: item.room_number,
                                    out_point: item.room_number,
                                };
                            }));
                        }
                    } );
                  },
                  minLength: 2,
                  select: function( event, ui ) {
                    console.log( "Selected: " + ui.item.value + " aka " + ui.item.label );

                    $("#name").val(ui.item.name);
                    $("input[name={{ $field['key'] }}]").val(ui.item.value).change();
                    $("input[name=phone]").val(ui.item.phone);
                    $("input[name=email]").val(ui.item.email);
                    $("select[name=hotel_id]").append('<option value=' + ui.item.hotel_id + '>' + ui.item.hotel_name + '(' + ui.item.hotel_address + ')' + '</option>');
                    $("select[name=hotel_id]").select2("trigger", "select", {
                        data: { id: ui.item.hotel_id }
                    });
                    $("input[name=address]").val(ui.item.address);
                    $("input[name=room_number]").val(ui.item.room_number);
                    $("input[name=out_point]").val(ui.item.out_point);



                    return false;
                  }
                });

                $("input[name={{ $field['key'] }}]").change(function() {
                    if ($(this).val() == "") {
                        $("#stat__{{ $field['key'] }}").removeClass('bg-olive');
                        $("#remove__{{ $field['key'] }} button")
                            .attr('disabled', 'true')
                            .addClass('btn-default')
                            .removeClass('btn-danger');
                    } else {
                        $("#stat__{{ $field['key'] }}").addClass('bg-olive');
                        $("#remove__{{ $field['key'] }} button")
                            .removeAttr('disabled')
                            .removeClass('btn-default')
                            .addClass('btn-danger');
                    }
                }).change();

                $("#remove__{{ $field['key'] }} button").click(function() {
                    if (!$(this).attr("disabled")) {
                        $("input[name={{ $field['key'] }}]").val("").change();
                    }
                });
            });
        </script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
