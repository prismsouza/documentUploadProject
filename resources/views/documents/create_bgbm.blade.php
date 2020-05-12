@extends ('layout_standalone')

@section ('content')
    <h1 class="heading has-text-weight-bold is-size-4 py-6">Novo BGBM</h1>

    <form method="POST" action="/documentos/categorias/Boletim Geral" enctype="multipart/form-data" class="py-2"> @csrf

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

        <div class="control py-2 row">
            <div class="col-sm-1">
                <label class="label" for="description">Descricao</label>
            </div>
            <input
                class="input @error('description') is-danger @enderror col-5"
                type="text"
                name="description" id="description"
                value="{{ old('description') }}">

            @error('description')
            <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="py-2">
                <label for="file_name_pdf">Inserir arquivo em formato pdf: </label><br>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                <input
                    class="input @error('file_name_pdf') is-danger @enderror"
                    type="file" accept=".pdf, application/pdf"
                    name="file_name_pdf" id="file_name_pdf"
                    value="{{ old('file_name_pdf') }}">
        </div>
        @error('file_name_pdf')
        <p class="help is-danger">{{ $errors->first('file_name_pdf') }}</p>
        @enderror

        <div class="control py-2">
            <label class="label" for="date">Data de Publicacao do BGBM: </label>
            <i class="fas fa-calendar p-2"></i>
            <input
                name="date" id="date"
                type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">

            @error('date')
            <p class="help is-danger">{{ $errors->first('date') }}</p>
            @enderror
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="btn btn-dark float-md-right" type="submit">Importar BGBM</button>
            </div>
        </div>
    </form><br><br>
@endsection
