@section('sortbar')

<div class="border p-2">
    <form method="POST" id="sortForm" action= "{{ action('DocumentsController@sort') }}" enctype="multipart/form-data" class="py-2"> @csrf
            <div id="option">
                <div class="row px-4 py-2">Ordenar resultados por:</div>
                <div class="row px-4">
                    <span class="px-4"></span> <b>Nome:</b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="nomeAsc">
                        Crescente
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="nomeDesc">
                        Decrescente
                    </div>
                    <span class="px-4"></span> <b>Data do documento: </b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataAsc">
                        Crescente
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataDesc">
                        Decrescente
                    </div>
                    <span class="px-4"></span> <b>Data de postagem: </b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataCreatedAtAsc">
                        Crescente
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataCreatedAtDesc">
                        Decrescente
                    </div>
                    <input class="input" style="display: none">
                </div>
            </div>
    </form>
</div><br>

<script>
    $(function(){
        $('#option').click(function(){
            $('#sortForm').submit();
        })
    })
</script>
@endsection
