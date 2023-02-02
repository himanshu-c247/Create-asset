@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>{{ trans('cruds.transaction.title_singular') }} {{ trans('global.list') }}</h4>
        <div class="filter-search-block d-flex justify-content-between">
            <form method="GET" id="search-form" action="{{route('admin.transactions.index')}}" autocomplete="off">
                <div class="row">
                    <div class="form-group col-md-6">
                        <select class="form-control" id="category" name="category">
                            <option disabled selected>Search By Category</option>
                            <option value="">All</option>
                                @isset($categories)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                    @endforeach
                                @endisset
                        </select>
                    </div>
                    <div class="form-group search-group col-md-6">
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
        </div>
    </div>

    <div class="card-body">
       
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">
                            {{ trans('cruds.transaction.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.transaction.fields.asset') }}
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            {{ trans('cruds.transaction.fields.user') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.transaction.fields.stock') }}
                        </th>
                        <th class="text-center">
                           Date
                        </th>
                    </tr>
                </thead>
                <tbody class="transaction-table">
                    @include('admin.transactions.transactiontable')
                </tbody>
            </table>
            {{$transactions->links()}}
            {{-- <div class="text-align-left">
            </div> --}}
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent

<script>
    /* =========== Leave History Search =========== */
var searchFilter = function () {
    var form_action = $("#search-form").attr("action");
    $.ajax({
        url: form_action,
        type: "GET",
        dataType: 'json',
        data: $('#search-form').serialize(),
        success: function (data) {
            $('.transaction-table').html(data.transactionSearch);
        },
    });
}
$(document).on('keyup', '#search', function () {
    searchFilter();
});

$(document).on('change', '#category', function () {
    searchFilter();
});

</script>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    // order: [[ 0, 'ase' ]],
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
