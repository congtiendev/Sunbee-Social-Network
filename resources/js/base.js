
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

//================================Preview media================================

const uploadedFiles = []; // Mảng lưu trữ các tệp đã tải lên
function previewMultiple(file, previewElementId, callback) {
    const previewElement = document.querySelector(previewElementId);
    const previewContainer = document.createElement("div");
    previewContainer.classList.add("preview-container", "relative");
    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            const mediaElement = document.createElement(file.type.startsWith("video/") ? "video" : "img");
            mediaElement.classList.add("w-full", "h-40", "object-cover", "rounded-md", "relative");
            mediaElement.src = reader.result;
            if (file.type.startsWith("video/")) {
                mediaElement.controls = true;
            }
            const removeButton = document.createElement("button");
            removeButton.classList.add("remove-btn", "absolute", "top-0", "right-0", "cursor-pointer");
            removeButton.innerHTML = `<img src="${API_URL}resources/images/icon/remove-icon.png" alt="close" class="w-7 h-7">`;
            removeButton.addEventListener("click", function () {
                // Xóa tệp khỏi mảng uploadedFiles
                const index = uploadedFiles.indexOf(file);
                if (index !== -1) { // Nếu tệp tồn tại trong mảng uploadedFiles
                    uploadedFiles.splice(index, 1); // Xóa tệp khỏi mảng uploadedFiles
                }
                previewContainer.remove();
            });
            previewContainer.appendChild(mediaElement);
            previewContainer.appendChild(removeButton);
            previewElement.appendChild(previewContainer);

            // Thêm tệp vào mảng uploadedFiles
            uploadedFiles.push(file);

            if (callback) {
                callback(previewContainer);
            }
        };
        reader.readAsDataURL(file);
    }
}

const postMediaUpload = document.getElementById("post_media");
if (postMediaUpload) {
    postMediaUpload.addEventListener("change", function () {
        const files = postMediaUpload.files;
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!uploadedFiles.includes(file)) {
                    const previewMedia = "#post__media-preview";
                    previewMultiple(file, previewMedia);
                }
            }
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
// ===================================CREATE POSTS=====================================//

$(document).ready(function () {
    $('#create__post-btn').on('click', function (event) {
        event.preventDefault();
        const user_id = $(this).data('user-id');
        const post_content = $('#post_content').val();
        const post_media = $('#post_media').prop('files');
        if (post_media.length == 0 && post_content.length == 0) {
            swal('Bài viết của bạn không có nội dung và hình ảnh', '', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('user_id', user_id);
        formData.append('post_content', post_content);
        formData.append('post_media', post_media);
        for (let i = 0; i < post_media.length; i++) {
            formData.append('post_media[]', post_media[i]);
            console.log(post_media[i]);
        }

        $.ajax({
            url: API_URL + 'admin/posts/create',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                swal('Bài viết đã được đăng ', '', 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            },
            error: function (error) {
                console.log(error);
                swal('Đã có lỗi xảy ra', '', 'error');
            }
        });
    });
});

/* ===================================Slider Media================================= */

if (document.querySelector('.sliderPosts')) {
    var swiper = new Swiper(".sliderPosts", {
        effect: "cards",
        grabCursor: true
    });
}
if (document.querySelector('.sliderDetailsPosts')) {
    var swiper = new Swiper(".sliderDetailsPosts", {
        grabCursor: true,
        effect: "creative",
        creativeEffect: {
            prev: {
                shadow: true,
                translate: ["-20%", 0, -1],
            },
            next: {
                translate: ["100%", 0, 0],
            },
        },
    });
}


/* ====================================Like post====================================*/

$(document).ready(function () {
    $('.like__post-btn, .like__details-post-btn').on('click', function () {
        const postID = $(this).data('post-id');
        const userID = $(this).data('user-id');
        const postAction = $(`#post-action_${postID}`);
        const likePostBtn = postAction.find(".like__post-btn");
        const likePostCount = postAction.find(".like__post-count");
        const likeDetailsPostBtn = postAction.find(".like__details-post-btn");
        const likeDetailsPostCount = postAction.find(".like__details-post-count");

        let count = parseInt(likePostCount.text());

        if (likePostBtn.hasClass("active") && likeDetailsPostBtn.hasClass("active")) {
            count -= 1;
            likePostBtn.removeClass("active");
            likeDetailsPostBtn.removeClass("active");
            handleLikePost(postID, userID, 'admin/posts/unlike-post');
        } else {
            count += 1;
            likePostBtn.addClass("active");
            likeDetailsPostBtn.addClass("active");
            handleLikePost(postID, userID, 'admin/posts/like-post');
        }
        likePostCount.text(count);
        likeDetailsPostCount.text(count);
    });

    function handleLikePost(postID, userID, url) {
        $.ajax({
            url: API_URL + url,
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
    $('.save__post-btn,.save__details-post-btn').on('click', function () {
        const postID = $(this).data('post-id');
        const userID = $(this).data('user-id');
        const postAction = $(`#post-action_${postID}`);
        const savePostBtn = postAction.find(".save__post-btn");
        const saveDetailsPostBtn = postAction.find(".save__details-post-btn");

        if (savePostBtn.hasClass("active") && saveDetailsPostBtn.hasClass("active")) {
            savePostBtn.removeClass("active");
            saveDetailsPostBtn.removeClass("active");
            handleSavePost(postID, userID, 'admin/posts/unsave-post');
        } else {
            savePostBtn.addClass("active");
            saveDetailsPostBtn.addClass("active");
            handleSavePost(postID, userID, 'admin/posts/save-post');
        }
    });

    function handleSavePost(postID, userID, url) {
        $.ajax({
            url: API_URL + url,
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

// ===================================Comment post====================================
$(document).ready(function () {
    $('.add__comment-btn').on('click', function (event) {
        event.preventDefault();
        const post_id = $(this).data('post-id');
        const user_id = $(this).data('user-id');
        const comment_content = $(`#comment_content_${post_id}`).val();
        const comment_media = $(`#comment_media_${post_id}`).prop('files');
        if (!comment_content && comment_media.length === 0) {
            return;
        }
        const form_data = new FormData();
        form_data.append('post_id', post_id);
        form_data.append('user_id', user_id);
        form_data.append('comment_content', comment_content);
        for (let i = 0; i < comment_media.length; i++) {
            form_data.append('comment_media', comment_media[i]);
        }
        $.ajax({
            url: API_URL + 'admin/posts/add-comment',
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});


                // if (response.status == 'success') {
                //     const comment = response.data;
                //     const commentElement = `
                //     <div class="comment__item">
                //         <div class="comment__item-avatar">
                //             <img src="${comment.user.avatar}" alt="">
                //         </div>
                //         <div class="comment__item-content">
                //             <div class="comment__item-content-info">
                //                 <div class="comment__item-content-info-name">${comment.user.name}</div>
                //                 <div class="comment__item-content-info-time">${comment.created_at}</div>
                //             </div>
                //             <div class="comment__item-content-text">${comment.comment_content}</div>
                //             <div class="comment__item-content-media">
                //                 <img src="${comment.comment_media}" alt="">
                //             </div>
                //         </div>
                //     </div>
                //     `;
                //     $(`#comment_${post_id}`).prepend(commentElement);
                //     $(`#comment_content_${post_id}`).val('');
                //     $(`#comment_media_${post_id}`).val('');
                // }