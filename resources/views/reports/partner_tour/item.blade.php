@php
    $adults = 0;
    $childs = 0;

    $qtd = 0;

    $partnerId = -1;

    $vl_subtotal = 0;
    $vl_expense = 0;
    $vl_total = 0;
    $vl_partner = 0;
@endphp


@foreach ($items as $e)

    @if ($partnerId != $e->partner_id)

        @php
            $partnerId = $e->partner_id;
            $adults = 0;
            $childs = 0;
            $qtd = 0;

            $vl_subtotal = 0;
            $vl_expense = 0;
            $vl_total = 0;
            $vl_partner = 0;
        @endphp

        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><b>{{ $e->partner_name }}</b></h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-sortable table-bordered">
                    <thead>
                    <tr>

                        <th>Data</th>
                        <th>Passeio</th>
                        <th>Cliente</th>
                        <th>Adultos</th>
                        <th>Crianças</th>
                        <th>Subtotal</th>
                        <th>Despesas</th>
                        <th>Total</th>
                        <th>Valor parceiro</th>
                    </tr>
                    </thead>
                    <tbody>
    @endif

                    <tr>

                        <td>{{ Date::parse($e->dt_tour)->format(config('backpack.base.default_date_format'))  }}</td>
                        <td>{{ $e->item_name }}</td>
                        <td>{{ $e->name }}</td>
                        <td class="text-right">{{ $e->adults }}</td>
                        <td class="text-right">{{ $e->childs }}</td>
                        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_subtotal, 0, ',', '.') }}</td>
                        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_expense, 0, ',', '.') }}</td>
                        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_total, 0, ',', '.') }}</td>
                        <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_partner, 0, ',', '.') }}</td>

                    </tr>

    @php
        $qtd += 1;
        $adults += $e->adults;
        $childs += $e->childs;

        $vl_subtotal += $e->vl_subtotal;
        $vl_expense += $e->vl_expense;
        $vl_total += $e->vl_total;
        $vl_partner += $e->vl_partner;
    @endphp


    @if ($loop->last || $items[$loop->index + 1]->partner_id != $partnerId)

                    </tbody>
                    <tfoot>

                        <tr>
                            <th colspan="3">
                                Quantidade de passeios: {{ $qtd  }}
                            </th>
                            <th class="text-right">{{ $adults }}</th>
                            <th class="text-right">{{ $childs }}</th>
                            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_subtotal, 0, ',', '.') }}</th>
                            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_expense, 0, ',', '.') }}</th>
                            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_total, 0, ',', '.') }}</th>
                            <th class="text-right"><div style="float:left;">$</div>{{ number_format($vl_partner, 0, ',', '.') }}</th>
                        </tr>

                    </tfoot>
                </table>
            </div>
        </div>
    @endif
@endforeach




