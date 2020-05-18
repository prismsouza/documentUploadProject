<?php $documents = App\Document::all(); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : 'bg-light'}}"
                   href="/">Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('categorias') ? 'active' : 'bg-light'}}"
                   href="/categorias">Categorias
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('departamentos') ? 'active' : 'bg-light'}}"
                   href="/unidades">Departamentos
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ Request::is('documentos') ? 'active' : 'bg-light'}}"
                   id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                   href="/documents">Documents
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach($categories as $category)
                        @forelse($category->documents as $document)
                            <a class="dropdown-item" href="/documentos/{{ $document->id }}"> {{  $document->name }}</a>
                        @endforeach
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="py-2"></div>
