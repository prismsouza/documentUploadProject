@extends ('layout_admin')
<?php $categories = App\Category::all();?>

<style>
    table, tr, td{
        text-align: center;
    }
</style>
@section ('content')

    <a href="{{ route('documents.index') }}">
        <button class="btn btn-light btn-outline-dark float-md-right" type="submit">
            Voltar
        </button>
    </a><p class="py-4"></p>

    <table class="table table-bordered table-striped">
        <tr><td colspan="4"><b>Painel do Administrador</b></td></tr>
        <tr>
            <td class="col-md-3">
                <b>MASP</b>
            </td>
            <td class="col-md-3">

                <b>Nome</b>
            </td>
            <td class="col-md-3">
                <b>Unidade</b>
            </td>
            <td class="col-md-3">
                <b>Nível de Acesso</b>
            </td>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>
                    {{$user->masp}}
                </td>
                <td>
                    {{$user->masp}}
                </td>
                <td>
                    {{$user->masp}}
                </td>
                <td>
                    {{$user->admin}}
                </td>
            </tr>
            @endforeach

    </table>
@endsection
