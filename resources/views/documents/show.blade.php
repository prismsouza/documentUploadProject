@extends ('layout')

@section ('content')
    <p><b>Tema: </b>{{ $document->theme->title }}</p>
    <b>Documento</b>
    <div class="title">
        <h2>{{ $document->name }}</h2>
    </div>
    <p><b>Resumo: </b>{{ $document->description }}</p>
    <p><b>Arquivo:</b> {{ $document->file_path }}</p>
    <p><b>Criado por:</b> {{ $document->user_id }}</p>

    <a href="{{ url('/view/'.$document->file_path)}}" > Download</a>

    <p style="margin-top: 1em">
        <b>Tags: </b>
        @foreach ($document->tags as $tag)
            <a href="{{ route ('documents.index',['tag' => $tag->name]) }}">{{ $tag->name }}</a>
        @endforeach

    </p>
@endsection
