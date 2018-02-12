<!-- number input -->
<div @include('crud::inc.field_wrapper_attributes') >

    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
        	type="float_number"
        	ng-model="item.{{ $field['name'] }}"
            value="{{ old($field['name']) ? str_replace('.', ',', old($field['name'])) :
                (isset($field['value']) ? str_replace('.', ',', $field['value']) : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::inc.field_attributes')
        	>
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif

    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

</div>
