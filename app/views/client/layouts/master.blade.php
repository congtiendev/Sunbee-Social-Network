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
    <div id="loading-all">
        <img src="{{ IMG_PATH }}illustration/loading-bee.gif" alt="Loading..." />
    </div>
    @include('client.layouts.scripts')
</body>

</html>