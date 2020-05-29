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
    <div id="page" class="container row py-3">

        <div class="col-10">
            @yield('content')
        </div>
        <div class="menu col-2 text-left light lighten-1 ">
            <ul class="nav nav-tabs flex-column lighten-4 list-group">
                <li style="text-align: center">
                    <h3>
                        @if ($user=="admin") <a href={{route('categories.index')}}> Categorias </a>
                        @else Categorias @endif
                    </h3>
                </li>
                <li class="nav-item border">
                    <a class="list-group-item {{ (Request::is('documentos') || Request::is('/')) ? 'active' : ''}}"
                       href="{{ route('documents.index') }}">
                        <b>Todos</b>
                    </a>
                </li>

                @foreach($categories as $category)
                <li class="nav-item border">
                    <a class="list-group-item {{ Request::is('documentos/categorias/'.$category->name) ? 'active' : ''}}"
                       href={{ $category->path() }}>
                        {{ $category->name }}<br>
                    </a>

                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</div>
@include('footer')
</body>


