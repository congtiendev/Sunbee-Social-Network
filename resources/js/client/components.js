const API_URL = "http://localhost:88/Sunbee-Social-Network/";
const POST_MEDIA_PATH = API_URL + "public/uploads/posts/";
const AVATAR_PATH = API_URL + "public/uploads/avatars/";
const ICON_PATH = API_URL + "public/images/icon/";
let swiper = null;
export function loadSwiper() {
  const swiper = new Swiper(".swiper", {
    autoHeight: true,
    spaceBetween: 20,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
}
export function isImageUrl(url) {
  const imageExtensions = [".jpg", ".jpeg", ".png", ".gif", ".bmp"];
  const extension = url.substring(url.lastIndexOf(".")).toLowerCase();
  return imageExtensions.includes(extension);
}

//---------------------------------Preview media------------------------------------//
const uploadedFiles = [];
export function previewMultiple(file, previewElementId, callback) {
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
          'public/images/icon/remove-icon.png" alt="close" class="w-7 h-7">'
      );
      removeButton.on("click", function () {
        const index = uploadedFiles.indexOf(file);
        //Xóa giá trị file tải lên khỏi input

        if (index !== -1) {
          uploadedFiles.splice(index, 1);
        }
        previewContainer.remove();
      });
      previewContainer.append(mediaElement);
      previewContainer.append(removeButton);
      previewElement.append(previewContainer);

      uploadedFiles.push(file);

      if (callback) {
        callback(previewContainer);
      }
    };
    reader.readAsDataURL(file);
  }
}

export function postTemplate(data) {
  return `
    <section id="posts-${
      data.post_id
    }" class="post bg-white shadow rounded-lg mb-6 
  }">
      <div class="flex justify-between">
        <div class="flex flex-row px-2 py-3 mx-3">

          <div class="w-auto h-auto rounded-full">
            <img class="w-12 h-12 object-cover rounded-full shadow cursor-pointer" alt="User avatar"
              src="${data.avatar}">
          </div>
          <div class="flex  flex-col mb-2 ml-4 mt-1">
            <a href="#" class="text-gray-900 dark:text-gray-100 text-sm font-semibold">
              ${data.first_name} ${data.last_name}
            </a>
            <div class="flex w-full mt-1">
              <span class="text-blue-700 font-base text-xs mr-1 cursor-pointer">
                ${data.username}
              </span>
              <span class="text-gray-400 font-thin text-xs">
                • ${data.post_date}
              </span>
            </div>
          </div>
        </div>
        <div class="p-2 options-post">
          <a href="#"> <i
              class="p-2 -mr-1 text-2xl transition rounded-full icon-feather-more-horizontal hover:bg-gray-200 dark:hover:bg-gray-700"></i>
          </a>
          <div
            class="hidden w-56 p-2 mx-auto mt-12 text-base text-gray-500 bg-white border border-gray-100 rounded-md shadow-md dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
            uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">

            <ul class="space-y-1">
              ${
                data.isAuthor
                  ? `
              <li>
                <a href="#" data-post-id="${data.post_id}" data-user-id="${data.user_id}"
                  class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 text-gray-900 dark:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>

                  Chỉnh sửa bài viết
                </a>
              </li>
              <li>
                <a href="#" data-post-id="${data.post_id}" data-user-id="${data.user_id}"
                  class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                  <svg class="w-5 h-5 fill-black dark:fill-white" viewBox="0 0 48 48">
                    <path clip-rule="evenodd"
                      d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                      fill-rule="evenodd"></path>
                  </svg>
                  Tắt bình luận
                </a>
              </li>

              <li>
                <hr class="my-2 -mx-2 border-gray-300 dark:border-gray-500" />
              </li>
              <li>
                <a data-post-id="${data.post_id}" data-user-id="${data.user_id}" href=""
                  class="flex items-center gap-3 p-2 text-red-500 rounded-md hover:bg-red-100 hover:text-white dark:hover:bg-red-600 delete__post-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>

                  Xóa bài viết
                </a>
              </li>
              `
                  : `
              <li>
                <a href="#" data-post-id="${data.post_id}" data-user-id="${data.user_id}"
                  class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 text-gray-900 dark:text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                  </svg>
                  Báo cáo bài viết
                </a>
              </li>
              `
              }
            </ul>

          </div>
        </div>
      </div>
      ${
        data.post_content
          ? `
      <a href="#post__detail-${data.post_id}" uk-toggle>
        <p class="text-gray-900 dark:text-gray-100 text-sm  px-3 pt-2 pb-4 max-w-full font-sunbee">
          ${data.post_content}</p>
      </a>`
          : ""
      }

      <div class="text-gray-400 font-medium text-sm">
        <div uk-lightbox>
          <div class="swiper postMedia">
            <div class="swiper-wrapper postMedia-${data.post_id}">
              ${
                Array.isArray(data.post_media)
                  ? data.post_media
                      .map((media) => {
                        if (isImageUrl(media)) {
                          return `
              <div class="swiper-slide">
                <a href="${POST_MEDIA_PATH + media}">
                  <img src="${
                    POST_MEDIA_PATH + media
                  }" alt="Post image" class="w-full h-full" />
                </a>
              </div>
              `;
                        } else {
                          return ` < div class="swiper-slide">
                < a href="${POST_MEDIA_PATH + media}
">
                  < video src="${POST_MEDIA_PATH + media}
" controls class="
w - full h - full "></video>
                    < /a>
                      < /div>
                        `;
                        }
                      })
                      .join("")
                  : ""
              }
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>


      <div class="flex justify-between items-center px-5 py-3 border-t border-gray-100 text-gray-900 dark:text-gray-100">
        <div class="flex gap-5">
          <svg data-user-id="${data.user_id}" data-post-id="${
    data.post_id
  }" class="w-6 h-6 fill-black dark:fill-white like__post-btn like__post-btn-${
    data.post_id
  }" viewBox="0 0 48 48">
            <path
              d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z">
            </path>
          </svg>
          <a href="#post__detail-${data.post_id}" uk-toggle>
            <svg class="w-6 h-6 fill-black dark:fill-white comment" viewBox="0 0 48 48">
              <path clip-rule="evenodd"
                d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                fill-rule="evenodd"></path>
            </svg>
          </a>
          <svg class="w-6 h-6 fill-black dark:fill-white" viewBox="0 0 48 48">
            <path
              d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z">
            </path>
          </svg>
        </div>
        <svg data-user-id="${data.user_id}" data-post-id="${
    data.post_id
  }" class="w-6 h-6 save__post-btn save__post-btn-${
    data.post_id
  } fill-black dark:fill-white" viewBox="0 0 48 48">
          <path
            d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
          </path>
        </svg>
      </div>
      <div class="flex w-full border-t border-gray-100">
        <div class="mt-3 mx-5 w-full flex text-xs">
          <div class=" font-semibold like__post">
            <span class="like__post-count-${data.post_id}">
              ${data.like_count}</span> lượt thích
          </div>
        </div>
        <div class="mt-3 mx-5 flex flex-row text-xs whitespace-nowrap">
          <div class=" font-semibold share__post">
            <span class="like__post-count-${data.post_id}">
              ${data.share_count}</span> lượt chia sẻ
          </div>
        </div>
      </div>
   
    
      <div class="mt-2 pb-2 text-sm text-[#737373] dark:text-gray-400 comment__post px-5">
        <a href="#post__detail-${data.post_id}" uk-toggle >
          Xem <span class="comment__post-count-${data.post_id}">${
    data.comment_count
  }</span> bình luận
        </a>
      </div>
    

      <!-- ---------------------------POSTS DETAIL------------------------------ -->
      <div id="post__detail-${
        data.post_id
      }" class="uk-modal-container glassmorphism__dark" uk-modal>
        <div class="bg-white uk-modal-dialog dark:bg-gray-900">
          <button
            class="p-4 -mt-5 -mr-5 transition bg-white rounded-full shadow-lg uk-modal-close-default lg:-mt-9 lg:-mr-9 glassmorphism"
            type="button" uk-close></button>
          <div class="w-full mx-auto sm:max-w-3xl md:max-w-full lg:max-w-screen-xl">
            <div class="${
              data.post_media.length > 0 ? " grid md:grid-cols-2" : ""
            }">
              <div>
                <!-- ------------------------------DETAIL POSTS MEDIA---------------------------- -->
                <section
                  class=" max-w-xs  xs:max-w-[370px]  sm:max-w-2xl md:max-w-3xl lg:max-w-screen-xl swiper sliderPosts ">
                  <div uk-lightbox class=" swiper-wrapper">
                    ${
                      Array.isArray(data.post_media)
                        ? data.post_media
                            .map((media) => {
                              if (isImageUrl(media)) {
                                return `
                    <div class="swiper-slide">
                      <a href="${POST_MEDIA_PATH + media}">
                        <img src="${POST_MEDIA_PATH + media}" alt="Mở ảnh"
                          class=" w-full  mx-auto h-full min-h-[320px] max-h-[320px] xs:min-h-[355px] xs:max-h-[355px] sm:min-h-[400px] sm:max-h-[400px] md:min-h-[500px] md:max-h-[500px]  object-cover" />
                      </a>
                    </div>
                    `;
                              } else {
                                return ` < div class="swiper-slide">
                      < a href="${POST_MEDIA_PATH + media}
">
                        < video
                          class=" w-full  mx-auto h-full min-h-[320px] max-h-[320px] xs:min-h-[355px] xs:max-h-[355px] sm:min-h-[400px] sm:max-h-[400px] md:min-h-[500px] md:max-h-[500px]  object-contain"
                          controls>
                          < source src="${POST_MEDIA_PATH + media}
" type="
video / mp4 " />
                          < /video>
                            < /a>
                              < /div>
                                `;
                              }
                            })
                            .join("")
                        : ""
                    }
                  </div>
                </section>
                <!-- ------------------------------END DETAIL POSTS MEDIA----------------------------- -->
              </div>
              <!-- -------------------------------DETAIL POSTS CONTENT---------------------------------- -->
              <section class="  flex flex-col max-h-[500px] details__posts justify-between">
                <!-- --------------------------------AUTHOR INFO--------------------------------- -->
                <div class="relative flex flex-col overflow-y-auto hidden__scrollbar">
                  <div class="flex items-center gap-2 px-5 py-2 author">
                    <div class="avatar">
                      <div class="w-10 h-10 bg-gray-200 rounded-full">
                        <img src="${data.avatar}" />
                      </div>
                    </div>
                    <div class="author__name">
                      <a href="#" class="text-sm text-[#262626] dark:text-white font-semibold">${
                        data.first_name
                      } ${data.last_name}</a>
                      <p class="text-xs text-gray-400 dark:text-gray-500">
                        ${data.post_date}
                      </p>
                    </div>
                  </div>
                  <!-- -------------------------------END AUTHOR INFO--------------------------------- -->
                  <pre id="post__content-${data.post_id}"
                    class="font-sunbee  px-4 pt-2 pb-3  whitespace-normal text-sm text-[#000000] dark:text-gray-100 ">
                                                ${data.post_content}
                                            </pre>
                  <div
                    class="flex items-center justify-between p-4 border-t border-b border-gray-200 dark:border-gray-700">
                    <div class="flex gap-5">
                      <svg data-post-id="${data.post_id}" data-user-id="${
    data.user_id
  }" class="w-6 h-6 fill-black dark:fill-white like__post-btn like__post-btn-${
    data.post_id
  }" height="24" viewBox="0 0 48 48" width="24">
                        <path
                          d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z">
                        </path>
                      </svg>
                      <svg class="w-6 h-6 fill-black dark:fill-white" viewBox="0 0 48 48">
                        <path clip-rule="evenodd"
                          d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                          fill-rule="evenodd"></path>
                      </svg>
                      <svg class="w-6 h-6 fill-black dark:fill-white" viewBox="0 0 48 48">
                        <path
                          d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z">
                        </path>
                      </svg>
                    </div>
                    <svg data-post-id="${data.post_id}" data-user-id="${
    data.user_id
  }" class="w-6 h-6 save__post-btn save__post-btn-${
    data.post_id
  } fill-black dark:fill-white" viewBox="0 0 48 48">
                      <path
                        d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
                      </path>
                    </svg>
                  </div>
                  <section
                    class="my-2 flex items-center justify-between text-[#000000] total-interact dark:text-white px-4">
                    <div class="pb-2 text-sm font-semibold like__post">
                      <span class="like__post-count-${data.post_id}">
                        ${data.like_count}
                      </span>
                      lượt thích
                    </div>
                    <div class="pb-2 text-sm font-semibold share__post">
                      <span class="share__post-count-${data.post_id}">
                        ${data.share_count}
                      </span>
                      chia sẻ
                    </div>
                  </section>
                  <!-- ---------------------------OPTIONS DETAIL POSTS---------------------------- -->
                  <div class="absolute details__post-options top-3 right-10">
                    <div class="dropdown dropdown-end">
                      <label tabindex="${data.post_id}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                          stroke="currentColor" class="w-6 h-6 text-gray-900 dark:text-white">
                          <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                      </label>
                      <ul tabindex="${data.post_id}"
                        class="bg-white shadow dropdown-content dark:bg-base-100 rounded-xl">
                        <div
                          class="w-48 p-2 text-sm text-gray-500 bg-white border border-gray-100 dark:bg-base-100 dark:text-gray-100 dark:border-gray-700 rounded-md">
                          <ul class="space-y-1">
                            ${
                              data.isAuthor
                                ? `
                            <li>
                              <a href="#" data-post-id="${data.post_id}" data-user-id="${data.user_id}"
                                class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor"
                                  class="w-5 h-5 text-gray-900 dark:text-white">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>

                                Chỉnh sửa bài viết
                              </a>
                            </li>
                            <li>
                              <a href="#" data-post-id="${data.post_id}" data-user-id="${data.user_id}"
                                class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                <svg class="w-5 h-5 fill-black dark:fill-white" viewBox="0 0 48 48">
                                  <path clip-rule="evenodd"
                                    d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                                    fill-rule="evenodd"></path>
                                </svg>
                                Tắt bình luận
                              </a>
                            </li>

                            <li>
                              <hr class="my-2 -mx-2 border-gray-300 dark:border-gray-500" />
                            </li>
                            <li>
                              <a data-post-id="${data.post_id}" data-user-id="${data.user_id}" href=""
                                class="flex items-center gap-3 p-2 text-red-500 rounded-md hover:bg-red-100 hover:text-white dark:hover:bg-red-600 delete__post-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-500">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>

                                Xóa bài viết
                              </a>
                            </li>
                            `
                                : `
                            <li>
                              <a href="#" data-post-id="${data.post_id}" data-user-id="${data.user_id}"
                                class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor"
                                  class="w-5 h-5 text-gray-900 dark:text-white">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                </svg>
                                Báo cáo bài viết
                              </a>
                            </li>
                            `
                            }
                          </ul>
                        </div>
                      </ul>
                    </div>
                  </div>

                  <!-- --------------------------------DETAIL POSTS COMMENTS---------------------- -->
                  <section class="post__list-comments-${
                    data.post_id
                  } min-h-[220px] max-h-[250px]">
                    ${
                      data.comment_count > 0
                        ? `
                    ${data.comments
                      .map((comment) => {
                        return `
                    <!-- ------------------------------COMMENTS------------------------- -->
                    <div class="relative flex px-4 antialiased text-black">
                      <div class="absolute top-0 comment-options right-5">
                        <div class="z-50 dropdown dropdown-end">
                          <label tabindex="0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor" class="w-6 h-6 text-gray-900 dark:text-white">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                          </label>
                          <div tabindex="${data.post_id}"
                            class="bg-white shadow dropdown-content dark:bg-base-100 rounded-xl">
                            <ul
                              class="p-1 text-xs font-normal text-gray-500 bg-white border border-gray-100 w-fit whitespace-nowrap dark:bg-base-100 dark:text-gray-100 dark:border-gray-700">
                              <li>
                                <a href="#"
                                  class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 text-gray-900 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                  </svg>

                                  Chỉnh sửa bình luận
                                </a>
                              </li>

                              <li>
                                <a href="#"
                                  class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-4 h-4 text-gray-900 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                  </svg>
                                  Báo cáo bình luận
                                </a>
                              </li>
                              <li>
                                <hr class="my-1 border-gray-300 dark:border-gray-500" />
                              </li>
                              <li>
                                <a href="${API_URL}posts/comment/delete/${comment.post_id}/${comment.comment_id}" data-comment-id="${comment.comment_id}" data-post-id="${comment.post_id}" 
                                  class="flex items-center gap-3 p-1 text-red-500 rounded-md hover:bg-red-100 hover:text-white dark:hover:bg-red-600 delete__comment-btn">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                  </svg>
                                  Xóa bình luận
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <img class="w-8 h-8 mt-1 mr-2 rounded-full user__avatar"
                        src="https://picsum.photos/id/1027/200/200" />
                      <div>
                        <a href="#" class="text-sm font-semibold leading-relaxed username dark:text-gray-100">
                          congtiendev
                        </a>

                        <div class="w-fit bg-gray-100 dark:bg-gray-800 rounded-lg mt-1 px-4 pt-2 pb-2.5">
                          <p class="text-xs leading-snug dark:text-gray-100 md:leading-normal">
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Voluptate animi expedita hic. Voluptates nemo
                            id ad ipsa alias repellat consequatur inventore
                            nobis asperiores doloribus ea, quisquam dolores
                            minus, molestiae deleniti.
                          </p>
                        </div>
                        <div class="comment__media-${data.post_id} w-[65%] h-auto my-1 rounded-lg">
                          <img class="w-full h-full rounded-lg"
                            src="{{ COMMENT_MEDIA_PATH . $comment->comment_media }}" />
                        </div>
                        <span class="text-xs text-gray-500">
                          1 giờ trước
                        </span>
                      </div>
                    </div>
                    <!-- ------------------------------END COMMENTS------------------------- -->
                    `;
                      })
                      .join("")}
                    `
                        : `
                    <div 
                      class="flex no__comment-${data.post_id} flex-col items-center justify-center mx-auto mt-20 text-sm text-center text-gray-500 empty__comment dark:text-gray-400">
                      <span class="no__comment-${data.post_id}">Chưa có bình luận nào</span>
                    </div>
                    `
                    }
                  </section>
                </div>
                <!-- ------------------------------------ADD COMMENT -------------------------- -->
                <form method="post" id="add__comment-${data.post_id}"
                  class="relative flex items-center self-center w-full p-4 overflow-hidden text-gray-600 focus-within:text-gray-400">
                  <img class="object-cover w-10 h-10 mr-2 rounded-full shadow cursor-pointer" alt="User avatar" src="${
                    AVATAR_PATH + data.auth_avatar
                  }">
                  <span class="absolute inset-y-0 right-0 flex items-center gap-2 pr-5 md:gap-3">
                    <svg class="w-6 h-6 text-gray-400 transition duration-300 ease-out hover:text-yellow-500"
                      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                      </path>
                    </svg>


                <label for="comment_media-${data.post_id}" class="mt-1.5">
                      <input data-post-id="${data.post_id}" id="comment_media-${
    data.post_id
  }" type="file" name="comment_media" class="sr-only comment__media-upload" accept=" image/*,video/*" />
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 transition duration-300 ease-out hover:text-yellow-500">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                      </svg>
                  </label>
                  <button type="submit" data-post-id="${
                    data.post_id
                  }" data-user-id="${
    data.user_id
  }" class="focus:outline-none focus:shadow-none add__comment-btn">
                      <svg class="w-5 h-5 transition duration-300 ease-out fill-gray-400 hover:fill-yellow-500" viewBox="0 0 48 48">
                          <path d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z">
                          </path>
                      </svg>
                  </button>
              </span>
              <input type="search" id="comment_content-${
                data.post_id
              }" class="w-full py-2 pl-4 pr-10 text-sm placeholder-gray-400 border border-transparent appearance-none rounded-tg" style="border-radius: 25px" placeholder="Nhập bình luận ..." autocomplete="off">
          </form>
          <div id="comment__media-preview-${
            data.post_id
          }" class="hidden w-20 h-auto ml-3 mb-3">
                                    </div>
              </section>
            </div>
          </div>
        </div>
      </div>
      <!-- ---------------------------END POSTS DETAIL------------------------------- -->

    </section>
    `;
}

export function commentTemplate(comment) {
  return `
<!-- ------------------------------COMMENTS------------------------- -->
                                            <div id="post__comment-${
                                              comment.comment_id
                                            }" class="flex p-4 gap-2">
                                                <div class="relative flex-shrink-0 w-10 h-10 rounded-full">
                                                    <img src="${
                                                      comment.avatar
                                                    }" alt="" class="absolute w-full object-cover h-full rounded-full">
                                                </div>
                                                <div class="relative">
                                                    <div class="absolute top-0 comment-options right-5">
                                                        <div class="z-50 dropdown dropdown-end">
                                                            <label tabindex="${
                                                              comment.comment_id
                                                            }">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-900 dark:text-white">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                                </svg>
                                                            </label>
                                                            <div tabindex="${
                                                              comment.comment_id
                                                            }" class="bg-white shadow dropdown-content dark:bg-base-100 rounded-xl z-50">
                                                                <ul tabindex="${
                                                                  comment.comment_id
                                                                }" class="bg-white shadow dropdown-content dark:bg-base-100 rounded-xl">

                                                                    <div class="w-48 p-2 text-sm text-gray-500 bg-white border border-gray-100 dark:bg-base-100 rounded-xl dark:text-gray-100 dark:border-gray-700">
                                                                        <ul class="space-y-1">
                                                                          ${
                                                                            comment.isAuthor
                                                                              ? `
                                                                            <li>
                                                                                <span onclick="comment__${comment.comment_id}.showModal()" class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">

                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-900 dark:text-white">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                                    </svg>

                                                                                    Chỉnh sửa bình luận
                                                                                </span>
                                                                            </li>
                                                                            <li>
                                                                                <a href="#" data-comment-id="${comment.comment_id}" data-post-id="${comment.post_id}" data-user-id="${comment.user_id}" class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">

                                                                                    <svg class="w-5 h-5 fill-black dark:fill-white" viewBox="0 0 48 48">
                                                                                        <path clip-rule="evenodd" d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z" fill-rule="evenodd">
                                                                                        </path>
                                                                                    </svg>
                                                                                    Tắt bình luận
                                                                                </a>
                                                                            </li>
                                                                          
                                                                            <li>
                                                                                <hr class="my-2 -mx-2 border-gray-300 dark:border-gray-500" />
                                                                            </li>
                                                                            <li>
                                                                                <a href="#" data-comment-id="${comment.comment_id}" data-post-id="${comment.post_id}" class="flex items-center gap-3 px-2 py-1 text-red-500 rounded-md hover:bg-red-100 hover:text-white dark:hover:bg-red-600 delete__comment-btn">

                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-500">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                                    </svg>
                                                                                    Xóa bình luận
                                                                                </a>
                                                                            </li>
                                                                              `
                                                                              : `  <li>
                                                                                <a href="#" data-comment-id="${comment.comment_id}" data-post-id="${comment.post_id}" data-user-id="${comment.user_id}" class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">

                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-900 dark:text-white">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                                                                    </svg>
                                                                                    Báo cáo bình luận
                                                                                </a>
                                                                            </li>
                                                                             `
                                                                          }
                                                                        </ul>
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-3 py-2 w-fit min-w-[150px] text-gray-800 bg-gray-100 rounded-lg lg:mr-12 dark:bg-slate-800 border dark:text-gray-100 relative">
                                                        <a href="" class="font-semibold text-sm "> ${
                                                          comment.first_name
                                                        } ${
    comment.last_name
  }</a>

                                                        <p class=" leading-6 text-sm  ">
                                                            ${
                                                              comment.comment_content
                                                            }
                                                        </p>
                                                        <div class="react__comment absolute right-2 flex items-center  gap-1 pr-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                                            <img class="w-3.5 h-3.5 rounded-full object-contain " src="${ICON_PATH}tym-icon.png" alt="">
                                                            <span class="like__comment-count-${
                                                              comment.comment_id
                                                            } text-xs font-medium">${
    comment.like_count
  }</span>
                                                        </div>
                                                    </div>
                                                    ${
                                                      comment.comment_media
                                                        ? `
                                                    <div uk-lightbox class="comment__media  mt-2">
                                                        <a href="${
                                                          comment.comment_media
                                                        }">
                                                           ${
                                                             isImageUrl(
                                                               comment.comment_media
                                                             )
                                                               ? `
                                                            <img src="${comment.comment_media}" alt="" class="object-cover w-full rounded-lg max-w-[200px] sm:max-w-[300px] lg:max-w-[350px]">

                                                          `
                                                               : `
                                                            <video src="${comment.comment_media}" class="w-auto rounded-lg object-contain max-w-[200px] sm:max-w-[300px] lg:max-w-[350px]" controls></video>
                                                               `
                                                           }
                                                        </a>
                                                    </div>
                                                    `
                                                        : ""
                                                    }
                                                    <div class="flex items-center mt-2  space-x-3 text-xs">
                                                        <a href="#" data-comment-id="${
                                                          comment.comment_id
                                                        }" data-user-id="${
    comment.user_id
  }" class="hover:text-red-500 like__comment-btn like__comment-btn-${
    comment.comment_id
  }">Thích</a>
                                                        <span class="hover:text-yellow-500"> Phản hồi </span>
                                                        <span class="hover:text-yellow-500"> ${
                                                          comment.comment_time
                                                        }</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <dialog id="comment__${
                                              comment.comment_id
                                            }" class="modal">
                                                <form method="dialog" class="modal-box bg-gray-300 dark:bg-gray-900">
                                                    <div class="form-group flex">
                                                        <div class="user ">
                                                            <img class="absolute w-10 h-10 rounded-full object-cover mr-3" src="${
                                                              comment.avatar
                                                            }" alt="">
                                                        </div>
                                                        <textarea name="comment_content" class="w-fit bg-gray-300 dark:bg-gray-900 px-2 py-2 border pl-11 border-gray-300 rounded outline-none focus:border-indigo-500 comment_content" placeholder="Nhập nội dung bình luận">${
                                                          comment.comment_content
                                                        }</textarea>
                                                    </div>
                                                    <div class="modal-action">
                                                        <button type="submit" class="btn btn-sm ">Hủy</button>
                                                        <button type="button" class="btn btn-sm btn-primary">
                                                            Lưu
                                                        </button>
                                                    </div>
                                                </form>
                                            </dialog>
                                            <!-- ------------------------------END COMMENTS------------------------- -->
`;
}
