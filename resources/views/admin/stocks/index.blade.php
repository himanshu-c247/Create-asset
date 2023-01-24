@extends('layouts.admin')
@section('content')
{{-- @can('stock_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12 mt-2">
            
        </div>
    </div>
@endcan --}}
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ trans('cruds.stock.title_singular') }} {{ trans('global.list') }}</h4>
        @can('permission_create')
            <div class="d-flex justify-content-between">
                @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            </div>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Stock">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.stock.fields.asset') }}
                        </th>
                        @admin
                            <th>
                                Organization
                            </th>
                        @endadmin
                        <th class="text-center">
                            {{ trans('cruds.stock.fields.current_stock') }}
                        </th>
                        @user
                            <th class="text-center">
                                Add Stock
                            </th>
                            <th class="text-center">
                                Remove Stock
                            </th>
                        @enduser
                        <th class="text-center">
                            {{ trans('cruds.stock.fields.action') }}
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $key => $stock)
                        <tr>
                            <td class="text-capitalize">
                                {{ $stock->asset->name ?? '' }}
                            </td>
                            @admin
                                <td class="text-capitalize">
                                    {{ $stock->team->name }}
                                </td>
                            @endadmin
                            <td class="text-center">
                                {{ $stock->current_stock ?? '' }}
                            </td>
                            @user
                                <td class="text-center">
                                    <form action="{{ route('admin.transactions.storeStock', $stock->id) }}" method="POST" style="display: inline-block;" class="form-inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="add">
                                        <input type="number" name="stock" class="form-control form-control-sm col-8" min="">
                                        <input type="submit" class="btn btn-xs btn-danger text-right" value="ADD">
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.transactions.storeStock', $stock->id) }}" method="POST" style="display: inline-block;" class="form-inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="number" name="stock" class="form-control form-control-sm col-8" min="1">
                                        <input type="submit" class="btn btn-xs btn-danger" value="REMOVE">
                                    </form>
                                </td>
                            @enduser
                            <td class="text-center">
                                @can('stock_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.stocks.show', $stock->id) }}" data-toggle="tooltip" data-placement="top" title="View">
                                       <i class="fa fa-eye"></i>
                                    </a>
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

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'asc' ]],
    pageLength: 100,
      columnDefs: [{
          orderable: true,
          className: '',
          targets: 0
      }]
  });
  $('.datatable-Stock:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
