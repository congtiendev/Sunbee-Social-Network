@extends('auth.master')
@section('content')
    <main class="items-center justify-center gap-20 pt-5 md:flex bg-gray-50 dark:bg-gray-900">
        <div class="items-center hidden md:flex">
            <div style="
              background-image: url('{{ IMG_PATH }}illustration/iphone6.png');
            "
                class="w-[290px] h-[590px] bg-no-repeat bg-cover relative">
                <div class="absolute overflow-hidden top-[9%] bottom-[11%] left-[6%] right-[6%]">
                    <img class="object-cover w-full h-full" src="https://media.giphy.com/media/xUA7b6vkQ9HbeThJEQ/giphy.gif"
                        alt="" />
                </div>
            </div>
        </div>

        <div class="">
            <div class="flex flex-col items-center justify-center">
                <div class="flex flex-col items-center py-8 mb-3 bg-white border border-gray-300 w-80">
                    <img id="logo" class="w-44" src="{{ IMG_PATH }}logo/logo.png" alt="" />
                    <form id="login__form" method="post" action="{{ route('login/verify') }}"
                        class="flex flex-col w-64 mt-8">
                        <span class="account__error text-xs text-red-500 my-0.5">
                            @if (isset($_SESSION['errors']) &&
                                    isset($_SESSION['errors']['account']) &&
                                    count($_SESSION['errors']['account']) > 0 &&
                                    isset($_GET['msg']))
                                {{ $_SESSION['errors']['account'][0] }}
                            @endif
                        </span>
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="account" placeholder="Số điện thoại, tên người dùng hoặc email" type="text"
                            value="{{ isset($_SESSION['valid_data']['account']) && isset($_GET['msg']) ? $_SESSION['valid_data']['account'] : null }}" />
                        <span class="password__error text-xs text-red-500 my-0.5">
                            @if (isset($_SESSION['errors']) &&
                                    isset($_SESSION['errors']['password']) &&
                                    count($_SESSION['errors']['password']) > 0 &&
                                    isset($_GET['msg']))
                                {{ $_SESSION['errors']['password'][0] }}
                            @endif
                        </span>
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            id="password" name="password" placeholder="Mật khẩu" type="password"
                            value="{{ isset($_SESSION['valid_data']['password']) && isset($_GET['msg']) ? $_SESSION['valid_data']['password'] : null }}" />
                        <label class="cursor-pointer flex items-center gap-2 pb-2">
                            <input type="checkbox" name="remember"
                                class="checkbox w-[17px] h-[17px] rounded-sm checkbox-warning" />
                            <span class="text-xs">Nhớ tài khoản</span>
                        </label>
                        <button type="submit" class="py-1 text-sm font-medium text-center text-white bg-blue-300 rounded">
                            Đăng nhập
                        </button>
                    </form>
                    <div class="flex w-64 mt-4 space-x-2 justify-evenly">
                        <span class="relative flex-grow h-px bg-gray-300 top-2"></span>
                        <span class="flex-none text-xs font-semibold text-gray-400 uppercase">Hoặc</span>
                        <span class="relative flex-grow h-px bg-gray-300 top-2"></span>
                    </div>
                    <button class="flex items-center mt-4">
                        <img class="w-5 mr-1 rounded" src="{{ IMG_PATH }}logo/facebook.png" alt="" />
                        <span class="text-xs font-semibold text-blue-900">Đăng nhập bằng Facebook</span>
                    </button>
                    <a href="{{ route('forgot-password') }}" class="mt-4 -mb-4 text-xs text-blue-900 cursor-pointer">Quên
                        mật khẩu?</a>
                </div>
                <div class="py-4 text-center bg-white border border-gray-300 w-80">
                    <span class="text-sm">Bạn không có tài khoản?</span>
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-blue-500">Đăng ký</a>
                </div>
            </div>
        </div>
    </main>
@endsection
