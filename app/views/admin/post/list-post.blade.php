@extends('admin.layouts.master')
@section('content')
<main class="w-full h-full p-2 overflow-y-auto sm:p-5 rounded-2xl hidden__scrollbar">
    <div class="flex flex-wrap items-center justify-between pb-3">
        <div class="relative flex items-center form-group">
            <span class="absolute">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>
            <form method="get" id="search__post" action="{{ route('admin/posts/search-post') }}">
                <input id="search__post-input" name="keyword" type="search" placeholder="Tìm kiếm bài viết..."
                    class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" />
            </form>
        </div>
        <label for="create__posts"
            class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-white transition-all duration-300 bg-indigo-600 font-montserrat rounded-xl hover:bg-indigo-500"
            style="box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.6)">
            <span class="hidden sm:block">Tạo bài viết</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
            </svg>
        </label>
        <!-- The button to open modal -->
        <input type="checkbox" id="create__posts" class="modal-toggle" />

        <div class="modal modal-bottom sm:modal-middle">
            <div class="modal-box bg-slate-50 dark:bg-base-100 hidden__scrollbar">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="text-xl font-bold text-gray-700 dark:text-gray-100">
                        Tạo bài viết
                    </h1>
                    <label for="create__posts">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </label>
                </div>
                <div class="flex items-center gap-2 mb-2 author">
                    <img class="object-cover w-10 h-10 rounded-full author__avatar"
                        src="{{ empty($user->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $user->avatar }}"
                        alt="author avatar" />
                    <div class="flex flex-col author__info item-center">
                        <h2 class="text-sm font-semibold text-[#000000] author__name dark:text-gray-100">
                            {{ $user->first_name . ' ' . $user->last_name }}
                        </h2>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $user->username }}
                        </span>
                    </div>
                </div>
                <form id="create__post-form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <textarea name="post_content" id="post_content"
                            class="w-full h-32 p-3 text-[#000000] bg-gray-100 border border-gray-200 rounded-lg dark:border-gray-700 dark:text-gray-100 dark:bg-gray-700 focus:outline-none"
                            placeholder="Bạn đang nghĩ gì thế ?"></textarea>
                    </div>

                    <div id="post__media-preview" class="grid grid-cols-2 gap-1 max-h-40"></div>
                    <div class="flex items-center justify-between mt-2 form-group">
                        <div
                            class="flex items-center gap-3 px-2 py-1 border border-gray-200 rounded-lg options-posts dark:border-gray-600">
                            <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-100">
                                Thêm vào bài viết
                            </h2>
                            <label for="post_media">
                                <input multiple type="file" name="media[]" accept="image/*,video/*" id="post_media"
                                    class="sr-only" />
                                <img class="w-7 h-7" src="{{ IMG_PATH }}icon/camera-icon.png" alt="" />
                            </label>
                            <img class="w-8 h-8" src="{{ IMG_PATH }}icon/feelings.png" alt="" />
                        </div>
                        <button data-user-id="{{ $_SESSION['auth']->id }}" id="create__post-btn" type="submit"
                            class="px-4 py-2 text-white bg-blue-500 rounded-lg">
                            Đăng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section class="flex items-center justify-center w-full">
        <!-- -----------------------list post----------------------- -->
        <section
            class="grid px-4 space-y-4 list-posts md:px-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 sm:gap-5 md:gap-6 md:space-y-0">
            @foreach ($posts as $post)
            <!-- --------------------------------posts------------------------------ -->
            <section id="post-{{ $post->post_id }}"
                class="max-w-sm min-w-[250px] px-4 pt-4 pb-1 transition duration-500 transform bg-white shadow-lg posts-item dark:bg-boxdark rounded-xl hover:scale-105">
                <section class="relative flex items-center gap-2 infor__user">
                    <!-- -------------------options posts------------------------- -->
                    <section class="absolute top-0 right-0 btn-options">
                        <section class="relative">
                            <div class="dropdown dropdown-end">
                                <label tabindex="{{ $post->post_id }}"><button
                                        class="p-1 rounded-full motion-reduce:transition-none hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none"
                                        type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-6 h-6">
                                            <path fill-rule="evenodd"
                                                d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                                clip-rule="evenodd" />
                                        </svg></button></label>
                                {{-- ------------------POST OPTIONS ---------------}}
                                <ul tabindex="{{ $post->post_id }}"
                                    class="z-50 bg-white shadow dropdown-content dark:bg-base-100 rounded-xl">
                                    <div
                                        class="w-48 p-2 text-sm text-gray-500 bg-white border border-gray-100 dark:bg-base-100 rounded-xl dark:text-gray-100 dark:border-gray-700">
                                        <ul class="space-y-1">
                                            <li>
                                                <a href="#"
                                                    class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5 text-gray-900 dark:text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                    Chỉnh sửa bài viết
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                                    <svg class="w-5 h-5 fill-black dark:fill-white" viewBox="0 0 48 48">
                                                        <path clip-rule="evenodd"
                                                            d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                                                            fill-rule="evenodd"></path>
                                                    </svg>
                                                    Tắt bình luận
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5 text-gray-900 dark:text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                                    </svg>

                                                    Đi đến bài viết
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5 text-gray-900 dark:text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                                    </svg>
                                                    Báo cáo bài viết
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="my-2 -mx-2 border-gray-300 dark:border-gray-500" />
                                            </li>
                                            <li>
                                                <a href="#" data-post-id="{{ $post->post_id }}"
                                                    data-user-id="{{ $post->user_id }}"
                                                    class="flex items-center gap-3 p-2 text-red-500 rounded-md hover:bg-red-100 hover:text-white dark:hover:bg-red-600 delete__post-btn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-red-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>

                                                    Xóa bài viết
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </ul>
                                {{-- --------------------------END POST OPTIONS--------------------- --}}
                            </div>
                        </section>
                    </section>
                    <img src="{{ empty($post->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $post->avatar }}"
                        alt="" class="object-cover w-10 h-10 rounded-full" />
                    <div>
                        <a href="#">
                            <h3 class="text-sm font-semibold text-[#000000] dark:text-white full-name">
                                {{ $post->first_name }} {{ $post->last_name }}
                            </h3>
                        </a>
                        <span class="date text-sm text-[#737373] dark:text-gray-200 whitespace-nowrap">
                            {{ date('H:i d/m/Y', strtotime($post->post_date)) }}</span>
                    </div>
                </section>

                <div class="my-3 img__post">
                    <div class="w-full swiper sliderPosts rounded-xl">
                        <div onclick="post__details_{{ $post->post_id }}.showModal()"
                            class="w-full swiper-wrapper rounded-xl">
                            @foreach ($post->medias as $media)
                            @if (isImage($media->post_media))
                            <div class="w-full swiper-slide rounded-xl">
                                <img src="{{ POST_MEDIA_PATH . $media->post_media }}" alt=""
                                    class="w-full min-h-[200px] max-h-[200px] object-cover rounded-xl" />
                            </div>
                            @else
                            <div class="w-full min-h-[200px] max-h-[200px] bg-black swiper-slide rounded-xl">
                                <video class="w-full min-h-[200px] max-h-[200px] object-contain rounded-xl" controls>
                                    <source src="{{ POST_MEDIA_PATH . $media->post_media }}" type="video/mp4">
                                </video>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <section id="post__action-{{ $post->post_id }}">
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex gap-5">
                            <svg data-post-id="{{ $post->post_id }}" data-user-id="{{ $_SESSION['auth']->id }}"
                                class="w-6 h-6 fill-black dark:fill-white like__post-btn  @if ($post->is_liked) active @endif"
                                height="24" viewBox="0 0 48 48" width="24">
                                <path
                                    d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z">
                                </path>
                            </svg>
                            <svg class="w-6 h-6 comment-icon fill-black dark:fill-white" viewBox="0 0 48 48">
                                <path clip-rule="evenodd"
                                    d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                                    fill-rule="evenodd"></path>
                            </svg>
                            <svg class="w-6 h-6 share-icon fill-black dark:fill-white" viewBox="0 0 48 48">
                                <path
                                    d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z">
                                </path>
                            </svg>
                        </div>
                        <svg data-post-id="{{ $post->post_id }}" data-user-id="{{ $_SESSION['auth']->id }}"
                            class="save__post-btn w-6 h-6 fill-black dark:fill-white @if ($post->is_saved) active @endif"
                            viewBox="0 0 48 48">
                            <path
                                d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
                            </path>
                        </svg>
                    </div>
                    <section class="my-2 text-[#000000] text-sm total-interact dark:text-white">
                        <div class="font-semibold like__post"><span class="like__post-count-{{ $post->post_id }}">
                                {{ intval($post->like_count) }}</span> lượt thích
                        </div>
                        @if (!empty($post->post_content))
                        <div class="my-1 text-sm text-[#000000] dark:text-white">
                            <a href="#" class="font-medium limited__content-3">{{ $post->username }}</a>
                            <p>{{ $post->post_content }}</p>
                        </div>
                        @endif
                        <div class=" text-sm text-[#737373] dark:text-gray-400 comment__post">
                            @if ($post->comment_count > 0)
                            <a href="#">
                                Xem <span class="comment__post-count_{{ $post->post_id }}">{{
                                    intval($post->comment_count) }}</span>
                                bình luận
                            </a>
                            @else
                            <span class="no__comment_{{ $post->post_id }}">Chưa có bình luận</span>
                            @endif
                        </div>
                    </section>
                    <!-- ------------------------------ DETAILS POST MODAL-------------------------------- -->
                    <dialog id="post__details_{{ $post->post_id }}" class="modal">
                        <form method="dialog"
                            class="relative z-10 w-11/12 max-w-6xl p-0 bg-white modal-box dark:bg-base-100 hidden__scrollbar">
                            <button for="post__details_{{ $post->post_id }}"
                                class="absolute z-40 border-none outline-none right-2 top-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-gray-900 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <!-- -------------------------------DETAILS POSTS MODAL ---------------------------- -->
                            <div class="w-full mx-auto sm:max-w-3xl md:max-w-full lg:max-w-screen-xl">
                                <div class="grid md:grid-cols-2">
                                    <div>
                                        <!-- ------------------------------DETAILS POSTS SLIDER----------------------------- -->
                                        <section
                                            class="rounded-xl max-w-xs  xs:max-w-[370px]  sm:max-w-2xl md:max-w-3xl lg:max-w-screen-xl swiper sliderPosts ">
                                            <div class=" swiper-wrapper rounded-xl">
                                                @foreach ($post->medias as $media)
                                                @if (isImage($media->post_media))
                                                <div
                                                    class="flex items-center p-2 bg-white w-fit swiper-slide rounded-xl">
                                                    <img src="{{ POST_MEDIA_PATH . $media->post_media }}" alt=""
                                                        class="rounded-xl w-full flex-shrink-0 mx-auto h-full min-h-[320px] max-h-[320px] xs:min-h-[355px] xs:max-h-[355px] sm:min-h-[400px] sm:max-h-[400px] md:min-h-[500px] md:max-h-[500px]  object-cover" />
                                                </div>
                                                @else
                                                <div class="flex p-2 w-fit swiper-slide glassmorphism rounded-xl">
                                                    <video
                                                        class="rounded-xl w-full flex-shrink-0 mx-auto h-full min-h-[320px] max-h-[320px] xs:min-h-[355px] xs:max-h-[355px] sm:min-h-[400px] sm:max-h-[400px] md:min-h-[500px] md:max-h-[500px]  object-contain"
                                                        controls>
                                                        <source src="{{ POST_MEDIA_PATH . $media->post_media }}"
                                                            type="video/mp4" />
                                                    </video>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </section>
                                        <!-- ------------------------------END DETAILS POSTS SLIDER----------------------------- -->
                                    </div>
                                    <!-- -------------------------------DETAILS POSTS CONTENT---------------------------------- -->
                                    <section class="  flex flex-col max-h-[500px] details__posts justify-between">
                                        <!-- --------------------------------AUTHOR INFO--------------------------------- -->
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2 px-5 py-2 author">
                                                <div class="avatar">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-full">
                                                        <img
                                                            src="{{ empty($post->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $post->avatar }}" />
                                                    </div>
                                                </div>
                                                <div class="author__name">
                                                    <a href="#"
                                                        class="text-sm text-[#262626] dark:text-white font-semibold">{{
                                                        $post->username }}</a>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                                        {{ $post->post_date }}</p>
                                                    </p>
                                                </div>
                                            </div>
                                            <pre
                                                class="font-sunbee  px-4 pt-2 pb-3 border-b border-gray-200 dark:border-gray-700 whitespace-normal text-sm text-[#000000] dark:text-gray-100">{{ $post->post_content }}</pre>


                                            <!-- --------------------------------DETAILS POSTS COMMENTS---------------------- -->
                                            <section id="post__comments__{{ $post->post_id }}"
                                                class=" overflow-y-auto min-h-[100px] max-h-[220px] lg:max-h-[250px] hidden__scrollbar">
                                                @if ($post->comment_count == 0)
                                                <div
                                                    class="flex flex-col items-center justify-center mx-auto mt-20 text-sm text-center text-gray-500 empty__comment dark:text-gray-400">
                                                    <span>Chưa có bình luận nào</span>
                                                </div>
                                                @else
                                                @foreach ($post->comments as $comment)
                                                <!-- ------------------------------COMMENTS------------------------- -->
                                                <div id="comment__{{ $comment->comment_id }}"
                                                    class="relative flex p-4 antialiased text-black">
                                                    {{-- ----------------OPTIONS COMMENT------------ --}}
                                                    <div class="absolute top-0 comment-options right-5">
                                                        <div class="z-50 dropdown dropdown-end">
                                                            <label tabindex="{{ $comment->comment_id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor"
                                                                    class="w-6 h-6 text-gray-900 dark:text-white">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                                </svg>
                                                            </label>
                                                            <div tabindex="{{ $comment->comment_id }}"
                                                                class="bg-white shadow dropdown-content dark:bg-base-100 rounded-xl">
                                                                <ul
                                                                    class="p-2 text-xs font-normal text-gray-500 bg-white border border-gray-100 w-fit whitespace-nowrap dark:bg-base-100 rounded-xl dark:text-gray-100 dark:border-gray-700">
                                                                    <li>
                                                                        <a href="#"
                                                                            class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="1.5" stroke="currentColor"
                                                                                class="w-4 h-4 text-gray-900 dark:text-white">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                            </svg>

                                                                            Chỉnh sửa bình luận
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="#"
                                                                            class="flex items-center gap-3 p-1 rounded-md hover:bg-gray-100 text-[#000000] dark:text-white dark:hover:bg-gray-800">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="1.5" stroke="currentColor"
                                                                                class="w-4 h-4 text-gray-900 dark:text-white">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                                                            </svg>
                                                                            Báo cáo bình luận
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <hr
                                                                            class="my-1 border-gray-300 dark:border-gray-500" />
                                                                    </li>
                                                                    <li>
                                                                        <button
                                                                            data-comment-id="{{ $comment->comment_id }}"
                                                                            data-post-id="{{ $post->post_id }}"
                                                                            class="flex items-center gap-3 p-1 text-red-500 rounded-md hover:bg-red-100 hover:text-white dark:hover:bg-red-600 delete__comment">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="1.5" stroke="currentColor"
                                                                                class="w-4 h-4 text-red-500">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                            </svg>
                                                                            Xóa bình luận
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- ----------------END OPTIONS COMMENT------------ --}}
                                                    <img class="w-8 h-8 mt-1 mr-2 rounded-full user__avatar"
                                                        src="{{ empty($comment->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $comment->avatar }}" />
                                                    <div class="author_and_content">
                                                        <a href="#"
                                                            class="text-sm font-semibold leading-relaxed username dark:text-gray-100">
                                                            {{ $comment->username }}
                                                        </a>
                                                        @if ($comment->comment_content)
                                                        <div
                                                            class="bg-gray-100 dark:bg-gray-800 rounded-lg px-4 pt-2 pb-2.5">
                                                            <p
                                                                class="text-xs leading-snug dark:text-gray-100 md:leading-normal">
                                                                {{ $comment->comment_content }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div
                                                            class="comment_media_{{ $post->post_id }} w-[65%] h-auto my-1 rounded-lg">
                                                            @if($comment->comment_media)
                                                            @if(isImage($comment->comment_media))
                                                            <img class="w-full h-full rounded-lg"
                                                                src="{{ COMMENT_MEDIA_PATH . $comment->comment_media }}" />
                                                            @else
                                                            <video class="w-full h-full rounded-lg" controls>
                                                                <source
                                                                    src="{{ COMMENT_MEDIA_PATH . $comment->comment_media }}"
                                                                    type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                            @endif
                                                            @endif
                                                        </div>
                                                        <span class="text-xs text-gray-500">
                                                            {{ timeAgo($comment->comment_date) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- ------------------------------END COMMENTS------------------------- -->
                                                @endforeach
                                                @endif
                                            </section>
                                        </div>

                                        <section id="details__post-action_{{ $post->post_id }}" class="p-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-5">
                                                    <svg data-post-id="{{ $post->post_id }}"
                                                        data-user-id="{{ $_SESSION['auth']->id }}"
                                                        class="w-6 h-6 fill-black dark:fill-white like__post-btn @if ($post->is_liked) active @endif"
                                                        height="24" viewBox="0 0 48 48" width="24">
                                                        <path
                                                            d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-6 h-6 comment-icon fill-black dark:fill-white"
                                                        viewBox="0 0 48 48">
                                                        <path clip-rule="evenodd"
                                                            d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
                                                            fill-rule="evenodd"></path>
                                                    </svg>
                                                    <svg class="w-6 h-6 share-icon fill-black dark:fill-white"
                                                        viewBox="0 0 48 48">
                                                        <path
                                                            d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <svg data-post-id="{{ $post->post_id }}"
                                                    data-user-id="{{ $_SESSION['auth']->id }}"
                                                    class="save__post-btn w-6 h-6 fill-black dark:fill-white @if ($post->is_saved) active @endif"
                                                    viewBox="0 0 48 48">
                                                    <path
                                                        d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <section class="my-2 text-[#000000] total-interact dark:text-white">
                                                <div class="pb-2 text-sm font-semibold like__post">
                                                    <span class="like__post-count-{{ $post->post_id }}">
                                                        {{ intval($post->like_count) }}</span>
                                                    lượt thích
                                                </div>
                                                <div id="add__comment_{{ $post->post_id }}"
                                                    class="relative flex items-center gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                                    <label for="comment_media_upload_{{ $post->post_id }}">
                                                        <input data-post-id="{{ $post->post_id }}"
                                                            id="comment_media_upload_{{ $post->post_id }}" type="file"
                                                            name="comment_media" class="sr-only comment_media_upload"
                                                            accept="image/*,video/*" />
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-7 h-7 text-[#000000] dark:text-white">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                                        </svg>
                                                    </label>
                                                    <input id="comment_content_input_{{ $post->post_id }}" type="text"
                                                        placeholder="Thêm bình luận..." name="comment_content"
                                                        class="w-full pt-1 text-sm text-[#000000] bg-transparent border-none rounded outline-none dark:text-white " />
                                                    <button data-post-id="{{ $post->post_id }}"
                                                        data-user-id="{{ $_SESSION['auth']->id }}"
                                                        id="add__comment-btn_{{ $post->post_id }}"
                                                        class="absolute right-0 text-sm font-semibold text-blue-500 add__comment-btn dark:text-white ">
                                                        <img id="comment__loading_{{ $post->post_id }}"
                                                            src="{{ IMG_PATH }}illustration/loading-bee-btn.gif"
                                                            class="hidden w-14">
                                                        <span
                                                            id="add__comment-btn-text_{{ $post->post_id }}">Đăng</span>
                                                    </button>

                                                </div>
                                                <div id="comment__media-preview_{{ $post->post_id }}"
                                                    class="w-20 h-auto">
                                                </div>
                                            </section>
                                        </section>
                                    </section>
                                </div>
                            </div>
                        </form>
                    </dialog>
                </section>
            </section>
            <!-- ------------------------------ END POST-------------------------------- -->
            @endforeach
        </section>
    </section>
</main>
@endsection