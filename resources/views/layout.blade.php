<!DOCTYPE html>
<?php
    $categories = App\Category::all();
    $tags = App\Tag::all();
?>

@include('includes')
<body>
    @include('header')
    <div class="container py-4">

    @yield('searchbar')
    @yield('sortbar')

    <div id="wrapper">
        <div id="page" class="row py-1">
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


