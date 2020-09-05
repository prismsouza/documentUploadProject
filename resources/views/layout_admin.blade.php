<!DOCTYPE html>
<html lang="pt-BR">

@include('includes')
<body>
    @include('header')

    <div class="container">
        <!-- @ include('navbar') -->
        @include('navbar_admin')
        @yield('searchbar')
        @yield('sortbar')
        @yield('searchmessagebar')
        <div id="wrapper">
            <div id="page" class="py-3">
                @yield('content')
            </div>
        </div>
    </div>
    @include('footer')
</body>

</html>
