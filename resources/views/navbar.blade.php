<?php $documents = App\Document::all(); ?>

<div class="container">
    <nav class="mb-1 navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="/">Inicio</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
            aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" >
                <a class="list-group-item {{ Request::is('categorias') ? 'bg-light' : 'navbar-light'}}"
                   href="/categorias">Categorias
                </a>
            </li>
            <li class="nav-item">
                <a class="list-group-item {{ Request::is('departamentos') ? 'bg-light' : 'navbar-light'}}"
                   href="/unidades">Departamentos
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="list-group-item {{ Request::is('documentos') ? 'bg-light' : 'navbar-light'}} dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Documentos
                </a>
                <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                    @foreach($documents as $document)
                        <a class="dropdown-item" href="documentos/{{ $document->id }}"> {{  $document->name }}</a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</nav>
</div>
