<header>
    <div class="header_wrap">
        <div class="header_inner mcontainer">
            <div class="left_side">
                <span class="slide_menu" uk-toggle="target: #wrapper ; cls: is-collapse is-active">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M3 4h18v2H3V4zm0 7h12v2H3v-2zm0 7h18v2H3v-2z" fill="currentColor"></path>
                    </svg>
                </span>

                <div id="logo">
                    <a href="feed.html">
                        <img src="{{ IMG_PATH }}logo/logo.png" alt="">
                        <img src="{{ IMG_PATH }}logo/logo.png" class="logo_mobile" alt="">
                    </a>
                </div>
            </div>

            <!-- search icon for mobile -->
            <div class="header-search-icon" uk-toggle="target: #wrapper ; cls: show-searchbox"> </div>
            <div class="header_search"><i class="uil-search-alt"></i>
                <input value="" type="text" class="form-control" placeholder="Tìm kiếm.." autocomplete="on">
                <div uk-drop="mode: click" class="header_search_dropdown">

                    <h4 class="search_title"> Tìm kiếm gần đây </h4>
                    <ul class="search_recently">
                        <li>
                            <a href="#" class="skeleton">
                                <img src="{{ IMG_PATH }}avatars/avatar-1.jpg" alt="" class="list-avatar">
                                <div class="list-name"> Nguyễn Gia Thái</div>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="right_side">

                <div class="header_widgets">
                    <a href="#" class="is_icon skeleton" uk-tooltip="title: Cart">
                        <img class="w-8 h-auto" src="{{ IMG_PATH }}icon/cart-icon.png" alt="">
                    </a>
                    <!-- ---------------Dropdown cart------------ -->
                    <div uk-drop="mode: click" class="header_dropdown dropdown_cart">
                        <div class="drop_headline">
                            <h4> Giỏ hàng</h4>
                            <a href="#" class="px-2 py-1 mr-2 underline rounded-md btn_action hover:bg-gray-100 skeleton">
                                Thanh toán </a>
                        </div>
                        <ul class="dropdown_cart_scrollbar" data-simplebar>
                            <li>
                                <div class="cart_avatar skeleton">
                                    <img src="{{ IMG_PATH }}product/2.jpg" alt="">
                                </div>
                                <div class="cart_text">
                                    <div class="skeleton font-semibold leading-4 mb-1.5 text-base line-clamp-1">
                                        Wireless headphones </div>
                                    <p class="text-sm">Type Accessories </p>
                                </div>
                                <div class="cart_price">
                                    <span class=" skeleton"> $14.99 </span>
                                    <button class="type skeleton"> Xóa</button>
                                </div>
                            </li>
                        </ul>
                        <div class="cart_footer">
                            <p class=" skeleton"> Subtotal : $ 320 </p>
                            <h1 class=" skeleton"> Total : <strong> $ 320</strong> </h1>
                        </div>
                    </div>
                    <!-- ------------End cart---------------- -->
                    <a href="#" class="is_icon" uk-tooltip="title: Thông báo">
                        <img class="h-auto w-7" src="{{ IMG_PATH }}icon/notify-icon.png" alt="">
                        <span>3</span>
                    </a>
                    <!-- ----------------Dropdown notify----------- -->
                    <div uk-drop="mode: click" class="header_dropdown">
                        <div class="dropdown_scrollbar" data-simplebar>
                            <div class="drop_headline">
                                <h4>Thông báo </h4>
                                <div class="btn_action">
                                    <a href="#" data-tippy-placement="left" title="Cài đặt thông báo">
                                        <i class="icon-feather-settings"></i>
                                    </a>
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar">
                                            <img src="{{ IMG_PATH }}avatars/avatar-1.jpg" alt="">
                                        </div>
                                        <span class="drop_icon bg-gradient-primary">
                                            <i class="icon-feather-thumbs-up"></i>
                                        </span>
                                        <div class="drop_text">
                                            <p>
                                                <strong>Adrian Mohani</strong> Like Your Comment On Video
                                                <span class="text-link">Learn Prototype Faster </span>
                                            </p>
                                            <time> 2 hours ago </time>
                                        </div>
                                    </a>
                                </li>
                                <li class="not-read">
                                    <a href="#">
                                        <div class="drop_avatar status-online"> <img src="{{ IMG_PATH }}avatars/avatar-2.jpg" alt="">
                                        </div>
                                        <div class="drop_text">
                                            <p>
                                                <strong>Stella Johnson</strong> Replay Your Comments in
                                                <span class="text-link">Adobe XD Tutorial</span>
                                            </p>
                                            <time> 9 hours ago </time>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a href="#" class="see-all"> Xem tất cả thông báo</a>
                    </div>

                    <!-------------- Message -------------->
                    <a href="#" class="is_icon" uk-tooltip="title: Tin nhắn">
                        <img class="h-auto w-7" src="{{ IMG_PATH }}icon/message-icon.png" alt="">
                        <span>4</span>
                    </a>
                    <!-- ----------Drop message----------- -->
                    <div uk-drop="mode: click" class="header_dropdown is_message">
                        <div class="dropdown_scrollbar" data-simplebar>
                            <div class="drop_headline">
                                <h4>Tin nhắn </h4>
                                <div class="btn_action">
                                    <a href="#" data-tippy-placement="left" title="Cài đặt tin nhắn">
                                        <i class="icon-feather-settings"></i>
                                    </a>
                                </div>
                            </div>
                            <input type="text" class="uk-input" placeholder="Tìm kiếm tin nhắn...">
                            <ul class="list-message">
                                <li class="un-read">
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="{{ IMG_PATH }}avatars/avatar-7.jpg" alt="">
                                        </div>
                                        <div class="drop_text">
                                            <strong> Stella Johnson </strong> <time>12:43 PM</time>
                                            <p> Alex will explain you how ... </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="drop_avatar"> <img src="{{ IMG_PATH }}avatars/avatar-1.jpg" alt="">
                                        </div>
                                        <div class="drop_text">
                                            <strong> Adrian Mohani </strong> <time> 6:43 PM</time>
                                            <p> Thanks for The Answer sit amet... </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a href="#" class="see-all"> Xem tất cả tin nhắn</a>
                    </div>
                    <!-- ------------------Profile---------------- -->
                    <a href="#">
                        <img src="{{ empty($user->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $user->avatar }}" class="object-cover is_avatar" alt="">
                    </a>
                    <!-- ------------------Drop Profile---------------- -->
                    <div uk-drop="mode: click;offset:5" class="header_dropdown profile_dropdown">
                        <a href="#" class="flex items-center user">
                            <div class="user_avatar">
                                <img class="object-cover is_avatar" src="{{ empty($user->avatar) ? AVATAR_PATH . 'default-avatar.jpg' : AVATAR_PATH . $user->avatar }}" alt="avatar">
                            </div>
                            <div class="user_name">
                                <h1 class="text-sm">{{ $user->first_name }} {{ $user->last_name }}</h1>
                                <span> {{ $user->username }}</span>
                            </div>
                        </a>
                        <hr>
                        <a href="#">
                            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                            Cài đặt tài khoản
                        </a>
                        <a href="groups.html">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />
                            </svg>
                            Quản lý trang
                        </a>
                        <a href="pages-setting.html">
                            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            </svg>
                            Đơn hàng
                        </a>
                        <a href="#" id="night-mode" class="btn-night-mode">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>
                            Chế độ ban đêm
                            <span class="btn-night-mode-switch">
                                <span class="uk-switch-button"></span>
                            </span>
                        </a>
                        <a href="{{ route('logout') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Đăng xuất
                        </a>
                    </div>
                    <!-- ------------------End Profile---------------- -->
                </div>
            </div>
        </div>
    </div>
</header>
