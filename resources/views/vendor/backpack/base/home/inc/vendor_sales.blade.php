@php
    $totalSales = 0.00;

    foreach ($items as $e) {
        $totalSales += $e->vl_total;
    }
@endphp

@foreach ($items as $e)

    @php

        $percent = $e->vl_total * 100 / $totalSales;

    @endphp

    <div class="progress-group">
        <span class="progress-text">{{ $e->user_name  }}</span>
        <span class="progress-number"><b>$ {{ number_format($e->vl_total, 0, ',', '.') }}</b> / {{ number_format($percent, 0, ',', '.') }}%</span>

        <div class="progress sm">
            <div class="progress-bar progress-bar-green" style="width: {{ $percent  }}%"></div>
        </div>
    </div>

@endforeach


<p class="text-right">
    <strong>{{ trans('app.total_sales')  }}: $ {{ number_format($totalSales, 0, ',', '.') }}</strong>
</p>