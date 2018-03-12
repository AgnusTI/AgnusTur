<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes')>

    <?php $entity_model = $crud->model; ?>
    <select
        ng-model="item.{{ $field['name'] }}"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control child_select2_field'])
        >
            @if (isset($field['allow_null']))
            <option value="">{{ trans('app.none')  }}</option>
            @endif

            @if (isset($field['model']))
                @foreach ($field['model']::all() as $connected_entity_entry)
                    <option value="{{ $connected_entity_entry->getKey() }}"
                        @if (isset($field['dataAttributes']) && is_array($field['dataAttributes']))
                            @foreach($field['dataAttributes'] as $col)
                                data-{{ $col }}="{{ $connected_entity_entry->{$col} }}"
                            @endforeach
                        @endif
                    >{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @endforeach
            @endif
    </select>

</div>
