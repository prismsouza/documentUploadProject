<ul class="nav justify-content-center navbar-navy bg-navy p-1">
    <li class="nav-item">
        <a class="nav-link active text-white" href="http://intranet.bombeiros.mg.gov.br">INTRANET</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-secondary" href="http://intranet.bombeiros.mg.gov.br/post/recent">Contribuições Recentes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-secondary" href="http://www.expressomg.mg.gov.br">E-mail</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-secondary" href="http://www.sei.mg.gov.br">SEI/BM</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link text-secondary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Links externos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
        </div>
    </li>
</ul>

<div class="container mt-1">
    <div class="row">
        <div class="col-md-2">
            <figure style="padding: 1em; background: #f8f9fa; border-radius: 5px; text-align: center;">
                <a href="{{ route('documents.index') }}"><img class="img-fluid" src={{ asset('images/logo.png') }} alt=""></a>
            </figure>
        </div>
        <div class="col-md-10">
            <h2 style="text-transform: uppercase; font-size: 1.2em; margin-top: 1em">Módulo de Documentos</h2>
            <p>Documentos Publicados do Corpo de Bombeiros Militar de Minas Gerais</p>
        </div>
    </div>
</div>
