import {
  isImageUrl,
  previewMultiple,
  postTemplate,
  loadSwiper,
} from "./components.js";

const API_URL = "http://localhost:88/Sunbee-Social-Network/";

const pusher = new Pusher("c3271ec62a7f5d395eb3", {
  cluster: "ap1",
  useTLS: true,
});
loadSwiper();
$(document).ready(function () {
  //---------------------------------Create post------------------------------------//

  const postChannel = pusher.subscribe("post-channel");
  postChannel.bind("post-event", function (data) {
    console.log(data);
    const post = postTemplate(data);
    $("#list__posts").prepend(post);
    loadSwiper();
  });

  const uploadedFiles = [];
  const postMediaUpload = $("#post_media");
  if (postMediaUpload.length) {
    postMediaUpload.on("change", function () {
      const files = postMediaUpload.get(0).files;
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

  const createPost = $("#create-post");
  createPost.on("submit", function (event) {
    event.preventDefault();
    const user_id = $(this).data("user-id");
    const post_content = $("#post_content").val();
    const post_media = $("#post_media").prop("files");

    if (post_media.length == 0 && post_content.length == 0) {
      alert("Bạn chưa nhập nội dung bài viết hoặc chưa chọn ảnh/video");
      return;
    }
    const formData = new FormData();
    formData.append("user_id", user_id);
    formData.append("post_content", post_content);
    formData.append("post_media", post_media);
    for (let i = 0; i < post_media.length; i++) {
      formData.append("post_media[]", post_media[i]);
    }
    $.ajax({
      url: API_URL + "posts/create",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#create__post-btn").attr("disabled", true);
        $("#create__post-btn").html("Đang đăng...");
      },
      success: function (response) {
        console.log(response);
        postChannel.trigger("client-post-event", response);
      },
      error: function (error) {
        console.log(error);
      },
      complete: function () {
        UIkit.modal("#create-post-modal").hide();
        $("#create__post-btn").attr("disabled", false);
        $("#create__post-btn").html("Chia sẻ");
        $("#post_content").val("");
        $("#post_media").val("");
        $("#post__media-preview").html("");
        swal("Đã đăng", "Bài viết của bạn đã được chia sẻ", "success");
      },
    });
  });
});

/* ---------------------------------Like post------------------------------------------*/

const likeChannel = pusher.subscribe("like-post");
likeChannel.bind("like", function (data) {
  const likeCount = $(`.like__post-count-${data.post_id}`);
  likeCount.text(data.like_count);
});

likeChannel.bind("unlike", function (data) {
  const likeCount = $(`.like__post-count-${data.post_id}`);
  likeCount.text(data.like_count);
});

$(".like__post-btn").on("click", function () {
  const postID = $(this).data("post-id");
  const userID = $(this).data("user-id");
  const likePostBtn = $(`.like__post-btn-${postID}`);
  if ($(this).hasClass("active")) {
    likePostBtn.removeClass("active");
    handleLikePost(postID, userID, "posts/unlike-post");
  } else {
    likePostBtn.addClass("active");
    handleLikePost(postID, userID, "posts/like-post");
  }
});

function handleLikePost(postID, userID, url) {
  $.ajax({
    url: API_URL + url,
    type: "POST",
    data: {
      postID: postID,
      userID: userID,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (error) {
      console.log(error);
    },
  });
}

/* ---------------------------------Comment post------------------------------------------*/

/* ---------------------------------Save post--------------------------------------------*/
let savePostHandle = false;
$(".save__post-btn").on("click", function () {
  if (savePostHandle) {
    return;
  }
  const postID = $(this).data("post-id");
  const userID = $(this).data("user-id");
  const savePostBtn = $(`.save__post-btn-${postID}`);

  if ($(this).hasClass("active")) {
    savePostBtn.removeClass("active");
    handleSavePost(postID, userID, "posts/unsave-post");
    swal("Đã bỏ lưu bài viết !", "", "success");
  } else {
    savePostBtn.addClass("active");
    handleSavePost(postID, userID, "posts/save-post");
    swal("Bài viết đã được lưu !", "", "success");
  }

  savePostHandle = true;
  savePostBtn.prop("disabled", true);
  setTimeout(function () {
    savePostHandle = false;
    savePostBtn.prop("disabled", false);
  }, 500);
});

function handleSavePost(postID, userID, url) {
  $.ajax({
    url: API_URL + url,
    type: "POST",
    data: {
      postID: postID,
      userID: userID,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (error) {
      console.log(error);
    },
  });
}

/* ---------------------------------Delete post------------------------------------------*/
const deletePostChanel = pusher.subscribe("delete-posts");
$(".delete__post-btn").on("click", function (event) {
  event.preventDefault();
  const post_id = $(this).data("post-id");
  swal({
    title: "Bạn có chắc chắn muốn xóa bài viết này?",
    text: "Bài viết sẽ bị xóa vĩnh viễn!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      handleDeletePost(post_id, "posts/delete/" + post_id);
      swal("Bài viết đã được xóa!", {
        icon: "success",
      });
    } else {
      swal("Bài viết chưa được xóa!");
    }
  });
});

function handleDeletePost(postID, url) {
  $.ajax({
    url: API_URL + url,
    type: "GET",
    data: {
      postID: postID,
    },
    success: function (response) {
      console.log(response);
      deletePostChanel.trigger("client-delete", response);
    },
    error: function (error) {
      console.log(error);
    },
  });
}

deletePostChanel.bind("delete", function (data) {
  console.log(data);
  const postID = data.post_id;
  const post = $(`#posts-${postID}`);
  post.remove();
});
