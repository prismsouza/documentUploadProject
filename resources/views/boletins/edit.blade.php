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
                                <option value="<?php echo $boletim->category->id == 1 ? 2 : 1; ?>">
                                    <?php echo $boletim->category->name == 'BGBM' ? 'BEBM' : 'BGBM'; ?>
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

<!-- -------------- UPDATE FILES -------------- -->
                <?php $files = $boletim->files->whereNull('alias')->all(); $i=0; ?>
                <?php $count_anexos = count($files);?>
                @if (!empty($files))
                    <p class="py-4"><b>Anexos:</b> (máximo 5)</p>

                    @foreach ($files as $file)
                    <div class="form-row" ID="upload_files">
                        <div class="col-md-1">
                            <label for="new_file{{$i}}" class="btn btn-light border">Anexar</label><span class="px-3"></span>
                        </div>
                        <div class="col-md">
                            <span id="current_file{{$i}}" class="current_file_text">
                                Atual: {{ $file->name }}
                            </span><span class="px-3"></span>
                            <a  data-toggle="tooltip" title="download {{ $file->name }}"
                                href="{{ route('boletins.download', [$boletim->id , $file->hash_id]) }}"
                                class="btn btn-light"
                                id="download{{$file->id}}">
                                <i class="fas fa-download" style="color:darkseagreen"></i>
                            </a>
                            @if ($file->type == "application/pdf")
                                <a  data-toggle="tooltip" title="visualizar {{ $file->name }}"
                                    href="{{ route('boletins.viewfile', [$boletim->id , $file->id]) }}" target="_blank"
                                    class="btn btn-light"
                                    id="visualize{{$file->id}}">
                                    <i class="fas fa-eye" style="color:cadetblue"></i>
                                </a>
                            @endif
                            <span
                                class="btn btn-light" id="remove_field{{$i}}"
                                data-toggle="tooltip" title="remover {{ $file->name }}">
                                <i class="far fa-trash-alt" style="color: darkred" aria-hidden="true"></i>
                            </span>
                            <span
                                class="btn btn-light" id="undo_field{{$i}}" style="visibility: hidden"
                                data-toggle="tooltip" title="desfazer">
                                <i class="fa fa-undo" style="color: dimgrey" aria-hidden="true"></i>
                            </span>

                            <input
                                class="input" type="file"
                                name="files[]" id="new_file{{$i}}"
                                value="{{ $file->name }}"
                                style="display: none">
                            <span id="new_file_text{{$i}}" class="new_file_text py-2"
                                  style="display:none">
                            </span>

                            <script>
                                $( "#new_file{{$i}}").click(function() {
                                    $("input[value]").bind("change", function() {
                                        new_file({{$i}});
                                    });
                                });
                                $( "#remove_field{{$i}}" ).click(function() {
                                    remove_file({{$i}});
                                });
                                 $( "#undo_field{{$i}}" ).click(function() {
                                     undo_file({{$i}});
                                 });
                            </script>

                            @error('new_file{{$i}}')
                            <p class="help is-danger">{{ $errors->first('new_file'.$i) }}</p>
                            @enderror
                            </div>
                    </div>
                        <?php $i = $i+1; ?>
                    @endforeach
                @endif
                @for ($i=$count_anexos; $i < 5; $i++)
                    <div class="form-row">
                        <div class="col-md-1">
                            <label for="new_file{{$i}}" class="btn btn-light border">Anexar</label><span class="px-3"></span>
                        </div>
                        <div class="flex-column px-2">
                            <input
                                class="input" type="file"
                                name="files[]" id="new_file{{$i}}"
                                value="{{ $file->name }}"
                                style="display: none">
                            <span id="new_file_text{{$i}}" class="py-2"></span>
                            <span class="px-3"></span>
                        </div>
                        <div class="flex-column">
                                <span
                                    class="btn btn-light " id="remove_field{{$i}}" style="display:none"
                                    data-toggle="tooltip" title="remover {{ $file->name }}">
                                    <i class="far fa-trash-alt" style="color: darkred" aria-hidden="true"></i>
                                </span>

                                <script>
                                $( "#new_file{{$i}}").click(function() {
                                    $("input[value]").bind("change", function() {
                                        console.log($("#remove_field{{$i}}"));
                                        new_file({{$i}});
                                        $("#remove_field{{$i}}").css("visibility", "visible");
                                    });
                                });
                                $( "#remove_field{{$i}}" ).click(function() {
                                    remove_file({{$i}});

                                });
                                $( "#undo_field{{$i}}" ).click(function() {
                                    undo_file({{$i}});
                                });
                            </script>

                            <script>
                                /*$("#new_file_text{{$i}}").css("display", "none");
                                var input = document.getElementById('new_file{{$i}}');
                                var infoArea;
                                input.addEventListener( 'change', showFileName);
                                function showFileName( event ) {
                                    var input = event.srcElement;
                                    var fileName = input.files[0].name;
                                    infoArea = document.getElementById('new_file_text{{$i}}');
                                    $("#current_file{{$i}}").css({"color": "darkred", "text-decoration": "line-through"});
                                    $("#new_file_text{{$i}}").css("display", "block");
                                    $("#remove_field{{$i}}").css("visibility", "visible");
                                    $("#remove_field{{$i}}").fadeIn();
                                    $("#undo_field{{$i}}").fadeOut();
                                    infoArea.textContent = (fileName);
                                }

                                $("#remove_field{{$i}}").on("click", function(){ //user click on remove text
                                    $("#new_file_text{{$i}}").text();
                                    $("#remove_field{{$i}}").fadeOut();
                                });*/

                            </script>
                        </div>
                    </div>
                    @endfor



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
