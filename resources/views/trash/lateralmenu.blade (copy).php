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
    <?php
    $exclude = []; ?>
    @foreach($categories as $category)
        @if (count($category->hassubcategory)>0)
            @foreach($category->hassubcategory as $sub_cat)
                <?php array_push($exclude, $sub_cat->id); ?>
            @endforeach
        @endif
    @endforeach

    <?php $categories = $categories->except($exclude); ?>
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
            <a class="list-group-item {{ Request::is('documentos/categorias/'.$category->name) ? 'active' : ''}}"
               href={{ $category->path() }}>
                {{ $category->name }}
            </a>
            @endif



        </li>

    @endforeach
</ul>
<script src="{{ asset('site/lateralmenu.js') }}"></script>
