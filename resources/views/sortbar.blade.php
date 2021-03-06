
@section('sortbar')

<div class="border p-2">
    <form method="POST" id="sortForm" action="{{ route('documents.index') }}" enctype="multipart/form-data" class="py-2"> @csrf
            <div id="option">
                <div class="row px-4 py-2">Ordenar por:
                    <span class="px-4"></span> <b>Nome:</b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="nomeAsc"
                        @if (Session::get('option') == "nomeAsc") checked @endif >
                        A-Z
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="nomeDesc"
                               @if (Session::get('option') == "nomeDesc") checked @endif >
                        Z-A
                    </div>
                    <span class="px-4"></span> <b>Data do documento: </b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataAsc"
                               @if (Session::get('option') == "dataAsc") checked @endif >
                        Antigos  <i class="fa fa-arrow-right" style="color:black" aria-hidden="true"></i>Novos
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataDesc"
                               @if (Session::get('option') == "dataDesc") checked @endif >
                        Novos <i class="fa fa-arrow-right" style="color:black" aria-hidden="true"></i> Antigos
                    </div>
                @if(Session::get('admin'))
                    <span class="px-4"></span> <b>Data inserção no sistema: </b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataCreatedAtAsc"
                               @if (Session::get('option') == "dataCreatedAtAsc") checked @endif >
                        Crescente
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataCreatedAtDesc"
                               @if (Session::get('option') == "dataCreatedAtDesc") checked @endif >
                        Decresc
                    </div>
                    @endif
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
