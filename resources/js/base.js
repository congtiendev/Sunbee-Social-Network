
const API_URL = "http://localhost:88/Sunbee-Social-Network/";

//==========================Loading page=================================================
$(window).on('load', function () {
    $('#loader-overlay').fadeOut('slow');
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
                    window.location.href = API_URL + 'admin/delete-avatar/' + id;
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

function previewMultipleImage(file, previewElementId, callback) {
    const previewElement = document.querySelector(`${previewElementId}`);
    previewElement.innerHTML = "";
    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            const img = document.createElement("img");
            img.classList.add("w-full", "h-40", "object-cover", "rounded-md");
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

const postsMediaUpload = document.querySelector("#posts__media-uploads");
if (postsMediaUpload) {
    postsMediaUpload.addEventListener("change", function (event) {
        const files = event.target.files;
        const previewMedia = document.querySelector("#posts__media-preview");
        previewMedia.innerHTML = "";
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            previewMultipleImage(file, "#posts__media-preview", function (img) {
                previewMedia.appendChild(img);
            });
        }
    });
}

// ===================================Preview text=====================================//
function previewText(text, previewElementId) {
    const previewElement = document.querySelector(`#${previewElementId}`);
    previewElement.innerHTML = "";
    if (text) {
        const p = document.createElement("p");
        p.innerHTML = text;
        previewElement.appendChild(p);
    }
}

const postsContent = document.querySelector("#posts__content");
if (postsContent) {
    postsContent.addEventListener("keyup", function (event) {
        const text = event.target.value;
        previewText(text, "posts__content-preview");
    });
}

/* ===================================List post image================================= */

if (document.querySelector('.sliderPosts')) {
    var swiper = new Swiper(".sliderPosts", {
        effect: "cards",
        grabCursor: true
    });
}

/* ====================================Like post====================================*/

$(document).ready(function () {
    $('.like__post-btn').on('click', function () {
        const postID = $(this).data('post-id');
        const userID = $(this).data('user-id');
        const likePostCount = $(this).closest(".post__actions").find(".like__post-count");;
        let count = parseInt(likePostCount.text());
        console.log(count);
        console.log(postID);
        console.log(userID);

        if ($(this).hasClass("active")) {
            count -= 1;
            $(this).removeClass("active");
            unlikePost(postID, userID);
        } else {
            count += 1;
            $(this).addClass("active");
            likePost(postID, userID);
        }
        likePostCount.text(count);
    });

    function likePost(postID, userID) {
        $.ajax({
            url: API_URL + 'admin/like-post',
            type: 'POST',
            data: {
                postID: postID,
                userID: userID
            },
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function unlikePost(postID, userID) {
        $.ajax({
            url: API_URL + 'admin/unlike-post',
            type: 'POST',
            data: {
                postID: postID,
                userID: userID
            },
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});

//==============================================Save post==========================================

$(document).ready(function () {
    $('.save__post-btn').on('click', function () {
        const postID = $(this).data('post-id');
        const userID = $(this).data('user-id');
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            unSavePost(postID, userID);
            swal("Đã bỏ lưu bài viết", "", "success");
        } else {
            $(this).addClass("active");
            savePost(postID, userID);
            swal("Bài viết đã được lưu", "", "success");
        }
    });

    function savePost(postID, userID) {
        $.ajax({
            url: API_URL + 'admin/save-post',
            type: 'POST',
            data: {
                postID: postID,
                userID: userID
            },
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function unSavePost(postID, userID) {
        $.ajax({
            url: API_URL + 'admin/unsave-post',
            type: 'POST',
            data: {
                postID: postID,
                userID: userID
            },
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});

