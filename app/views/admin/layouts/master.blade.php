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
    <div id="loader-overlay">
        <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExNTFiNDBmNWM5ZWRmZmI4YjI4MWU3M2RhNDAyZjg0Zjc1ODFlMmFiMCZlcD12MV9pbnRlcm5hbF9naWZzX2dpZklkJmN0PXM/i4yTcA8ihuOsgcj77T/giphy.gif"
            alt="Loading..." />
    </div>
</body>

</html>
