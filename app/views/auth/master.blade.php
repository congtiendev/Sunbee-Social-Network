<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ IMG_PATH }}logo/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @include('auth.styles')
</head>

<body>
    <div class="h-screen mx-auto bg-gray-50 dark:bg-gray-900">
        @yield('content')
        <footer class="bg-gray-50 dark:bg-gray-900">
            <div class="pt-5 text-center md:pt-10">
                <span class="text-xs">Tải ứng dụng.</span>
                <div class="flex justify-center mt-3 space-x-2">
                    <img class="w-32" src="{{ IMG_PATH }}logo/apple.png" alt="" />
                    <img class="w-32" src="{{ IMG_PATH }}logo/google.png" alt="" />
                </div>
            </div>
            <div class="max-w-2xl py-5 mx-auto text-gray-900 md:py-10 dark:text-white">
                <div
                    class="flex flex-col items-center pt-5 text-xs text-gray-500 dark:text-gray-50 md:flex-row md:justify-between">
                    <p class="order-2 mt-5 md:order-1 md:mt-0">
                        &copy; CongTienDev, 2023
                    </p>
                    <div class="order-1 md:order-2">
                        <a class="px-2">Giới thiệu</a>
                        <a class="px-2 border-l">Trợ giúp</a>
                        <a class="px-2 border-l">Điều khoản & chính sách</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @include('auth.scripts')
</body>

</html>