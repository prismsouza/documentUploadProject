<!DOCTYPE html>
<?php
$categories = App\Category::all();
$tags = App\Tag::all();
?>

@include('includes')

<body>
@include('header')

<div class="container">
    @include('navbar_admin')
    @include('searchbar')

    <div id="wrapper">
        <p><img src="images/banner2.jpg" class="img-fluid" style="opacity: 0.5"></p>
        <p>Aliquam libero. Vivamus nisl nibh, iaculis vitae, viverra sit amet, ullamcorper vitae, turpis. s eget,
            vulputate sed, convallis at, ultricies quis, justo. Donec nonummy magna quis risus.</p>
    </div>
</div>
@include('footer')
</body>
