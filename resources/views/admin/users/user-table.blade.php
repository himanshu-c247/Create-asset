
@if (isset($users))
    @forelse ($users as $key => $user)
    <tr>
   
        <td class="text-center">
            {{ $loop->index + 1 }}
        </td>
        <td class="text-capitalize">
            {{ $user->name ?? 'NA' }}
        </td>
        <td class="text-capitalize">
            {{ $user->email ?? 'NA' }}
        </td>
        <td class="text-capitalize">
            {{$user->segment->name ?? 'NA' }}
        </td>
        <td class="text-center">
            @foreach($user->roles as $key => $item)
                <span class="badge  badge-info">{{ $item->title }}</span>
            @endforeach
        </td>
        <td class="text-center">
            @can('user_show')
                <a class="btn btn-sm btn-default" href="{{ route('admin.users.show', $user->id) }}"data-toggle="tooltip" data-placement="top" title="View">
                    <i class="fa fa-eye"></i>
                </a>
            @endcan
    
            @can('user_edit')
                <a class="btn btn-sm btn-default" href="{{ route('admin.users.edit', $user->id) }}"data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="fa fa-edit"></i>
                </a>
            @endcan
    
            @can('user_delete')
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>                                       
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