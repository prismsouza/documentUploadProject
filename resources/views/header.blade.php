
<div id="topo">
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
</ul>

<div class="container mt-1">
    <div class="row">
        <div class="col-md-2">
            <figure style="padding: 1em; background: #f8f9fa; border-radius: 5px; text-align: center;">
                <a href="https://intranet.bombeiros.mg.gov.br"><img class="img-fluid" src={{ asset('images/logo.png') }} alt=""></a>
            </figure>
        </div>
        <div class="col-md-7">
            <h2 style="text-transform: uppercase; font-size: 1.2em; margin-top: 1em"><b>Pesquisa Normativa</b></h2>
            <p>Documentos Publicados do Corpo de Bombeiros Militar de Minas Gerais</p>
        </div>
        <div class="col-md-3 form-inline">
            <div class="nav-item dropdown btn-light border" >
                <a class="nav-link text-secondary" href="#"
                   id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Links relacionados<span class="float-md-right"> <span class="caret"></span></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="width: 130%">
                    <a class="dropdown-item py-2"
                       href="http://pesquisalegislativa.mg.gov.br/Legislacao.aspx" target="_blank">
                        Normas Poder Executivo MG</a>
                    <a class="dropdown-item py-2" href="https://www.almg.gov.br/home/index.html" target="_blank">
                        Leis e Decretos Estaduais
                    </a>
                </div>
            </div>
            <div>
                <a href="{{ route('documents.refresh_session') }}" class="btn btn-light border float-md-right">
                    <i class="fas fa-home"></i>
                </a>
            </div>
        </div>
    </div>

</div>
<br>
</div>
