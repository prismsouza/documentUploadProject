@extends ('layout_admin')
@section('content')

    <?php
    $files = App\File::all();
    $fileEmentario = $files->where('alias', 'ementario')->first();
    ?>

    <h1 class="heading has-text-weight-bold is-size-4 py-6">Editar Documento</h1>
    <form method="POST" action="/"
          enctype="multipart/form-data" class="p-5 border">
    @csrf
    @method('PUT')

        <!-- -------------- REPLACE PDF FILE-------------- -->
        <div class="form-row" ID="upload_file">
            <div class="col-md-12 mb-3">
                <label for="file_name_pdf" class="btn border">Atualizar arquivo:<b>*</b> </label>
                <i class="fa fa-upload p-1"></i>
                <i class="fa fa-file-pdf" aria-hidden="true"></i>

                <input
                    class="input @error('file_name_pdf') is-danger @enderror"
                    type="file" accept=".pdf, application/pdf"
                    name="file_name_pdf" id="file_name_pdf"
                    value="{{ old('file_name_pdf') }}"
                    style="display: none">
                <!--style="visibility: hidden">-->

                <spam id="file_pdf_old" style="color: dimgrey">
                    {{ $fileEmentario->name }}
                </spam><br>

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

        <!-- -------------- BTN Salvar Alteração -------------- -->
        <div class="field is-grouped" id="btn_create_document">
            <button class="btn btn-dark btn-outline-light border" type="submit">Salvar</button>
        </div>
    </form>

    <br><br>
@endsection
