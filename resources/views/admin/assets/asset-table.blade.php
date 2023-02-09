
@if (isset($assets))
    @forelse ($assets as $key => $asset)
    <tr style="vertical-align: middle;" data-entry-id="{{ $asset->id }}">
        <td class="text-center" style="vertical-align: middle;" >
            {{ $loop->index + 1 }}
        </td>
        <td class="text-capitalize" style="vertical-align: middle;">
            {{ $asset->name ?? 'NA' }}
        </td>
        <td class="text-capitalize" style="vertical-align: middle;">
            {{ $asset->category->name ?? 'NA' }}
        </td>
        
        <td class="text-center">
            @if ($asset->getFirstMediaUrl('avatar') != null)
                <img src="{{ $asset->getFirstMediaUrl('avatar') }}" width="60px">
            @else
                <img src="{{ asset('no_image.png') }}" width="60px">
            @endif
        </td>
        <td class="text-capitalize" style="vertical-align: middle;">
            {{ $asset->type }}
        </td>
        <td class="text-center" style="vertical-align: middle;">
            <form action="{{ route('admin.assets.updateStatus', $asset->id) }}" id="status"
                method="POST">
                @csrf
                @method('post')
                <input type="hidden" name="status" value={{ $asset->status }}>
                
                <a class="status_confirm"
                    type="button"><span class="badge badge-{{ $asset->status == '0' ? 'danger' : 'primary' }}">{{ $asset->status == '0' ? 'Inactive' : 'Active' }}</span></a>
            </form>
        </td>
        {{-- <td>
        {{ucfirst(Str::limit($asset->description,25) ?? 'NA') }}
    </td> --}}
        <td class="text-center" style="vertical-align: middle;">
            {{ $asset->danger_level }}
        </td>
        <td class="text-center" style="vertical-align: middle;">
            @can('asset_show')
                <a class="btn btn-sm btn-default" href="{{ route('admin.assets.show', $asset->id) }}"
                    data-toggle="tooltip" data-placement="top" title="View">
                    <i class="fa fa-eye"></i>
                </a>
            @endcan
    
            @can('asset_edit')
                <a class="btn btn-sm btn-default" href="{{ route('admin.assets.edit', $asset->id) }}"
                    data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="fa fa-edit"></i>
                </a>
            @endcan
    
            @can('asset_delete')
                <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" style="display: inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="button" class="btn btn-sm btn-default delete_confirm" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                </form>
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