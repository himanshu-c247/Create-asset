//============= Team-Add-Model ================//
// $(document).on('click', '.user-model', function () {
//   alert('asdasdasd');
//     var id = '#createUserModal';
//     if ($('.modal').hasClass('user-modal-create')) {
//       $(id).modal('show')
//     } else {
//       var url = $(this).attr('data-url')
//       $.ajax({
//         url: url,
//         method: 'get',
//         success: function (response) {
//           if (response.status == 'success') {
//             $('.model-render').html(response.output);
//             $(id).modal('show');
//           }
//         },
//       })
//     }
//   });
  
  

/* =================== Team Delete ======================= */
$(document).on('click', '.user-delete', function () {
  Swal.fire({
    title: 'Are you sure?',
    text: 'Once deleted, you will not be able to revert this Team!',
    icon: 'error',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Confirm it!',
  }).then((result) => {
    if (result.isConfirmed) {
      var url = $(this).attr('data-url')
      method = 'POST'
      $.ajax({
        url: url,
        method: method,
        data: {
          _method: 'DELETE',
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
          if (response.status == 'success') {
            $('.user-table').html(response.output)
            toastr.success(response.message, 'Success!', {
              timeOut: '4000',
            })
          }
        },
      })
    }
  })
})

 /* ===========  User Search =========== */
 var searchFilter = function() {
  var form_action = $("#search-form").attr("action");
  $.ajax({
      url: form_action,
      type: "GET",
      dataType: 'json',
      data: $('#search-form').serialize(),
      success: function(data) {
          $('.user-table').html(data.userSearch);
      },
  });
}
$(document).on('keyup', '#search', function() {

  searchFilter();
});