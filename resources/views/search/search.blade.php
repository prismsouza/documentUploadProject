    <?php $categories = \App\Category::all(); $documents = \App\Document::all(); ?>

    <style>
        a {
            color: darkred;
        }
    </style>

    <div class="tab-content">
        <div id="menu1" class="tab-pane fade in active border px-4">
            BUSCAR POR<p></p>

            <div class="p-2" style="font-size: 16px">
                <form method="POST" action="{{ route('documents.filter') }}" enctype="multipart/form-data"> @csrf
                    <div class="row p-4">
                        <div class="col" id="Categorias">
                            <b>Tipo de Documento:</b><br>
                            <select
                                id="category" name="category"
                                class="selectpicker col-10"
                                value="category" data-live-search="true">
                                <option id="results_per_page" name="results_per_page" value="0">
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
                                <option id="results_per_page" name="results_per_page">10</option>
                                <option id="results_per_page" name="results_per_page">20</option>
                                <option id="results_per_page" name="results_per_page">30</option>
                                <option id="results_per_page" name="results_per_page">40</option>
                                <option id="results_per_page" name="results_per_page">50</option>
                                <option id="results_per_page" name="results_per_page">100</option>
                            </select>
                        </div>
                        <div class="col" id="number">
                            <b>Número:</b><br>
                            <input
                                class="form-control col-8"
                                type="number" name="number" id="number"
                                value="{{ request()->input('number') }}">
                        </div>
                        <div class="col" id="year">
                            <b>Ano:</b> (ex.: 1989)<br>
                            <input
                                class="form-control col-6"
                                type="text" name="year" id="year"
                                value="{{ request()->input('year') }}">
                        </div>
                    </div>
                    <div class="row p-4">
                        <div class="col" id="Subject">
                            <b>Assunto: </b> <a></a><br>
                            <input
                                class="form-control col-sm-10"
                                type="text" name="subject" id="subject"
                                value="{{ request()->input('subject') }}">
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
                            Data mais recente
                        </div>

                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="order_by" id="order_by" value="category">
                            Tipo
                        </div>

                        <div class=" col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="order_by" id="order_by" value="created_at">
                            Não ordenar <br>(pesquisa rápida)
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
                        <div class="col" id="btnBuscar1">
                            <button class="btn btn-danger btn-lg" data-toggle="tooltip" title="buscar resultados">
                                Buscar
                            </button>
                            <button class="btn btn-light border btn-lg " type="submit"  action="{{ route('documents.index') }}">
                                <a href="{{ route('search') }}" data-toggle="tooltip" title="limpar campos">
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

</div> @yield('index_content')
    <p></p><br>

