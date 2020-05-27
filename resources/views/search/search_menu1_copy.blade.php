
    <?php $categories = \App\Category::all(); $documents = \App\Document::all(); ?>

    <ul class="nav nav-tabs" style="padding-left: 5%">
        <li class="active" style="font-size: 20px"><a href="/pesquisa">PESQUISA</a></li>
        <li style="font-size: 20px"><a href="/pesquisa_tema">PESQUISA POR TEMA</a></li>
        <li style="font-size: 20px"><a href="/pesquisa_avancada">PESQUISA AVANCADA</a></li>
    </ul>

    <div class="tab-content">
        <div id="menu1" class="tab-pane fade in active border px-4">
            BUSCAR POR<p></p>

            <div class="p-2" style="font-size: 16px">
                <form method="POST" action="" enctype="multipart/form-data"> @csrf
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
                        <div class="col" id="Numero">
                            <b>Número:</b><br>
                            <input
                                class="form-control col-8"
                                type="text" name="number" id="number"
                                value="{{ request()->input('number') }}">
                        </div>
                        <div class="col" id="Ano">
                            <b>Ano:</b> (ex.: 1989)<br>
                            <input
                                class="form-control col-6"
                                type="text" name="year" id="year"
                                value="{{ request()->input('year') }}">
                        </div>
                    </div>
                    <div class="row p-4">
                        <div class="col" id="Assunto">
                            <b>Assunto: </b> <a></a><br>
                            <input
                                class="form-control col-sm-10"
                                type="text" name="word" id="word"
                                value="{{ request()->input('word') }}">
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
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                            Data mais recente
                        </div>

                        <div class="col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                            Tipo
                        </div>

                        <div class=" col form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                            Não ordenar <br>(pesquisa rápida)
                        </div>

                        <div class="col" id="ResultadosPorPag">
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
                        <div class="col" id="btnBuscar">
                            <button class="btn btn-danger btn-lg">Buscar</button>
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

</div>
    <p></p><br>
    <span style="font-size: 18px" class="py-4">Mostrando de <b>1</b> a <b>2</b> de <b>2</b> resultados</span>
    <p></p>
    <table class="table border">
        <tr>
            <td colspan="3"><i class="fas fa-print float-md-right"></i></td>
        </tr>
        <tr>
            <td>
                <b style="color: darkred; font-size: 20px">BOLETIM GERAL 21, de 21/05/2020</b><br>
                <span style="color: dimgrey; font-size: 16px">Boletim Geral do Corpo de Bombeiros Militar de Minas Gerais</span>
            </td>
            <td class="col-2">
                <i class="far fa-file-alt"></i> Texto Orginal
            </td>
            <td class="col-2">
                <i class="fas fa-file-alt"></i> Texto Atualizado
            </td>
        </tr>
        <tr>
            <td>
                <b style="color: darkred; font-size: 20px">BOLETIM GERAL 20, de 14/05/2020</b><br>
                <span style="color: dimgrey; font-size: 16px">Boletim Geral do Corpo de Bombeiros Militar de Minas Gerais</span>
            </td>
            <td class="col-2">
                Texto Orginal
            </td>
            <td class="col-2">
                Texto Atualizado
            </td>
        </tr>
    </table>
