@section('searchbar')
<?php
$tags = App\Tag::all();
$tags_array = request('tags') ? request('tags') : [];
$categories = App\Category::all();
$categories_array = request('categories') ? request('categories') : [];
?>

<div class="border p-2">

<form method="POST" action="{{ route('documents.filter') }}" enctype="multipart/form-data" class="py-2"> @csrf
    <div class="row">
        <div class="col-sm" id="name_description">
            Nome/Descrição:
            <input
                class="form-control col-sm-12"
                type="text" name="word" id="word"
                value="{{ request()->input('word') }}">
        </div>

        <div class="col-sm" id="Categories">
            Categorias:<br>
            <button id="categories_btn" role="button" href="#" class="btn btn-light border px-5"
                    data-toggle="dropdown" data-target="#" >
                Selecione... <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" style="width: 110%">
                <input class="form-control " id="categories_input" type="text" placeholder="Search..">
                            @forelse($categories as $category)
                                <div class="col-sm">
                                    <li class="p-1">
                                    <label class="box px-5 checkbox-inline">
                                        <input
                                            type="checkbox" value=" {{ $category->id }} "
                                            id="{{ $category->id }}" name="categories[]"
                                            placeholder="Selecionado"
                                            <?php echo (in_array($category->id,$categories_array)) ?'checked':'' ?>>
                                        {{ $category->name }}
                                        <span class="checkmark"></span>
                                    </label>
                                    </li>
                                </div>
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse

            </ul>

        </div>
        <div class="col-sm-4" id="Data Publicação">
            <i class="fas fa-calendar-alt p-2"></i>Data de Publicacao:<br>
            <div>
            <label class="px-1 small">De</label>
            <input
                name="first_date" id="first_date" type="date"
                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                value="{{ request()->input('first_date') }}">
            <label class="px-1 small">a</label>
            <input
                name="last_date" id="last_date" type="date"
                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                value="{{ request()->input('last_date') }}">
            </div>
        </div>

        <div class="col-sm" id="Tags">
            Pesquisar por assunto: <br>
            <button id="tags_btn" role="button" href="#" class="btn btn-light border px-5"
                    data-toggle="dropdown" data-target="#" >
                Selecione... <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" style="width: 90%">
                <input class="form-control" id="tags_input" type="text" placeholder="Search..">
                    @forelse($tags as $tag)
                        <div class="col-sm">
                            <li class="p-1">
                            <label class="box px-5 checkbox-inline">
                                <input
                                    type="checkbox" value=" {{ $tag->id }} "
                                    id="{{ $tag->id }}" name="tags[]"
                                    placeholder="Selecionado"
                                    <?php echo (in_array($tag->id,$tags_array)) ?'checked':'' ?>>
                                {{ $tag->name }}
                                <span class="checkmark"></span>
                            </label>
                            </li>
                        </div>

                    @empty
                         <p><h5>Nao ha tags cadastradas</h5></p>
                    @endforelse
            </ul>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control py-2">
            <button class="btn btn-dark border btn-outline-light float-md-right" type="submit" >
                Pesquisar <i class="fas fa-search px-2"></i>
            </button>

            <button class="btn btn-light border float-md-right" type="submit"  action="{{ route('documents.index') }}">
                <a href="{{ route('documents.index') }}">
                    Limpar <i class="fas fa-eraser px-2"></i>
                </a>
            </button>
            <button class="btn btn-light border float-md-right" type="submit"  action="{{ route('home') }}">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                </a>
            </button>

            <button class="btn btn-light border px-4" type="button" data-toggle="collapse"
                    data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                +
            </button><br>


                <div class="collapse" id="collapseExample"><br>
                    <div id="is_active">
                        <div class="row px-4">Documento:
                            <div class="form-check form-check-inline px-4">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                                Esta vigente
                            </div>
                            <div class="form-check form-check-inline px-3">
                                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="-1">
                                Nao esta vigente
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</form>
</div>
<br>

@if (request()->input('word') || request()->input('categories') || request()->input('first_date') || request()->input('last_date') || request()->input('tags') || request()->input('is_active'))
    <div class="border p-2">
        <b>Filtro aplicado:</b>
    @if (request()->input('word'))
        <br>Nome Documento / Descrição:
        <b class="px-2"> {{ request()->input('word') }} </b>
    @endif

    @if (request()->input('categories'))
        <br>Categorias:
        @foreach ( request()->input('categories')  as $cat)
            <b class="p-1">{{ $category = $categories->where('id', $cat)->first()->name }}</b>
        @endforeach
    @endif

    @if (request()->input('first_date') || request()->input('last_date'))
        <?php
        $first_date = date('d/m/Y', strtotime(request()->input('first_date')));
        $last_date = date('d/m/Y', strtotime(request()->input('last_date')));
        ?>

        @if (request()->input('first_date') && request()->input('last_date'))
            <br>Data de publicação:
            <b class="px-2">de {{ $first_date }}
            ate {{ $last_date }} </b>
        @elseif (request()->input('first_date'))
             <br>Documentos publicados:
             <b class="px-2">a partir de
             {{ $first_date }}</b>
             ate a data de hoje.
        @elseif (request()->input('last_date'))
              <br>Documentos publicados:
              <b class="px-2">ate {{ $last_date }}</b>
        @endif
    @endif

    @if (request()->input('tags'))
        <br>Tags:
        @foreach (request()->input('tags')  as $t)
            <b class="p-1">{{ $tag = $tags->where('id', $t)->first()->name }} </b>
        @endforeach
    @endif

    @if (request()->input('is_active'))
        <br>Vigencia:
        <b class="p-1">{{ request()->input('is_active') == "1" ? "Vigente" : "Revogado" }}</b>
    @endif

    </div>
    <br>
@endif


    <script src="{{ asset('site/searchbar.js') }}"></script>
@endsection
