@extends ('layout')
<?php $categories = App\Category::all();?>


@section ('content')

        <a href="{{ route('documents.index') }}">
            <button class="btn btn-light btn-outline-dark float-md-right" type="submit">
                Voltar
            </button>
        </a><p class="py-4"></p>
    <table class="table table-bordered bg-white table-striped text-center"">
        <th colspan="3">Painel do Administrador</th>
        <tr>
            <th>
                Categorias
            </th>
            <td class="col-sm-2"><a href="{{ route("categories.index") }}">
                    Listar <i class="fas fa-list-ul"></i></a>
            </td>
            <td class="col-sm-2"><a href="{{ route("categories.create") }}">
                    Criar <i class="fas fa-plus-circle"></i></a>
            </td>
        </tr>
        <tr>
            <th>
                Documentos
            </th>
            <td><a href="/documentos">
                    Listar <i class="fas fa-list-ul"></i></a>
            </td>
            <td><a href="/documentos/novo">
                    Criar <i class="fas fa-plus-circle"></i></a>
            </td>
        </tr>
        <tr>
            <th>
                Boletim Geral
            </th>
            <td><a href="/documentos/categorias/Boletim Geral">
                    Listar <i class="fas fa-list-ul"></i></a>
            </td>
            <td><a href="/documentos/novo/bgbm">
                    Criar <i class="fas fa-plus-circle"></i></a>
            </td>
        </tr>
        <tr>
            <th>
                Tags
            </th>
            <td><a href="/tags">
                    Listar <i class="fas fa-list-ul"></i></a>
            </td>
            <td><a href="/tags/novo">
                    Criar <i class="fas fa-plus-circle"></i></a>
            </td>
        </tr>
        <tr>
            <th>
                Mensagens
            </th>
            <td colspan="3"><a href="/admin/mensagens">
                    Listar <i class="fas fa-list-ul"></i></a>
            </td>
        </tr>
    </table>
@endsection
