@extends ('layout_admin')

@section ('content')


    <h1 class="heading has-text-weight-bold is-size-4 py-6">Novo Documento</h1>

    <form method="POST" action="/documentos" enctype="multipart/form-data" class="py-2"> @csrf

<!-- -------------- CATEGORY -------------- -->
        <div class="control row" id="category">
            <div class="col-sm-1">
                <label for="category_id">Categoria</label>
            </div><b class="px-1">*</b>
            <select
                id="category_id" name="category_id"
                class="selectpicker"
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

<!-- -------------- NAME -------------- -->
        <div class="control py-2 row" id="name">
            <div class="col-sm-1">
                <label for="name">Nome </label>
            </div><b class="px-1">*</b>
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

<!-- -------------- DESCRIPTION -------------- -->
        <div class="control py-2 row" id="description">
            <div class="col-sm-1">
                <label for="description">Descrição</label>
            </div>
            <b class="px-1">*</b>
            <input
                class="input @error('description') is-danger @enderror col-5"
                type="text"
                name="description" id="description"
                value="{{ old('description') }}">

                @error('description')
                    <p class="help is-danger">{{ $errors->first('description') }}</p>
                @enderror
        </div>

<!-- -------------- UPLOAD PDF FILE -------------- -->
        <div class="row py-2" ID="upload_file">
            <div class="col-4">
                <label for="file_name_pdf">Inserir arquivo em formato pdf:<b>*</b> </label><br>
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
            </div>
<!-- -------------- UPLOAD MORE FILES -------------- -->
            <div class="col"><br>
                <button class="add_field_button btn border">Adicionar outro arquivo</button>
                <div class="input_fields_wrap"></div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var max_fields      = 6; //maximum input boxes allowed
                var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
                var add_button      = $(".add_field_button"); //Add button ID

                var x = 1; //initlal text box count
                $(add_button).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append
                        ('<div>' +
                            '<input class="input" type="file" name="files[]" id="file2" value="file2">' +
                            '<a href="#" class="remove_field">' +
                            '<i class="far fa-trash-alt" style="color: black" aria-hidden="true"></i>' +
                            '</a>' +
                            '</div>');
                        /*('<div>' +
                            '<input type="text" name="mytext[]"/>' +
                            '<a href="#" class="remove_field">' +
                            '<i class="far fa-trash-alt" style="color: black" aria-hidden="true"></i>' +
                            '</a></div>'); //add input box*/
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
        </script>

<!-- -------------- DOCUMENT_HAS_DOCUMENT -------------- -->
        <div class="control py-2" id="document_has_document">
        <label for="document_id">Documentos relacionados: </label><br>
        <select
            id="document_has_document" name="document_has_document[]"
            class="selectpicker" multiple
            value="document_id" data-live-search="true">

            @foreach($documents as $document)
                @if ($document->category_id != 1)
                    <option value='{{ $document->id }}'> {{ $document->id }} - {{ $document->name }} - {{ $document->description }}</option>
                @endif
            @endforeach
        </select>
        </div>

<!-- -------------- PUBLISHED AT BGBM X -------------- -->
        <div class="control py-2" ID="published_at">
            <label for="bgbm_document_id">Publicado no BGBM: </label>
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
            <label for="date">Data de Publicacao do Documento: <b>*</b></label>
            <i class="fas fa-calendar p-2"></i>
            <input
                name="date" id="date" class="@error('date') is-danger @enderror"
                type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                value="{{ old('date') }}">

            @error('date')<p class="help is-danger">{{ $errors->first('date') }}</p>@enderror
        </div>

<!-- -------------- IS_ACTIVE -------------- -->
        <div class="control" id="is_active">
            <div class="form-check form-check-inline" id="is_active">
                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" checked>
                <label class="form-check-label" for="inlineRadio1">Esta vigente</label>
            </div>
            <div class="form-check form-check-inline" id="is_active">
                <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0">
                <label class="form-check-label" for="inlineRadio1">Nao esta vigente</label><b class="px-2">*</b>
            </div>
        @error('is_active')<p class="help is-danger">{{ $errors->first('is_active') }}</p>@enderror
        </div>

<!-- -------------- TAGS -------------- -->
        <div class="control py-2" id="tags">
        <label for="tags">Tags</label>
            <a href="/tags">
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
        </div><br>

        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                Tags
             </button>
            <ul class="dropdown-menu">
                <input class="form-control" id="myInput" type="text" placeholder="Search.."
                       name="tags[]"class="selectpicker" multiple >
                    @foreach($tags as $tag)
                        <li><option value="{{ $tag->id }}">{{ $tag->name }}</option></li>
                    @endforeach
            </ul>
        </div>

        <script>
            $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".dropdown-menu option").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>

        <span class="small float-md-left">* campos obrigatorios</span><br>

<!-- -------------- BTN Criar Documento -------------- -->
        <div class="field is-grouped" id="btn_create_document">
                <button class="btn btn-dark btn-outline-light border" type="submit">Criar Documento</button>
        <a href="{{ route('home') }}" class="btn btn-light border">
            <i class="fas fa-home"></i>
        </a>
        </div>
    </form>


    <br><br>
@endsection
