@php
    use \App\Http\Controllers\Admin\HomeController;
    use \App\Models\Sale;

    $items = HomeController::salesByStatus(Sale::SALE_STATUS__OPENED);

@endphp


<table class="table table-striped table-sortable ">
    <thead>
    <tr>
        <th>{{ trans('app.dt_tour') }}</th>
        <th>{{ trans('app.item') }}</th>
        <th>{{ trans('app.client') }}</th>
        <th>{{ trans('app.total') }}</th>
        <th>{{ trans('app.vendor') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @php
        $qtd = 0;
    @endphp
    @foreach ($items as $e)
        <tr>
            <td>{{ Date::parse($e->dt_tour)->format(config('backpack.base.default_date_format'))  }}</td>
            <td>{{ $e->item_name }}</td>
            <td>{{ $e->name }}</td>
            <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_total, 0, ',', '.') }}</td>
            <td>{{ $e->user_name }}</td>
            <td><a href="/admin/sale/{{ $e->sale_id }}/edit" class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-edit"></i>{{ trans('backpack::crud.edit')  }}</a></td>
        </tr>
        @php
            $qtd += 1;
        @endphp
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>{{ number_format($qtd, 0, ',', '.') }}</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </tfoot>
</table>