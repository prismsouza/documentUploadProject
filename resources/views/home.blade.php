@extends('layout')

@include('searchbar')

@section('content')
    @if($admin)
        <a href="{{ route('admin.view') }}" class="btn btn-light border">
            Administrador  <i class="fas fa-user-cog"></i>
        </a>
        <br><br>
    @endif
    <div id="wrapper">
        <p><img src="images/banner2.jpg" class="img-fluid" style="opacity: 0.6"></p>
    </div>
@endsection

