<!DOCTYPE html>
<?php
$categories = App\Category::all();
$tags = App\Tag::all();
$user = "admin";
?>

@include('includes')

<body>
    @include('header')
<p class="py-4"></p>
    <div class="container">
        @yield('content')
    </div>

    @include('footer')
</body>
