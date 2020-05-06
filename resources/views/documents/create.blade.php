@extends ('layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <link href="~bulma-calendar/dist/css/bulma-calendar.min.css" rel="stylesheet">
    <script src="~bulma-calendar/dist/js/bulma-calendar.min.js"></script>
    <script>
        // Initialize all input of type date
        var calendars = bulmaCalendar.attach('[type="date"]', options);

        // Loop on each calendar initialized
        for(var i = 0; i < calendars.length; i++) {
            // Add listener to date:selected event
            calendars[i].on('select', date => {
                console.log(date);
            });
        }

        // To access to bulmaCalendar instance of an element
        var element = document.querySelector('#my-element');
        if (element) {
            // bulmaCalendar instance is available as element.bulmaCalendar
            element.bulmaCalendar.on('select', function(datepicker) {
                console.log(datepicker.data.value());
            });
        }
    </script>
@endsection

@section ('content')
    <div id="content">
            <h1 class="heading has-text-weight-bold is-size-4">Novo Documento</h1>

            <form method="POST" action="/documentos" enctype="multipart/form-data">
                @csrf
                <div class="field">
                    <label class="label" for="category_id">Categoria</label>

                    <div class="control">
                        <select
                            id="category_id"
                            name="category_id"
                            class="selectpicker"
                            value="category_id"
                            data-live-search="true">

                            @foreach($categories as $category)
                                <option value={{ $category->id }}>{{ $category->name }}</option>
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
                            class="input @error('description') is-danger @enderror "
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
                    <div class="control">
                        <label class="label" for="date">Data do Documento: </label>
                        <i class="fas fa-calendar p-2"></i>
                        <input name="date" id="date" type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">

                        @error('date')
                            <p class="help is-danger">{{ $errors->first('date') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1">
                            <label class="form-check-label" for="inlineRadio1">Esta vigente</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0">
                            <label class="form-check-label" for="inlineRadio1">Nao esta vigente</label>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="document_id">Documento relacionado: </label>
                        <select
                            id="document_id"
                            name="document_id"
                            class="selectpicker"
                            multiple
                            value="document_id"
                            data-live-search="true">

                            @foreach($documents as $document)
                                <option value={{ $document->id }}>{{ $document->name }} - {{ $document->description }}</option>
                            @endforeach
                        </select>

                </div>

                <div class="field"><br>
                    <label for="file_name">Upload a document: </label>
                    <i class="fa fa-upload p-1"></i>
                    <input
                        class="input @error('file_name') is-danger @enderror"
                        type="file"
                        accept=".pdf, application/pdf"
                        name="file_name"
                        id="file_name"
                        value="{{ old('file_name') }}">
                </div>

                <div class="field"><br>
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
                        <button class="button is-link" type="submit">Criar</button>
                    </div>
                </div>
            </form>
    </div>
@endsection
