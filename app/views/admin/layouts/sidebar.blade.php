    <aside class="sidebar overflow-y-auto w-[85px] hidden__scrollbar hidden lg:block md:py-2">
        <!-- menu pc -->
        <nav class="w-full sidebar__pc">
            <ul class="flex flex-col items-center justify-center h-full gap-5 p-4 rounded-xl glassmorphism">
                <li>
                    <a href="{{route('dashboard')}}">
                    <div class="w-16 h-auto mx-auto logo">
                        <img data-tilt data-tilt-scale="1.1" src="{{BASE_URL}}resources/images/logo.png" alt="logo"
                            class="w-full logo-img" />
                    </div>
                    </a>
                </li>
                <li class="flex items-center rounded-xl">
                    <a href="{{route('dashboard')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-9 h-9 menu-btn"
                         src="{{BASE_URL}}resources/images/home-icon.png"
                        alt="" />
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{route('trending')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-7 h-7" src="{{BASE_URL}}resources/images/trending-icon.png"
                        alt="" />
                    </a>
                </li>

                <li class="flex items-center">
                    <a href="{{route('list-posts')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-9 h-9" src="{{BASE_URL}}resources/images/post-icon.png"
                        alt="" />
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{route('list-accounts')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-9 h-9" src="{{BASE_URL}}resources/images/account-icon.png"
                        alt="" />
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{route('list-users')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-9 h-9" src="{{BASE_URL}}resources/images/user-icon.png"
                        alt="" />
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{route('list-contacts')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-8 h-8" src="{{BASE_URL}}resources/images/contact-icon.png"
                        alt="" />
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{route('statistical')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-9 h-9"
                         src="{{BASE_URL}}resources/images/statistical-icon.png"
                        alt="" />
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{route('list-ads')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-9 h-9" src="{{BASE_URL}}resources/images/ads-icon.png"
                        alt="" />
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{route('setting-admin')}}">
                    <img data-tilt data-tilt-scale="1.1" class="w-9 h-9" src="{{BASE_URL}}resources/images/setting-icon.png"
                        alt="" />
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
