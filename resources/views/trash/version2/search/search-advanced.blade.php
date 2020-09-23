<?php $categories = \App\Category::all(); $documents = \App\Document::all(); $tags = \App\Tag::all()?>

<style>
    a {
        color: darkred;
    }
</style>

<div class="tab-content">
    <div id="menu3" class="tab-pane fade in active border px-4">
        BUSCAR POR<p></p>

        <?php $tags_array = request('tags') ? request('tags') : []; ?>
        <form method="POST" action="{{ route('documents.filter') }}" enctype="multipart/form-data"> @csrf

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
<br>
@yield('index_content')

