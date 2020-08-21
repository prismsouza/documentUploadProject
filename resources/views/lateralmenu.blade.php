<?php
    $categories = App\Category::all()->sortBy('name');
?>
<ul class="nav nav-tabs flex-column lighten-4 list-group">
    <li style="text-align: center">
        <h3>Categorias</h3>
    </li>
    <li class="nav-item border">
        <a class="list-group-item {{ (Request::is('documentos') || Request::is('/')) ? 'active' : ''}}"
           href="{{ route('documents.index') }}">
            <b>Todos</b>
        </a>
    </li>

    @foreach($categories as $category)
        <li class="nav-item border">

            @if (count($category->hassubcategory)>0)

                <a type="button" class="collapsible list-group-item">
                    {{ $category->name }}
                    <i class="fa fa-plus float-md-right"  style="color: lightblue" aria-hidden="true"></i>
                </a>
                <div class="content">
                    <i class="fas fa-chevron-right fa-xs"></i>
                    <a class="border-bottom {{ Request::is('documentos/categorias/'.$category->name) ? 'active' : ''}}"
                       href="{{ $category->path() }}" style="color: #6c757d">
                        Todos
                    </a>
                    @foreach($category->hassubcategory as $sub_cat)<br>
                        <i class="fas fa-chevron-right fa-xs"></i>
                        <a class="border-bottom {{ Request::is('documentos/categorias/'.$sub_cat->name) ? 'active' : ''}}"
                           href="{{ $sub_cat->path() }}" style="color: #6c757d">
                            {{ $sub_cat->name }}
                        </a>
                    @endforeach
                </div>
            @else

                    @if (count($category->hasparent)==0)
                        <a class="list-group-item {{ Request::is('documentos/categorias/'.$category->name) ? 'active' : ''}}"
                           href={{ $category->path() }}>
                            {{ $category->name }}
                        </a>
                    @endif
            @endif
        </li>

    @endforeach

</ul>

<ul class="nav nav-tabs flex-column lighten-4 list-group">
    <li style="text-align: center">
        <h3>Outros</h3>
    </li>
    <li class="nav-item border">
        <a class="list-group-item {{ (Request::is('categorias/ementario')) ? 'active' : ''}}"
           href="{{ route('categories.ementario') }}">
            Ementário
        </a>
    </li>
</ul>
<script src="{{ asset('site/lateralmenu.js') }}"></script>
