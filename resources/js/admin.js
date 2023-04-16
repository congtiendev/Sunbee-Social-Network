
//================================Confirm delete account====================================
$(document).ready(function () {
    $('.delete-account').on('click', function (e) {
        e.preventDefault();
        const id = $(this).data('id'); // Lấy ID người dùng từ thuộc tính data-user-id của nút xóa tương ứng
        swal({
            title: 'Bạn có chắc chắn muốn xóa tài khoản ?',
            text: 'Tất cả các dữ liệu liên quan đến tài khoản này sẽ bị xóa.! ',
            icon: 'warning',
            buttons: ['Hủy', 'Xóa'],
            dangerMode: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                swal({
                    title: 'Đã xóa tài khoản',
                    icon: 'success',
                    timer: 1500,
                }).then(function () {
                    window.location.href = 'http://localhost:88/sunbee/admin/delete-account/' + id;
                });
            } else {
                swal('Hủy xóa tài khoản', 'Tài khoản này sẽ không bị xóa.', 'info')
            }
        });
    });
});



