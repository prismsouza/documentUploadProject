<!DOCTYPE html>
<?php
    $categories = App\Category::all();
    $tags = App\Tag::all();
    $user = "admin";
?>

@include('includes')
<body>
    @include('header')
    <div class="container">
    <!-- @ include('navbar') -->
    @if ($user == "admin")
        @include('navbar_admin')
    @endif

    @include('searchbar')

    <div id="wrapper">
        <div id="page" class="row py-3">

            <div class="col-10">
                @yield('content')
            </div>
            <div class="menu col-2 text-left light lighten-1 ">
                @include('lateralmenu')
            </div>
        </div>
    </div>
</div>
@include('footer')
</body>


