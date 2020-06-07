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

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Editar BGBM/BEBM</h1>
    <form method="POST" action="/documentos/boletim/{{ $document->id }}" class="p-5 border">
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
                                <option value="<?php echo $document->category->id == 1 ? 2 : 1; ?>">
                                    <?php echo $document->category->name == 'BGBM' ? 'BEBM' : 'BGBM'; ?>
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
                    <span class="small float-md-left">* campos obrigatorios</span><br>

                    <!-- -------------- BTN Editar Boletim -------------- -->
                    <div class="field is-grouped" id="btn_create_document">
                        <button class="btn btn-dark btn-outline-light border" type="submit">Editar BGBM/BEBM</button>
                        <a href="{{ route('home') }}" class="btn btn-light border">
                            <i class="fas fa-home"></i>
                        </a>
                    </div>
            </form>
    <br><br>
    <script src="{{ asset('site/create_document.js') }}"></script>
@endsection
