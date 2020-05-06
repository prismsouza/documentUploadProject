@extends ('layout')

@section ('content')
    <p><b>Categoria: </b>{{ $document->category->name }}</p>
    <b>Documento</b>
    <div class="title">
        <h2>{{ $document->name }}</h2>
    </div>
    <p><b>Descricao: </b>{{ $document->description }}</p>

    <p><b>Criado pela unidade:</b> {{ $document->user->unit->name }}</p>
    <p><b>Criado pelo usuario:</b> {{ $document->user->name }}</p>

    <p><b>Data do documento:</b> {{ $document->date }}</p>

    <b>Validade:</b> Este documento esta <?php echo ($document->is_active ? "vigente" : "invalido"); ?><br><br>

    <b>Documentos relacionados:</b>
    <?php echo ($document->name); ?><br><br>


    <p><b>Download:</b>
        <a href="{{ route('documents.download', $document->id) }}">
            {{ $document->file_name }}
        </a>
    </p>

    <p><b>Visualizar em uma nova aba:</b>
        <a href="{{ route('documents.viewfile', $document->id) }}" target="_blank">
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
