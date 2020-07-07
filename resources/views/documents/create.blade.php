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
                    <option class="collapsible list-group-item" value="{{ old('category_id') }}">
                        @if (old('category_id') != null)
                            {{ App\Category::where("id", old('category_id'))->first()->name }}
                        @endif

                    </option>

                    @foreach($categories as $category)
                        @if ($category->id != '1' && $category->id != '2' && $category->id != old('category_id')) <!-- BGBM e BEBM -->
                            @if (count($category->hassubcategory)>0)
                                <optgroup label="  {{ $category->name }}" class="px-2">
                                    @foreach($category->hassubcategory as $sub_cat)<br>
                                        @if ($sub_cat->id != old('category_id'))
                                        <option id="category_id" name="category_id"
                                                class="collapsible list-group-item"
                                                value={{ $sub_cat->id }}> - {{ $sub_cat->name }}
                                        </option>
                                    @endif
                                    @endforeach
                                </optgroup>

                            @else
                                @if (count($category->hasparent)==0)
                                    <option id="category_id" name="category_id"
                                            value={{ $category->id }}>{{ $category->name }}
                                    </option>
                                @endif
                            @endif
                        @endif
                    @endforeach

                </select>
                <?php if (old('category_id') == null) { ?>
                    <p style="color: darkred">{{ $errors->first('category_id') }}</p>
                <?php } ?>
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
            <p style="color: darkred">{{ $errors->first('name') }}</p>
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
                        <p style="color: darkred">{{ $errors->first('description') }}</p>
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
                    value="{{ old('file_name_pdf') }}"
                    style="visibility: hidden">

                <label for="file_name_pdf" class="btn border">Anexar...</label>
                <div id="file_pdf_upload" style="color: darkolivegreen"></div>

                <script>
                    var input = document.getElementById('file_name_pdf' );
                    var infoArea = document.getElementById( 'file_pdf_upload' );
                    input.addEventListener( 'change', showFileName);
                    function showFileName( event ) {
                        var input = event.srcElement;
                        var fileName = input.files[0].name;
                        infoArea.textContent = fileName;
                        console.log(fileName);
                    }
                </script>

                @error('file_name_pdf')
                <p style="color: darkred">{{ $errors->first('file_name_pdf') }}</p>
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
                        <input class="form-control" id="document_has_document_input" type="text" placeholder="Search..">
                        @foreach($documents as $document)
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
                        @endforeach
                    </ul>
                </div>

<!-- -------------- PUBLISHED AT BGBM X -------------- -->
                <div class="dropdown " id="published_at">
                    <label>Publicado no BGBM/BEBM:</label>
                    <button id="dropdownPublishedAt" role="button" type="button"
                            class="border p-3 btn-light form-control col-10"
                            data-toggle="dropdown" data-target="#"
                            aria-haspopup="true" aria-expanded="true">
                        @if (old('boletim_document_id') != null)
                            {{ App\Boletim::where("id", old('boletim_document_id'))->first()->name }}
                            - {{ date('d/m/Y', strtotime(App\Boletim::where("id", old('boletim_document_id'))->first()->date)) }}
                        @endif
                        <span class="caret float-md-right"></span>
                    </button>


                    <ul class="dropdown-menu" style="width: 90%" aria-labelledby="dropdownPublishedAt">

                        <input class="form-control" id="boletim_document_input" type="text" placeholder="Search..">
                            <?php $boletins = App\Boletim::all(); ?>
                            <li class="px-5" id="0">
                                <input
                                    type="radio" name="boletim_document_id"
                                    id="0" value="0"> vazio
                            </li>

                            @foreach($boletins as $doc_boletim)
                                <li class="px-5">
                                        <input
                                        type="radio" name="boletim_document_id"
                                        id="{{ $doc_boletim->id }}"
                                        value="{{ $doc_boletim->id }}">
                                    {{ $doc_boletim->name }} - {{ date('d/m/Y', strtotime($document->date)) }}
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
                    <i class="fas fa-calendar-alt p-2"></i>
                    <input
                        name="date" id="date" class="@error('date') is-danger @enderror"
                        type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                        value="{{ old('date') }}">

                    @error('date')<p style="color:darkred">{{ $errors->first('date') }}</p>@enderror
                </div>
            </div>
        </div>

<!-- -------------- IS_ACTIVE -------------- -->
        <div class="form-row">
            <div class="col-md-12 mb-4">
                <div class="control" id="is_active">
                    <label for="is_active">O documento: <b>*</b></label>
                    <div class="form-check form-check-inline px-5" id="is_active">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1"
                        @if ( old('is_active')  == 1) {{"checked"}} @endif >
                        <label class="form-check-label">Está vigente</label>
                    </div>
                    <div class="form-check form-check-inline" id="is_active">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0"
                        @if ( old('is_active')  == 0 && old('is_active')  != null) {{"checked"}} @endif >
                        <label class="form-check-label">Não está vigente</label>
                    </div>
                @error('is_active')<p style="color: darkred">{{ $errors->first('is_active') }}</p>@enderror
                </div>
            </div>
        </div>

<!-- -------------- TAGS -------------- -->
        <div class="form-row py-2">
            <div class="col-md-12">
                <div class="dropdown" id="tags">
                    <label>Tags:</label>
                    <a href="/tags" class="btn">
                        <i class="fas fa-cog"></i>
                    </a>
                    <button id="dLabel" role="button" href="#" class="btn btn-light border"
                            data-toggle="dropdown" data-target="#" >
                        Selecione tags... <span class="caret"></span>
                    </button>


                    <ul class="dropdown-menu" style="width: 90%" id="tags_ul">
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
