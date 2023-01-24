@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ trans('cruds.permission.title_singular') }} {{ trans('global.list') }}</h4>
        @can('permission_create')
            <div class="d-flex justify-content-between">
                <a class="btn btn-success" href="{{ route("admin.permissions.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.permission.title_singular') }}
                </a>
            </div>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Permission">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th width="10" class="text-center">
                            {{ trans('cruds.permission.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.permission.fields.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr>
                            <td>

                            </td>
                            <td class="text-center">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="text-capitalize">
                                {{ str_replace('_',' ',($permission->title ?? 'Na')) }}
                            </td>
                            <td class="text-center">
                                @can('permission_show')
                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.permissions.show', $permission->id) }}" data-toggle="tooltip" data-placement="top" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endcan

                                @can('permission_edit')
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.permissions.edit', $permission->id) }}"data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan

                                @can('permission_delete')
                                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
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
@can('permission_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.permissions.massDestroy') }}",
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
    // order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  $('.datatable-Permission:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection