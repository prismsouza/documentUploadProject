<?php
    use App\Document;
    $categories = App\Category::all()->sortBy('name');
    $documents = Document::all();
    Session::put('documents',  $documents);
?>

<ul class="nav nav-tabs flex-column lighten-4 list-group">
    <li style="text-align: center">
        <h3>Categorias</h3>
    </li>
    <li class="nav-item border">
        <a class="list-group-item {{ (Request::is('documentos') || Request::is('/')) ? 'active' : ''}}"
           href="{{ route('documents.index')}}">
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

    <li class="nav-item border">
        <a class="list-group-item {{ Request::is('boletins') ? 'active' : ''}}"
            href="/boletins">
            BGBM + BEBM + Separata
        </a>
    </li>
</ul>

<ul class="nav nav-tabs flex-column lighten-4 list-group">
    <li style="text-align: center">
        <h3>Outros</h3>
    </li>
    <li class="nav-item border">
        @if ($admin)
            <span>
                <a class="btn btn-sm" data-toggle="tooltip" title="visualizar"
                   href="{{ route('files.view')}}" target="_blank">
                    Ementário
                </a>
                <a href="{{ route('categories.ementario_edit') }}" class="btn border float-md-right">
                    <i class="fas fa-edit small" style="color: black"></i>
                </a>
                <a href="{{ route('files.download') }}" class="btn border float-md-right">
                    <i class="fas fa-download small" style="color: black" aria-hidden="true"></i>
                </a>

            </span>
        @else
            <span>
                <a class="btn" data-toggle="tooltip" title="visualizar"
                      href="{{ route('files.view')}}" target="_blank">
                    Ementário <i class="fas fa-eye"></i>
                </a>
            <a data-toggle="tooltip" title="download"
               href="{{ route('files.download') }}" class="btn border float-md-right">
                <i class="fas fa-download" style="color: black" aria-hidden="true"></i>
            </a>
            </span>
        @endif

    </li>
</ul>
<script src="{{ asset('site/lateralmenu.js') }}"></script>
