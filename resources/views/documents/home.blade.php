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
</div><br><br>
    @endsection
