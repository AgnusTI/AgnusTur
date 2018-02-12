<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10 bg-info">
    <div class="">
    	<div class="row">

                <div class="col-md-4">
    				<label>{{ trans('app.name') }}:</label>
    				<span>{{ $entry->name }}</span>
    			</div>
                <div class="col-md-4">
    				<label>{{ trans('app.email') }}:</label>
    				<span>{{ $entry->email }}</span>
    			</div>
                <div class="col-md-4">
    				<label>{{ trans('app.phone') }}:</label>
    				<span>{{ $entry->phone }}</span>
    			</div>

        </div>
        <div class="row">
            <div class="col-md-3">
				<label>{{ trans('app.hotel') }}:</label>
				<span>{{ is_null($entry->hotel) ? '' : $entry->hotel->description }}</span>
			</div>
            <div class="col-md-3">
				<label>{{ trans('app.address') }}:</label>
				<span>{{ $entry->address }}</span>
			</div>
            <div class="col-md-2">
				<label>{{ trans('app.room_number') }}:</label>
				<span>{{ $entry->room_number }}</span>
			</div>
            <div class="col-md-4">
				<label>{{ trans('app.out_point') }}:</label>
				<span>{{ $entry->out_point }}</span>
			</div>
    	</div>
        <div class="row">
    		<div class="col-md-12">
				<label>{{ trans('app.note') }}:</label>
				<span>{{ $entry->note }}</span>
    		</div>
    	</div>
        <div class="row">
            <div class="col-md-2">
				<label>{{ trans('app.subtotal') }}:</label>
				<span class="text-right">$ {{ number_format($entry->vl_subtotal, 0, ',', '.') }}</span>
			</div>
            <div class="col-md-2">
				<label>{{ trans('app.discount') }}:</label>
				<span class="text-right">$ {{ number_format($entry->vl_discount, 0, ',', '.') }} ({{ number_format($entry->vl_percent_discount, 0, ',', '.') }} %)</span>
			</div>
            <div class="col-md-2">
				<label>{{ trans('app.total') }}:</label>
    			<span class="text-right">$ {{ number_format($entry->vl_total, 0, ',', '.') }}</span>
			</div>
            <div class="col-md-2">
				<label>{{ trans('app.pay') }}:</label>
    			<span class="text-right">$ {{ number_format($entry->vl_pay, 0, ',', '.') }}</span>
			</div>
            <div class="col-md-2">
				<label>{{ trans('app.rest') }}:</label>
    			<span class="text-right">$ {{ number_format($entry->vl_rest, 0, ',', '.') }}</span>
			</div>
    	</div>
        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
        <div class="row">
            <div class="col-md-6">
				<label>{{ trans('app.vendor') }}:</label>
				<span>{{ is_null($entry->user) ? '' : $entry->user->name }}</span>
			</div>
            <div class="col-md-6">
                <label>{{ trans('app.commission') }}:</label>
                <span class="text-right">$ {{ number_format($entry->vl_commission, 0, ',', '.') }} ({{ number_format($entry->vl_percent_commission, 0, ',', '.') }} %)</span>
            </div>

    	</div>
        @endif

    </div>
</div>
<div class="clearfix"></div>
