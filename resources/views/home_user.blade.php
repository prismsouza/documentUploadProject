<!DOCTYPE html>
<?php
$categories = App\Category::all();
$tags = App\Tag::all();
?>

@include('includes')

<body>
@include('header')

<div class="container">
    @include('searchbar')
    
</div>
@include('footer')
</body>
