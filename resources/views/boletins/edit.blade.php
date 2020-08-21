@extends ('layout_admin')
@section('content')

    <style>
        .new_file_text {
            color: darkolivegreen;
            font-weight: bold;

        }
        .remove_file_text {
            color: darkred;
            text-decoration: line-through;
        }
        .current_file_text {
            color: dimgrey;
        }

    </style>
    <?php
    $categories = App\Category::all();
    $boletins = App\Boletim::all();
    ?>
    <a href="{{ route('boletins.index') }}">
        <button class="btn btn-light border float-md-right" type="submit">
            Voltar
        </button>
    </a>

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Editar BGBM/BEBM</h1>
    <form method="POST" action="/boletins/{{ $boletim->id }}" enctype="multipart/form-data" class="p-5 border">
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
                                <option value={{ $boletim->category->id }}>{{ $boletim->category->name }}</option>
                                @for($i=1; $i<=3; $i++)
                                    @if ($i != $boletim->category->id)
                                        <option id="category_id" name="category_id"
                                                value={{$i}}>
                                            {{ $categories->where('id', $i)->first()->name }}
                                        </option>
                                    @endif
                                @endfor
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
                                value="{{ $boletim->name }}">

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
                        value="{{ $boletim->description }}">

                    @error('description')
                    <p class="help is-danger">{{ $errors->first('description') }}</p>
                    @enderror
                        </div>
                    </div>

<!-- -------------- REPLACE PDF FILE -------------- -->
                <div class="form-row py-2" ID="upload_file">
                    <div class="col-md-4">
                            <label for="file_name_pdf">Substituir arquivo pdf:<b>*</b> </label>
                            <i class="fa fa-upload p-1"></i>
                            <i class="fa fa-file-pdf px-2" aria-hidden="true"></i>

                            <label for="file_name_pdf" class="btn btn-light border">Anexar novo</label>
                            <span class="px-3"></span>
                    </div>
                    <div class="col-md">
                            <span id="file_pdf_old" style="color: dimgrey">
                                {{ $boletim->files->whereNotNull('alias')->first()->alias }}
                            </span>

                        <input
                            class="input"
                            type="file" accept=".pdf, application/pdf"
                            name="file_name_pdf" id="file_name_pdf"
                            value="{{ $boletim->files->first()->name }}"
                            style="visibility: hidden">
                        <span id="new_file_pdf" style="color: darkolivegreen; font-weight: bold; display:none">
                        </span>

                        <script>
                            $("#file_name_pdf").css("display", "none");
                            var input = document.getElementById('file_name_pdf');
                            var infoArea;
                            input.addEventListener( 'change', showPDFFileName);
                            function showPDFFileName( event ) {
                                var input = event.srcElement;
                                var fileName = input.files[0].name;
                                infoArea = document.getElementById('new_file_pdf');
                                $("#file_pdf_old").css({"color": "darkred", "text-decoration": "line-through"});
                                $("#new_file_pdf").css("display", "block");
                                infoArea.textContent = (fileName);
                            }
                        </script>

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
                                    value="{{ $boletim->date }}">

                                @error('date')<p class="help is-danger">{{ $errors->first('date') }}</p>@enderror
                            </div>
                        </div>
                    </div>
                    <span class="small float-md-left">* campos obrigatorios</span><br>

                    <!-- -------------- BTN Editar Boletim -------------- -->
                    <div class="field is-grouped" id="btn_create_document">
                        <button class="btn btn-dark btn-outline-light border" type="submit" >
                            Salvar
                        </button>
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
            </form>
    <br><br>
    <script src="{{ asset('site/edit_document.js') }}"></script>
    <php>

    </php>
@endsection
