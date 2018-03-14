@php

use Illuminate\Support\Facades\Auth;
use App\Models\Sale;

@endphp

@if (Auth::user()->isVendor())
    @if ($entry->status == Sale::SALE_STATUS__OPENED)
        @include('crud::buttons.update')
    @endif
@else
    @include('crud::buttons.update')
@endif