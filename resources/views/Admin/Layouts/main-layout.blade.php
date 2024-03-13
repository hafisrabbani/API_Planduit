<!DOCTYPE html>
<html lang="en">

<head>
    @include('Admin.Component.header')
    @yield('meta-tag')
    @stack('styles')
</head>

<body>
<div id="app">
    @include('Admin.Component.sidebar')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>@yield('title')</h3>
                        <p class="text-subtitle text-muted">@yield('subtitle')</p>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
        @include('Admin.Component.footer')
    </div>
</div>
</body>
@include('Admin.Component.scripts')
@stack('scripts')
</html>
