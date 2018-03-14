@php

    use Illuminate\Support\Facades\Auth;
    use App\Models\Sale;

@endphp

@if (Auth::user()->isVendor())
    @if ($entry->status == Sale::SALE_STATUS__OPENED)
        @include('crud::buttons.delete')
    @endif
@else
    @include('crud::buttons.delete')
@endif