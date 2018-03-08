@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('app.sales') }}</div>
                </div>



                <div class="box-body">
                    <table class="table table-striped">
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
                            <th>{{ trans('app.commission') }}</th>
                            <th></th>
                        </tr>
                        @foreach (\App\Models\Sale::getSalesWithItems(null, null) as $e)
                        <tr>
                            <td>{{ Date::parse($e->dt_tour)->format(config('backpack.base.default_date_format'))  }}</td>
                            <td>{{ $e->hr_tour }}</td>
                            <td>{{ $e->item_name }}</td>
                            <td>{{ $e->name }}</td>
                            <td class="text-right">{{ $e->adults }}</td>
                            <td class="text-right">{{ $e->childs }}</td>
                            <td class="text-right">{{ number_format($e->vl_subtotal, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($e->vl_discount, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($e->vl_percent_discount, 0, ',', '.') }} %</td>
                            <td class="text-right">{{ number_format($e->vl_total, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($e->vl_pay, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($e->vl_rest, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($e->vl_expense, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($e->vl_comission, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($e->vl_percent_comission, 0, ',', '.') }} %</td>
                            
                        </tr>
                        @endforeach
                    </table>
                
                </div>
            </div>
        </div>
    </div>
@endsection
