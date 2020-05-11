@extends ('layout_standalone')

@section ('content')
    <h1 class="heading has-text-weight-bold is-size-4 py-6">Novo Documento</h1>

    <form method="POST" action="/documentos" enctype="multipart/form-data" class="py-2"> @csrf

        <label class="label" for="category_id">Categoria</label>
        <select
            id="category_id" name="category_id"
            class="selectpicker"
            value="category_id" data-live-search="true">

            @foreach($categories as $category)
                <option value={{ $category->id }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <div class="control py-2 row">
            <div class="col-sm-1">
                <label class="label" for="name">Nome</label>
            </div>
            <input
                class="input @error('name') is-danger @enderror col-3"
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}">

            @error('name')
            <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="control py-2  row">
            <div class="col-sm-1">
                <label class="label" for="description">Descricao</label>
            </div>
            <input
                class="input @error('description') is-danger @enderror col-5"
                type="text"
                name="description" id="description"
                value="{{ old('description') }}">

                @error('excerpt')
                    <p class="help is-danger">{{ $errors->first('excerpt') }}</p>
                @enderror
        </div>

        <div class="row py-2">
            <div class="col">
                <label for="file_name_pdf">Inserir arquivo em formato pdf: </label><br>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                <input
                    class="input @error('file_name_pdf') is-danger @enderror"
                    type="file" accept=".pdf, application/pdf"
                    name="file_name_pdf" id="file_name_pdf"
                    value="{{ old('file_name_pdf') }}">
            </div>
            <div class="col">
                <label for="file_name_doc">Inserir arquivo em formato doc: </label><br>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-word" aria-hidden="true"></i>
                <input
                    class="input"
                    type="file" accept=".doc, .docx, .odt"
                    name="file_name_doc" id="file_name_doc"
                    value="{{ old('file_name_doc') }}">
            </div>
        </div>

        <div class="control py-2">
        <label class="label" for="document_id">Documentos relacionados: </label><br>
        <select
            id="document_has_document" name="document_has_document[]"
            class="selectpicker" multiple
            value="document_id" data-live-search="true">

            @foreach($documents as $document)
                <option value={{ $document->id }}>{{ $document->name }} - {{ $document->description }}</option>
            @endforeach
        </select>
        </div>

        <div class="control py-2">
            <label class="label" for="date">Data de Publicacao do Documento: </label>
            <i class="fas fa-calendar p-2"></i>
            <input
                name="date" id="date"
                type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">

            @error('date')
            <p class="help is-danger">{{ $errors->first('date') }}</p>
            @enderror
        </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                <label class="form-check-label" for="inlineRadio1">Esta vigente</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0">
                <label class="form-check-label" for="inlineRadio1">Nao esta vigente</label>
            </div>


        <div class="control py-2">
        <label class="label" for="tags">Tags</label><br>

            <select
                id="tags" name="tags[]"
                class="selectpicker" multiple
                title="Tags">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="btn btn-dark float-md-right" type="submit">Criar Documento</button>
            </div>
        </div>
    </form><br><br>
@endsection
