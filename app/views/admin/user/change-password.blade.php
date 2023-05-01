@extends('admin.layouts.master')
@section('content')
    <main class="w-full h-full overflow-y-auto rounded-2xl hidden__scrollbar">
        <section class="flex w-full h-screen gap-1">
            <aside class="hidden h-full bg-white shadow-xs md:block whitespace-nowrap" aria-label="Sidebar">
                <div class="overflow-y-auto bg-white shadow-xs">
                    <ul class="flex flex-col gap-1 p-3 list-sidebar">
                        <li class="flex items-center gap-1 p-2 rounded-md">
                            <a href="{{ route('update-profile/' . $user->id) }}" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="p-1 text-gray-600 bg-gray-200 rounded-full w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Thông tin cá
                                    nhân</span>
                            </a>
                        </li>
                        <li class="flex items-center gap-1 p-2 bg-gray-100 rounded-md">
                            <a href="{{ route('update-account/' . $user->id) }}" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="p-0.5 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <span class="text-sm font-medium text-gray-700">Thông tin tài khoản</span>
                            </a>
                        </li>
                        <li class="flex items-center gap-1 p-2 rounded-md">
                            <a href="{{ route('home') }}" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                </svg>

                                <span class="text-sm font-medium text-gray-700">Thông báo</span>
                            </a>
                        </li>

                        <li class="flex items-center gap-1 p-2 rounded-md">
                            <a href="{{ route('home') }}" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Quyền riêng tư</span>
                            </a>
                        </li>
                        <li class="flex items-center gap-1 p-2 rounded-md">
                            <a href="{{ route('home') }}" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="p-1 text-gray-500 bg-gray-200 rounded-full w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>

                                <span class="text-sm font-medium text-gray-700">Nhật kí hoạt động</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
            <article class="w-full h-full px-4 py-3 bg-white shadow-xs sm:px-5 sm:py-3">
                <section class="w-full h-full setting-user-info">
                    <form action="{{ route('admin/save-change-password/' . $user->id) }}" method="post"
                        class="w-full h-full">
                        <h1 class="my-4 text-xl font-semibold text-gray-700">Thay đổi mật khẩu
                        </h1>
                        <div class="grid grid-cols-1 gap-5 form-control">
                            <div class="form-group">
                                <label for="password" class="block text-sm font-medium text-gray-500 ">Mật khẩu
                                </label>
                                <div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>

                                    </span>
                                    <input type="password" placeholder="Mật khẩu ..." name="password"
                                        class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        value="{{ isset($_SESSION['valid_data']['password']) && isset($_GET['msg']) ? $_SESSION['valid_data']['password'] : null }}">
                                </div>
                                <span class="mt-2 text-xs text-red-500">
                                    @if (isset($_SESSION['errors']['password']) && isset($_GET['msg']))
                                        {{ $_SESSION['errors']['password'] }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="block text-sm font-medium text-gray-500 ">Mật khẩu mới
                                </label>
                                <div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>

                                    </span>
                                    <input type="password" placeholder="Mật khẩu mới..." name="new_password"
                                        class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        value="{{ isset($_SESSION['valid_data']['new_password']) && isset($_GET['msg']) ? $_SESSION['valid_data']['new_password'] : null }}">
                                </div>
                                <span class="mt-2 text-xs text-red-500">
                                    @if (isset($_SESSION['errors']['new_password']) && isset($_GET['msg']))
                                        {{ $_SESSION['errors']['new_password'] }}
                                    @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="block text-sm font-medium text-gray-500 ">Xác
                                    nhận
                                    mật khẩu
                                </label>
                                <div class="relative flex items-center mt-2">
                                    <span class="absolute">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-3 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>

                                    </span>
                                    <input type="password" placeholder="Nhập lại mật khẩu..." name="confirm_password"
                                        class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5   focus:border-indigo-400 focus:ring-indborder-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40"
                                        value="{{ isset($_SESSION['valid_data']['confirm_password']) && isset($_GET['msg']) ? $_SESSION['valid_data']['confirm_password'] : null }}">
                                </div>
                                <span class="mt-2 text-xs text-red-500">
                                    @if (isset($_SESSION['errors']['confirm_password']) && isset($_GET['msg']))
                                        {{ $_SESSION['errors']['confirm_password'] }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-center  gap-2 my-5 btn-group">
                                <button type="reset" style="background-color: #ff0000"
                                    class="w-32 px-4 py-2 font-medium text-white transition-all duration-300  rounded-xl hover:bg-red-500">Hủy</button>
                                <button name="btn-save"
                                    class="w-32 px-4 py-2 font-medium text-white transition-all duration-300 bg-green-600  rounded-xl hover:bg-green-500">Lưu</button>
                            </div>
                        </div>
                    </form>
                </section>
            </article>
        </section>
    </main>
@endsection
