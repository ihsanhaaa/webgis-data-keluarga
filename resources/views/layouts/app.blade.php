<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BBDP Sambas</title>

    @stack('css-plugins')
</head>

<body>

    @yield('content')

    @stack('js-plugins')
    <script src="{{ asset('script.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>