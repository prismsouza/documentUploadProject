@extends ('layout')

@section ('content')
    <p><b>Categoria: </b>{{ $document->theme->name }}</p>
    <b>Documento</b>
    <div class="title">
        <h2>{{ $document->name }}</h2>
    </div>
    <p><b>Descricao: </b>{{ $document->description }}</p>

    <p><b>Criado pela unidade:</b> {{ $document->user->unit->name }}</p>
    <p><b>Criado pelo usuario:</b> {{ $document->user->name }}</p>

    <p><b>Download:</b>
        <a href="{{ route('documents.download', $document->id) }}">
            {{ $document->file_name }}
        </a>
    </p>

    <p style="margin-top: 1em">
        <b>Tags: </b>
        @forelse ($document->tags as $tag)
            <a href="{{ route ('documents.index',['tag' => $tag->name]) }}">{{ $tag->name }}</a>
        @empty
            Nenhuma tag cadastrada
        @endforelse

    </p>
@endsection
