<?php $categories = \App\Category::all(); $documents = \App\Document::all(); $tags = \App\Tag::all()?>

<style>
    a {
        color: darkred;
    }
</style>

<div class="tab-content">
    <div id="menu2" class="tab-pane fade in active border px-4">
        BUSCAR POR<p></p>

        <?php $tags_array = request('tags') ? request('tags') : []; ?>
            <form method="POST" action="{{ route('documents.filter') }}" enctype="multipart/form-data"> @csrf
                    Tags: <br>
                    <div class="checkbox">
                        @foreach($tags->chunk(4) as $chunked_tag)
                            <div class="row py-2">
                            @foreach( $chunked_tag as $tag )
                                <div class="col-sm-3">
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
                    </div>

                <div class="row p-4">
                    <div class="col" id="Categorias">
                        <b>Tipo de Documento:</b><br>
                        <select
                            id="category" name="category"
                            class="selectpicker col-10"
                            value="category" data-live-search="true">
                            <option id="category" name="category" value="0">
                                Todos
                            </option>
                            @forelse($categories as $category)
                                <div class="col">
                                    <option id="results_per_page" name="results_per_page" value=" {{ $category->id }} ">
                                        {{ $category->name }}
                                    </option>
                                </div>
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse
                        </select>
                    </div>

                    <div class="col" id="Periodo">
                        <b>Período de:</b> <br>
                        <div>
                            <input
                                name="first_date" id="first_date" type="date"
                                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                                value="{{ request()->input('first_date') }}">
                            <i class="fas fa-calendar-alt p-2"></i>
                            <label class="px-1 small">até</label>
                            <input
                                name="last_date" id="last_date" type="date"
                                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                                value="{{ request()->input('last_date') }}">
                            <i class="fas fa-calendar-alt p-2"></i>
                        </div>
                    </div>
                </div>


                <b class="p-4">Ordenar por:</b>
                <div class="row px-4">
                    <div class="px-4 col form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="order_by" id="order_by" value="date">
                        Data crescente
                    </div>

                    <div class="col form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="order_by" id="order_by" value="category">
                        Data decrescente
                    </div>

                    <div class="col" id="results_per_page">
                        Resultados por página
                        <select
                            id="results_per_page" name="results_per_page"
                            class="selectpicker"
                            value="category_id" data-live-search="true">
                            <option id="results_per_page" name="results_per_page">10</option>
                            <option id="results_per_page" name="results_per_page">20</option>
                            <option id="results_per_page" name="results_per_page">30</option>
                            <option id="results_per_page" name="results_per_page">40</option>
                            <option id="results_per_page" name="results_per_page">50</option>
                            <option id="results_per_page" name="results_per_page">100</option>
                        </select>
                    </div>
                    <div class="col-2" id="btnBuscar2">
                        <button class="btn btn-danger btn-lg" data-toggle="tooltip" title="buscar resultados">
                            Buscar
                        </button>
                        <button class="btn btn-light border btn-lg " type="submit"  action="{{ route('documents.index') }}">
                            <a href="{{ route('search-theme') }}" data-toggle="tooltip" title="limpar campos">
                                <i class="fas fa-eraser" style="color: black"></i>
                            </a>
                        </button>
                    </div>
                </div>
            </form> <p class="py-2 border-bottom"></p>
            <p>
                <a class="btn btn-danger" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    +
                </a> <b style="color:darkred"> Dicas de Pesquisa</b>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    Não use artigos, preposições, conjunções e pronomes. <br>A acentuação é opcional.                    </div>
            </div>
        </div>
    </div>

<p></p><br>
@yield('index_content')

