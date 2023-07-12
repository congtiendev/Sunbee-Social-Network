<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../public/images/logo/favicon.png" rel="icon" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sunbee social network">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ IMG_PATH }}logo/favicon.png" />
    @include('client.layouts.styles')
    <script>
        if (
            localStorage.theme === "dark" ||
            (!("theme" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
        localStorage.theme = "light";
        localStorage.theme = "dark";
        localStorage.removeItem("theme");

        window.addEventListener("load", function() {
            var elements = document.querySelectorAll(".skeleton");
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.remove("skeleton");
            }
        });

    </script>
</head>

<body>
    <div id="wrapper">
        <!-- Header -->
        @include('client.layouts.header')

        <!-- ----------------Sidebar-------------- -->
        @include('client.layouts.sidebar')

        <!-- Main Contents -->
        @yield('content')
    </div>

    <!-- -----------------open chat box------------------- -->
    @include('client.components.chat-box')
    @include('client.layouts.scripts')
</body>

</html>
