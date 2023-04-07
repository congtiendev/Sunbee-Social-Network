function toggleDropdown(button, dropdown) {
    if (button && dropdown) {
        button.addEventListener('click', function () {
            dropdown.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    }
}

// Show/hide the dropdown for the user's account information
toggleDropdown(
    document.querySelector('.btn-account'),
    document.querySelector('.dropdown-account')
);
// Show/hide the dropdown for the messages
toggleDropdown(
    document.querySelector('.btn-messages'),
    document.querySelector('.dropdown-messages')
);
// Show/hide the notification dropdown and its options notifications
toggleDropdown(
    document.querySelector('.btn-notification'),
    document.querySelector('.dropdown-notification')
);

// Show/hide the mobile menu
toggleDropdown(
    document.querySelector('.btn-menu-mobile'),
    document.querySelector('.menu-mobile')
);

//================================Confirm delete account====================================
$(document).ready(function () {
    $('.delete-account').on('click', function (e) {
        e.preventDefault();
        const user_id = $(this).data('id'); // Lấy ID người dùng từ thuộc tính data-user-id của nút xóa tương ứng
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
                    window.location.href = 'http://localhost:88/sunbee/delete-account/' + user_id;
                });
            } else {
                swal('Hủy xóa tài khoản', 'Tài khoản này sẽ không bị xóa.', 'info')
            }
        });
    });
});

//================================Show notification when create new account====================================


