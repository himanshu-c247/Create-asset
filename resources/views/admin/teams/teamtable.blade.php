
@if (isset($teams))
    @forelse ($teams as $key => $team)
    <tr data-entry-id="{{ $team->id }}">
        <td class="text-center">
            {{ $loop->index + 1 }}
        </td>
        <td class="text-capitalize">
            {{ $team->name ?? 'NA' }}
        </td>
        <td class="text-center">
            @can('team_show')
                <a class="btn btn-sm btn-default" href="{{ route('admin.teams.show', $team->id) }}" data-toggle="tooltip" data-placement="top" title="View">
                    <i class="fa fa-eye"></i>
                </a>
            @endcan
    
            @can('team_edit')
                <a class="btn btn-sm btn-default" href="{{ route('admin.teams.edit', $team->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                    <i class="fa fa-edit"></i>
                </a>
            @endcan
    
            @can('team_delete')
                <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
