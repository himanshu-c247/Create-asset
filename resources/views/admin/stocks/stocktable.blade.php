@if (isset($stocks))
    @forelse($stocks as $key => $stock)
        <tr>
            <td class="text-center">
                {{ $loop->index + 1 }}
            </td>
            <td class="text-capitalize">
                {{ $stock->asset->name ?? 'NA' }}
            </td>
            <td class="text-capitalize">
                {{ $stock->asset->category->name ?? 'NA' }}
            </td>
            <td class="text-center">
                {{ $stock->current_stock ?? 'NA' }}
            </td>
            <td class="text-capitalize text-center">
                {{ $stock->asset->unit ?? 'NA' }}
            </td>
            @user
                <td class="text-center">
                    <form style="display: inline-block;" id="removeStockForm" class="form-inline">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="action" value="remove">
                        <input type="text" name="stock" class="form-control form-control-sm col-7 stock-value"
                            min="1"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                            onkeydown="{{ $stock->asset->unit == 'quantity' ? 'if(event.key==="."){event.preventDefault();}' : ' ' }}">
                        <button type="button" class="btn btn-xs btn-primary remove-stock"
                            data-url="{{ route('admin.transactions.storeStock', $stock->id) }}"
                            data-current-stock={{ $stock->current_stock }}>REMOVE</button>
                    </form>
                </td> 
            @enduser    
                <td class="text-center">
                @admin
                    <a class="btn btn-xs btn-default assign-stock-model"
                        data-url="{{ route('admin.stocks.assignStock', $stock->id) }}" data-toggle="tooltip"
                        data-placement="top" title="Assign Stock">
                        <i class="fa fa-cogs"></i>
                    </a>
                    @can('stock_show')
                        <a class="btn btn-xs btn-default edit-stock" data-url="{{ route('admin.stocks.edit', $stock->id) }}"
                            data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                    @endcan
                @endadmin
                @can('stock_show')
                    <a class="btn btn-xs btn-default" href="{{ route('admin.stocks.show', $stock->id) }}"
                        data-toggle="tooltip" data-placement="top" title="Stock History">
                        <i class="fa fa-eye"></i>
                    </a>
                @endcan
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
