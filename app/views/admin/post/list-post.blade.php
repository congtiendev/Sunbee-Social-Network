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
                <input type="search" placeholder="Tìm kiếm bài viết..."
                    class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" />
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
                            <h2 class="text-sm font-semibold text-gray-900 author__name dark:text-gray-100">
                                {{ $user->first_name . ' ' . $user->last_name }}
                            </h2>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $user->username }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('admin/posts/create') }}" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="content" id="posts__content"
                                class="w-full h-32 p-3 text-gray-900 bg-gray-100 border border-gray-200 rounded-lg dark:border-gray-700 dark:text-gray-100 dark:bg-gray-700 focus:outline-none"
                                placeholder="Bạn đang nghĩ gì thế ?"></textarea>
                        </div>
                        <pre id="posts__content-preview" class="text-gray-900 font-montserrat text-start dark:text-gray-100"></pre>
                        <div id="posts__media-preview" class="grid grid-cols-2 gap-1"></div>
                        <div class="flex items-center justify-between mt-2 form-group">
                            <div
                                class="flex items-center gap-3 px-2 py-1 border border-gray-200 rounded-lg options-posts dark:border-gray-600">
                                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-100">
                                    Thêm vào bài viết
                                </h2>
                                <label for="posts__media-uploads">
                                    <input multiple type="file" name="media[]" accept="image/*,video/*"
                                        id="posts__media-uploads" class="sr-only" />
                                    <img class="w-7 h-7" src="{{ IMG_PATH }}icon/camera-icon.png" alt="" />
                                </label>

                                <img class="w-8 h-8" src="{{ IMG_PATH }}icon/feelings.png" alt="" />
                            </div>
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg">
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
                    <section
                        class="max-w-sm min-w-[300px] px-4 pt-4 pb-1 transition duration-500 transform bg-white shadow-lg posts-item dark:bg-boxdark rounded-xl hover:scale-105">
                        <section class="relative flex items-center gap-2 infor__user">
                            <!-- -------------------options posts------------------------- -->
                            <section class="absolute top-0 right-0 btn-options">
                                <section class="relative">
                                    <div class="dropdown dropdown-end">
                                        <label tabindex="1"><button
                                                class="p-1 rounded-full motion-reduce:transition-none hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none"
                                                type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                                        clip-rule="evenodd" />
                                                </svg></button></label>
                                        <ul tabindex="1"
                                            class="flex flex-col w-40 gap-1 px-3 py-2 text-sm text-gray-700 shadow dropdown-content bg-gray-50 dark:bg-base-100 rounded-box whitespace-nowrap dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-base-200">
                                            <li>
                                                <a href="#" class="flex items-center gap-2">Báo cáo
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="flex items-center gap-2">Lưu bài viết
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="flex items-center gap-2">Xóa bài viết
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- -------------dropdown post----------------- -->
                                </section>
                            </section>
                            <img src="{{ empty($post->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $post->avatar }}"
                                alt="" class="object-cover w-10 h-10 rounded-full" />
                            <section class="text-gray-700 name-user dark:text-white">
                                <a href="#">
                                    <h3 class="text-base font-semibold full-name">
                                        {{ $post->first_name }} {{ $post->last_name }}
                                    </h3>
                                </a>
                                <p class="text-xs text-gray-900 sm:text-sm time dark:text-gray-200">
                                    {{ date('H:i d/m/Y', strtotime($post->created_at)) }}
                                </p>
                            </section>
                        </section>
                        <div class="mt-3 text-gray-900 content-post dark:text-white">
                            <p class="text-xs sm:text-sm limited__content-3">
                                {{ $post->content }}
                            </p>
                            @if (!empty($post->hashtag))
                                <div
                                    class="hashtag text-xs sm:text-sm text-indigo-900 dark:text-indigo-400 font-bold flex gap-0.5 flex-wrap">
                                    <a href="#">
                                        {{ $post->hashtag }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="my-3 img__post">
                            <div class="w-full swiper sliderPosts rounded-xl">
                                <div class="w-full swiper-wrapper rounded-xl">
                                    @foreach ($post->media_url as $index => $name)
                                        @if (isImage($name))
                                            <div class="w-full swiper-slide rounded-xl">
                                                <img src="{{ POST_MEDIA_PATH . $name }}" alt=""
                                                    class="w-full min-h-[200px] max-h-[200px] object-cover rounded-xl" />
                                            </div>
                                        @else
                                            <div
                                                class="w-full min-h-[200px] max-h-[200px] bg-black swiper-slide rounded-xl">
                                                <video class="w-full min-h-[200px] max-h-[200px] object-contain rounded-xl"
                                                    controls>
                                                    <source src="{{ POST_MEDIA_PATH . $name }}" type="video/mp4">
                                                </video>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <section class="flex items-center justify-between p-2 mt-3 border-t-2 border-dashed interact-post">
                            <div class="flex items-center gap-1 like__count">
                                <svg data-post-id="{{ $post->post_id }}" data-user-id="{{ $_SESSION['auth']->id }}"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-black dark:text-gray-100 like__post-btn @if ($post->is_liked) active @endif">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                <span
                                    class="text-xs text-gray-900 dark:text-gray-100 like__post-count sm:text-base font-extralight">
                                    {{ intval($post->likes) }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1 count-like">
                                <img src="{{ IMG_PATH . 'icon/comment-icon.png' }}" alt="" class="w-6 h-6" />
                                <span
                                    class="text-xs text-gray-900 dark:text-gray-100 sm:text-base font-extralight">1</span>
                            </div>
                            <div class="flex items-center gap-1 count-like">
                                <span
                                    class="text-xs text-gray-900 dark:text-gray-100 sm:text-base font-extralight">1</span>
                                <img src="{{ IMG_PATH . 'icon/share-icon.png' }}" alt="" class="w-6 h-6" />
                            </div>
                        </section>
                    </section>
                    <!-- ------------------------------end post-------------------------------- -->
                @endforeach
            </section>
        </section>
    </main>
@endsection
