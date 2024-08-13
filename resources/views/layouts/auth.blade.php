<!DOCTYPE html>
<html lang="en">
@include('layouts.partials._head')
<body id="body" class="auth-page" style="background-image: url({{asset('admin-assets/images/p-1.png')}}); background-size: cover; background-position: center center;">
    <div class="container-md">
        @yield('content')
    </div><!--end container-->
    @vite('resources/js/app.js')
</body>
</html>