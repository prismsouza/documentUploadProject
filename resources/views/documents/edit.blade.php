@extends ('layout_admin')
@section('content')

    <?php
    $categories = App\Category::all();
    $documents = App\Document::all();
    ?>

    <a onclick="goBack()" class="btn btn-light border float-md-right">Voltar</a>

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Editar Documento</h1>
    <form method="POST" action="/documentos/{{ $document->id }}"
          enctype="multipart/form-data" class="p-5 border">
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
                            @if ($category->name != $document->category->name &&
                                $category->id != '1' && $category->id != '2' && $category->id != '3') <!-- BGBM, BEBM e Separata -->) <!-- Boletim Geral -->

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
                <label for="name">Nome <b>*</b> </label>
                <input
                    class="form-control input @error('name') is-danger @enderror"
                    type="text" minlength="3" maxlength="84"
                    name="name" id="name" value="{{ $document->name }}">

                @error('name')
                <p style="color: darkred">{{ $errors->first('name') }}</p>
                @enderror
            </div>

<!-- -------------- DESCRIPTION -------------- -->
            <div class="col-md-8 mb-3">
                <label for="description">Descrição<b> *</b></label>
                <input
                    class="form-control input @error('description') is-danger @enderror"
                    type="text" name="description" id="description" maxlength="138"
                    value="{{ $document->description }}">

                @error('description')
                <p style="color: darkred">{{ $errors->first('description') }}</p>
                @enderror
            </div>
        </div>

<!-- -------------- REPLACE PDF FILE-------------- -->
        <div class="form-row" ID="upload_file">
            <div class="col-md-12 mb-3">
                <label for="file_name_pdf" class="btn border">Substituir Arquivo Principal em PDF:<b>*</b> </label>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-pdf" aria-hidden="true"></i>

                <input
                    class="input @error('file_name_pdf') is-danger @enderror"
                    type="file" accept=".pdf, application/pdf"
                    name="file_name_pdf" id="file_name_pdf"
                    value="{{ old('file_name_pdf') }}"
                    style="display: none">
                    <!--style="visibility: hidden">-->

                <span id="file_pdf_old" style="color: dimgrey">
                    @if (count($document->files->where('alias')->all()) != 0)
                        {{ $document->files->whereNotNull('alias')->first()->alias }}
                    @else
                        <span id="missing_file" style="color: darkred"> Não há nenhum arquivo principal em PDF cadastrado</span>
                    @endif
                </span><br>
                <script>
                    $( "#missing_file" ).fadeOut( 5000, function() {
                        $( this ).remove();
                    });
                </script>

                <div id="file_pdf_upload" style="color: darkolivegreen"></div>

                <script>
                    var input = document.getElementById('file_name_pdf' );
                    var infoArea = document.getElementById( 'file_pdf_upload' );
                    input.addEventListener( 'change', showFileName);
                    function showFileName( event ) {
                        var input = event.srcElement;
                        var fileName = input.files[0].name;
                        infoArea.textContent = fileName;
                        $("#file_pdf_old").css({"color": "darkred", "text-decoration": "line-through"});
                    }
                </script>

                @error('file_name_pdf')
                <p style="color: darkred">{{ $errors->first('file_name_pdf') }}</p>
                @enderror
            </div>
        </div>

<!-- -------------- UPLOAD MORE FILES -------------- -->
        <div class="form-group">
            <span id="attach_more">
                Anexar mais documentos
            </span>
            <label id="plus" for="files" class="btn border">+</label>

            <input multiple
                   name="files[]" id="files" type="file"
                   style="display: none">
            <input name="filesToUpload[]" id="filesToUpload" type="hidden" value="" >

            <div class="list_files" style="color: forestgreen"></div>

            <input name="to_delete[]" id="to_delete" type="text" style="display: none">

            <script>

                to_delete = [];
                names = [];
                items = [];
                @foreach($document->files as $file)
                    @if ($file->alias == NULL)
                        names.push('{{$file->name}}');
                        items.push({ id:{{$file->id}} , name:'{{$file->name}}'});
                    @endif
                @endforeach
                console.log(items);

                $(function() {
                    generateList();
                    $("#files").on('change', function() {
                        $('.list_files').text("");
                        var files = document.getElementById('files').files;

                        for (var i = 0; i < files.length; i++) {
                            names.push(files.item(i).name);
                        }
                        generateList();
                    });
                });

                var generateList = function() {
                    names.forEach((name, i) => {
                        var line = "<button class='btn' style=\"color: forestgreen\">" + name + "  <i class=\"fas fa-trash-alt\"></i></button><br>";
                        $('.list_files').append(line);
                    });
                    document.getElementById("filesToUpload").value = JSON.stringify(names);
                }

                $('.list_files').on("click","button", function() { //user click on remove text
                    var name = $(this).text().trim();
                    var position = names.indexOf(name);

                    var item = items.find(item => item.name === name);
                    if (item) to_delete.push(item.id);
                    console.log(to_delete);

                    names.splice(position, 1);
                    $('.list_files').text("");
                    generateList();
                })
            </script>
        </div>
<!-- -------------- DOCUMENT_HAS_DOCUMENT -------------- -->
        <div class="dropdown py-2" id="document_has_document">
            <label>Documentos Relacionados:</label>
            <button id="dLabel" role="button" class="btn btn-light border"
                    data-toggle="dropdown" data-target="#" >
                Selecione documentos... <span class="caret"></span>
            </button>

            <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 90%">
                <input class="form-control" id="document_has_document_input" type="text" placeholder="Search..">
                @foreach($documents as $doc)
                    @if ($doc->id == $document->id) @continue @endif
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
                @endforeach
            </ul>
        </div>

<!-- -------------- PUBLISHED AT BGBM X -------------- -->
        <div class="dropdown py-3" id="published_at" style="width: 50%">
            <label>Publicado no BGBM/BEBM:</label>
            <button id="dropdownPublishedAt" role="button" type="button"
                    class="btn btn-light border form-control col-10"
                    data-toggle="dropdown" data-target="#"
                    aria-haspopup="true" aria-expanded="true">
                @if (count($document->hasboletim) != 0)
                    Atual:
                    {{ $document->hasboletim->first()->name }} - {{  date('d/m/Y', strtotime($document->hasboletim->first()->date)) }}
                    <span class="caret"></span>
                @else N/A <span class="caret"></span>
                @endif
            </button>

            <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 90%" aria-labelledby="dropdownPublishedAt">
                <input class="form-control" id="boletim_document_input" type="text" placeholder="Search..">
                    <?php $boletins = App\Boletim::all(); ?>
                    @if (count($document->hasboletim) != 0)
                        <li class="px-5" id="0">
                            <input
                                type="radio" name="boletim_document_id" checked
                                value="{{ $document->hasboletim->first()->id }}" style="background: darkseagreen">

                            Atual: {{ $document->hasboletim->first()->name }} - {{ date('d/m/Y', strtotime($document->hasboletim->first()->date)) }}
                        </li>
                    @endif

                <li class="px-5" id="0">
                    <input
                        type="radio" name="boletim_document_id"
                        id="0" value="0"> N/A
                </li>

                @foreach($boletins as $doc_boletim)

                    @if (count ($document->hasboletim)>0 && $doc_boletim->id == $document->hasboletim->first()->id) @continue @endif
                        <li class="px-5">
                            <input
                                type="radio" name="boletim_document_id"
                                id="{{ $doc_boletim->id }}"
                                value="{{ $doc_boletim->id }}">
                            {{ $doc_boletim->name }} - {{ date('d/m/Y', strtotime($doc_boletim->date)) }}
                        </li>

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
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" @if ($document->is_active == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="inlineRadio1">Está vigente</label>
                                </div>
                                <div class="form-check form-check-inline" id="is_active">
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0" @if ($document->is_active == 0) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="inlineRadio1">Não está vigente</label>
                                </div>
                                @error('is_active')<p style="color: darkred">{{ $errors->first('is_active') }}</p>@enderror
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


                                <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 90%">
                                    <input class="form-control" id="tags_input" type="text" placeholder="Search..">
                                    @forelse($tags as $tag)
                                        <div class="col-sm">
                                            <li class="p-1">
                                                <label class="box px-5 checkbox-inline">
                                                    <input
                                                        type="checkbox" value="{{ $tag->id }}"
                                                        id="{{ $tag->id }}" name="tags[]"
                                                    <?php if ($document->tags()->find($tag->id)) echo "checked";?>>

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
                        <button class="btn btn-dark btn-outline-light border" type="submit" onclick="allFiles()">Editar Documento</button>
                        <a href="{{ route('home') }}" class="btn btn-light border">
                            <i class="fas fa-home"></i>
                        </a>
                    </div>
    </form>
    <script>
        function allFiles() {
            document.getElementById('filesToUpload').value = names; //JSON.stringify(names);
            document.getElementById('to_delete').value = to_delete; //JSON.stringify(names);
        }
    </script>

    <br><br>
    <script src="{{ asset('site/create_document.js') }}"></script>
@endsection
