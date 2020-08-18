@extends(($admin) ? 'layout_admin' : 'layout')

@section ('content')

<div class="border p-5">
    <div class="border-bottom border-top py-4">
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
                    <label class="px-2"> Download </label> <label class="px-4"> Visualizar</label><br>
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
        <p style="color: grey">Tags:
        @forelse ($document->tags as $tag)
            <a style="color:darkgrey" class="px-2" href="{{ route ('documents.index',['tag' => $tag->name]) }}">
                {{ $tag->name }}
            </a>
        @empty
            Nenhuma tag cadastrada
        @endforelse
        </p>
    </div><br>
    <p><b>Publicado em </b>
        <span class="border p-3">
            {{ date('d/m/Y', strtotime($document->date)) }}
        </span>
    </p><br>


        @if (count($document->hasboletim) != 0)
        <p><b>Publicado no BGBM/BEBM:</b>
            <a style="color:navy" href= "/boletins/{{$document->hasboletim->first()->id}}" target="_blank">
                {{ $document->hasboletim->first()->name }}</p>
        </a><br>
        @endif

        <p><b>Validade:</b> Este documento <b><?php echo ($document->is_active ? "<span style=color:green>está vigente" : "<span style=color:red>não está vigente"); ?></b></p><br>

        @if (count($related_documents)>0)

                <p><b>Documentos Relacionados:</b>
                <ul>
                    @foreach ($related_documents as $doc)
                        <li class="px-2 py-1">
                             {{ $doc->name }} <span class="px-2"></span>
                            <a data-toggle="tooltip" title="ver detalhes {{ $doc->name }}"
                                class="btn btn-light"
                                href="{{ $doc->id }}" target="_blank">
                                <i class="fas fa-info-circle" style="color:seagreen"></i>
                            </a>
                            <?php $d = $doc->files->whereNotNull('alias')->first(); ?>
                            <a data-toggle="tooltip" title="download {{ $d->name }}"
                                class="btn btn-light"
                                href="{{ route('documents.download', [$d->document_id , $d->hash_id]) }}">
                                <i class="fas fa-download" style="color:darkseagreen"></i>
                            </a>
                             <a data-toggle="tooltip" title="visualizar {{ $d->name }}"
                                class="btn btn-light"
                                href="{{ route('documents.viewfile', [$d->document_id , $d->id]) }}" target="_blank">
                                 <i class="fas fa-eye" style="color:cadetblue"></i>
                             </a>
                        </li>
                    @endforeach
                </ul></p>


        <p></p><br>
        @endif
        @if (!empty($files))

            <p><b>Anexos:</b></p>
            <ul>
                @foreach ($files as $file)
                    <li class="px-2 py-1">
                        {{ $file->name }}<span class="px-2"></span>
                        <a  data-toggle="tooltip" title="download {{ $file->name }}" class="btn btn-light"
                           href="{{ route('documents.download', [$document->id , $file->hash_id]) }}">
                            <i class="fas fa-download" style="color:darkseagreen"></i>
                        </a>

                        @if ($file->type == "application/pdf")
                        <a data-toggle="tooltip" title="visualizar {{ $file->name }}" class="btn btn-light"
                           href="{{ route('documents.viewfile', [$document->id , $file->id]) }}" target="_blank">
                            <i class="fas fa-eye" style="color:cadetblue"></i>
                        </a>
                        @endif
                @endforeach
            </ul>
        @endif
</div>

    @if ($admin)
        <br>
        <button type="button" class="btn btn-info">
            <a href="{{ route('documents.edit', $document->id) }}" style="color:white">
                Editar documento  <i class="fas fa-edit" style="color: black"></i>
            </a>
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
    @else
        @include('documents/message_report')
    @endif

@endsection
