<?php use App\Http\Controllers\UsersController; ?>

@extends(($admin) ? 'layout_admin' : 'layout')
@include('searchbar')

@include('sortbar')

@section('content')
<div class="float-md-right">
    @if (UsersController::isUserSuperAdmin() && Session::get('admin') == 1)
        <a href="{{ route('admin.index') }}" class="btn btn-light border">
            <i class="fas fa-user-cog"></i>Painel do Administrador
        </a>
    @endif
    @if (UsersController::isUserAdmin() && Session::get('admin') == 1)
        <a href="{{ route('user.view') }}" class="btn btn-light border">
            <i class="fa fa-user"></i>Visão do usuário
        </a>
    @endif

    @if (UsersController::isUserAdmin() && Session::get('admin') == 0 )
        <a href="{{ route('admin.view') }}" class="btn btn-light border">
            <i class="fas fa-user-cog"></i>Visão do Administrador
        </a>
    @endif
</div><br>

@if (UsersController::isUserAdmin() && Session::get('admin') == 1)
    <a href="{{ route('documents.create') }}">
        <button class="btn btn-dark btn-outline-light border" type="submit">
            Novo Documento
        </button>
    </a><p></p>
@endif

@if (UsersController::isUserAdmin() && Session::get('admin') == 0)

<br><br>
    <div style="border:1px dashed red; padding: 10px"><strong>Obs.: </strong>
        Para acesso como administrador deste Módulo, a Unidade deverá encaminhar
        uma solicitação à BM1 através do Sistema Eletronico de Informações - SEI.
    </div>

@endif
@endsection
