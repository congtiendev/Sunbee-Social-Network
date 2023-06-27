const API_URL = "http://localhost:88/Sunbee-Social-Network/";
const POST_MEDIA_PATH = API_URL + "public/uploads/posts/";

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

export function postTemplate(data) {
  return `
          <section id="post-${
            data.post_id
          }" class="post bg-white shadow rounded-lg mb-6">
                        <div class="flex justify-between">
                            <div class="flex flex-row px-2 py-3 mx-3">

                                <div class="w-auto h-auto rounded-full">
                                    <img class="w-12 h-12 object-cover rounded-full shadow cursor-pointer"
                                        alt="User avatar"
                                        src="${data.avatar}">
                                </div>
                                <div class="flex  flex-col mb-2 ml-4 mt-1">
                                    <a href="#" class="text-gray-600 text-sm font-semibold">
                                        ${data.first_name}  ${data.last_name}
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
                                <div class="hidden w-56 p-2 mx-auto mt-12 text-base text-gray-500 bg-white border border-gray-100 rounded-md shadow-md dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
                                    uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">

                                    <ul class="space-y-1">
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-3 py-2 rounded-md hover:bg-gray-200 hover:text-gray-800 dark:hover:bg-gray-800">
                                                <i class="mr-1 uil-edit-alt"></i> Chỉnh sửa bài viết
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-3 py-2 rounded-md hover:bg-gray-200 hover:text-gray-800 dark:hover:bg-gray-800">
                                                <i class="mr-1 uil-comment-slash"></i> Tắt bình luận
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="my-2 -mx-2 dark:border-gray-800">
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-3 py-2 text-red-500 rounded-md hover:bg-red-100 hover:text-red-500 dark:hover:bg-red-600">
                                                <i class="mr-1 uil-trash-alt"></i> Xóa bài viết
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    ${
                      data.post_content
                        ? `
                      <p class="text-gray-500 text-sm  px-3 pt-2 pb-4 max-w-full font-sunbee">
                       ${data.post_content}</p>`
                        : ""
                    }
                       
                      <div class="text-gray-400 font-medium text-sm">
                        <div uk-lightbox>
                          <div class="swiper postMedia">
                            <div class="swiper-wrapper postMedia-${
                              data.post_id
                            }">
                              ${
                                Array.isArray(data.post_media)
                                  ? data.post_media
                                      .map((media) => {
                                        if (isImageUrl(media)) {
                                          return `
                                            <div class="swiper-slide">
                                              <a href="${
                                                POST_MEDIA_PATH + media
                                              }">
                                                <img src="${
                                                  POST_MEDIA_PATH + media
                                                }" alt="Post image" class="w-full h-full" />
                                              </a>
                                            </div>
                                          `;
                                        } else {
                                          return `
                                            <div class="swiper-slide">
                                              <a href="${
                                                POST_MEDIA_PATH + media
                                              }">
                                                <video src="${
                                                  POST_MEDIA_PATH + media
                                                }" controls class="w-full h-full"></video>
                                              </a>
                                            </div>
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


                        <div class="flex justify-between items-center px-5 py-3 border-t border-gray-100">
                            <div class="flex gap-5">
                                <svg data-user-id="${
                                  data.user_id
                                }" data-like-count="${data.like_count}"
                                    class="w-6 h-6 fill-black dark:fill-white like__post-btn" viewBox="0 0 48 48">
                                    <path
                                        d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z">
                                    </path>
                                </svg>
                                <svg  class="w-6 h-6 fill-black dark:fill-white" viewBox="0 0 48 48">
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
                            <svg data-user-id="${data.user_id}" data-post-id="${
    data.post_id
  }" 
                                class="w-6 h-6 save__post-btn fill-black dark:fill-white" viewBox="0 0 48 48">
                                <path
                                    d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex w-full border-t border-gray-100">
                            <div class="mt-3 mx-5 w-full flex text-xs">
                                <div class=" font-semibold like__post">
                                    <span class="like__post-count-${
                                      data.post_id
                                    }">
                                        ${data.like_count}</span> lượt thích
                                </div>
                            </div>
                            <div class="mt-3 mx-5 flex flex-row text-xs whitespace-nowrap">
                                <div class=" font-semibold share__post">
                                    <span class="like__post-count-${
                                      data.post_id
                                    }">
                                        ${data.share_count}</span> lượt chia sẻ
                                </div>
                            </div>
                        </div>
                 ${
                   data.comment_count > 0
                     ? `
                        <div class="text-black  dark:text-white p-4 antialiased flex">
                            <img class="rounded-full h-8 w-8 mr-2 mt-1 " src="https://picsum.photos/id/1027/200/200">
                            <div>
                                <div class="bg-gray-100 border rounded-xl px-4 pt-2 pb-2.5">
                                    <div class="font-medium  leading-relaxed">Sara Lauren</div>
                                    <div class="text-xs leading-snug md:leading-normal">
                                    Nội dung bình luận
                                    </div>
                                </div>
                                <div class="text-xs  mt-0.5 text-gray-500">14 giờ</div>
                            </div>

                        </div>
                        <div class="mb-0.5 text-sm text-[#737373] dark:text-gray-400 comment__post px-5">
                            <a href="#">
                                Xem <span class="comment__post-count-${data.post_id}">${data.comment_count}</span> bình luận
                            </a>
                        </div>
                        `
                     : `
                        <div class="mt-2 text-sm text-[#737373] dark:text-gray-400 comment__post px-5">
                            <span class="no__comment-${data.post_id}">Chưa có bình luận</span>
                        </div>
                        `
                 }

              <form method="post" id="add__comment-${
                data.post_id
              }" enctype="multipart/form-data"
								class="relative flex items-center self-center w-full max-w-xl p-4 overflow-hidden text-gray-600 focus-within:text-gray-400">
								<img class="object-cover w-10 h-10 mr-2 rounded-full shadow cursor-pointer"
									alt="User avatar"
									src="${data.avatar}">
								<span class="absolute inset-y-0 right-0 flex items-center gap-2 pr-7 md:gap-3">
									<svg class="w-6 h-6 text-gray-400 transition duration-300 ease-out hover:text-yellow-500"
										xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
										</path>
									</svg>


									<label for="comment__media-${data.post_id}" class="mt-1.5">
										<input id="comment__media-${data.post_id}" type="file" name="comment_media"
											class="sr-only comment__media" accept="image/*,video/*" />
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
											stroke-width="1.5" stroke="currentColor"
											class="w-6 h-6 text-gray-400 transition duration-300 ease-out hover:text-yellow-500">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
										</svg>
									</label>
									<button type="submit" data-post-id="${data.post_id}" data-user-id="${
    data.user_id
  }"  class="focus:outline-none focus:shadow-none btn__add-comment">
										<svg class="w-5 h-5 transition duration-300 ease-out fill-gray-400 hover:fill-yellow-500"
											viewBox="0 0 48 48">
											<path
												d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z">
											</path>
										</svg>
									</button>
								</span>
								<input type="search"
                  name="comment_content"
									class="w-full py-2 pl-4 pr-10 text-sm placeholder-gray-400 border border-transparent appearance-none rounded-xl comment__content"
									placeholder="Nhập bình luận ..." autocomplete="off">
							</form>
            </section>`;
}

//---------------------------------Preview media------------------------------------//

const uploadedFiles = []; // Mảng lưu trữ các tệp đã tải lên
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
