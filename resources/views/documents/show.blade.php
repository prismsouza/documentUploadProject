@extends ('layout')

<?php $user_id = 1; // admin ?>

@section ('content')
<style>p {font-size: 110%;}</style>
<div class="border p-5">
    <div class="row">
        <div class="col">
            <p><b>Categoria: </b>
                <a href="categorias/{{$document->category->name}}" >
                    {{ $document->category->name }}
                </a>
            </p>
            <div class="title">
                <h1>{{ $document->name }}</h1>
            </div>
            <h4>{{ $document->description }}</h4><br>
        </div>

        <div class="col-4">
            <div class="float-right">
                    <a class="btn border" data-toggle="tooltip" title="download {{ $pdf_file->alias }}"
                       href="{{ route('documents.download', [$document->id , $pdf_file->hash_id]) }}">
                        <i class="fas fa-download fa-4x" style="color:darkseagreen"></i>
                    </a>
                    <a class="btn border" data-toggle="tooltip" title="visualizar {{ $pdf_file->alias }}"
                       href="{{ route('documents.viewfile', [$document->id, $pdf_file->id]) }}" target="_blank">
                        <i class="fas fa-eye fa-4x" style="color:cadetblue"></i>
                    </a>
             </div>
        </div>
    </div>
    @if ($document->boletim_document_id != 0)
        <p style="color: grey">Tags:
        @forelse ($document->tags as $tag)
            <a style="color:darkgrey" class="px-2" href="{{ route ('documents.index',['tag' => $tag->name]) }}">
                {{ $tag->name }}
            </a>
        @empty
            Nenhuma tag cadastrada
        @endforelse
        </p><br>
@endif
    <p><b>Publicado em </b>
        <span class="border p-3">
            {{ date('d/m/Y', strtotime($document->date)) }}
        </span>
    </p><br>

    @if ($document->category_id != 1 && $document->category_id != 2)

        @if ($document->boletim_document_id != 0)
        <p><b>Publicado no BGBM/BEBM:</b>
            <a style="color:navy" href= "{{$document->boletim_document_id}}" target="_blank">
                {{ $document->where('id', $document->boletim_document_id)->first()->name }}</p>
        </a><br>
        @endif

        <p><b>Validade:</b> Este documento <b><?php echo ($document->is_active ? "<span style=color:green>esta vigente" : "<span style=color:red>nao esta vigente"); ?></b></p><br>

        @if (count($related_documents)>0)

                <p><b>Documentos Relacionados:</b>
                <ul>
                    @foreach ($related_documents as $doc)
                        <li class="px-2 py-1">
                                <a style="color:navy" href="{{ $doc->id }}" target="_blank">
                                    {{ $doc->name }} </a>
                            </li>
                    @endforeach
                </ul></p>


        <p></p><br>
        @endif
    @endif
        @if (!empty($files))

            <p><b>Anexos:</b></p>
            <ul>
                @foreach ($files as $file)
                    <li class="px-2 py-1">
                        <a style="color:navy" href="{{ route('documents.download', [$document->id, $file->hash_id]) }}">
                            {{ $file->name }}</a>
                        <a  data-toggle="tooltip" title="download {{ $file->name }}"
                           href="{{ route('documents.download', [$document->id , $file->hash_id]) }}">
                            <i class="fas fa-download" style="color:darkseagreen"></i>
                        </a>
                        <a  data-toggle="tooltip" title="visualizar {{ $file->name }}"
                           href="{{ route('documents.viewfile', [$document->id , $file->id]) }}" target="_blank">
                            <i class="fas fa-eye" style="color:cadetblue"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
</div>


    @if ($user_id == 0)
        @include('documents/message_report')
    @else
        <br>
        <button type="button" class="btn btn-info">
            @if($document->category_id == 1 || $document->category_id == 2)
                <a href="{{ route('documents_boletim.edit', $document->id) }}" style="color:white">
                    Editar Documento  <i class="fas fa-edit" style="color: black"></i>
                </a>

            @else
                <a href="{{ route('documents.edit', $document->id) }}" style="color:white">
                    Editar documento  <i class="fas fa-edit" style="color: black"></i>
                </a>
            @endif
        </button>
        <form method="POST" id="delete-form-{{ $document->id }}"
              action="{{ route('documents.destroy', $document) }}"
              style="display: none;">
            {{ csrf_field() }}
            {{ method_field('delete') }}
        </form>
        <button type="button" class="btn btn-danger">
            <a onclick="if (confirm('Tem certeza que deseja DELETAR esse documento?')){
                event.preventDefault();
                document.getElementById('delete-form-{{ $document->id }}').submit();
                } else {
                event.preventDefault();
                }"
               href=" {{ route ('documents.index') }}" style="color:white">
               Excluir documento <i class="far fa-trash-alt" style="color:black" aria-hidden="true"></i>
            </a>
        </button>


    @endif

@endsection
