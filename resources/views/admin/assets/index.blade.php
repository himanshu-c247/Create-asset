@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>{{ trans('cruds.asset.title_singular') }} {{ trans('global.list') }}</h4>
            @can('asset_create')
                <div class="d-flex justify-content-between">
                    <a class="btn btn-primary" href="{{ route('admin.assets.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.asset.title_singular') }}
                    </a>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="10">
                                {{ trans('cruds.asset.fields.s_no') }}
                            </th>
                            <th>
                                {{ trans('cruds.asset.fields.name') }}
                            </th>
                            <th>
                                Category
                            </th>
                            <th class="text-center">
                                Image
                            </th>
                            <th class="text-center">
                                Type
                            </th>
                            <th class="text-center">
                                Status
                            </th>
                            {{-- <th ewi>
                            {{ trans('cruds.asset.fields.description') }}
                        </th> --}}
                            <th class="text-center" width="10">
                                Danger level
                            </th>
                            <th class="text-center">
                                {{ trans('cruds.asset.fields.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets as $key => $asset)
                            <tr data-entry-id="{{ $asset->id }}">
                                <td class="text-center">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="text-capitalize">
                                    {{ $asset->name ?? 'NA' }}
                                </td>
                                <td class="text-capitalize">
                                    {{ $asset->category->name ?? 'NA' }}
                                </td>
                                {{-- {{dd($asset->getFirstMediaUrl('avatar'))}} --}}
                                <td class="text-center">
                                    @if ($asset->getFirstMediaUrl('avatar') != null)
                                        <img src="{{ $asset->getFirstMediaUrl('avatar') }}" width="80px">
                                    @else
                                        <img src="{{ asset('no_image.png') }}" width="80px">
                                    @endif
                                </td>
                                <td class="text-capitalize">
                                    {{ $asset->type }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.assets.updateStatus', $asset->id) }}" id="status"
                                        method="POST">
                                        @csrf
                                        @method('post')
                                        <input type="hidden" name="status" value={{ $asset->status }}>
                                        <button class="btn btn-{{ $asset->status == '0' ? 'danger' : 'primary' }} status_confirm"
                                            type="submit">{{ $asset->status == '0' ? 'Inactive' : 'Active' }}</button>
                                    </form>
                                </td>
                                {{-- <td>
                                {{ucfirst(Str::limit($asset->description,25) ?? 'NA') }}
                            </td> --}}
                                <td class="text-center">
                                    {{ $asset->danger_level }}
                                </td>
                                <td class="text-center">
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
     
        $('.delete_confirm').click(function(event) {
             var form =  $(this).closest("form");
             var name = $(this).data("name");
             event.preventDefault();
             swal({
                 title: `Are you sure you want to delete this record?`,
                 text: "If you delete this, it will be gone forever.",
                 icon: "warning",
                 buttons: true,
                 dangerMode: true,
             })
             .then((willDelete) => {
               if (willDelete) {
                 form.submit();
               }
             });
         });
     
   </script>
    <script>
     
         $('.status_confirm').click(function(event) {
              var form =  $(this).closest("form");
              var name = $(this).data("name");
              event.preventDefault();
              swal({
                  title: `Are you sure you want to update this record?`,
                  icon: "warning",
                  buttons: true,
                  dangerMode: false,
              })
              .then((willUpdate) => {
                if (willUpdate) {
                  form.submit();
                }
              });
          });
      
    </script>
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('asset_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.assets.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                // order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            $('.datatable-Asset:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
