<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ IMG_PATH }}logo/favicon.png" />
    @include('admin.layouts.styles')
</head>

<body x-data="{ page: 'Messages', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark text-bodydark bg-boxdark-2': darkMode === true }">
    <div class="flex h-screen overflow-hidden font-montserrat">
        <!-- --------------------------Sidebar--------------------------- -->
        @include('admin.layouts.sidebar')
        <!-- -------------------------------------Content------------------------------- -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <!-- ---------------------------------Header------------------------------- -->
            @include('admin.layouts.header')
            <!-- ---------------------------------Main------------------------------- -->
            @yield('content')
        </div>
    </div>
    @include('admin.layouts.scripts')
    @if (isset($errors) && !empty($errors))
        <script>
            $(document).ready(function() {
                swal({
                    title: "Lỗi!",
                    text: "Vui lòng kiểm tra lại thông tin!",
                    icon: "error",
                    button: "OK",
                });
            });
        </script>
    @endif
</body>

</html>
