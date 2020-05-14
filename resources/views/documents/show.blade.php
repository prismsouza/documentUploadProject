@extends ('layout')

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

    <p><b>Criado pela unidade:</b> {{ $document->user->unit->name }}</p>
    <p><b>Criado pelo usuario:</b> {{ $document->user->name }}</p>

    <p><b>Data de publicacao do documento:</b> {{ $document->date }}</p>

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

    <p><b>Download: </b>DOC
        <a style="color:navy" href="{{ route('documents.download', [$document->id , "doc"]) }}">
            {{ $doc_file->alias }}
        </a></p>
        @endif
    <p><b>Download: </b>PDF
        <a style="color:navy" href="{{ route('documents.download', [$document->id , "pdf"]) }}">
            {{ $pdf_file->alias }}
        </a>
    </p>

    <p><b>Visualizar PDF em nova aba:</b>
        <a style="color:navy" href="{{ route('documents.viewfile', $document->id) }}" target="_blank">
            {{ $pdf_file->alias }}
        </a>
    </p>

    <button type="button" class="btn btn-dark btn-sm float-md-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
        Reportar erro ou fazer sugestao
    </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">
                                Deseja reportar algum erro na norma ou fazer alguma sugestao/alerta para correcao do conteudo?
                            </label>
                        </div>
                        <div class="form-group">
                            <textarea
                                class="form-control"
                                id="message"
                                value="{{ old('message') }}"
                                rows="5">
                            </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>



@endsection
