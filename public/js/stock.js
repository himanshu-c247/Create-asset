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
          $('.' + 'current_stock' + '-error').html(response.message)
          $('.' + 'current_stock' + '-error').show()
        }else if (response.status == 'success') {
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

//============= Assign-Stock-checked-value ================//
$(document).on('change', '.checked', function () {
        if($(this).val() == '2') {
         $('.store-check').removeClass('d-none');           
    }

    else {
         $('.store-check').addClass('d-none');   
    }  
});


    /* ===========  stock Search =========== */
    var searchFilter = function() {
        var form_action = $("#search-form").attr("action");
        $.ajax({
            url: form_action,
            type: "GET",
            dataType: 'json',
            data: $('#search-form').serialize(),
            success: function(data) {
                $('.stock-table').html(data.stockSearch);
            },
        });
    }
    $(document).on('keyup', '#search', function() {
        searchFilter();
    });

    /* =========== remove stock =========== */

    $(documnet).on('click','.remove-stock',function() {
        var url = $(this).attr('data-url');
        var value = $(this).parents("tr").find('.stock-value').val();
        var currentStock = $(this).attr('data-current-stock');
        if (currentStock - value < 0) {
            Swal.fire({
                title: 'Opss...',
                text: "Not enough items in stock!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Inform Admin!'
            })
        }else {
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#removeStockForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    toastr.success(data.message, 'Success!', {
                            timeOut: '4000',
                        }),
                        location.reload();
                }
            })
        }
    });




