const API_URL = "http://localhost:88/Sunbee-Social-Network/";
const pusher = new Pusher("c3271ec62a7f5d395eb3", {
  cluster: "ap1",
  useTLS: true,
});

$(document).ready(function () {
  function isImageUrl(url) {
    const imageExtensions = [".jpg", ".jpeg", ".png", ".gif", ".bmp"];
    const extension = url.substring(url.lastIndexOf(".")).toLowerCase();
    return imageExtensions.includes(extension);
  }

  //---------------------------------Preview media------------------------------------//

  const uploadedFiles = []; // Mảng lưu trữ các tệp đã tải lên
  function previewMultiple(file, previewElementId, callback) {
    const previewElement = $(previewElementId);
    const previewContainer = $("<div>").addClass("preview-container relative");
    if (file) {
      const reader = new FileReader();
      reader.onload = function () {
        const mediaElement = $(
          "<" + (file.type.startsWith("video/") ? "video" : "img") + ">"
        ).addClass("w-full h-full object-cover rounded-md relative");
        mediaElement.attr("src", reader.result);
        if (file.type.startsWith("video/")) {
          mediaElement.prop("controls", true);
        }
        const removeButton = $("<button>").addClass(
          "remove-btn absolute top-0 right-0 cursor-pointer"
        );
        removeButton.html(
          '<img src="' +
            API_URL +
            'resources/images/icon/remove-icon.png" alt="close" class="w-7 h-7">'
        );
        removeButton.on("click", function () {
          // Xóa tệp khỏi mảng uploadedFiles
          const index = uploadedFiles.indexOf(file);
          if (index !== -1) {
            // Nếu tệp tồn tại trong mảng uploadedFiles
            uploadedFiles.splice(index, 1); // Xóa tệp khỏi mảng uploadedFiles
          }
          previewContainer.remove();
        });
        previewContainer.append(mediaElement);
        previewContainer.append(removeButton);
        previewElement.append(previewContainer);

        // Thêm tệp vào mảng uploadedFiles
        uploadedFiles.push(file);

        if (callback) {
          callback(previewContainer);
        }
      };
      reader.readAsDataURL(file);
    }
  }

  //---------------------------------Create post------------------------------------//
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
      console.log(post_media[i]);
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
        $("#post_content").val("");
        $("#posts_media").val("");
        uploadedFiles.splice(0, uploadedFiles.length);
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

  const swiper = new Swiper(".postMedia", {
    spaceBetween: 30,
    effect: "fade",
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
});
