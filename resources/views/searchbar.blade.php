<div class="border p-2">
<?php $tags_array = request('tags') ? request('tags') : []; ?>
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

            <ul class="dropdown-menu" style="width: 110%">
                    <li class="p-2">
                        <label>
                            @forelse($categories as $category)
                                <div class="col-sm">
                                    <label class="box px-5 checkbox-inline">
                                        <input
                                            type="checkbox" value=" {{ $category->id }} "
                                            id="categories" name="categories[]"
                                            style="transform: scale(1.5);"
                                            placeholder="Selecionado">
                                        {{ $category->name }}
                                        <span class="checkmark px-2"></span>
                                    </label>
                                </div>
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse
                        </label>
                    </li>
                </li>
            </ul>
        </div>

        <div class="col-sm-4" id="Data Publicacao">
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
            Tags: <br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu" style="width: 90%">
                <li class="p-2">
                    <label>
                    @forelse($tags as $tag)
                        <div class="col-sm">
                            <label class="box px-5 checkbox-inline">
                                <input
                                    type="checkbox" value="{{ $tag->id }}"
                                    id="{{ $tag->id }}" name="tags[]"
                                <?php echo (in_array($tag->id,$tags_array)) ?'checked':'' ?>>
                                {{ $tag->name }}
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    @empty
                         <p><h5>Nao ha tags cadastradas</h5></p>
                    @endforelse
                    </label>

                </li>
            </ul>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control py-2">
            <button class="btn btn-dark border btn-outline-light float-md-right" type="submit" >
                Aplicar filtros <i class="fas fa-search px-2"></i>
            </button>

            <button class="btn btn-light border float-md-right" type="submit"  action="{{ route('documents.index') }}">
                <a href="{{ route('documents.index') }}">
                    Limpar filtros <i class="fas fa-eraser px-2"></i>
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

                            <?php $tags_array = request('tags') ? request('tags') : []; ?>
                                <div class="checkbox">
                                    @foreach($tags->chunk(6) as $chunked_tag)
                                        <div class="row py-1 px-6 is-flexible">
                                            @foreach( $chunked_tag as $tag )
                                                <div class="col-sm-2">
                                                    <label class="box px-5">
                                                        <input
                                                            type="checkbox"
                                                            id="{{ $tag->id }}" name="tags[]"
                                                            value="{{ $tag->id }}"
                                                        <?php echo (in_array($tag->id,$tags_array)) ?'checked':'' ?>>
                                                        {{ $tag->name }}
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                        <?php $tags_array = []; ?>
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
        <?php $tags_array =  array_unique(request()->input('tags')) ?>
        <br>Tags:
        @foreach ($tags_array as $tag)
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

