<div class="border p-2"  style="font-size:85%">
<form method="POST" action="{{ route('documents.filter') }}" enctype="multipart/form-data" class="py-2"> @csrf
    <div class="row">
        <div class="col-sm" id="Nome/Descricao">
            Nome/Descricão:
            <input
                class="form-control col-sm-12"
                type="text" name="word" id="word"
                value="{{ request()->input('word') }}">
        </div>

        <div class="col-sm" id="Categorias">
            Categorias:<br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu">
                <li>
                    <div class="checkbox">
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
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-sm-4" id="Data Publicacao">
            <i class="fas fa-calendar-alt p-2"></i>Data de Publicacao:<br>
            <div style="font-size:70%">
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
            Tags: <br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu">
                <li>
                    <div class="checkbox">
                    <label>
                    @forelse($tags as $tag)
                        <div class="col-sm">
                            <label class="checkbox-inline">
                                <input
                                    type="checkbox" value="{{ $tag->id }}"
                                    id="tag" name="tags[]"
                                    style="transform: scale(1.5);">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @empty
                         <p><h5>Nao ha tags cadastradas</h5></p>
                    @endforelse
                    </label>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control py-2">
            <button class="btn btn-dark  float-md-right" type="submit" >
                Aplicar filtros <i class="fas fa-search px-2"></i>
            </button>

            <button class="btn btn-light border  float-md-right" type="submit"  action="{{ route('documents.index') }}">
                <a href="{{ route('documents.index') }}">
                    Limpar filtros <i class="fas fa-eraser px-2"></i>
                </a>
            </button>

            <button class="btn btn-light border float-md-left px-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                +
            </button>

            <div class="row px-4">
                <div class="collapse dropdown-menu-lg-right float-md-left" id="collapseExample" >
                    <div class="control" id="is_active">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                            <label class="form-check-label" for="inlineRadio1">Esta vigente</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="-1">
                            <label class="form-check-label" for="inlineRadio2">Nao esta vigente</label>
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
        <br>Nome Documento / Descricao:
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

    @if (request()->input('is_active'))
        <br>Vigencia:
        <b class="p-1">{{ request()->input('is_active') == "1" ? "Vigente" : "Revogado" }}</b>
    @endif

    </div>
    <br>
@endif

