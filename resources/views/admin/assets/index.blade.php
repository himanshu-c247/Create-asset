@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
        <h4 class="title"><i class="fas fa-cogs mr-2"></i>{{ trans('cruds.asset.title_singular') }}</h4>
            @can('asset_create')
            <div class="filter-search-block d-flex justify-content-between">
                <form method="GET" id="search-form" action="{{route('admin.assets.index')}}" autocomplete="off">
                    <div class="row">
                        <div class="form-group search-group">
                            <div class="search-box">
                                <input type="text" id="search" name="search" value="{{ app('request')->input('search') }}" class="form-control" placeholder="Search...">
                                <i class="ri-search-line search-icon"></i>
                                <div class="search-via">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <a href=""><button type="button" class="reset-btn btn btn-primary ml-3" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-refresh text-white"></i></button></a> 
                <a href="{{ route('admin.assets.create') }}"><button class="btn btn-primary stock-model ml-2">{{ trans('global.add') }} {{ trans('cruds.asset.title_singular') }}</button></a>
            </div>     
       
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="10" style="vertical-align: middle;">
                                {{ trans('cruds.asset.fields.s_no') }}
                            </th>
                            <th style="vertical-align: middle;">
                                {{ trans('cruds.asset.fields.name') }}
                            </th>
                            <th style="vertical-align: middle;">
                                Category
                            </th>
                            <th class="text-center" style="vertical-align: middle;">
                                Image
                            </th>
                            <th class="text-center" style="vertical-align: middle;">
                                Type
                            </th>
                            <th class="text-center" style="vertical-align: middle;">
                                Status
                            </th>
                            {{-- <th ewi>
                            {{ trans('cruds.asset.fields.description') }}
                        </th> --}}
                            <th class="text-center" width="10" style="vertical-align: middle;">
                                Danger level
                            </th>
                            <th class="text-center" style="vertical-align: middle;">
                                {{ trans('cruds.asset.fields.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="asset-table">
                      @include('admin.assets.asset-table')
                    </tbody>
                </table>
                <div class="text-align-right">
                    {{$assets->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        /* =========== Leave History Search =========== */
        var searchFilter = function() {
            var form_action = $("#search-form").attr("action");
            $.ajax({
                url: form_action,
                type: "GET",
                dataType: 'json',
                data: $('#search-form').serialize(),
                success: function(data) {
                    $('.asset-table').html(data.assetSearch);
                },
            });
        }
        $(document).on('keyup', '#search', function() {
           
            searchFilter();
        });
    </script>
    
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
