@extends ('layout_admin')
@section ('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Novo Boletim</h1>
    <form method="POST" action="/boletins" enctype="multipart/form-data" class="p-5 border"> @csrf
    <!-- -------------- CATEGORY -------------- -->
        <div class="form-row" id="category">
            <div class="col-md-12 mb-3">
                <label for="category_id">Categoria <b>*</b></label>
                <select
                    id="category_id" name="category_id"
                    class="selectpicker form-control col-4"
                    value="category_id" data-live-search="true">
                    <?php $category = App\Category::where('id', 1)->first();?>
                    <option id="category_id" name="category_id"
                            value={{ $category->id }}>{{ $category->name }}
                    </option>
                    <?php $category = App\Category::where('id', 2)->first();?>
                    <option id="category_id" name="category_id"
                        value={{ $category->id }}>{{ $category->name }}
                    </option>
                    <?php $category = App\Category::where('id', 3)->first();?>
                    <option id="category_id" name="category_id"
                        value={{ $category->id }}>{{ $category->name }}
                    </option>
                </select>
            </div>
        </div>

<!-- -------------- NAME -------------- -->
        <div class="form-row py-4">
            <div class="col-md-4 mb-3">
                <label>Nome <b>*</b> </label>
            <input
                class="form-control input @error('name') is-danger @enderror"
                type="text" minlength="7" maxlength="40"
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
                <label for="file_name_pdf" class="btn border">Anexar Arquivo em PDF<b>*</b></label>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-pdf" aria-hidden="true"></i>

                <input
                    class="input @error('file_name_pdf') is-danger @enderror"
                    type="file" accept=".pdf, application/pdf"
                    name="file_name_pdf" id="file_name_pdf"
                    value="{{ old('file_name_pdf') }}"
                    style="display: none">

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

<!-- -------------- DATE -------------- -->
        <div class="control py-4 mb-4">
            <label for="date">Data de Publicação: <b>*</b></label>
            <i class="fas fa-calendar-alt p-2"></i>
            <input
                name="date" id="date"
                type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">

            @error('date')
            <p style="color: darkred">{{ $errors->first('date') }}</p>
            @enderror
        </div>

        <span class="small float-md-left">* campos obrigatorios</span><br>


        <!-- -------------- BTN Criar BGBM -------------- -->
        <div class="field is-grouped" id="btn_create_document">
            <button class="btn btn-dark btn-outline-light border" type="submit">Salvar</button>
            <a href="{{ route('home') }}" class="btn btn-light border">
                <i class="fas fa-home"></i>
            </a>
            <a onclick="goBack()" class="btn btn-light border">
                Voltar
            </a>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </div>
            </div>
        </div>
    </form><br><br>

    <script src="{{ asset('site/create_document.js') }}"></script>
@endsection
