<!DOCTYPE html>

@include('includes')
<body>
    @include('header')
    <div class="container">
        <!-- @ include('navbar') -->
        @include('navbar_admin')
        @yield('searchmessagebar')
        <div id="wrapper">
            <div id="page" class="py-3">
                @yield('content')
            </div>
        </div>
    </div>
    @include('footer')
</body>
