
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

//================================Confirm delete avatar====================================
$(document).ready(function () {
    $('.delete-avatar').on('click', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        swal({
            title: 'Bạn có chắc chắn muốn xóa ảnh đại diện ?',
            text: 'Ảnh đại diện của tài khoản này sẽ bị xóa.! ',
            icon: 'warning',
            buttons: ['Hủy', 'Xóa'],
            dangerMode: true,
        }).then(function (isConfirm) {
            if (isConfirm) {
                swal({
                    title: 'Đã xóa ảnh đại diện',
                    icon: 'success',
                    timer: 1500,
                }).then(function () {
                    window.location.href = 'http://localhost:88/sunbee/admin/delete-avatar/' + id;
                });
            } else {
                swal('Hủy xóa ảnh đại diện', 'Ảnh đại diện của tài khoản này sẽ không bị xóa.', 'info')
            }
        });
    });
});
//================================Preview image================================
function previewImage(file, previewElementId, callback) {
    const previewElement = document.querySelector(`#${previewElementId}`);
    previewElement.innerHTML = "";
    if (file) {
        if (!file.type.startsWith("image/")) {
            swal("File bạn chọn không phải là ảnh", "", "error");
            return;
        }
        const reader = new FileReader();
        reader.onload = function () {
            const img = document.createElement("img");
            img.src = reader.result;
            if (callback) {
                callback(img);
            } else {
                previewElement.appendChild(img);
            }
        };
        reader.readAsDataURL(file);
    }
}

const avatar = document.querySelector("#upload-avatar");
if (avatar) {
    avatar.addEventListener("change", function (event) {
        const file = event.target.files[0];
        previewImage(file, "avatar-preview", function (img) {
            const previewElement = document.querySelector("#avatar-preview");
            previewElement.innerHTML = "";
            previewElement.appendChild(img);

        });
    });
}
const coverPhoto = document.querySelector("#upload-cover-photo");
if (coverPhoto) {
    coverPhoto.addEventListener("change", function (event) {
        const file = event.target.files[0];
        previewImage(file, "cover-photo-preview", function (img) {
            const previewElement = document.querySelector(
                "#cover-photo-preview"
            );
            previewElement.innerHTML = "";
            previewElement.appendChild(img);
        });
    });
}


if (document.querySelector('.sliderPosts')) {
    var swiper = new Swiper(".sliderPosts", {
        effect: "cards",
        grabCursor: true
    });
}
