<table class="table table-striped table-sortable">
    <thead>
    <tr>
        <th>{{ trans('app.dt_tour') }}</th>
        <th>{{ trans('app.hr_tour') }}</th>
        <th>{{ trans('app.item') }}</th>
        <th>{{ trans('app.client') }}</th>
        <th>{{ trans('app.adults') }}</th>
        <th>{{ trans('app.childs') }}</th>
        <th>{{ trans('app.total') }}</th>
        <th>{{ trans('app.rest') }}</th>
        <th>{{ trans('app.vendor') }}</th>
        <th>{{ trans('app.status') }}</th>
    </tr>
    </thead>
    <tbody>
    @php
        $adults = 0;
        $childs = 0;

        $qtd = 0;
    @endphp


    @foreach ($items as $e)
        <tr>
            <td>{{ Date::parse($e->dt_tour)->format(config('backpack.base.default_date_format'))  }}</td>
            <td>{{ $e->hr_tour }}</td>
            <td>{{ $e->item_name }}</td>
            <td>{{ $e->name }}</td>
            <td class="text-right">{{ $e->adults }}</td>
            <td class="text-right">{{ $e->childs }}</td>
            <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_total, 0, ',', '.') }}</td>
            <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_rest, 0, ',', '.') }}</td>
            <td>{{ $e->user_name }}</td>
            <td>{{ isset($e->sale_status) ? \App\Models\Sale::getSaleStatus()[$e->sale_status] : "" }}</td>
        </tr>

        @php
            $qtd += 1;
            $adults += $e->adults;
            $childs += $e->childs;

        @endphp
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>{{ number_format($qtd, 0, ',', '.') }}</th>
        <th></th>
        <th></th>
        <th></th>
        <th class="text-right">{{ $adults }}</th>
        <th class="text-right">{{ $childs }}</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </tfoot>
</table>