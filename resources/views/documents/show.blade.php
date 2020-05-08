@extends ('layout')

@section ('content')
    <p><b>Categoria: </b>{{ $document->category->name }}</p>
    <b>Documento</b>
    <div class="title">
        <h2>{{ $document->name }}</h2>
    </div><br>
    <p><b>Descricao: </b>{{ $document->description }}</p>

    <p><b>Criado pela unidade:</b> {{ $document->user->unit->name }}</p>
    <p><b>Criado pelo usuario:</b> {{ $document->user->name }}</p>

    <p><b>Data de publicacao do documento:</b> {{ $document->date }}</p>

    <p><b>Validade:</b> Este documento esta <b><?php echo ($document->is_active ? "<span style=color:green>vigente" : "<span style=color:red>invalido"); ?></b></p>

    <b>Documentos relacionados:</b>
            <table class="table-bordered">
                @forelse ($related_documents as $doc)
                    <tr><td class="px-2 py-1"><a style="color:navy" href="{{ $doc->id }}">{{ $doc->name }} </a></td></tr>
                @empty
                    Nenhum documento relacionado
                @endforelse
            </table>
    <p></p>

    <p><b>Download:</b>
        <a style="color:navy" href="{{ route('documents.download', $document->id) }}">
            {{ $document->file_name }}
        </a>
    </p>

    <p><b>Visualizar em uma nova aba:</b>
        <a style="color:navy" href="{{ route('documents.viewfile', $document->id) }}" target="_blank">
            {{ $document->file_name }}
        </a>
    </p>


    </p><b>Tags: </b>
    <table class="table-bordered">
        @forelse ($document->tags as $tag)
            <tr><td class="px-2 py-1"><a style="color:navy" href="{{ route ('documents.index',['tag' => $tag->name]) }}">{{ $tag->name }}</a></td></tr>
        @empty
            Nenhuma tag cadastrada
        @endforelse
    </table>

@endsection
