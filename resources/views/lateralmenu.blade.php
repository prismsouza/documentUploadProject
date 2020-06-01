<?php $user="notadmin"; ?>
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
