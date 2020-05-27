@extends ('layout')

<?php $user_id = 1; // admin ?>

@section ('content')
    <p><b>Categoria: </b>
        <a href="categorias/{{$document->category->name}}" >
            {{ $document->category->name }}
        </a>
    </p>
    <b>Documento</b>
    <div class="title">
        <h2>{{ $document->name }}</h2>
    </div>
    @if ($document->category_id != 100)
        <p style="color: grey">Tags:
        @forelse ($document->tags as $tag)
            <a style="color:darkgrey" class="px-2" href="{{ route ('documents.index',['tag' => $tag->name]) }}">
                {{ $tag->name }}
            </a>
        @empty
            Nenhuma tag cadastrada
        @endforelse
    @endif
        </p>
    <p><b>Descricao: </b>{{ $document->description }}</p>

    <p><b>Data de publicacao do documento:</b>
        {{ date('d/m/Y', strtotime($document->date)) }}
    </p>

    @if ($document->category_id != 100)

        @if ($document->bgbm_document_id !=0)
        <p><b>Publicado no BGBM:</b>
            <a style="color:navy" href= {{$document->bgbm_document_id}}>
                {{ $document->where('id', $document->bgbm_document_id)->first()->name }}</p>
        </a>
        @endif

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

        @if ($doc_file != null)
        <p><b>Baixar word: </b><i class="fa fa-file-word" aria-hidden="true"></i>
            <a style="color:navy" href="{{ route('documents.download', [$document->id , "doc"]) }}">
                  {{ $doc_file->alias }}
            </a></p>
        @endif
    @endif

    <p><b class="pr-2">Baixar pdf: </b><i class="fa fa-file-pdf" aria-hidden="true"></i>
        <a style="color:navy" href="{{ route('documents.download', [$document->id , "pdf"]) }}">
            {{ $pdf_file->alias }}
        </a>
    </p>

    <p><b>Visualizar PDF em nova aba:</b>
        <a style="color:navy" href="{{ route('documents.viewfile', $document->id) }}" target="_blank">
            {{ $pdf_file->alias }}
        </a>
    </p>

    @if ($user_id == 0)
        @include('documents/message_report')
    @else
        <button type="button" class="btn btn-info">
            <a href="{{ route('documents.edit', $document->id) }}" style="color:white">
                Editar documento <i class="fas fa-edit"></i>
            </a>
        </button>
        <form method="POST" id="delete-form-{{ $document->id }}"
              action="{{ route('documents.destroy', $document) }}"
              style="display: none;">
            {{ csrf_field() }}
            {{ method_field('delete') }}
        </form>
        <button type="button" class="btn btn-danger float-md-right">
            <a onclick="if (confirm('Tem certeza que deseja DELETAR esse documento?')){
                event.preventDefault();
                document.getElementById('delete-form-{{ $document->id }}').submit();
                } else {
                event.preventDefault();
                }"
               href=" {{ route ('documents.index') }}" style="color:white">
               Excluir documento <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </button>


    @endif

@endsection
