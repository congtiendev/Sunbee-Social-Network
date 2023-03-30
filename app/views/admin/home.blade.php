@extends('admin.layouts.master')
@section('content')
    <main class="w-full h-full p-2 overflow-y-auto rounded-2xl hidden__scrollbar">
        <!-- ------------------------wrapper title & fill  -->
        <div class="flex items-center justify-between mb-1 title__list-user">
            <!-- ----------------------Title account------------------------ -->
            <h2 class="flex items-center gap-2 pb-1 text-sm font-semibold sm:gap-3 sm:text-lg">
                <img class="w-6 h-6" src="./resources/images/list-icon.png" alt="" />
                Số liệu thống kê
            </h2>
        </div>
        <section class="mt-3">
            <div class="container mx-auto">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none md:w-1/3 lg:w-1/4 xl:w-1/5">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-xs rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <h5 class="flex items-center gap-1 mb-1 text-2xl font-bold text-indigo-500">
                                                55.000<span class="text-xs font-semibold text-green-500">+
                                                    109</span>
                                            </h5>
                                            <p class="font-sans text-sm font-semibold uppercase ">
                                                Người dùng
                                            </p>
                                            <a href="#" class="text-xs font-medium text-blue-500 wh">Chi tiết</a>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div
                                            class="inline-block text-center rounded-full w-14 h-14 rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                            <img src="./resources/images/user-icon.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ---------------------------------------------------- -->
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none md:w-1/3 lg:w-1/4 xl:w-1/5">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-xs rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <h5 class="flex items-center gap-1 mb-1 text-2xl font-bold text-cyan-600">
                                                500<span class="text-xs font-semibold text-green-500">+
                                                    109</span></h5>
                                            <p class="font-sans text-sm font-semibold uppercase whitespace-nowrap">
                                                Bài đăng
                                            </p>
                                            <a href="#" class="text-xs font-medium text-blue-500">Chi
                                                tiết</a>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div
                                            class="inline-block text-center rounded-full w-14 h-14 rounded-circle bg-gradient-to-tl from-cyan-500 to-violet-500">
                                            <img src="./resources/images/lock-account.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ---------------------------------------------------- -->
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none md:w-1/3 lg:w-1/4 xl:w-1/5">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-xs rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <h5 class="mb-1 text-2xl font-bold text-green-500">500</h5>
                                            <p class="font-sans text-sm font-semibold uppercase whitespace-nowrap">
                                                Đang hoạt động
                                            </p>
                                            <a href="#" class="text-xs font-medium text-blue-500">Chi
                                                tiết</a>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div
                                            class="inline-block text-center rounded-full w-14 h-14 rounded-circle bg-gradient-to-tl from-green-500 to-green-700">
                                            <img src="./resources/images/user-active.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ---------------------------------------------------- -->
                    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none md:w-1/3 lg:w-1/4 xl:w-1/5">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-xs rounded-2xl bg-clip-border">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <h5 class="flex items-center gap-1 mb-1 text-2xl font-bold text-red-600">
                                                500<span class="text-xs font-semibold text-red-500">+
                                                    109</span>
                                            </h5>
                                            <p class="font-sans text-sm font-semibold uppercase whitespace-nowrap">
                                                Báo cáo
                                            </p>
                                            <a href="#" class="text-xs font-medium text-blue-500">Chi
                                                tiết</a>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div
                                            class="flex items-center justify-center text-center rounded-full w-14 h-14 rounded-circle bg-gradient-to-tl from-red-500 to-violet-500">
                                            <img class="w-10 h-10" src="./resources/images/contact-icon.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- -------------------------------chart------------------ -->

        <section class="container mx-auto">
            <div class="flex chart-box">
                <div class="min-w-0 p-4 mb-5 bg-white rounded-lg shadow-xs">
                    <h4 class="mb-4 font-semibold text-gray-800">Lines</h4>
                    <canvas id="line"></canvas>
                    <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600">
                        <!-- Chart legend -->
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                            <span>Organic</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                            <span>Paid</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <!-- Doughnut/Pie chart -->
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
                    <h4 class="mb-4 font-semibold text-gray-800">
                        Thống kê giới tính
                    </h4>
                    <canvas id="pie"></canvas>
                    <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600">
                        <!-- Chart legend -->
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"></span>
                            <span>Nam</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                            <span>Nữ</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                            <span>Khác</span>
                        </div>
                    </div>
                </div>
                <!-- Lines chart -->

                <!-- Bars chart -->
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
                    <h4 class="mb-4 font-semibold text-gray-800">Bars</h4>
                    <canvas id="bars"></canvas>
                    <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600">
                        <!-- Chart legend -->
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                            <span>Shoes</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                            <span>Bags</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
