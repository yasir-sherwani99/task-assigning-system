<!DOCTYPE html>
<html lang="en">
@include('layouts.partials._head')
<body id="body" class="light-sidebar menuitem-active">
    @include('layouts.partials._loader')
    @include('layouts.partials._left_sidebar')
    @include('layouts.partials._topbar')
    <div class="page-wrapper">
        <div class="page-content-tab">
            <div class="container-fluid">
                @include('layouts.partials._breadcrumbs')
                @yield('content')
            </div>
            @include('layouts.partials._footer')
        </div>
    </div>
    @vite('resources/js/app.js')
    @yield('script')
</body>
</html>