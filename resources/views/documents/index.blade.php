@extends('layout')
@section('content')
    @if($theme_option)
        <h2>{{ $theme_option }}</h2><br><br>
    @endif

    @if($documents=='[]')
        <h5>No documents found for this filter</h5>

    @else
    <table class="table table-striped table-bordered">
        <thead class="black white-text">
        <tr>
            <th scope="col">Titulo</th>
            <th scope="col">Autor/Unidade</th>
            <th scope="col">Tema</th>
            <th scope="col">Tamanho</th>
        </tr>
        </thead>
        <tbody>
    @endif

    @foreach($documents as $document)
        <tr>
            <td><a href="{{ $document->path()  }}">{{ $document->title }}</a></th>
            <td>{{ $document->user_id }}</td>
            <td>{{ $document->theme->title }}</td>
            <td>1KB</td>
        </tr>
    @endforeach

        </tbody>
    </table>

@endsection
