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

  const createPost = $("#create-post");
  createPost.on("submit", function (event) {
    event.preventDefault();
    const user_id = $(this).data("user-id");
    const post_content = $("#post_content").val();
    const post_media = $("#posts_media").prop("files");
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
      url: API_URL + "post/create",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#create__post-btn").attr("disabled", true);
        $(".loading-create-post").removeClass("hidden");
      },
      success: function (response) {
        console.log(response);
        postChannel.trigger("client-post-event", response);
        $("#post_content").val("");
        $("#posts_media").val("");
      },
      error: function (error) {
        console.log(error);
      },
      complete: function () {
        UIkit.modal("#create-post-modal").hide();
        $("#create__post-btn").attr("disabled", false);
        $(".loading-create-post").addClass("hidden");
      },
    });
  });
});
