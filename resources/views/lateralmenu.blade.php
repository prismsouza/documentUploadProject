<?php
use App\Document;
$categories = App\Category::all()->sortBy('name');
$documents = Document::all();
?>


<span>
    <a class="list-group-item {{ Request::is('boletins') ? 'active' : ''}}"
       href="/boletins">
        BGBM + BEBM + Separata
    </a>
</span>

<?php

if (Session::has('categories') && count(Session::get('categories')) == 1 && !Request::is('boletins') ) {
    $choosen_category = Session::get('categories')[0];
} else {
    $choosen_category = null;
}
?>

<form method="POST" action="{{ route('documents.index') }}" enctype="multipart/form-data" class="py-2"> @csrf

    <ul class="nav nav-tabs flex-column lighten-4 list-group">
        <li style="text-align: center">
            <h3>Categorias</h3>
        </li>
        <li class="nav-item border">
            <button class="list-group-item"
                    href="{{route('documents.refresh_session')}}">
                <b>Todos</b>
            </button>
        </li>

        @foreach($categories as $category)
            @if ($category->id == 1 ||  $category->id == 2|| $category->id == 3) @continue @endif
            <li class="nav-item border">

                @if (count($category->hassubcategory)>0)
                    <a class="collapsible list-group-item">
                        {{ $category->name }}
                        <i class="fa fa-plus float-md-right"  style="color: lightblue" aria-hidden="true"></i>
                    </a>
                    <div class="content">
                        <i class="fas fa-chevron-right fa-xs"></i>
                        <a type="submit"  class="border-bottom {{ $choosen_category == $category->id ? 'active' : ''}}"
                           href="" style="color: #6c757d"
                           name="categories[]" value="{{$category->hassubcategory}}">
                            Todos
                        </a>
                        @foreach($category->hassubcategory as $sub_cat)<br>
                        <i class="fas fa-chevron-right fa-xs"></i>
                        <a type="submit" class="border-bottom {{ $choosen_category == $sub_cat->id ? 'active' : ''}}"
                           href="{{ $sub_cat->path() }}" style="color: #6c757d"
                           name="categories[]" value="{{$sub_cat->id}}">
                            {{ $sub_cat->name }}
                        </a>
                        @endforeach
                    </div>
                @else

                    @if (count($category->hasparent)==0)
                        <button type="submit" class="list-group-item {{ $choosen_category == $category->id  ? 'active' : ''}}"
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
<script src="{{ asset('site/lateralmenu.js') }}"></script>
