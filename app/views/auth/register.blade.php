@extends('auth.master')
@section('content')
    <main class="items-center justify-center gap-20 pt-5 md:flex bg-gray-50 dark:bg-gray-900">
        <section class="items-center hidden md:flex">
            <div style="
              background-image: url('{{ IMG_PATH }}illustration/iphone6.png');
            "
                class="w-[290px] h-[590px] bg-no-repeat bg-cover relative">
                <div class="absolute overflow-hidden top-[9%] bottom-[11%] left-[6%] right-[6%]">
                    <img class="object-cover w-full h-full" src="https://media.giphy.com/media/xUA7b6vkQ9HbeThJEQ/giphy.gif"
                        alt="" />
                </div>
            </div>
        </section>

        <div class="">
            <div class="flex flex-col items-center justify-center">
                <div class="flex flex-col items-center py-8 mb-3 bg-white border border-gray-300 w-80">
                    <img id="logo" class="w-44" src="{{ IMG_PATH }}logo/logo.png" alt="" />
                    <button class="flex gap-1 my-4">
                        <img class="w-5 mr-1 rounded" src="{{ IMG_PATH }}logo/facebook.png" alt="" />
                        <span class="text-xs font-semibold text-blue-900">Đăng nhập bằng Facebook</span>
                    </button>
                    <div class="flex w-64 space-x-2 justify-evenly">
                        <span class="relative flex-grow h-px bg-gray-300 top-2"></span>
                        <span class="flex-none text-xs font-semibold text-gray-400 uppercase">Hoặc</span>
                        <span class="relative flex-grow h-px bg-gray-300 top-2"></span>
                    </div>
                    <form id="login__form" method="post" action="{{ route('register/handle') }}"
                        class="flex flex-col w-64 mt-4">
                        <span class="email__error text-xs text-red-500 my-0.5">
                            @if (isset($_SESSION['errors']) &&
                                    isset($_SESSION['errors']['email']) &&
                                    count($_SESSION['errors']['email']) > 0 &&
                                    isset($_GET['msg']))
                                {{ $_SESSION['errors']['email'][0] }}
                            @endif
                        </span>
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="email" placeholder="Email" type="email"
                            value="{{ isset($_SESSION['old']['email']) && isset($_GET['msg']) ? $_SESSION['old']['email'] : null }}" />
                        <span class="lastname__error text-xs text-red-500 my-0.5">
                            @if (isset($_SESSION['errors']) &&
                                    isset($_SESSION['errors']['last_name']) &&
                                    count($_SESSION['errors']['last_name']) > 0 &&
                                    isset($_GET['msg']))
                                {{ $_SESSION['errors']['last_name'][0] }}
                            @endif
                        </span>
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="last_name" placeholder="Họ" type="text"
                            value="{{ isset($_SESSION['old']['first_name']) && isset($_GET['msg']) ? $_SESSION['old']['first_name'] : null }}" />
                        <span class="firstname__error text-xs text-red-500 my-0.5">
                            @if (isset($_SESSION['errors']) &&
                                    isset($_SESSION['errors']['first_name']) &&
                                    count($_SESSION['errors']['first_name']) > 0 &&
                                    isset($_GET['msg']))
                                {{ $_SESSION['errors']['first_name'][0] }}
                            @endif
                        </span>
                        <input autofocus
                            class="w-full
                            px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none
                            focus:border-gray-400 active:outline-none"
                            name="first_name" placeholder="Tên" type="text"
                            value="{{ isset($_SESSION['old']['last_name']) && isset($_GET['msg']) ? $_SESSION['old']['last_name'] : null }}" />
                        <span class="username__error text-xs text-red-500 my-0.5">
                            @if (isset($_SESSION['errors']) &&
                                    isset($_SESSION['errors']['username']) &&
                                    count($_SESSION['errors']['username']) > 0 &&
                                    isset($_GET['msg']))
                                {{ $_SESSION['errors']['username'][0] }}
                            @endif
                        </span>
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="username" placeholder="Tên người dùng" type="text"
                            value="{{ isset($_SESSION['old']['username']) && isset($_GET['msg']) ? $_SESSION['old']['username'] : null }}" />
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
                            value="{{ isset($_SESSION['old']['password']) && isset($_GET['msg']) ? $_SESSION['old']['password'] : null }}" />
                        <span class="confirm-password__error text-xs text-red-500 my-0.5">
                            @if (isset($_SESSION['errors']) &&
                                    isset($_SESSION['errors']['confirm_password']) &&
                                    count($_SESSION['errors']['confirm_password']) > 0 &&
                                    isset($_GET['msg']))
                                {{ $_SESSION['errors']['confirm_password'][0] }}
                            @endif
                        </span>
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu" type="password"
                            value="{{ isset($_SESSION['old']['confirm_password']) && isset($_GET['msg']) ? $_SESSION['old']['confirm_password'] : null }}" />

                        <div class="py-2 terms_and_policies">
                            <p class="text-xs text-gray-400">
                                Bằng cách đăng ký, bạn đồng ý với
                                <a href="#" class="text-blue-500">Điều khoản</a>,
                                <a href="#" class="text-blue-500">Chính sách dữ liệu</a> và
                                <a href="#" class="text-blue-500">Chính sách cookie</a> của
                                chúng tôi.
                            </p>
                        </div>
                        <button type="submit" class="py-1 text-sm font-medium text-center text-white bg-blue-300 rounded">
                            Đăng ký
                        </button>
                    </form>
                </div>
                <div class="py-4 text-center bg-white border border-gray-300 w-80">
                    <span class="text-sm">Bạn đã có tài khoản?</span>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-500">Đăng nhập</a>
                </div>
            </div>
        </div>
    </main>
@endsection
