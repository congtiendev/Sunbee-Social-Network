import {
  isImageUrl,
  previewMultiple,
  postTemplate,
  commentTemplate,
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
    $.ajax({
      url: API_URL + "is-author",
      method: "POST",
      data: {
        author_id: data.user_id,
      },
      success: function (response) {
        if (response == "true") {
          data.isAuthor = true;
        } else {
          data.isAuthor = false;
        }
        const post = postTemplate(data);
        $("#list__posts").prepend(post);
        loadSwiper();
      },
      error: function (error) {
        console.log(error);
      },
    });
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
    const user_id = parseInt($(this).data("user-id"));
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

$(document).on("click", ".like__post-btn", function () {
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

const commentMediaUpload = document.querySelectorAll(".comment__media-upload");
console.log(commentMediaUpload);
if (commentMediaUpload) {
  commentMediaUpload.forEach((commentMedia, index) => {
    commentMedia.addEventListener("change", function () {
      let file = this.files[0];
      const post_id = $(this).data("post-id");
      let previewMedia = document.querySelector(
        `#comment__media-preview-${post_id}`
      );
      if (file) {
        previewMedia.classList.remove("hidden");
        previewMultiple(file, previewMedia);
      }
    });
  });
}

const commentChannel = pusher.subscribe("comments");
commentChannel.bind("new-comment", function (data) {
  $.ajax({
    url: API_URL + "is-author",
    method: "POST",
    data: {
      author_id: data.user_id,
    },
    success: function (response) {
      if (response == "true") {
        data.isAuthor = true;
      } else {
        data.isAuthor = false;
      }
      const listComment = $(`.post__list-comments-${data.post_id}`);
      const comment = commentTemplate(data);
      const commentCount = $(`.post__comment-count-${data.post_id}`);
      let count = parseInt(commentCount.text());
      count += 1;
      commentCount.text(count);
      listComment.append(comment);
    },
    error: function (error) {
      console.log(error);
    },
  });
});
$(document).on("click", ".add__comment-btn", function (event) {
  event.preventDefault();
  const user_id = $(this).data("user-id");
  const post_id = $(this).data("post-id");
  const comment_content = $(`#comment_content-${post_id}`).val();
  const comment_media = $(`#comment_media-${post_id}`)[0].files;
  const noComment = $(`.no__comment-${post_id}`);

  if (!comment_content && comment_media.length === 0) {
    return;
  }

  const form_data = new FormData();
  form_data.append("post_id", post_id);
  form_data.append("user_id", user_id);
  form_data.append("comment_content", comment_content);
  for (let i = 0; i < comment_media.length; i++) {
    form_data.append("comment_media", comment_media[i]);
  }

  $.ajax({
    url: API_URL + "posts/comment/add",
    type: "POST",
    data: form_data,
    contentType: false,
    processData: false,
    beforeSend: function () {
      $(`#comment_content-${post_id}`).val("");
      $(`#comment_media-${post_id}`).val("");
      $(`#comment__media-preview-${post_id}`).html("");
      noComment.remove();
    },
    success: function (response) {
      console.log(response);
      commentChannel.trigger("client-new-comment", response);
    },
    error: function (error) {
      console.log(error);
    },
    complete: function () {},
  });
});

/* ---------------------------------Like comment------------------------------------------*/

commentChannel.bind("like", function (data) {
  const likeCount = $(`.like__comment-count-${data.comment_id}`);
  likeCount.text(data.like_count);
});
commentChannel.bind("unlike", function (data) {
  const likeCount = $(`.like__comment-count-${data.comment_id}`);
  likeCount.text(data.like_count);
});

$(".like__comment-btn").each(function () {
  const comment_id = $(this).data("comment-id");
  const user_id = $(this).data("user-id");
  $.ajax({
    url: API_URL + "posts/comment/is-liked",
    type: "POST",
    data: {
      user_id: user_id,
      comment_id: comment_id,
    },
    success: function (response) {
      if (response == "true") {
        $(`.like__comment-btn-${comment_id}`).addClass("text-red-500");
      }
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).on("click", ".like__comment-btn", function (e) {
  e.preventDefault();
  const comment_id = $(this).data("comment-id");
  const user_id = $(this).data("user-id");
  if ($(this).hasClass("text-red-500")) {
    $(this).removeClass("text-red-500");
    handleLikeComment(user_id, comment_id, "posts/comment/unlike");
  } else {
    $(this).addClass("text-red-500");
    handleLikeComment(user_id, comment_id, "posts/comment/like");
  }
});
function handleLikeComment(user_id, comment_id, url) {
  $.ajax({
    url: API_URL + url,
    type: "POST",
    data: {
      user_id: user_id,
      comment_id: comment_id,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (error) {
      console.log(error);
    },
  });
}

/* ---------------------------------Delete comment------------------------------------------*/
$(document).on("click", ".delete__comment-btn", function (event) {
  event.preventDefault();
  const comment_id = $(this).data("comment-id");
  const post_id = $(this).data("post-id");
  console.log(comment_id, post_id);
  deleteComment(post_id, comment_id);
});

function deleteComment(post_id, comment_id) {
  $.ajax({
    url: API_URL + "posts/comment/delete/" + post_id + "/" + comment_id,
    type: "GET",
    success: function (response) {
      console.log(response);
      commentChannel.trigger("client-delete-comment", response);
    },
    error: function (error) {
      console.error("Error deleting comment:", error);
    },
  });
}
commentChannel.bind("delete-comment", function (data) {
  console.log(data);
  const commentElement = $(`#post__comment-${data.comment_id}`);
  const commentCount = $(`.post__comment-count-${data.post_id}`);
  let count = parseInt(commentCount.text());
  count--;
  commentCount.text(count);
  commentElement.remove();
});

/* ---------------------------------Save post--------------------------------------------*/
let savePostHandle = false;
$(document).on("click", ".save__post-btn", function () {
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
const deletePostChannel = pusher.subscribe("delete-posts");
$(document).on("click", ".delete__post-btn", function (event) {
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
      deletePostChannel.trigger("client-delete", response);
    },
    error: function (error) {
      console.log(error);
    },
  });
}

deletePostChannel.bind("delete", function (data) {
  console.log(data);
  const postID = data.post_id;
  const post = $(`#posts-${postID}`);
  post.remove();
});
