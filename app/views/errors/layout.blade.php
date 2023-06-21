<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ IMG_PATH }}logo/favicon.png" />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ BASE_URL }}resources/css/tailwind.css">
</head>

<body>
    <div class="w-full h-screen flex flex-col items-center justify-center font-jetbrains-mono">
        @yield('content')
    </div>
</body>

</html>