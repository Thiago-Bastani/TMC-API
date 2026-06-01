<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMC Admin — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col items-center justify-center p-4">

    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow z-50">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded shadow z-50">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

</body>
</html>
