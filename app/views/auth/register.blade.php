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
                    <form id="login__form" method="post" action="" class="flex flex-col w-64 mt-4">
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="email" placeholder="Email" type="email" />
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="last_name" placeholder="Họ" type="text" />
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="first_name" placeholder="Tên" type="text" />
                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            name="username" placeholder="Tên người dùng" type="text" />

                        <input autofocus
                            class="w-full px-2 py-2 mb-2 text-xs bg-gray-100 border border-gray-300 rounded focus:outline-none focus:border-gray-400 active:outline-none"
                            id="password" name="password" placeholder="Mật khẩu" type="password" />
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
