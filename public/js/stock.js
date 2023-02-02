//============= Stock-Add-Model ================//
$(document).on('click', '.stock-model', function () {
  var id = '#addStockModal';
  if ($('.modal').hasClass('modal-create')) {
    $(id).modal('show')
  } else {
    var url = $(this).attr('data-url')
    $.ajax({
      url: url,
      method: 'get',
      success: function (response) {
        if (response.status == 'success') {
          $('.model-render').html(response.output);
          $(id).modal('show');
        }
      },
    })
  }
});

//============= Stock-store ================//
$(document).on('click', '.store-stock', function () {
  var url = $(this).attr('data-url');
  (method = 'POST')
  $.ajax({
    url: url,
    method: method,
    data: $('#addStockForm').serialize(),
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function (response) {
      if (response.status == 'success') {
        $('#addStockForm')[0].reset()
        $('.stock-table').html(response.output)
        $('.btn-close').trigger('click')
        toastr.success(response.message, 'Success!', {
          timeOut: '4000',
        })
        $('.error').html('')
      }
    },
    error: function (response) {
      var errorResponse = $.parseJSON(response.responseText);
      $.each(errorResponse.errors, function (index, value) {
        $('.' + index + '-error').html(value)
        $('.' + index + '-error').show()
      })
    }
  })
})

//============= Stock-Edit-Model ================//
$(document).on('click', '.edit-stock', function () {
  var id = '#editStockModal';
  var url = $(this).attr('data-url')
  $.ajax({
    url: url,
    method: 'get',
    success: function (response) {
      if (response.status == 'success') {
        $('.model-render').html(response.output);
        $(id).modal('show');
      }
    },
  })
})

//============= Stock-Update ================//
$(document).on('click', '.update-stock', function () {
  var url = $(this).attr('data-url')
    method = 'POST'
    $.ajax({
      url: url,
      method: method,
      data: $('#editStockForm').serialize(),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (response) {
        if (response.status == 'error') {
          $.each(response.error, function (index, value) {
            console.log(index)
            $('.' + index + '-error').html(value)
            $('.' + index + '-error').show()
          })
        } else if (response.status == 'success') {
          $('#editStockForm')[0].reset()
          $('.stock-table').html(response.output)
          $('.btn-close').trigger('click')
          toastr.success(response.message, 'Success!', {
            timeOut: '4000',
          })

          $('.error').html('')
        }
      },

    })
})

//============= Assign-Stock-Model ================//

$(document).on('click', '.assign-stock-model', function () {
  var id = '#assignStockModal';
    var url = $(this).attr('data-url')
    $.ajax({
      url: url,
      method: 'get',
      success: function (response) {
        if (response.status == 'success') {
          $('.model-render').html(response.output);
          $(id).modal('show');
        }
      },
    })
  
});

//============= Assign-Stock ================//
$(document).on('click', '.assign-stock', function () {
  var url = $(this).attr('data-url');
  (method = 'POST')
  $.ajax({
    url: url,
    method: method,
    data: $('#assignStockForm').serialize(),
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function (response) {
      console.log(response.message);
     
      if (response.status == 'error') {
        $('.' + 'current_stock' + '-error').html(response.message)
        $('.' + 'current_stock' + '-error').show()
      }else if (response.status == 'success') {
        $('#assignStockForm')[0].reset()
        $('.stock-table').html(response.output)
        $('.btn-close').trigger('click')
        toastr.success(response.message, 'Success!', {
          timeOut: '4000',
        })
        $('.error').html('')
      }
    },
    error: function (response) {
      var errorResponse = $.parseJSON(response.responseText);
      $.each(errorResponse.errors, function (index, value) {
        $('.' + index + '-error').html(value)
        $('.' + index + '-error').show()
      })
    }
  })
})



