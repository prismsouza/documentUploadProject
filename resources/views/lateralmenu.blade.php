<?php
use App\Document;
$categories = App\Category::all()->sortBy('name');
$documents = Document::all();
?>

<div>
    <ul class="nav nav-tabs flex-column lighten-4 list-group">
        <li class="nav-item border">
        <a class="list-group-item {{ Request::is('boletins') ? 'active' : ''}}"
           href="{{route('boletins.refresh_session')}}">
            BGBM / BEBM / Separata</a>
        </li>
    </ul>

    <?php
    if (Session::has('categories') && count(Session::get('categories')) == 1 && !Request::is('boletins'))
        $choosen_category = Session::get('categories')[0];
    else $choosen_category = null;
    ?>

    <style>
        .button {
            cursor: pointer;
            outline: none;
            border: none;
        }
        .buttonsub {
            background: white;
            padding: 6px 0px 6px 0px;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: dimgrey;
            border: none;
        }
        .buttonsub:hover {background-color: whitesmoke}
    </style>
    <form method="POST" action="{{ route('documents.index') }}" enctype="multipart/form-data" class="py-2"> @csrf

        <ul class="nav nav-tabs flex-column lighten-4 list-group">
            <li style="text-align: center">
                <h3>Categorias</h3>
            </li>
            <li class="nav-item border">
                <a class="list-group-item" type="submit"
                   href="{{route('documents.refresh_session_index')}}">
                    <b>Todos</b>
                </a>
            </li>

            @foreach($categories as $category)
                @if ($category->id == 1 ||  $category->id == 2|| $category->id == 3) @continue @endif
                <li class="nav-item border">
                    @if (count($category->hassubcategory)>0)
                        <a class="collapsible button list-group-item" style="cursor: pointer">
                            {{ $category->name }}
                            <i class="fa fa-plus float-md-right"  style="color: lightblue" aria-hidden="true"></i>
                        </a>
                        <div class="content">
                            <button type="submit" class="buttonsub {{ $choosen_category == $category->id ? 'active' : ''}}"
                                    name="categories[]" value="{{$category->id}}">
                                <i class="fas fa-chevron-right fa-xs"></i>
                                Todos
                            </button>
                            @foreach($category->hassubcategory as $sub_cat)<br>

                            <button type="submit" class="buttonsub  {{ $choosen_category == $sub_cat->id ? 'active' : ''}}"
                                    name="categories[]" value="{{$sub_cat->id}}">
                                <i class="fas fa-chevron-right fa-xs"></i>
                                {{ $sub_cat->name }}
                            </button>
                            @endforeach
                        </div>
                    @else
                        @if (count($category->hasparent)==0)
                            <button type="submit" class="button list-group-item {{ $choosen_category == $category->id  ? 'active' : ''}}"
                                    name="categories[]" value="{{$category->id}}">
                                {{ $category->name }}
                            </button>
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
                @if ($admin)
                    <span>
                    <a class="btn btn-sm" data-toggle="tooltip" title="visualizar"
                       href="{{ route('ementario.view')}}" target="_blank">
                        Ementário
                    </a>
                    <a href="{{ route('ementario.edit') }}" class="btn border float-md-right">
                        <i class="fas fa-edit small" style="color: black"></i>
                    </a>
                    <a href="{{ route('ementario.download') }}" class="btn border float-md-right">
                        <i class="fas fa-download small" style="color: black" aria-hidden="true"></i>
                    </a>

                </span>
                @else
                    <span>
                    <a class="btn" data-toggle="tooltip" title="visualizar"
                       href="{{ route('ementario.view')}}" target="_blank">
                        Ementário <i class="fas fa-eye"></i>
                    </a>
                <a data-toggle="tooltip" title="download"
                   href="{{ route('ementario.download') }}" class="btn border float-md-right">
                    <i class="fas fa-download" style="color: black" aria-hidden="true"></i>
                </a>
                </span>
                @endif

            </li>
        </ul>
    </form>
</div>
<script src="{{ asset('site/lateralmenu.js') }}"></script>

