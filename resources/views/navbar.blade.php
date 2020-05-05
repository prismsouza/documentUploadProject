<?php $documents = App\Document::all(); ?>
<div class="container">
    <nav class="mb-1 navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/documentos">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
            aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" >
                <a class="list-group-item {{ Request::is('categorias') ? 'list-group-item-dark' : 'bg-light'}}" href="#">Categorias

                </a>
            </li>
            <li class="nav-item">
                <a class="list-group-item {{ Request::is('docudmentos') ? 'list-group-item-dark' : 'bg-light'}}" href="#">Departamentos</a>
            </li>
            <li class="nav-item dropdown">
                <a class="list-group-item {{ Request::is('categorias') ? 'list-group-item-dark' : 'bg-light'}} dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Documentos
                </a>
                <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                    @foreach($documents as $document)
                        <a class="dropdown-item" href="documentos/{{ $document->id }}">$document->name</a>
                    @endforeach
                </div>
            </li>
        </ul>

        <form action="{{ route('documents.search', "word") }}" method="POST" role="search" class="form-inline my-2 my-lg-0">
            {{ csrf_field() }}
            <div class="input-group">
                <input class="form-control mr-sm-2" type="text" name="word" placeholder="Pesquisar Documentos" aria-label="Search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Pesquisar</button>
            </div>
        </form>
    </div>
</nav>
</div>
