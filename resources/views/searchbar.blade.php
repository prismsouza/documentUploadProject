<div class="border p-2">
<form method="POST" action="{{ route('documents.filter') }}" enctype="multipart/form-data" class="py-2"> @csrf
    <div class="row">
        <div class="col-sm">
            Documento:
            <input
                class="form-control col-sm-12"
                type="text" name="word" id="word"
                value="{{ request()->input('word') }}">
        </div>

        <div class="col-sm">
            Categorias:<br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu">
                <li><div class="checkbox">
                        <label>
                            @forelse($categories as $category)
                                <div class="col-sm">
                                    <label class="checkbox-inline">
                                        <input
                                            type="checkbox" value=" {{ $category->id }} "
                                            id="categories" name="categories[]"
                                            style="transform: scale(1.5);"
                                            placeholder="Selecionado">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse
                        </label>
                    </div></li>
            </ul>
        </div>

        <div class="col-sm-4">
            <i class="fas fa-calendar p-2"></i>Data de Publicacao:<br>
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

        <div class="col-sm">
            Tags: <br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu">
                <li><div class="checkbox">
                <label>
                    <input type="text" placeholder="Pesquisar..." id="myInput" onkeyup="filterFunction()">
                    @forelse($tags as $tag)
                        <div class="col-sm">
                            <label class="checkbox-inline">
                                <input
                                    type="checkbox" value="{{ $tag->id }}"
                                    id="tags" name="tags[]"
                                    style="transform: scale(1.5);">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @empty
                         <p><h5>Nao ha tags cadastradas</h5></p>
                    @endforelse
                </label>
                </div></li>
            </ul>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control float-md-right py-2">
            <button class="btn btn-light border" type="submit"  action="{{ route('documents.index') }}">
                <a href="{{ route('documents.index') }}">
                    Limpar filtros <i class="fas fa-eraser px-2"></i>
                </a>
            </button>
            <button class="btn btn-dark" type="submit" >
                Aplicar filtros <i class="fas fa-search px-2"></i>
            </button>
            <span class="p-2"></span>
        </div>
    </div>

</form>
</div>
<br>
<br>
@if (request()->input('word') || request()->input('categories') || request()->input('first_date') || request()->input('last_date') || request()->input('tags'))
    <div class="border p-2">
        <b>Filtro aplicado:</b><br>
    @if (request()->input('word'))
        Nome Documento / Descricao:
        <b class="px-2"> {{ request()->input('word') }} </b>
    @endif

    @if (request()->input('categories'))
        <br>Categorias:
        @foreach ( request()->input('categories')  as $cat)
            <b class="p-1">{{ $category = $categories->where('id', $cat)->first()->name }}</b>,
        @endforeach
    @endif

    @if (request()->input('first_date') || request()->input('last_date'))

            <?php
            $first_date = str_replace('-', '/', request()->input('first_date'));
            $first_date = date('d/m/Y', strtotime($first_date));
            $last_date = str_replace('-', '/', request()->input('last_date'));
            $last_date = date('d/m/Y', strtotime($last_date));
            ?>

        @if (request()->input('first_date') && request()->input('last_date'))
                <br>Data de publicacao:
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
                @foreach ( request()->input('tags')  as $tag)
                    <b class="p-1">{{ $tag = $tags->where('id', $tag)->first()->name }} </b>
                @endforeach
    @endif
    </div>
@endif

