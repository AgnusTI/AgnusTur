{{-- localized date using jenssegers/date --}}
<td data-order="{{ $entry->{$column['name']} }}" >
    <div style="text-align: right; padding-right: 20px;">
    @if (!empty($entry->{$column['name']}))
	{{ number_format($entry->{$column['name']}, 3, ',', '.') }}
    @endif
    </div>
</td>
