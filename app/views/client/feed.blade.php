@extends('client.layouts.master')
@section('content')
<div class="main_content">
    <div class="mcontainer">

        <!--  Feeds  -->
        <div class="lg:flex lg:space-x-10">
            <div class="lg:w-3/4 lg:px-20 space-y-7">

                <!-- ----------------------Story---------------- -->
                <div class="relative grid grid-cols-3 gap-2 user_story md:grid-cols-5 lg:-mx-20">
                    <!-- ----------------------Story 1---------------- -->
                    <a data-story-id="1" data-user-id="1" class="story" href="{{ IMG_PATH }}avatars/avatar-6.jpg"
                        uk-toggle="target: body ; cls: story-active">
                        <div class="single_story">
                            <img class="story-img" src="{{ IMG_PATH }}avatars/avatar-6.jpg" alt="">
                            <div class="story-avatar">
                                <img src="{{ IMG_PATH }}avatars/avatar-6.jpg" alt="">
                            </div>
                            <div class="story-content">
                                <h4>Erica Jones</h4>
                            </div>
                        </div>
                    </a>
                    <!-- ----------------------Story 2---------------- -->
                    <a data-story-id="2" data-user-id="2" class="story" href="{{ IMG_PATH }}avatars/avatar-7.jpg"
                        uk-toggle="target: body ; cls: story-active">
                        <div class="single_story story-2">
                            <img class="story-img" src="{{ IMG_PATH }}avatars/avatar-7.jpg" alt="">
                            <div class="story-avatar">
                                <img src="{{ IMG_PATH }}avatars/avatar-7.jpg" alt="">
                            </div>
                            <div class="story-content">
                                <h4>Erica Jones</h4>
                            </div>
                        </div>
                    </a>
                    <span
                        class="absolute z-10 items-center justify-center hidden p-2 -mr-4 text-xl bg-white rounded-full shadow-md lg:flex w-9 uk-position-center-right"
                        uk-toggle="target: body ; cls: story-active">
                        <i class="icon-feather-chevron-right"></i>
                    </span>
                </div>


                <!-- ----------------------Create post----------------------- -->

                <div class="p-4 card lg:mx-0" uk-toggle="target: #create-post-modal">
                    <div class="flex space-x-3">
                        <img src="{{ empty($user->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $user->avatar }}"
                            class="w-10 h-10 rounded-full object-cover">
                        <input placeholder="{{ $user->last_name }} ơi, bạn đang nghĩ gì thế  ?"
                            class="flex-1 h-10 px-6 bg-gray-100 rounded-full hover:bg-gray-200">
                    </div>
                    <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 text-sm font-semibold">
                        <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer  ">
                            <img src="{{ IMG_PATH }}icon/post-icon.png" class="w-10 h-auto">
                            <span class="ml-1 sm:ml-2 text-xs sm:text-sm whitespace-nowrap">Ảnh/Video</span>
                        </div>
                        <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer  ">
                            <img src="{{ IMG_PATH }}icon/tag-icon.png" class="w-11 h-auto">
                            <span class="ml-1 sm:ml-2 text-xs sm:text-sm whitespace-nowrap">Gắn thẻ</span>
                        </div>
                        <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer  ">
                            <img src="{{ IMG_PATH }}icon/feelings.png" class="w-9 h-auto">
                            <span class="ml-1 sm:ml-2 text-xs sm:text-sm whitespace-nowrap">Cảm xúc</span>
                        </div>
                    </div>
                </div>

                <!-------------------------- Post ---------------------------->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="flex justify-between">
                        <div class="flex flex-row px-2 py-3 mx-3">

                            <div class="w-auto h-auto rounded-full">
                                <img class="w-12 h-12 object-cover rounded-full shadow cursor-pointer" alt="User avatar"
                                    src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=2000&amp;q=80">
                            </div>
                            <div class="flex  flex-col mb-2 ml-4 mt-1">
                                <div class="text-gray-600 text-sm font-semibold">Lê Công Tiến</div>
                                <div class="flex w-full mt-1">
                                    <div class="text-blue-700 font-base text-xs mr-1 cursor-pointer">
                                        congtiendev
                                    </div>
                                    <div class="text-gray-400 font-thin text-xs">
                                        • 30 phút trước
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2">
                            <a href="#"> <i
                                    class="p-2 -mr-1 text-2xl transition rounded-full icon-feather-more-horizontal hover:bg-gray-200 dark:hover:bg-gray-700"></i>
                            </a>
                            <div class="hidden w-56 p-2 mx-auto mt-12 text-base text-gray-500 bg-white border border-gray-100 rounded-md shadow-md dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
                                uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">

                                <ul class="space-y-1">
                                    <li>
                                        <a href="#"
                                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-200 hover:text-gray-800 dark:hover:bg-gray-800">
                                            <i class="mr-1 uil-share-alt"></i> Share
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-200 hover:text-gray-800 dark:hover:bg-gray-800">
                                            <i class="mr-1 uil-edit-alt"></i> Edit Post
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-200 hover:text-gray-800 dark:hover:bg-gray-800">
                                            <i class="mr-1 uil-comment-slash"></i> Disable comments
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-200 hover:text-gray-800 dark:hover:bg-gray-800">
                                            <i class="mr-1 uil-favorite"></i> Add favorites
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="my-2 -mx-2 dark:border-gray-800">
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center px-3 py-2 text-red-500 rounded-md hover:bg-red-100 hover:text-red-500 dark:hover:bg-red-600">
                                            <i class="mr-1 uil-trash-alt"></i> Delete
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="border-b border-gray-100"></div>
                    <div class="text-gray-400 font-medium text-sm mb-7 mt-6 mx-3 px-2">
                        <div uk-lightbox>
                            <div class="swiper mySwiper ">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide rounded-md">
                                        <a href="{{ IMG_PATH }}avatars/340745011_3320815954895351_7942880981791125154_n.jpg"
                                            class="col-span-2">
                                            <img src="{{ IMG_PATH }}avatars/340745011_3320815954895351_7942880981791125154_n.jpg"
                                                alt=""
                                                class="w-full h-full rounded-md  sm:max-h-[350px] md:max-h-[450px] object-cover sm:min-h-[350px] md:min-h-[450px]">
                                        </a>
                                    </div>
                                    <div class="swiper-slide rounded-md">
                                        <a href="{{ IMG_PATH }}post/img-2.jpg">
                                            <img src="{{ IMG_PATH }}post/img-2.jpg" alt=""
                                                class="w-full h-full rounded-md  sm:max-h-[350px] md:max-h-[450px] object-cover sm:min-h-[350px] md:min-h-[450px] max-h-[300px] min-h-[300px]">
                                        </a>
                                    </div>
                                    <div class="swiper-slide rounded-md">
                                        <a href="{{ IMG_PATH }}avatars/retouch_2021121617152921.jpg" class="relative">
                                            <img src="{{ IMG_PATH }}avatars/retouch_2021121617152921.jpg" alt=""
                                                class="w-full h-full rounded-md  sm:max-h-[350px] md:max-h-[450px] object-cover sm:min-h-[350px] md:min-h-[450px] max-h-[300px] min-h-[300px]">
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm mb-6 mx-3 px-2">
                        Tôi là tùng 25 tuổi đang bị chú đầu trọc săn đuổi chú ấy cầm cái baton chú ấy xin miếng
                        da non
                    </div>
                    <div class="flex justify-between items-center px-5 py-3 border-t border-gray-100">
                        <div class="flex gap-5">
                            <svg data-post-id="1" data-user-id="1" data-like-count="1"
                                class="w-6 h-6 fill-black dark:fill-white like__post-btn" viewBox="0 0 48 48">
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
                        <svg data-post-id="1" data-user-id="1" class="w-6 h-6 save__post-btn fill-black dark:fill-white"
                            viewBox="0 0 48 48">
                            <path
                                d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex w-full border-t border-gray-100">
                        <div class="mt-3 mx-5 w-full flex text-xs">
                            <div class=" font-semibold like__post">
                                <span class="like__post-count-1">1</span>
                                lượt thích
                            </div>
                        </div>
                        <div class="mt-3 mx-5 flex flex-row text-xs whitespace-nowrap">
                            <div class=" font-semibold like__post">
                                <span class="like__post-count-1">1</span>
                                lượt chia sẻ
                            </div>
                        </div>
                    </div>
                    <div class="text-black  dark:text-white p-4 antialiased flex">
                        <img class="rounded-full h-8 w-8 mr-2 mt-1 " src="https://picsum.photos/id/1027/200/200">
                        <div>
                            <div class="bg-gray-100 border rounded-xl px-4 pt-2 pb-2.5">
                                <div class="font-medium  leading-relaxed">Sara Lauren</div>
                                <div class="text-xs leading-snug md:leading-normal">Lorem ipsum dolor sit amet,
                                    consectetur adipiscing
                                    elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                    enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.</div>
                            </div>
                            <div class="text-xs  mt-0.5 text-gray-500">14 giờ</div>
                        </div>

                    </div>
                    <div class="mb-0.5 text-sm text-[#737373] dark:text-gray-400 comment__post px-5">
                        Xem
                        <span class="comment__post-count">1</span>
                        bình luận
                    </div>
                    <div
                        class="relative flex items-center self-center w-full max-w-xl p-4 overflow-hidden text-gray-600 focus-within:text-gray-400">
                        <img class="w-10 h-10 object-cover rounded-full shadow mr-2 cursor-pointer" alt="User avatar"
                            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=2000&amp;q=80">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-6">
                            <button type="submit" class="p-1 focus:outline-none focus:shadow-none hover:text-blue-500">
                                <svg class="w-6 h-6 transition ease-out duration-300 hover:text-blue-500 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>

                            </button>
                        </span>
                        <input type="search"
                            class="w-full py-2 pl-4 pr-10 text-sm bg-gray-100 border border-transparent appearance-none rounded-tg placeholder-gray-400"
                            style="border-radius: 25px" placeholder="Nhập bình luận ..." autocomplete="off">
                    </div>
                </div>
                <!--------------------------End Post ---------------------------->


            </div>

            <!-- -------------Right sidebar------------ -->
            <div class="w-full lg:w-80 hidden md:block">
                <a href="#birthdays" uk-toggle>
                    <div class="px-4 py-3 mb-5 bg-white rounded-md shadow">
                        <h3 class="mb-1 font-semibold text-line-through"> Sinh nhật </h3>
                        <div class="w-fullflex px-2 py-2 -mx-2 duration-300 rounded-md hover:bg-gray-50">
                            <img src="{{ IMG_PATH }}icons/gift-icon.png" class="mr-3 w-9 h-9" alt="">
                            <p class="leading-6 line-clamp-2">Hôm nay là sinh nhật của <strong> Công Tiến
                                </strong> và <strong> 2</strong> người khác.
                            </p>
                        </div>
                    </div>
                </a>

                <h3 class="text-xl font-semibold"> Người liên hệ</h3>
                <div class="" uk-sticky="offset:80">
                    <nav class="mb-2 -mt-2 border-b responsive-nav extanded">
                        <ul>
                            <li class="text-left uk-active"><a class="active" href="#0">Bạn bè<span>
                                        310</span> </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- -----------------Contact-list--------------- -->
                    <div class="contact-list">
                        <a href="#">
                            <div class="contact-avatar">
                                <img src="{{ IMG_PATH }}avatars/avatar-1.jpg" alt="">
                                <span class="user_status status_online"></span>
                            </div>
                            <div class="contact-username"> Dennis Han</div>
                        </a>
                        <div uk-drop="pos: top-center ;animation: uk-animation-slide-top-small">
                            <div class="contact-list-box ">
                                <div class="contact-avatar">
                                    <img src="{{ IMG_PATH }}avatars/avatar-2.jpg" alt="">
                                    <span class="user_status status_online"></span>
                                </div>
                                <div class="contact-username"> Dennis Han</div>
                                <p>
                                    <ion-icon name="people" class="mr-1 text-lg"></ion-icon> Become friends with
                                    <strong> Stella Johnson </strong> and <strong> 14 Others</strong>
                                </p>
                                <!-- ------------hover preview------------- -->
                                <div class="contact-list-box-btns z-50">
                                    <button type="button" class="flex-1 block mr-2 button primary">
                                        <i class="mr-1 uil-envelope"></i> Send message</button>
                                    <button type="button" href="#" class="mr-2 button secondary button-icon">
                                        <i class="uil-list-ul"> </i> </button>
                                    <button type="button" a href="#" class="button secondary button-icon">
                                        <i class="uil-ellipsis-h"> </i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- ----------------------------------- -->
                        <a href="#">
                            <div class="contact-avatar">
                                <img src="{{ IMG_PATH }}avatars/avatar-2.jpg" alt="">
                                <span class="user_status"></span>
                            </div>
                            <div class="contact-username"> Erica Jones</div>
                        </a>
                        <div uk-drop="pos: top-center ;animation: uk-animation-slide-top-small">
                            <div class="contact-list-box">
                                <div class="contact-avatar">
                                    <img src="{{ IMG_PATH }}avatars/avatar-1.jpg" alt="">
                                    <span class="user_status"></span>
                                </div>
                                <div class="contact-username"> Erica Jones </div>
                                <p>
                                    <ion-icon name="people" class="mr-1 text-lg"></ion-icon> Become friends with
                                    <strong> Stella Johnson </strong> and <strong> 14 Others</strong>
                                </p>
                                <!-- ------------hover preview------------- -->
                                <div class="contact-list-box-btns">
                                    <button type="button" class="flex-1 block mr-2 button primary">
                                        <i class="mr-1 uil-envelope"></i> Send message</button>
                                    <button type="button" href="#" class="mr-2 button secondary button-icon">
                                        <i class="uil-list-ul"> </i> </button>
                                    <button type="button" a href="#" class="button secondary button-icon">
                                        <i class="uil-ellipsis-h"> </i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ----------------end contact-list------------- -->
                </div>
            </div>
            <!-- -------------End Right sidebar------------ -->
        </div>
    </div>
</div>


<!-- -------------------------Create post modal --------------------------------->

<div id="create-post-modal" class="create-post is-story" uk-modal>
    <form data-user-id="{{ $user->id }}" method="post" id="create-post" enctype="multipart/form-data"
        class="relative p-0 rounded-lg shadow-2xl uk-modal-dialog uk-modal-body uk-margin-auto-vertical lg:w-5/12 uk-animation-slide-bottom-small">

        <div class="py-3 text-center border-b">
            <h3 class="text-lg font-semibold"> Tạo bài viết</h3>
            <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 right-2" type="button" uk-close
                uk-tooltip="title: Đóng ; pos: bottom ;offset:7"></button>
        </div>
        <div class="user flex items-start flex-1 p-5 space-x-4">
            <img src="{{ empty($user->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $user->avatar }}"
                class="bg-gray-200 border border-white rounded-full w-11 h-11 object-cover">
            <div class="flex-1 pt-2">
                <textarea id="post_content"
                    class="text-lg md:text-sm font-medium text-black shadow-none resize-none uk-textare focus:shadow-none"
                    rows="5" name="post_content"
                    placeholder="{{ $user->last_name }} ơi, bạn đang nghĩ gì thế  ?"></textarea>
            </div>

        </div>
        <div class="bottom-0 w-full p-4 space-x-4 bsolute">
            <div class="flex items-center p-2 border border-purple-100 shadow-sm bg-gray-50 rounded-2xl">
                <span class="ml-1 text-sm">Thêm vào bài viết </span>
                <div class="flex items-center flex-1 space-x-2 justify-end">
                    <label for="posts__media-uploads">
                        <input multiple type="file" name="media[]" id="posts__media-uploads" class="sr-only" />
                        <img src="{{ IMG_PATH }}icon/post-icon.png" class="w-10 h-auto">
                    </label>
                    <div class="dropdown dropdown-top dropdown-end">
                        <label tabindex="0"><img src="{{ IMG_PATH }}icon/tag-icon.png" class=" w-11 h-auto"></label>
                        <ul tabindex="0"
                            class="dropdown-content flex flex-col gap-1 p-2 shadow bg-gray-100 dark:bg-base-100 rounded-box w-fit min-w-[200px]">
                            <div class="friend sm:max-h-[120px] overflow-y-auto p-1 hidden__scrollbar">
                                <div class="flex gap-2 items-center p-1">
                                    <input type="checkbox" class="w-5 h-5 ">
                                    <div class="flex gap-2 items-center">
                                        <img src="{{ IMG_PATH }}avatars/avatar-6.jpg"
                                            class="w-7 h-7 object-cover rounded-full">
                                        <span class="text-xs font-medium "> Erica Jones Erica Jones </span>
                                    </div>
                                </div>
                            </div>
                            <input type="search" name="search_friend" id="search_friend"
                                class="w-full px-2 h-10 text-xs rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                placeholder="Tìm kiếm bạn bè">
                        </ul>
                    </div>
                    <label> <img src="{{ IMG_PATH }}icon/locaiton-icon.png" class="w-10 h-auto"></label>
                    <div class="dropdown dropdown-top dropdown-end">
                        <label tabindex="0"><img src="{{ IMG_PATH }}icon/feelings.png" class=" w-10 h-auto"></label>
                        <div tabindex="0"
                            class="dropdown-content p-2 shadow bg-gray-100 dark:bg-base-100 rounded-box w-fit min-w-[200px] flex flex-col gap-1">
                            <h1 class="text-sm font-semibold text-center"> Bạn cảm thấy thế nào ? </h1>
                            <div class="max-h-[160px] border-t sm:max-h-[120px] overflow-y-auto p-1 hidden__scrollbar">
                                <div class="flex gap-2 items-center p-1">
                                    <input type="radio" class="w-5 h-5 ">
                                    <div class="flex gap-2 items-center">
                                        <img src="{{ IMG_PATH }}icon/feelings.png"
                                            class="w-7 h-7 object-cover rounded-full">
                                        <span class="text-sm font-medium text-black dark:text-white"> Vui vẻ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end w-full p-3 border-t whitespace-nowrap">
            <button type="submit" class="px-5 w-full font-medium text-white bg-yellow-500 rounded-md h-9">
                Chia sẻ </button>
        </div>
    </form>
</div>

<!-- story-preview -->
<div class="story-prev">
    <div class="story-sidebar uk-animation-slide-left-medium">
        <div class="items-center justify-between hidden py-2 md:flex">
            <h3 class="text-2xl font-semibold"> Tất cả tin</h3>
            <a href="#" class="text-blue-600"> Cài đặt</a>
        </div>

        <div class="story-sidebar-scrollbar" data-simplebar>
            <h3 class="text-lg font-medium hidden md:block"> Tin của bạn </h3>

            <a class="md:flex items-center py-2 space-x-4 rounded-lg hover:bg-gray-100 hidden  md:my-2 hover:text-gray-700"
                href="#">
                <svg class="w-12 h-12 p-3 ml-1 text-blue-500 bg-gray-200 rounded-full" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <div class="flex-1">
                    <div class="text-lg font-semibold"> Tạo tin mới</div>
                </div>
            </a>

            <h3 class="mt-1 text-lg font-medium lg:mt-3 hidden md:block"> Tin của bạn bè</h3>

            <div class="story-users-list"
                uk-switcher="connect: #story_slider ; toggle: >  ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium ">
                <!-- ------------------User story-1 -------------------- -->
                <a class="story-user-1 story-user" data-story-id="1" data-user-id="1"
                    href="{{ IMG_PATH }}avatars/avatar-6.jpg">
                    <div class="story-media">
                        <img src="{{ IMG_PATH }}avatars/avatar-6.jpg" alt="">
                    </div>
                    <div class="story-text">
                        <div class="story-username"> Dennis Han</div>
                        <p> <span class="story-count"> 2 new </span> <span class="story-time">
                                4Mn ago</span> </p>
                    </div>
                </a>
                <!-- ------------------User story-2 -------------------- -->
                <a class="story-user-2 story-user" data-story-id="2" data-user-id="2"
                    href="{{ IMG_PATH }}avatars/avatar-7.jpg">
                    <div class="story-media">
                        <img src="{{ IMG_PATH }}avatars/avatar-7.jpg" alt="">
                    </div>
                    <div class="story-text">
                        <div class="story-username"> Adrian Mohani</div>
                        <p> <span class="story-count"> 1 new </span> <span class="story-time">
                                1hr ago</span> </p>
                    </div>
                </a>
            </div>
        </div>

    </div>


    <!-- -------------------Story content--------------------- -->
    <div class="story-content">
        <ul class="uk-switcher" id="story_slider">
            <li id="story-content-1" data-story-id="1" data-user-id="1" class="relative">
                <div uk-lightbox>
                    <a href="{{ IMG_PATH }}avatars/279548448_2289919744484405_1358175479359291725_n.jpg"
                        data-alt="Image">
                        <img src="{{ IMG_PATH }}avatars/279548448_2289919744484405_1358175479359291725_n.jpg"
                            class="story-slider-image" data-alt="Image">
                    </a>
                </div>
            </li>

            <!-- --------------content story-2 --------------- -->

            <li id="story-content-2" data-story-id="2" data-user-id="2" class="relative">
                <div uk-lightbox>
                    <a href="{{ IMG_PATH }}avatars/340745011_3320815954895351_7942880981791125154_n.jpg"
                        data-alt="Image">
                        <img src="{{ IMG_PATH }}avatars/340745011_3320815954895351_7942880981791125154_n.jpg"
                            class="story-slider-image" data-alt="Image">
                    </a>
                </div>
            </li>
        </ul>

    </div>

    <!-- story colose button-->
    <span class="story-btn-close" uk-toggle="target: body ; cls: story-active"
        uk-tooltip="title:Close story ; pos: left">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
            </path>
        </svg>
    </span>

</div>

<!-- birthdays modal -->
<div id="birthdays" uk-modal>
    <div class="shadow-lg uk-modal-dialog uk-modal-body rounded-xl">
        <!-- close button -->
        <button class="uk-modal-close-default p-2.5 bg-gray-100 rounded-full m-3" type="button" uk-close></button>

        <div class="flex items-center mb-10 space-x-3">
            <ion-icon name="gift" class="p-1 text-xl text-yellow-500 rounded-md bg-yellow-50"></ion-icon>
            <div class="text-xl font-semibold">Sinh nhật hôm nay </div>
        </div>

        <div class="space-y-6">
            <div class="pb-2 space-y-6 sm:space-y-8">
                <!-- -------------------info user------------ -->
                <div class="flex items-center space-x-3 sm:space-x-6">
                    <img src="{{ IMG_PATH }}avatars/avatar-3.jpg" alt="" class="rounded-full sm:w-16 sm:h-16 w-14 h-14">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-base font-semibold"> <a href="#"> Alex Dolgove </a> </div>
                            <div class="text-sm font-medium text-gray-400"> 19 years old</div>
                        </div>
                        <div class="relative">
                            <input type="text" name="" id="" class="with-border" placeholder="Write her on Timeline">
                            <ion-icon name="happy" class="absolute text-2xl right-3 top-1/4"></ion-icon>
                        </div>
                    </div>
                </div>
                <!-- -------------------end info user------------ -->
            </div>
            <!-- ---------------Upcoming birthday----------------- -->
            <div class="relative cursor-pointer" uk-toggle="target: .upcoming__birthday; animation: uk-animation-fade">
                <div class="px-5 py-4 text-base font-semibold rounded-lg bg-gray-50"> Sinh nhật sắp tới</div>
                <i class="absolute text-xl text-gray-400 transform -translate-y-1/2 icon-feather-chevron-up right-4 top-1/2 upcoming__birthday"
                    hidden></i>
                <i
                    class="absolute text-xl text-gray-400 transform -translate-y-1/2 icon-feather-chevron-down right-4 top-1/2 upcoming__birthday"></i>
            </div>
            <!-- -------------------info user------------ -->
            <div class="mt-5 space-y-6 sm:space-y-8 upcoming__birthday" hidden>

                <div class="flex items-center space-x-3 sm:space-x-6">
                    <img src="{{ IMG_PATH }}avatars/avatar-6.jpg" alt="" class="rounded-full sm:w-16 sm:h-16 w-14 h-14">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-base font-semibold"> <a href="#"> Erica Jones </a> </div>
                            <div class="text-sm font-medium text-gray-400"> 19 years old</div>
                        </div>
                        <div class="relative">
                            <input type="text" name="" id="" class="with-border" placeholder="Write her on Timeline">
                            <ion-icon name="happy" class="absolute text-2xl right-3 top-1/4"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------end info user------------ -->
        </div>
        <!-- -------------------end upcoming birtday------------ -->
    </div>
</div>

@endsection