@extends ('layout_admin')
@section ('content')

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Novo Boletim</h1>
    <form method="POST" action="/documentos/categorias/BGBM" enctype="multipart/form-data" class="p-5 border"> @csrf
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
        <div class="form-row " ID="upload_file">
            <div class="col-md-12 mb-3">
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
        <div class="input_fields_wrap mb-4" style="width: 50%"></div>

        <div class="control py-2 mb-4">
            <label for="date">Data de Publicação: <b>*</b></label>
            <i class="fas fa-calendar-alt p-2"></i>
            <input
                name="date" id="date"
                type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">

            @error('date')
            <p class="help is-danger">{{ $errors->first('date') }}</p>
            @enderror
        </div><br>

        <span class="small float-md-left">* campos obrigatorios</span><br>


        <!-- -------------- BTN Criar BGBM -------------- -->
        <div class="field is-grouped" id="btn_create_document">
            <button class="btn btn-dark btn-outline-light border" type="submit">Criar Boletim BM</button>
            <a href="{{ route('home') }}" class="btn btn-light border">
                <i class="fas fa-home"></i>
            </a>
        </div>
            </div>
        </div>
    </form><br><br>

    <script src="{{ asset('site/create_document.js') }}"></script>
@endsection
