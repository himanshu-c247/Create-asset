@forelse($stock->asset->transactions as $transaction)
@if(!empty($transaction->team->name))
<tr>
    <td class=text-center> {{ $loop->index + 1 }}</td>
    <td>{{ $stock->asset->name ?? 'NA' }}</td>
    <td class="text-capitalize">
        {{ $transaction->team->name ?? '' }}
    </td>
    <td class="text-center">{{ $transaction->stock }}</td>
    <td class="text-center">{{ dateFormat($transaction->created_at) ?? 'NA'}}</td>
</tr>
@endif
@empty
@endforelse