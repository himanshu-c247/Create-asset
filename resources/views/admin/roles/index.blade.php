@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}</h4>
        @can('role_create')
            <div class="d-flex justify-content-between">
                <a class="btn btn-primary" href="{{ route("admin.roles.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
                </a>
            </div>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th width="10" class="text-center">
                            {{ trans('cruds.role.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.role.fields.title') }}
                        </th>
                        <th width="60%">
                            {{ trans('cruds.role.fields.permissions') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.role.fields.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                        <tr>
                            <td>

                            </td>
                            <td class="text-center">
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $role->title ?? 'NA' }}
                            </td>
                            <td class="text-capitalize">
                                @foreach($role->permissions as $key => $item)
                                    <span class="badge badge-info">{{ str_replace('_',' ',$item->title) ?? 'NA' }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @can('role_show')
                                    <a class="btn btn-sm btn-default" href="{{ route('admin.roles.show', $role->id) }}" data-toggle="tooltip" data-placement="top" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endcan

                                @can('role_edit')
                                    <a class="btn btn-sm btn-default" href="{{ route('admin.roles.edit', $role->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan

                                @can('role_delete')
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('role_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    // order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection