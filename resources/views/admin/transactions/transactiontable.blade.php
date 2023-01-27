@foreach ($transactions as $key => $transaction)
    <tr>
        <td class="text-center">
            {{ $loop->index + 1 }}
        </td>

        <td class="text-capitalize">
            {{ $transaction->asset->name ?? 'NA' }}
        </td>
        <td class="text-capitalize">
            {{ $transaction->asset->category->name ?? 'NA' }}
        </td>
        <td class="text-capitalize">
            {{ $transaction->user->name ?? 'NA' }}
        </td>
        <td class="text-center">
            {{ $transaction->stock ?? 'NA' }}
        </td>
        <td class="text-center">
            {{ dateFormat($transaction->created_at) ?? 'NA' }}
        </td>
    </tr>
@endforeach
