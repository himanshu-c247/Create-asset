
/* =================== Team Delete ======================= */
$(document).on('click', '.asset-delete', function () {
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
                        $('.asset-table').html(response.output)
                        toastr.success(response.message, 'Success!', {
                            timeOut: '4000',
                        })
                    }
                },
            })
        }
    })
})


/* =========== Asset Search =========== */
var searchFilter = function () {
    var form_action = $("#search-form").attr("action");
    $.ajax({
        url: form_action,
        type: "GET",
        dataType: 'json',
        data: $('#search-form').serialize(),
        success: function (data) {
            $('.asset-table').html(data.assetSearch);
        },
    });
}
$(document).on('keyup', '#search', function () {

    searchFilter();
});

/* =========== Asset Status Search =========== */
$(document).on('click','.status_confirm',function (event) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    Swal.fire({
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

