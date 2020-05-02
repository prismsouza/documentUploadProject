@extends('layout')
@section('content')
    @if($theme_option)
        <h2>{{ $theme_option }}</h2><br><br>
    @else
        <h2>Todos Documentos</h2><br><br>
    @endif

    @if($documents!='[]')
    <table class="table table-striped table-bordered">
        <thead class="black white-text">
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Descricao</th>
            <th scope="col">Tema</th>
            <th scope="col">Download</th>
            <th scope="col">Tamanho</th>
        </tr>
        </thead>
        <tbody>
    @endif

    @forelse($documents as $document)
        <tr>
            <td><a href="{{ $document->path()  }}">{{ $document->name }}</a></th>
            <td>{{ $document->description }}</td>
            <td><a href="{{ $document->theme->path()  }}">{{ $document->theme->name }}</td>
            <td><a href="{{ route('documents.download', $document->id) }}">{{ $document->file_name }}</a></td>
            <td>{{ $document->size }}</td>
        </tr>
    @empty
        <p>No relevant articles yet.</p>
    @endforelse

        </tbody>
    </table>

@endsection
