@php
    $adults = 0;
    $childs = 0;

    $qtd = 0;

    $itemId = 0;
@endphp


@foreach ($items as $e)

    @if ($itemId != $e->item_id)

        @php
            $itemId = $e->item_id;
            $adults = 0;
            $childs = 0;
            $qtd = 0;
        @endphp

        <div class="box box-success box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><b>{{ $e->item_name }}</b></h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-sortable table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>{{ trans('app.dt_tour') }}</th>
                        <th>{{ trans('app.vendor') }}</th>
                        <th>{{ trans('app.hr_tour') }}</th>
                        <th>{{ trans('app.adults') }}</th>
                        <th>{{ trans('app.childs') }}</th>
                        <th>{{ trans('app.client') }}</th>

                        <th>{{ trans('app.hotel') }}</th>
                        <th>{{ trans('app.room') }}</th>

                        <th>{{ trans('app.pay') }}</th>
                        <th>{{ trans('app.rest') }}</th>
                        <th>{{ trans('app.payment') }}</th>
                        <th>{{ trans('app.partner') }}</th>
                        <th>{{ trans('app.status') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
    @endif

                        <tr>
                            <td>
                                @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editSaleItem"
                                        data-sale-item-id="{{ $e->id }}"
                                        data-hr-tour="{{ $e->hr_tour }}"
                                        data-partner-id="{{ $e->partner_id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                @endif
                            </td>
                            <td>{{ Date::parse($e->dt_tour)->format(config('backpack.base.default_date_format'))  }}</td>
                            <td>{{ $e->user_name }}</td>
                            <td>{{ Date::parse("0000-00-00 " . $e->hr_tour)->format('H:i') }}</td>
                            <td class="text-right">{{ $e->adults }}</td>
                            <td class="text-right">{{ $e->childs }}</td>
                            <td>{{ $e->name }}</td>

                            <td>{{ $e->hotel_name . ' (' . $e->hotel_address . ')' }}</td>
                            <td>{{ $e->room_number }}</td>

                            <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_pay, 0, ',', '.') }}</td>
                            <td class="text-right"><div style="float:left;">$</div>{{ number_format($e->vl_rest, 0, ',', '.') }}</td>
                            <td>{{ $e->payment_description }}</td>
                            <td>{{ $e->partner_name }}</td>
                            <td>{{ isset($e->sale_status) ? \App\Models\Sale::getSaleStatus()[$e->sale_status] : "" }}</td>

                            <td>
                                @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
                                <a href="/public/admin/sale/{{ $e->sale_id }}/edit" class="btn btn-success" target="_blank"><i class="fa fa-external-link"></i> {{ trans('app.open')  }}</a>
                                @endif
                            </td>
                        </tr>

                @php
                    $qtd += 1;
                    $adults += $e->adults;
                    $childs += $e->childs;
                @endphp


    @if ($loop->last || $items[$loop->index + 1]->item_id != $itemId)

                    </tbody>
                    <tfoot>

                    @include('reports.logistics.item_tot',
                        ['qtd' => $qtd,
                         'adults' => $adults,
                         'childs' => $childs,
                         'e' => $e])

                    </tfoot>
                </table>
            </div>
        </div>
    @endif
@endforeach




