<div uk-toggle="target: #offcanvas-chat" class="start-chat">
    <img src="{{IMG_PATH}}icon/chat-icon.png" class=" w-10 h-10">
</div>
<div id="offcanvas-chat" uk-offcanvas="flip: true; overlay: true">
    <div class="w-full p-0 bg-white shadow-2xl uk-offcanvas-bar lg:w-80">

        <div class="relative px-4 pt-5">

            <h3 class="mb-2 text-2xl font-bold"> Tin nhắn </h3>

            <div class="absolute flex items-center space-x-2 right-3 top-4">

                <button class="relative inset-0 px-2 -mt-1 rounded-full uk-offcanvas-close lg:hidden blcok"
                    type="button" uk-close></button>

                <a href="#" uk-toggle="target: #search;animation: uk-animation-slide-top-small">
                    <ion-icon name="search" class="p-1 text-xl rounded-full hover:bg-gray-100"></ion-icon>
                </a>
                <a href="#">
                    <ion-icon name="settings-outline" class="p-1 text-xl rounded-full hover:bg-gray-100"></ion-icon>
                </a>
                <a href="#">
                    <ion-icon name="ellipsis-vertical" class="p-1 text-xl rounded-full hover:bg-gray-100">
                    </ion-icon>
                </a>
                <div class="hidden w-56 p-2 mx-auto mt-12 text-gray-500 bg-white border border-gray-100 rounded-md shadow-md dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
                    uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small; offset:5">
                    <ul class="space-y-1">
                        <li>
                            <a href="#"
                                class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800">
                                <ion-icon name="star-outline" class="pr-2 text-xl"></ion-icon> Tạo nhóm chat
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="absolute bg-white z-10 w-full -mt-5 lg:-mt-2 transform translate-y-1.5 py-2 border-b items-center flex"
            id="search" hidden>
            <input type="text" placeholder="Tìm kiếm..." class="flex-1">
            <ion-icon name="close-outline" class="p-1 mr-4 text-2xl rounded-full cursor-pointer hover:bg-gray-100"
                uk-toggle="target: #search;animation: uk-animation-slide-top-small"></ion-icon>
        </div>

        <nav class="mb-2 -mt-2 border-b responsive-nav extanded">
            <ul uk-switcher="connect: #chats-tab; animation: uk-animation-fade">
                <li class="uk-active"><a class="active" href="#0"> Bạn bè </a></li>
                <li><a href="#0">Nhóm <span> 10 </span> </a></li>
            </ul>
        </nav>

        <div class="px-2 contact-list uk-switcher" id="chats-tab">
            <div class="p-1 contact">
                <a href="chats-friend.html">
                    <div class="contact-avatar">
                        <img src="{{IMG_PATH}}avatars/avatar-7.jpg" alt="">
                    </div>
                    <div class="contact-username"> Alex Dolgove</div>
                </a>
            </div>

            <div class="p-1 group-chat">
                <a href="chats-group.html">
                    <div class="contact-avatar">
                        <img src="{{IMG_PATH}}avatars/avatar-1.jpg" alt="">
                        <span class="user_status status_online"></span>
                    </div>
                    <div class="contact-username"> Dennis Han</div>
                </a>
            </div>

        </div>
    </div>
</div>