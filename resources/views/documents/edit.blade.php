@extends ('layout_admin')
@section('content')

    <?php
    $categories = App\Category::all();
    $documents = App\Document::all();
    ?>
    <a href="{{ route('documents.index') }}">
        <button class="btn btn-light btn-outline-dark float-md-right " type="submit">
            Voltar
        </button>
    </a>

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Editar Documento</h1>
    <form method="POST" action="/documentos/{{ $document->id }}" class="p-5 border">
                @csrf
                @method('PUT')

<!-- -------------- CATEGORY -------------- -->
                    <div class="form-row" id="category">
                        <div class="col-md-12 mb-3">
                            <label for="category_id">Categoria <b>*</b></label>
                            <select
                                id="category_id" name="category_id"
                                class="selectpicker form-control col-4"
                                value="category_id" data-live-search="true">

                                <option value={{ $document->category->id }}>{{ $document->category->name }}</option>
                                @foreach($categories as $category)
                                    @if ($category->name != $document->category->name && $category->id != '1' && $category->id != '2') <!-- BGBM e BEBM -->) <!-- Boletim Geral -->
                                        <option id="category_id" name="category_id"
                                                value={{ $category->id }} >
                                            {{ $category->name }}
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
                                value="{{ $document->name }}">

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
                        value="{{ $document->description }}">

                    @error('description')
                    <p class="help is-danger">{{ $errors->first('description') }}</p>
                    @enderror
                        </div>
                    </div>

<!-- -------------- UPLOAD PDF and DOC FILE -------------- -->
                <div class="form-row" ID="upload_file">
                    <div class="col-md-6 mb-3">
                        <label for="file_name_pdf">Substituir arquivo pdf:<b>*</b> </label>
                        <i class="fa fa-upload p-1"></i>
                        <i class="fa fa-file-pdf" aria-hidden="true"></i>
                        <input
                            class="input @error('file_name_pdf') is-danger @enderror"
                            type="file" accept=".pdf, application/pdf"
                            name="file_name_pdf" id="file_name_pdf"
                            value="{{ $document->files->first()->name }}">

                        <spam style="color: dimgrey">
                            {{ $document->files->whereNotNull('alias')->first()->alias }}
                        </spam>

                        @error('file_name_pdf')
                        <p class="help is-danger">{{ $errors->first('file_name_pdf') }}</p>
                        @enderror
                    </div>
                </div>

<!-- -------------- DOCUMENT_HAS_DOCUMENT -------------- -->
                    <div class="dropdown py-5" id="document_has_document">
                        <label>Documentos Relacionados:</label>
                        <button id="dLabel" role="button" href="#" class="btn btn-light border"
                                data-toggle="dropdown" data-target="#" >
                            Selecione documentos... <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="width: 90%">
                            <input class="form-control" id="tags_input" type="text" placeholder="Search..">
                            @foreach($documents as $doc)
                                @if ($doc->category_id != 1 && $doc->category_id != 2)
                                    <div class="col-sm">
                                        <li class="p-1">
                                            <label class="box px-5 checkbox-inline">
                                                <input
                                                    type="checkbox" value="{{ $doc->id }}"
                                                    id="{{ $doc->id }}" name="document_has_document[]"
                                                    <?php if ($document->hasDocument()->find($doc->id)) echo "checked";?>>
                                                {{ $doc->name }}
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </div>
                                @endif
                            @endforeach
                        </ul>
                    </div>

<!-- -------------- PUBLISHED AT BGBM X -------------- -->
                    <div class="dropdown " id="published_at" style="width: 50%">
                        <label>Publicado no BGBM/BEBM:</label>
                        <button id="dropdownPublishedAt" role="button" type="button"
                                class="btn btn-light border form-control col-10"
                                data-toggle="dropdown" data-target="#"
                                aria-haspopup="true" aria-expanded="true">
                            @if (count($document->hasboletim) != 0)
                                {{ $document->hasboletim->first()->id }} - {{  date('d/m/Y', strtotime($document->hasboletim->first()->date)) }}
                            @endif
                        </button>


                        <ul class="dropdown-menu" style="width: 90%" aria-labelledby="dropdownPublishedAt">
                            <input class="form-control" id="boletim_document_input" type="text" placeholder="Search..">
                            <?php $documents_bgbm = $categories->where('name','BGBM')->first()->documents; ?>
                            <?php $documents_bebm = $categories->where('name','BEBM')->first()->documents; ?>
                            <?php $documents_boletins = $documents_bgbm->merge($documents_bebm);//$documents_boletim = $categories->where('name','BGBM')->where('name','BEBM')->first()->documents;?>

                            @if (count($document->hasboletim) != 0)
                            <li class="px-5" id="0">
                                <input
                                    type="radio" name="boletim_document_id"
                                    value=" {{ $document->boletim_document_id }}" style="background: darkseagreen">

                                    Atual: {{ $document->hasboletim->first()->name }} - {{ date('d/m/Y', strtotime($document->date)) }}
                            </li>
                            @endif
                            <li class="px-5" id="0">
                                <input
                                    type="radio" name="boletim_document_id"
                                    id="0" value="0">
                                vazio
                            </li>
                            @foreach($documents_boletins as $doc_boletim)
                                @if ($document->boletim_document_id != $doc_boletim->id)
                                    <li class="px-5">
                                        <input
                                            type="radio" name="boletim_document_id"
                                            id="{{ $doc_boletim->id }}"
                                            value="{{ $doc_boletim->id }}">
                                        {{ $doc_boletim->name }} - {{ date('d/m/Y', strtotime($document->date)) }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>


<!-- -------------- DATE -------------- -->
                    <div class="form-row">
                        <div class="col-md-12 mb-4">
                            <div class="control py-4" id="date">
                                <label for="date">Data de Publicacao do Documento: <b>*</b></label>
                                <i class="fas fa-calendar-alt p-2"></i>
                                <input
                                    name="date" id="date" class="@error('date') is-danger @enderror"
                                    type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                                    value="{{ $document->date }}">

                                @error('date')<p class="help is-danger">{{ $errors->first('date') }}</p>@enderror
                            </div>
                        </div>
                    </div>

                <!-- -------------- IS_ACTIVE -------------- -->
                    <div class="form-row">
                        <div class="col-md-12 mb-4">
                            <div class="control" id="is_active">
                                <label for="is_active">O documento: <b>*</b></label>
                                <div class="form-check form-check-inline px-5" id="is_active">
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" @if ($document->is_active == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="inlineRadio1">Está vigente</label>
                                </div>
                                <div class="form-check form-check-inline" id="is_active">
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0" @if ($document->is_active == 0) {{ 'checked' }} @endif>
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

                    <!-- -------------- BTN Editar Documento -------------- -->
                    <div class="field is-grouped" id="btn_create_document">
                        <button class="btn btn-dark btn-outline-light border" type="submit">Editar Documento</button>
                        <a href="{{ route('home') }}" class="btn btn-light border">
                            <i class="fas fa-home"></i>
                        </a>
                    </div>
            </form>
    <br><br>
    <script src="{{ asset('site/create_document.js') }}"></script>
@endsection
