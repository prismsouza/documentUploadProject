@extends ('layout_admin')
@section ('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <a onclick="goBack()" class="btn btn-light border float-md-right">Voltar</a>

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Novo Documento</h1>
    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="p-5 border"> @csrf

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
                        @if ($category->id != old('category_id'))

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
                        <div id="category{{$category->id}}" style="display: none"> textttttttttt{{ $category->hint }} </div>
                            <div id="category{{$category->id}}"> textttttttttt{{ $category->hint }} </div>
                            <span id="category{{$category->id}}" style="display: none"> textttttttttt{{ $category->hint }} </span>
                            <span id="category{{$category->id}}"> textttttttttt{{ $category->hint }} </span>



                    @endforeach

                </select>
                <?php if (old('category_id') == null) { ?>
                    <p style="color: darkred">{{ $errors->first('category_id') }}</p>
                <?php } ?>
            </div>
        </div>
        <div id="hint"></div>
        <script>


        $('#category_id').change(function() {
            $('#hint').value = $('#category_id').val();
            var category_id = $('#category_id').val();
            console.log(category_id);

            var category_hint = $('#category'+category_id).text();
            console.log(category_hint);

        })
        </script>
<!-- -------------- NAME -------------- -->
        <div class="form-row py-4">
            <div class="col-md-4 mb-3">
                <label for="name">Nome <b>*</b> </label>
                <input
                    class="form-control input @error('name') is-danger @enderror"
                    type="text" minlength="3" maxlength="84"
                    name="name" id="name" value="{{ old('name') }}">

                @error('name')
                <p style="color: darkred">{{ $errors->first('name') }}</p>
                @enderror
            </div>

<!-- -------------- DESCRIPTION -------------- -->
            <div class="col-md-8 mb-3">
                <label for="description">Descrição<b> *</b></label>
                <input
                    class="form-control input @error('description') is-danger @enderror"
                    type="text" maxlength="138"
                    name="description" id="description"
                    value="{{ old('description') }}">

                @error('description')
                    <p style="color: darkred">{{ $errors->first('description') }}</p>
                @enderror
            </div>
        </div>

<!-- -------------- UPLOAD PDF FILE -------------- -->
        <div class="form-row" ID="upload_file">
            <div class="col-md-12 mb-3">
                <label for="file_name_pdf" class="btn border">Anexar Arquivo Principal em PDF<b>*</b></label>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-pdf" aria-hidden="true"></i>

                <input
                    class="input @error('file_name_pdf') is-danger @enderror"
                    type="file" accept=".pdf, application/pdf"
                    name="file_name_pdf" id="file_name_pdf"
                    value="{{ old('file_name_pdf') }}"
                    style="display: none"><br>
                    <!--style="visibility: hidden">-->

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
                <script>
                    var names = [];
                    var file_name = '';

                    var generateList = function() {
                        names.forEach((name, i) => {
                            var line = "<button class='btn' style=\"color: forestgreen\">" + name + "  <i class=\"fas fa-trash-alt\"></i></button><br>";
                            $('.list_files').append(line);
                        });
                        document.getElementById("filesToUpload").value = JSON.stringify(names);
                    }

                $(function() {
                    $("#files").on('change', function() {
                       names = [];
                        $('.list_files').text("");
                        var files = document.getElementById('files').files;

                        for (var i = 0; i < files.length; i++) {
                            file_name = files.item(i).name;
                            file_name = file_name.replace(/,/g, "");
                            names.push(file_name);
                        }

                        generateList();
                        $("#attach_more").text("");
                        $("#plus").text("Substituir arquivos");

                        console.log(names);
                    });

                    $('.list_files').on("click","button", function() { //user click on remove text
                        console.log(names);
                        var name = $(this).text().trim();
                        console.log(name);
                        var position = names.indexOf(name);
                        console.log(position);

                        names.splice(position, 1);
                        $('.list_files').text("");
                        generateList();
                        //console.log(names);
                    })
                });
                </script>
            </div>

<!-- -------------- DOCUMENT_HAS_DOCUMENT -------------- -->
                <div class="dropdown py-2" id="document_has_document">
                    <label>Documentos Relacionados:</label>
                    <button id="dLabel" role="button" href="#" class="btn btn-light border"
                            data-toggle="dropdown" data-target="#" >
                        Selecione documentos... <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 50%">
                        <input class="form-control" id="document_has_document_input" type="text" placeholder="Search..">
                        @foreach(App\Document::all() as $document)
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

                <div class="dropdown py-3" id="published_at">
                    <label>Publicado no BGBM/BEBM: </label>

                    <button id="dropdownPublishedAt" role="button"
                            class="btn border px-3 btn-light col-4"
                            data-toggle="dropdown" data-target="#"
                            aria-haspopup="true" aria-expanded="true">
                            N/A <span class="caret"></span>
                        @if (old('boletim_document_id') != null)
                            {{ App\Boletim::where("id", old('boletim_document_id'))->first()->name }}
                            - {{ date('d/m/Y', strtotime(App\Boletim::where("id", old('boletim_document_id'))->first()->date)) }}
                        @endif
                    </button>

                    <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 50%" aria-labelledby="dropdownPublishedAt" >
                        <input class="form-control" id="boletim_document_input" type="text" placeholder="Search.." >
                            <?php $boletins = App\Boletim::all(); ?>

                            @foreach($boletins as $doc_boletim)
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
                        @if ( old('is_active')  == 1) {{"checked"}} @endif
                        onclick="hide();">
                        <label class="form-check-label">Está vigente</label>
                    </div>
                    <div class="form-check form-check-inline" id="is_active">
                        <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0"
                        @if ( old('is_active')  == 0 && old('is_active')  != null) {{"checked"}} @endif
                        onclick="show();">
                        <label class="form-check-label">Não está vigente</label>
                    </div>
                @error('is_active')<p style="color: darkred">{{ $errors->first('is_active') }}</p>@enderror
                </div>
            </div>
        </div>

<!-- -------------- DOCUMENT REVOKED BY -------------- -->
           <div id="divRevokedDoc" style="display: none">
              <div class="dropdown py-1" id="revoked_by">
                  <label>Foi revogado pelo documento: </label>

                  <button id="dropdownRevokedBy" role="button"
                          class="btn border px-3 btn-light col-4"
                          data-toggle="dropdown" data-target="#"
                          aria-haspopup="true" aria-expanded="true">
                      N/A <span class="caret"></span>
                      @if (old('document_successor_id') != null)
                          {{ App\Document::where("id", old('document_successor_id'))->first()->name }}
                          - {{ date('d/m/Y', strtotime(App\Document::where("id", old('document_successor_id'))->first()->date)) }}
                      @endif
                  </button>

                  <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 50%" aria-labelledby="dropdownRevokedBy" >
                      <input class="form-control" id="document_successor_input" type="text" placeholder="Search.." >

                      @foreach(App\Document::all() as $document)
                          <li class="px-5">
                              <input
                                  type="radio" name="document_successor_id"
                                  id="{{ $document->id }}"
                                  value="{{ $document->id }}">
                              {{ $document->name }} - {{ date('d/m/Y', strtotime($document->date)) }}
                          </li>
                      @endforeach
                  </ul>
              </div>
           </div>

              <script>
                  function hide(){
                      document.getElementById('divRevokedDoc').style.display ='none';
                  }
                  function show(){
                      document.getElementById('divRevokedDoc').style.display = 'block';
                  }
              </script>

<!-- -------------- TAGS -------------- -->
        <div class="form-row py-3">
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

                    <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 90%" id="tags_ul">
                        <input class="form-control" id="tags_input" type="text" placeholder="Search..">
                        @forelse(App\Tag::all() as $tag)
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
                <button class="btn btn-dark btn-outline-light border" type="submit" onclick="allFiles()">
                    Criar Documento
                </button>
        </div>
    </form>

    <script>
        function allFiles() {
            document.getElementById('filesToUpload').value = names; //JSON.stringify(names);
        }
    </script>

    <br><br>

    <script src="{{ asset('site/create_document.js') }}"></script>
@endsection
