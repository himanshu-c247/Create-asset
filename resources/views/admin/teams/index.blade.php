@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="title"><i class="fas fa-users mr-2" data-feather="phone"></i>{{ trans('cruds.team.title_singular') }}</h4>
        @can('team_create')
        <div class="filter-search-block d-flex justify-content-between">
            <form method="GET" id="search-form" action="{{route('admin.teams.index')}}" autocomplete="off">
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
            <a href="{{ route("admin.teams.create") }}"><button class="btn btn-primary stock-model ml-2">{{ trans('global.add') }} {{ trans('cruds.team.title_singular') }}</button></a>
        </div>    
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10" class="text-center">
                            {{ trans('cruds.team.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.team.fields.name') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.team.fields.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="team-table">
                   @include('admin.teams.teamtable')
                </tbody>
            </table>
            <div class="text-align-right">
                {{$teams->links()}}
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
                $('.team-table').html(data.teamSearch);
            },
        });
    }
    $(document).on('keyup', '#search', function() {
       
        searchFilter();
    });
</script>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('team_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.teams.massDestroy') }}",
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
  $('.datatable-Team:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection