@extends ('layout')

@section ('content')
    <p><b>Tema: </b>{{ $document->theme->title }}</p>
    <b>Documento</b>
    <div class="title">
        <h2>{{ $document->title }}</h2>
    </div>
    <p><b>Resumo: </b>{{ $document->excerpt }}</p>
    <p><b>Arquivo:</b> {{ $document->file_path }}</p>
    <p><b>Criado por:</b> {{ $document->user_id }}</p>

    <a href="{{ url('/view/'.$document->file_path)}}" > Download</a>
@endsection
