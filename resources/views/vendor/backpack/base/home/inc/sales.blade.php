<table class="table table-striped table-sortable">
    <thead>
        <tr>
            <th>{{ trans('app.dt_tour') }}</th>
            <th>{{ trans('app.hr_tour') }}</th>
            <th>{{ trans('app.item') }}</th>
            <th>{{ trans('app.client') }}</th>
            <th>{{ trans('app.adults') }}</th>
            <th>{{ trans('app.childs') }}</th>
            <th>{{ trans('app.subtotal') }}</th>
            <th>{{ trans('app.discount') }}</th>
            <th></th>
            <th>{{ trans('app.total') }}</th>
            <th>{{ trans('app.pay') }}</th>
            <th>{{ trans('app.rest') }}</th>
            <th>{{ trans('app.expense') }}</th>
            <th>{{ trans('app.vendor') }}</th>
            <th>{{ trans('app.commission') }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @php
        $adults = 0;
        $childs = 0;
        $vl_subtotal = 0;
        $vl_discount = 0;
        $vl_total = 0;
        $vl_pay = 0;
        $vl_total = 0;
        $vl_rest = 0;
        $vl_expense = 0;
        $vl_comission = 0;

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
        <td class="text-right"><div style="float:left;">$</div> {{ number_format($e->vl_subtotal, 0, ',', '.') }}</td>
        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_discount, 0, ',', '.') }}</td>
        <td class="text-right">{{ number_format($e->vl_percent_discount, 0, ',', '.') }} %</td>
        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_total, 0, ',', '.') }}</td>
        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_pay, 0, ',', '.') }}</td>
        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_rest, 0, ',', '.') }}</td>
        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_expense, 0, ',', '.') }}</td>
        <td>{{ $e->user_name }}</td>
        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_comission, 0, ',', '.') }}</td>
        
        <td class="text-right">{{ number_format($e->vl_percent_comission, 0, ',', '.') }} %</td>
        
    </tr>

        @php
            $qtd += 1;
            $adults += $e->adults;
            $childs += $e->childs;
            $vl_subtotal += $e->vl_subtotal;
            $vl_discount += $e->vl_discount;
            $vl_total += $e->vl_total;
            $vl_pay += $e->vl_pay;
            $vl_rest += $e->vl_rest;
            $vl_expense += $e->vl_expense;
            $vl_comission += $e->vl_comission;
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
            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_subtotal, 0, ',', '.') }}</th>
            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_discount, 0, ',', '.') }}</th>
            <th class="text-right"></th>
            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_total, 0, ',', '.') }}</th>
            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_pay, 0, ',', '.') }}</th>
            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_rest, 0, ',', '.') }}</th>
            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_expense, 0, ',', '.') }}</th>
            <th></th>
            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_comission, 0, ',', '.') }}</th>
            <th class="text-right"></th>
        </tr>
    </tfoot>
</table>