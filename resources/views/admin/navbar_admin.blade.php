<br>
<table class="table-bordered text-center" style="width: 100%; table-layout: fixed">
    <nav>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <tr><ul class="navbar-nav mr-auto">
                <td class="nav-item">
                    <a class="nav-link {{ (Request::is('documentos') || Request::is('/'))  ? 'bg-light' : ''}}"
                       href={{ route('documents.index') }}><b>Documentos</b>
                    </a>
                </td>
                <td class="nav-item">
                    <a class="nav-link {{ Request::is('boletins') ? 'bg-light' : ''}}"
                       href="{{ route('boletins.index') }}"><b>Boletins / Separata</b>
                    </a>
                </td>
                <td class="nav-item">
                    <a class="nav-link {{ Request::is('categorias') ? 'bg-light' : ''}}"
                       href={{ route('categories.index') }}><b>Categorias</b>
                    </a>
                </td>
                <td class="nav-item">
                    <a class="nav-link {{ Request::is('tags') ? 'bg-light' : ''}}"
                       href="{{ route('tags.index') }}"><b>Tags</b>
                    </a>
                </td>
                <td class="nav-item">
                    <a class="nav-link {{ Request::is('admin/mensagens') ? 'bg-light' : ''}}"
                       href="{{ route('messages.index') }}"><b>Mensagens</b>
                    </a>
                </td>
                <td class="nav-item">
                    <a class="nav-link {{ Request::is('admin/contato') ? 'bg-light' : ''}}"
                       href="{{ route('contacts.index') }}"><b>Contato</b>
                    </a>
                </td>
            </ul></tr>
        </div>
    </nav>
</table>
<div class="py-4"></div>
