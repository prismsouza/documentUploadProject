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

    <p><b>Validade:</b> Este documento <b><?php echo ($document->is_active ? "<span style=color:green>esta vigente" : "<span style=color:red>nao esta vigente"); ?></b></p>

    <b>Documentos relacionados:</b>
            <table class="table-bordered">
                @forelse ($related_documents as $doc)
                    <tr><td class="px-2 py-1"><a style="color:navy" href="{{ $doc->id }}">{{ $doc->name }} </a></td></tr>
                @empty
                    Nenhum documento relacionado
                @endforelse
            </table>
    <p></p>

    <p><b>Download:</b><br>
        PDF:
        <a style="color:navy" href="{{ route('documents.download', [$document->id , "pdf"]) }}">
            {{ $pdf_file->alias }}
        </a><br>
        DOC:
        <a style="color:navy" href="{{ route('documents.download', [$document->id , "doc"]) }}">
            {{ $doc_file->alias }}
        </a>
    </p>

    <p><b>Visualizar PDF em nova aba:</b>
        <a style="color:navy" href="{{ route('documents.viewfile', $document->id) }}" target="_blank">
            {{ $pdf_file->alias }}
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
