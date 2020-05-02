@extends ('layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
@endsection

@section ('content')
    <div id="content">
            <h1 class="heading has-text-weight-bold is-size-4">Upload de Documento</h1>

            <form method="POST" action="/documentos" enctype="multipart/form-data">
                @csrf
                <div class="field">
                    <label class="label" for="theme_id">Categoria</label>

                    <div class="control">
                        <select
                            id="theme_id"
                            name="theme_id"
                            class="selectpicker"
                            value="theme_id"
                            data-live-search="true">

                            @foreach($themes as $theme)
                                <option value={{ $theme->id }}>{{ $theme->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="name">Nome</label>

                    <div class="control">
                        <input
                            class="input @error('name') is-danger @enderror"
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}">

                        @error('name')
                            <p class="help is-danger">{{ $errors->first('name') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="description">Descricao</label>

                    <div class="control">
                        <input
                            class="input @error('description') is-danger @enderror"
                            type="text"
                            name="description"
                            id="description"
                            value="{{ old('description') }}">

                        @error('excerpt')
                            <p class="help is-danger">{{ $errors->first('excerpt') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="file_name">Upload a document</label><br>
                    <input
                        class="input @error('file_name') is-danger @enderror form-control"
                        type="file"
                        accept=".pdf, application/pdf"
                        name="file_name"
                        id="file_name"
                        value="{{ old('file_name') }}">
                </div>

                <div class="field">
                    <label class="label" for="tags">Tags</label>

                    <div class="control">
                        <select
                            id="tags"
                            name="tags[]"
                            class="selectpicker"
                            multiple
                            title="Tags"
                        >
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" type="submit">Submit</button>
                    </div>
                </div>
            </form>
    </div>
@endsection
