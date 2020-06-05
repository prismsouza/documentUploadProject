@extends ('layout_admin')
@section ('content')

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Novo Documento</h1>
    <form method="POST" action="/documentos" enctype="multipart/form-data" class="p-5 border"> @csrf

<!-- -------------- CATEGORY -------------- -->
        <div class="form-row" id="category">
            <div class="col-md-12 mb-3">
            <label for="category_id">Categoria <b>*</b></label>
            <select
                id="category_id" name="category_id"
                class="selectpicker form-control col-4"
                value="category_id" data-live-search="true">

                @foreach($categories as $category)
                    @if ($category->id != '1') <!-- Boletim Geral -->
                        <option id="category_id" name="category_id"
                                value={{ $category->id }}>{{ $category->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            </div>
        </div>

<!-- -------------- NAME -------------- -->
        <div class="form-row py-4">
            <div class="col-md-4 mb-3">
                <label>Nome <b>*</b> </label>
                <input
                    class="form-control input @error('name') is-danger @enderror"
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}">

            @error('name')
            <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
            </div>

<!-- -------------- DESCRIPTION -------------- -->
            <div class="col-md-8 mb-3">
                <label for="description">Descrição<b> *</b></label>
                <input
                    class="form-control input @error('description') is-danger @enderror"
                    type="text"
                    name="description" id="description"
                    value="{{ old('description') }}">

                    @error('description')
                        <p class="help is-danger">{{ $errors->first('description') }}</p>
                    @enderror
            </div>
        </div>
<!-- -------------- UPLOAD PDF FILE -------------- -->
        <div class="form-row" ID="upload_file">
            <div class="col-md-6 mb-3">
                <label for="file_name_pdf">Anexar arquivo em formato pdf:<b>*</b> </label>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                <input
                    class="input @error('file_name_pdf') is-danger @enderror"
                    type="file" accept=".pdf, application/pdf"
                    name="file_name_pdf" id="file_name_pdf"
                    value="{{ old('file_name_pdf') }}">

                @error('file_name_pdf')
                <p class="help is-danger">{{ $errors->first('file_name_pdf') }}</p>
                @enderror
<!-- -------------- UPLOAD MORE FILES -------------- -->
                Anexar mais arquivos (máximo 5)
                <button class="add_field_button btn border"><i class="fas fa-plus"></i></button>

<!-- -------------- DOCUMENT_HAS_DOCUMENT -------------- -->
                <div class="dropdown py-5" id="document_has_document">
                    <label>Documentos Relacionados:</label>
                    <button id="dLabel" role="button" href="#" class="btn btn-light border"
                            data-toggle="dropdown" data-target="#" >
                        Selecione documentos... <span class="caret"></span>
                    </button>


                    <ul class="dropdown-menu" style="width: 90%">
                        <input class="form-control" id="tags_input" type="text" placeholder="Search..">
                        @foreach($documents as $document)
                            @if ($document->category_id != 1)
                                <div class="col-sm">
                                    <li class="p-1">
                                        <label class="box px-5 checkbox-inline">
                                            <input
                                                type="checkbox" value="{{ $document->id }}"
                                                id="{{ $document->id }}" name="document_has_document[]">
                                            {{ $document->name }}
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </div>
                            @endif
                        @endforeach
                    </ul>
                </div>

<!-- -------------- PUBLISHED AT BGBM X -------------- -->
                <div class="dropdown " id="published_at">
                    <label>Publicado no BGBM:</label>
                    <button id="dropdownPublishedAt" role="button" type="button"
                            class="btn btn-light border form-control col-10"
                            data-toggle="dropdown" data-target="#"
                            aria-haspopup="true" aria-expanded="true">
                        <span class="caret float-md-right"></span>
                    </button>


                    <ul class="dropdown-menu" style="width: 90%" aria-labelledby="dropdownPublishedAt">
                        <input class="form-control" id="published_at_input" type="text" placeholder="Search..">
                            <?php $documents_bgbm = $categories->where('name','Boletim Geral')->first()->documents; ?>
                            <li class="p-1">
                                <a>--------------------------------</a>
                            </li>
                            @foreach($documents_bgbm as $doc_bgbm)
                                <li class="p-1">
                                    <a>{{ $doc_bgbm->name }} - {{ date('d/m/Y', strtotime($document->date)) }}</a>
                                </li>
                            @endforeach
                    </ul>
                </div>
            </div>

            <!-- -------------- UPLOAD MORE FILES -------------- -->
            <div class="col-md-6 mb-3" rowspan="2">
                <div class="input_fields_wrap" rowspan="2"></div>
            </div>
        </div> <!-- end row -->

<!-- -------------- DATE -------------- -->
        <div class="form-row">
            <div class="col-md-12 mb-4">
                <div class="control py-4" id="date">
                    <label for="date">Data de Publicacao do Documento: <b>*</b></label>
                    <i class="fas fa-calendar p-2"></i>
                    <input
                        name="date" id="date" class="@error('date') is-danger @enderror"
                        type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                        value="{{ old('date') }}">

                    @error('date')<p class="help is-danger">{{ $errors->first('date') }}</p>@enderror
                </div>
            </div>
        </div>

<!-- -------------- IS_ACTIVE -------------- -->
        <div class="form-row">
            <div class="col-md-12 mb-4">
                <div class="control" id="is_active">
                    <label for="is_active"class="">O documento: <b>*</b></label>
                    <div class="form-check form-check-inline px-5" id="is_active">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label" for="inlineRadio1">Está vigente</label>
                    </div>
                    <div class="form-check form-check-inline" id="is_active">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0">
                        <label class="form-check-label" for="inlineRadio1">Não está vigente</label>
                    </div>
                @error('is_active')<p class="help is-danger">{{ $errors->first('is_active') }}</p>@enderror
                </div>
            </div>
        </div>

<!-- -------------- TAGS -------------- -->

        <div class="form-row py-2">
            <div class="col-md-12">
                <div class="dropdown" id="Tags">
                    <label>Tags:</label>
                    <a href="/tags" class="btn">
                        <i class="fas fa-cog"></i>
                    </a>
                    <button id="dLabel" role="button" href="#" class="btn btn-light border"
                            data-toggle="dropdown" data-target="#" >
                        Selecione tags... <span class="caret"></span>
                    </button>


                    <ul class="dropdown-menu" style="width: 90%">
                        <input class="form-control" id="tags_input" type="text" placeholder="Search..">
                        @forelse($tags as $tag)
                            <div class="col-sm">
                                <li class="p-1">
                                    <label class="box px-5 checkbox-inline">
                                        <input
                                            type="checkbox" value="{{ $tag->id }}"
                                            id="{{ $tag->id }}" name="tags[]">
                                        {{ $tag->name }}
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </div>

                        @empty
                            <p><h5>Nao ha tags cadastradas</h5></p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <br><br><span class="small float-md-left">* campos obrigatorios</span><br>

<!-- -------------- BTN Criar Documento -------------- -->
        <div class="field is-grouped" id="btn_create_document">
                <button class="btn btn-dark btn-outline-light border" type="submit">Criar Documento</button>
        <a href="{{ route('home') }}" class="btn btn-light border">
            <i class="fas fa-home"></i>
        </a>
        </div>
    </form>


    <br><br>

    <script src="{{ asset('site/create_document.js') }}"></script>
@endsection
