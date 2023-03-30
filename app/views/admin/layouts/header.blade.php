  <header class="flex items-center justify-between w-full p-2 border-b-2 sm:px-5 sm:py-3 rounded-xl">
      <!-- -------------------btn menu mobile--------------------------- -->
      <div class="relative btn-menu-mobile lg:hidden">
          <img data-tilt data-tilt-scale="1.1" src="{{BASE_URL}}resources/images/menu-mobile-icon.png" alt=""
              class="w-6 h-6" />
          <!-- ----------------------------list-menu mobile--------------------------- -->
          <nav
              class="z-50 menu-mobile max-h-[400px] overflow-y-auto hidden__scrollbar hidden animate-down w-[190px] rounded-xl p-5 absolute border claymorphism-white">
              <div class="w-20 h-auto mx-auto mb-3 logo">
                  <img src="{{BASE_URL}}resources/images/logo.png" alt="logo" class="w-full logo-img" />
              </div>
              <ul class="flex flex-col gap-4 z-1000">
                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/home-icon.png" alt="" />
                      <a href="#" class="text-xs font-semibold text-gray-900 whitespace-nowrap">Trang chủ</a>
                  </li>
                  <li class="flex items-center gap-3">
                      <img class="h-6 w-7" src="{{BASE_URL}}resources/images/trending-icon.png" alt="" />
                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Xu
                          hướng</a>
                  </li>

                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/post-icon.png" alt="" />
                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Bài
                          đăng</a>
                  </li>
                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/account-icon.png" alt="" />
                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Tài
                          khoản</a>
                  </li>
                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/user-icon.png" alt="" />
                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Người
                          dùng</a>
                  </li>
                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/contact-icon.png" alt="" />

                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Phản
                          hồi</a>
                  </li>
                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/statistical-icon.png" alt="" />

                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Thống
                          kê</a>
                  </li>
                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/ads-icon.png" alt="" />
                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Quảng
                          cáo</a>
                  </li>
                  <li class="flex items-center gap-3">
                      <img class="w-7 h-7" src="{{BASE_URL}}resources/images/setting-icon.png" alt="" />
                      <a href="#" class="text-xs font-medium text-gray-700 whitespace-nowrap">Cài
                          đặt</a>
                  </li>
              </ul>
          </nav>
      </div>
      <section class="hidden search__box sm:block">
          <form action="" method="post" class="search__form">
              <div class="flex items-center gap-2 form-group">
                  <input type="text" name="search" value="" placeholder="Tìm kiếm..." required
                      class="px-2 py-1 bg-white rounded-md outline-none" />
                  <button type="submit" class="search__btn">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                          stroke="currentColor"
                          class="p-1 text-gray-200 bg-indigo-500 rounded-lg w-9 h-9 glass__shadow">
                          <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607
                        10.607z" />
                      </svg>
                  </button>
              </div>
          </form>
      </section>
      <section class="opiton__header">
          <ul class="flex items-center gap-3">
              <li class="relative message">
                  <button type="button" class="btn-messages">
                      <img src="{{BASE_URL}}resources/images/chat-btn.png" alt="" class="w-7" />
                  </button>
                  <span
                      class="absolute top-0 right-0 inline-block w-4 h-4 text-xs font-medium text-center text-white transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-none rounded-full">
                      9
                  </span>
                  <!-- --------------message dropdown------------------- -->
                  <div style="max-height: 400px"
                      class="absolute right-0 z-50 hidden w-64 px-3 pt-3 overflow-y-auto border rounded-lg claymorphism-white dropdown-messages">
                      <h2 class="mb-4 text-xs font-semibold text-gray-700 sm:text-sm">
                          Tin nhắn
                      </h2>
                      <div class="flex flex-col gap-2 mb-2 list__message">
                          <!-- -------------------messages-------------------- -->
                          <div class="relative flex gap-3 p-1 rounded-md list__message-item hover:bg-gray-100">
                              <!-- -------------btn delete message---------------- -->
                              <div class="absolute top-0 right-0">
                                  <div class="relative" data-te-dropdown-position="dropstart">
                                      <button class="rounded-full motion-reduce:transition-none" type="button"
                                          data-te-dropdown-toggle-ref aria-expanded="false" data-te-ripple-init>
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                              stroke-width="1.5" stroke="currentColor"
                                              class="w-6 h-6 p-1 text-gray-400 rounded-full hover:bg-gray-200">
                                              <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75
                                    0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0
                                    011.5 0z" />
                                          </svg>
                                      </button>
                                      <ul class="options__notification-box absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-md border-none bg-gray-200 bg-clip-padding text-left text-xs shadow-lg [&[data-te-dropdown-show]]:block"
                                          data-te-dropdown-menu-ref>
                                          <li>
                                              <a class="flex items-center w-full gap-2 px-4 py-2 text-xs font-normal border whitespace-nowrap text-neutral-700 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent claymorphism-white hover:bg-gray-200"
                                                  href="#" data-te-dropdown-item-ref>Xóa cuộc trò
                                                  chuyện
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                      class="w-4 h-4 text-gray-400">
                                                      <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M14.74 9l-.346 9m-4.788 0L9.26
                                          9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16
                                          19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0
                                          01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0
                                          00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0
                                          0a48.11 48.11 0 013.478-.397m7.5
                                          0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0
                                          00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5
                                          0a48.667 48.667 0 00-7.5 0" />
                                                  </svg>
                                              </a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                              <img class="object-cover rounded-full avatar-notification min-w-10 max-w-10 min-h-10 max-h-10"
                                  src="{{BASE_URL}}resources/images/default-avatar.jpg" alt="" />
                              <div class="message__content">
                                  <a href="#" class="text-sm font-normal text-gray-700">
                                      Lê Văn A
                                  </a>
                                  <div class="flex items-center gap-1">
                                      <p class="message max-w-[120px] truncate text-xs text-gray-700">
                                          Alo bạn, mình có thể hỏi một câu hỏi không?
                                      </p>
                                      <span class="text-xs text-gray-400">3 phút</span>
                                  </div>
                              </div>
                          </div>
                          <!-- ---------------------end message--------------------------------- -->
                          <a href="#" class="pt-2 text-xs font-medium text-center text-indigo-500 border-t">Xem
                              tất cả tin
                              nhắn</a>
                      </div>
                  </div>
              </li>
              <!-- ----------------------------btn notification------------------------ -->
              <li class="relative notification">
                  <div href="#" class="btn-notification">
                      <img src="{{BASE_URL}}resources/images/bell-icon.png" alt="" class="w-10" />
                  </div>
                  <span
                      class="absolute inline-block w-4 h-4 text-xs font-medium text-center text-white transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-none rounded-full top-1 right-2">
                      9
                  </span>
                  <!-- ----------------------List notification ------------------------>
                  <div style="max-height: 400px"
                      class="absolute right-0 z-50 hidden w-64 p-3 overflow-y-auto bg-white border rounded-lg shadow-lg dropdown-notification">
                      <h2 class="mb-4 text-xs font-semibold text-gray-700 sm:text-sm">
                          Thông báo
                      </h2>
                      <div class="flex flex-col gap-3 list__notification">
                          <div
                              class="relative flex justify-between gap-3 p-1 rounded-md cursor-pointer list__notification-item hover:bg-gray-100">
                              <div class="absolute top-0 right-0 flex justify-center options__notification-btn">
                                  <div class="relative" data-te-dropdown-position="dropstart">
                                      <button class="rounded-full motion-reduce:transition-none" type="button"
                                          data-te-dropdown-toggle-ref aria-expanded="false" data-te-ripple-init>
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                              stroke-width="1.5" stroke="currentColor"
                                              class="w-6 h-6 p-1 text-gray-400 rounded-full hover:bg-gray-200">
                                              <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75
                                        12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0
                                        11-1.5 0 .75.75 0 011.5 0z" />
                                          </svg>
                                      </button>
                                      <ul class="options__notification-box absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-md border-none bg-gray-200 bg-clip-padding text-left text-xs shadow-lg [&[data-te-dropdown-show]]:block"
                                          data-te-dropdown-menu-ref>
                                          <li>
                                              <a class="flex items-center w-full gap-2 px-4 py-2 text-xs font-normal border claymorphism-white hover:bg-gray-200 whitespace-nowrap text-neutral-700 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent"
                                                  href="#" data-te-dropdown-item-ref>Xóa thông báo
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                      class="w-4 h-4 text-gray-400">
                                                      <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M14.74 9l-.346 9m-4.788 0L9.26
                                              9m9.968-3.21c.342.052.682.107
                                              1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0
                                              01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772
                                              5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12
                                              .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0
                                              013.478-.397m7.5
                                              0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0
                                              00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5
                                              0a48.667 48.667 0 00-7.5 0" />
                                                  </svg>
                                              </a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                              <img class="object-cover rounded-full min-w-10 max-w-10 min-h-10 max-h-10 avatar-notification"
                                  src="{{BASE_URL}}resources/images/default-avatar.jpg" alt="" />
                              <div class="notification__content">
                                  <a href="#" class="text-sm font-semibold text-gray-700">
                                      Lê Văn A
                                  </a>
                                  <p class="text-xs text-gray-700">
                                      Lê Văn A đã thích bài viết của bạn
                                  </p>
                                  <p class="text-xs text-gray-400">9 giờ trước</p>
                              </div>
                              <!-- ------------------------------------------------------ -->
                          </div>
                          <!-- ------------------------------------------------------ -->
                      </div>
                  </div>
              </li>
              <!-- -----------------btn account header----------------- -->
              <li class="relative account">
                  <div class="w-7 btn-account">
                      <img src="{{BASE_URL}}resources/images/default-avatar.jpg" alt=""
                          class="w-full rounded-full avatar__account" />
                  </div>
                  <div
                      class="absolute right-0 z-50 hidden p-4 mt-2 bg-white border rounded-lg shadow-lg dropdown-account">
                      <ul class="flex flex-col gap-2 list-option">
                          <li class="flex items-center gap-3 mb-2">
                              <div class="w-7 account-btn">
                                  <img src="{{BASE_URL}}resources/images/default-avatar.jpg" alt=""
                                      class="w-full rounded-full" />
                              </div>
                              <a href="#" class="text-sm font-semibold text-gray-600">Lê Công
                                  Tiến</a>
                          </li>
                          <li class="flex items-center gap-2">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor"
                                  class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0
                                      00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966
                                      0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3
                                      3 0 016 0z" />
                              </svg>
                              <a href="#"
                                  class="text-xs font-normal text-gray-500 sm:text-sm whitespace-nowrap">Trang
                                  cá
                                  nhân</a>
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                              </svg>
                          </li>
                          <li class="flex items-center gap-2">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5" stroke="currentColor"
                                  class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0
                                          00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0
                                          002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                              </svg>
                              <a href="#"
                                  class="text-xs font-normal text-gray-500 sm:text-sm whitespace-nowrap">Đăng
                                  xuất</a>
                          </li>
                      </ul>
                  </div>
              </li>
          </ul>
      </section>
  </header>
