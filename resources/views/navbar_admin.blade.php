<b>Administrador - Acesso Rápido</b>
<table class="table table-bordered text-center">

<nav>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <tr>
        <ul class="navbar-nav mr-auto">

                <td class="nav-item" style="width: 20%">

                <a class="nav-link {{ Request::is('documentos') ? 'bg-light' : ''}}"
                   href={{ route('documents.index') }}>Documentos
                </a>

                </td>
            <td class="nav-item">
                <a class="nav-link {{ Request::is('categorias') ? 'bg-light' : ''}}"
                   href={{ route('categories.index') }}>Categorias
                </a>
            </td>
            <td class="nav-item">
                <a class="nav-link {{ Request::is('documentos/categorias/Boletim Geral') ? 'bg-light' : ''}}"
                   href="{{ route('documents_category.index', 'Boletim Geral') }}">Boletim Geral
                </a>
            </td>
            <td class="nav-item">
                <a class="nav-link {{ Request::is('tags') ? 'bg-light' : ''}}"
                   href="{{ route('tags.index') }}">Tags
                </a>
            </td>
            <td class="nav-item">
                <a class="nav-link {{ Request::is('mensagens') ? 'bg-light' : ''}}"
                   href="{{ route('messages.index') }}">Mensagens
                </a>
            </td>

        </ul>
        </tr>
    </div>
</nav>
</table>
<div class="py-2"></div>
