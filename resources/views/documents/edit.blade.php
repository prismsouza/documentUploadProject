@extends ('layout_standalone')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
@endsection

@section('content')
    <?php
    $categories = App\Category::all();
    $documents = App\Document::all();
    ?>
    <a href="{{ route('documents.index') }}">
        <button class="btn btn-light btn-outline-dark float-md-right" type="submit">
            Voltar
        </button>
    </a>

            <h1 class="heading has-text-weight-bold is-size-4">Editar Documento</h1>

            <form method="POST" action="/documentos/{{ $document->id }}">
                @csrf
                @method('PUT')

                <div class="control row" id="category">
                    <div class="col-sm-1">
                        <label class="label" for="category_id">Categoria</label>
                    </div><b class="px-1">*</b>
                    <select
                        id="category_id" name="category_id"
                        class="selectpicker"
                        value="category_id" data-live-search="true">

                        <option value={{ $document->category->id }}>{{ $document->category->name }}</option>
                    @foreach($categories as $category)
                        @if ($category->name != $document->category->name) <!-- Boletim Geral -->
                            <option id="category_id" name="category_id"
                                    value={{ $category->id }} >
                                {{ $category->name }}
                            </option>
                            @endif
                        @endforeach
                    </select>
                </div>

<!-- -------------- NAME -------------- -->
                <div class="control py-2 row" id="name">
                    <div class="col-sm-1">
                        <label class="label" for="name">Nome </label>
                    </div><b class="px-1">*</b>
                    <input
                        class="input @error('name') is-danger @enderror col-3"
                        type="text"
                        name="name"
                        id="name"
                        value="{{ $document->name }}">

                    @error('name')
                    <p class="help is-danger">{{ $errors->first('name') }}</p>
                    @enderror
                </div>

<!-- -------------- DESCRIPTION -------------- -->
                <div class="control py-2 row" id="description">
                    <div class="col-sm-1">
                        <label class="label " for="description">Descricao</label>
                    </div>
                    <b class="px-1">*</b>
                    <input
                        class="input @error('description') is-danger @enderror col-5"
                        type="text"
                        name="description" id="description"
                        value="{{ $document->description }}">

                    @error('description')
                    <p class="help is-danger">{{ $errors->first('description') }}</p>
                    @enderror
                </div>

<!-- -------------- UPLOAD PDF and DOC FILE -------------- -->
                <div class="row py-2" ID="upload_file">
                    <div class="col">
                        <label for="file_name_pdf">Substituir arquivo em formato pdf:<b>*</b> </label><br>
                        <i class="fa fa-upload p-1"></i>
                        <i class="fa fa-file-pdf" aria-hidden="true"></i>
                        <input
                            class="input @error('file_name_pdf') is-danger @enderror"
                            type="file" accept=".pdf, application/pdf"
                            name="file_name_pdf" id="file_name_pdf"
                            value="{{ 'file_name_pdf' }}">

                        @error('file_name_pdf')
                        <p class="help is-danger">{{ $errors->first('file_name_pdf') }}</p>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="file_name_doc">Inserir/Substituir arquivo em formato doc: </label><br>
                        <i class="fa fa-upload p-1"></i>
                        <i class="fa fa-file-word" aria-hidden="true"></i>
                        <input
                            class="input"
                            type="file" accept=".doc, .docx, .odt"
                            name="file_name_doc" id="file_name_doc"
                            value="{{ 'file_name_doc' }}">
                    </div>
                </div>
                <!-- -------------- DOCUMENT_HAS_DOCUMENT -------------- -->
                <div class="control py-2" id="related_documents">
                    <label class="label" for="document_id">Documentos relacionados: </label><br>
                    <select
                        id="document_has_document" name="document_has_document[]"
                        class="selectpicker" multiple
                        value="document_id" data-live-search="true">

                        @foreach($documents as $document)
                            @if ($document->category_id != 100)
                                <option value={{ $document->id }}>{{ $document->name }} - {{ $document->description }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- -------------- PUBLISHED AT BGBM X -------------- -->
                <div class="control py-2" ID="published_at">
                    <label class="label" for="bgbm_document_id">Publicado no BGBM: </label>
                    <select
                        id="bgbm_document_id" name="bgbm_document_id"
                        class="selectpicker"
                        value="document_id" data-live-search="true">
                        <option value="0"></option>
                        <?php $documents_bgbm = $categories->where('name','Boletim Geral')->first()->documents; ?>
                        @foreach($documents_bgbm as $doc_bgbm)
                            <option value={{ $doc_bgbm->id }}>{{ $doc_bgbm->name }} - {{ $doc_bgbm->description }} - {{ $doc_bgbm->date }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- -------------- DATE -------------- -->
                <div class="control py-2" id="date">
                    <label class="label" for="date">Data de Publicacao do Documento: <b>*</b></label>
                    <i class="fas fa-calendar p-2"></i>
                    <input
                        name="date" id="date" class="@error('date') is-danger @enderror"
                        type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">

                    @error('date')<p class="help is-danger">{{ $errors->first('date') }}</p>@enderror
                </div>

                <!-- -------------- IS_ACTIVE -------------- -->
                <div class="control" id="is_active">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                        <label class="form-check-label" for="inlineRadio1">Esta vigente</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0">
                        <label class="form-check-label" for="inlineRadio1">Nao esta vigente</label><b class="px-2">*</b>
                    </div>
                    @error('is_active')<p class="help is-danger">{{ $errors->first('is_active') }}</p>@enderror
                </div>

                <!-- -------------- TAGS -------------- -->
                <div class="control py-2" id="tags">
                    <label class="label" for="tags">Tags</label>
                    <a href="/tags" target="_blank">
                        <i class="fas fa-plus"></i>
                    </a><br>
                    <select
                        id="tags" name="tags[]"
                        class="selectpicker" multiple
                        title="Tags">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <span class="small float-md-right">* campos obrigatorios</span><br>

                <!-- -------------- BTN Editar Documento -------------- -->
                <div class="field is-grouped" id="btn_create_document">
                    <div class="control">
                        <button class="btn btn-dark float-md-right" type="submit">Salvar</button>
                    </div>
                </div>
            </form><br><br>
@endsection
