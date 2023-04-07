<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        {{ $title }}
    </title>
    @include('admin.layouts.styles')
</head>

<body>
    <div id="wrapper" class="bg-indigo-800 font-montserrat">
        <div class="flex gap-5 max-w-screen-2xl min-w-[320px] h-full lg:p-5 mx-auto">
            @include('admin.layouts.sidebar')
            <article class="flex flex-col w-full gap-2 lg:rounded-3xl">
                @include('admin.layouts.header')
                @yield('content')
            </article>
        </div>
    </div>
</body>
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

</html>
