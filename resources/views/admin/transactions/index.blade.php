@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ trans('cruds.transaction.title_singular') }} {{ trans('global.list') }}</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Transaction">
                <thead>
                    <tr>
                        <th class="text-center">
                            {{ trans('cruds.transaction.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.transaction.fields.asset') }}
                        </th>
                        <th>
                            {{ trans('cruds.transaction.fields.user') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.transaction.fields.stock') }}
                        </th>
                        <th class="text-center">
                            Created at
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $key => $transaction)
                        <tr>
                            <td class="text-center">
                                {{ $loop->index + 1 }}
                            </td>
                           
                            <td class="text-capitalize">
                                {{ $transaction->asset->name ?? 'NA' }}
                            </td>
                            <td class="text-capitalize">
                                {{ $transaction->user->name ?? 'NA' }}
                            </td>
                            <td class="text-center">
                                {{ $transaction->stock ?? 'NA' }}
                            </td>
                            <td class="text-center">
                                {{ $transaction->created_at ?? 'NA'}}
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
    // order: [[ 0, 'desc' ]],
    pageLength: 100,
      columnDefs: [{
          orderable: true,
          className: '',
          targets: 0
      }]
  });
  $('.datatable-Transaction:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
