<!-- select2 -->
<div clas="col-md-12">

    <?php $entity_model = $crud->model; ?>
    <select
        ng-model="item.{{ $field['name'] }}"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control child_select2_field'])
        >
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
