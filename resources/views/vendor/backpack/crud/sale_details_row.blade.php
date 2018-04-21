<div class="col-md-12 padding-10 bg-gray-light">
	<div class="bg-white sale-detail-row box box-success">
		<div class="box-header with-border m-b-20">
			<h3 class="box-title">Detalhes da venda</h3>
		</div>

		<div class="row">
			<div class="col-md-4 no-padding">
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.name') }}:</label>
					<span class="col-md-8">{{ $entry->name }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.email') }}:</label>
					<span class="col-md-8">{{ $entry->email }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.phone') }}:</label>
					<span class="col-md-8">{{ $entry->phone }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.hotel') }}:</label>
					<span class="col-md-8">{{ is_null($entry->hotel) ? '' : $entry->hotel->description }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.address') }}:</label>
					<span class="col-md-8">{{ $entry->address }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.room_number') }}:</label>
					<span class="col-md-8">{{ $entry->room_number }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.out_point') }}:</label>
					<span class="col-md-8">{{ $entry->out_point }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.note') }}:</label>
					<span class="col-md-8">{{ $entry->note }}</span>
				</div>
			</div>

			<div class="col-md-4 no-padding">
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.subtotal') }}:</label>
					<span class="col-md-8 text-right">$ {{ number_format($entry->vl_subtotal, 0, ',', '.') }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.discount') }}:</label>
					<span class="col-md-3 text-right">({{ number_format($entry->vl_percent_discount, 0, ',', '.') }} %)</span>
					<span class="col-md-5 text-right">$ {{ number_format($entry->vl_discount, 0, ',', '.') }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.total') }}:</label>
					<span class="col-md-8 text-right">$ {{ number_format($entry->vl_total, 0, ',', '.') }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.pay') }}:</label>
					<span class="col-md-8 text-right">$ {{ number_format($entry->vl_pay, 0, ',', '.') }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.rest') }}:</label>
					<span class="col-md-8 text-right">$ {{ number_format($entry->vl_rest, 0, ',', '.') }}</span>
				</div>
				<div class="col-md-12">
					<label class="col-md-4">{{ trans('app.payment') }}:</label>
					<span class="col-md-8">{{is_null($entry->payment) ? '' : $entry->payment->description }}</span>
				</div>
			</div>
			@if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
				<div class="col-md-4 no-padding">
					<div class="col-md-12">
						<div class="col-md-12">
							<label class="col-md-4">{{ trans('app.vendor') }}:</label>
							<span class="col-md-8">{{ is_null($entry->user) ? '' : $entry->user->name }}</span>
						</div>
						<div class="col-md-12">
							<label class="col-md-4">{{ trans('app.expense') }}:</label>
							<span class="col-md-8 text-right">$ {{ number_format($entry->expense, 0, ',', '.') }}</span>
						</div>
						<div class="col-md-12">
							<label class="col-md-4">{{ trans('app.net_total') }}:</label>
							<span class="col-md-8 text-right">$ {{ number_format($entry->net_total, 0, ',', '.') }}</span>
						</div>
						<div class="col-md-12">
							<label class="col-md-4">{{ trans('app.commission') }}:</label>
							<span class="col-md-3 text-right">({{ number_format($entry->vl_percent_commission, 0, ',', '.') }} %)</span>
							<span class="col-md-5 text-right">$ {{ number_format($entry->vl_commission, 0, ',', '.') }}</span>
						</div>
					</div>
				</div>
			@endif
		</div>
		<hr>

		<div class="row padding-10">
			<div class="col-xs-12 table-responsive ">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>{{ trans('app.item') }}</th>
							<th>{{ trans('app.dt_tour') }}</th>
							<th>{{ trans('app.hr_tour') }}</th>
							<th>{{ trans('app.adults') }}</th>
							<th>{{ trans('app.childs') }}</th>
							<th>{{ trans('app.subtotal') }}</th>
							<th>{{ trans('app.discount') }}</th>
							<th>{{ trans('app.total') }}</th>
							@if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
							<th>{{ trans('app.expense') }}</th>
							<th>{{ trans('app.commission') }}</th>
							<th>{{ trans('app.partner') }}</th>
							<th>{{ trans('app.vl_partner') }}</th>
							@endif
						</tr>
					</thead>
					<tbody>
						@foreach ($entry->items()->get() as $item)
						<tr>
							<td>{{ $item->item->name }}</td>
							<td>{{ Date::parse($item->dt_tour)->format(config('backpack.base.default_date_format')) }}</td>
							<td>{{ Date::parse($item->hr_tour)->format("H:m") }}</td>
							<td class="text-right">{{ $item->adults }}</td>
							<td class="text-right">{{ $item->childs }}</td>
							<td class="text-right">$ {{ number_format($item->vl_subtotal, 0, ',', '.') }}</td>
							<td>
								<span class="col-md-6 text-right">({{ number_format($entry->vl_percent_discount, 0, ',', '.') }} %)</span>
								<span class="col-md-6 text-right">$ {{ number_format($entry->vl_discount, 0, ',', '.') }}</span>
							</td>
							<td class="text-right">$ {{ number_format($item->vl_total, 0, ',', '.') }}</td>
							@if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
							<td class="text-right">$ {{ number_format($item->vl_expense, 0, ',', '.') }}</td>
							<td>
								<span class="col-md-6 text-right">({{ number_format($entry->vl_percent_commission, 0, ',', '.') }} %)</span>
								<span class="col-md-6 text-right">$ {{ number_format($entry->vl_commission, 0, ',', '.') }}</span>
							</td>
							<td>{{ is_null($item->partner) ? "" : $item->partner->name  }}</td>
							<td class="text-right">$ {{ number_format($item->vl_partner, 0, ',', '.') }}</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<!-- /.col -->
		</div>

	</div>
</div>
<div class="clearfix"></div>
