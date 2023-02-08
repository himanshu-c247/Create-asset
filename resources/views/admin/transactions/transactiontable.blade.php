@if (isset($transactions))
    @forelse ($transactions as $key => $transaction)
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
                {{ $transaction->team->name ?? 'NA' }}
            </td>
            <td class="text-center">
                {{ $transaction->stock ?? 'NA' }}
            </td>
            <td class="text-center">
                {{ dateFormat($transaction->created_at) ?? 'NA' }}
            </td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="12">
                <h4>No Data Found</h4>
            </td>
        </tr>
    @endforelse
@else
    <tr>
        <td colspan="12">
            <h4>No Data Found</h4>
        </td>
    </tr>
@endif
