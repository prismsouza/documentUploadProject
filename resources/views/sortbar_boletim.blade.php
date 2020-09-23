@section('sortbar_boletim')

<div class="border p-2">
    <form method="POST" id="sortForm" action="{{ route('boletins.index') }}" enctype="multipart/form-data" class="py-2"> @csrf
            <div id="option">
                <div class="row px-4 py-2">Ordenar por:
                    <span class="px-4"></span> <b>Nome:</b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="nomeAsc">
                        A-Z
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="nomeDesc">
                        Z-A
                    </div>
                    <span class="px-4"></span> <b>Data do documento: </b>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataAsc">
                        Antigos  <i class="fa fa-arrow-right" style="color:black" aria-hidden="true"></i>Novos
                    </div>
                    <div class="form-check form-check-inline px-2">
                        <input class="form-check-input" type="radio" name="option" id="option" value="dataDesc">
                        Novos <i class="fa fa-arrow-right" style="color:black" aria-hidden="true"></i> Antigos
                    </div>
                    @if(Session::get('admin'))
                        <span class="px-4"></span> <b>Data inserção no sistema: </b>
                        <div class="form-check form-check-inline px-2">
                            <input class="form-check-input" type="radio" name="option" id="option" value="dataCreatedAtAsc">
                            Crescente
                        </div>
                        <div class="form-check form-check-inline px-2">
                            <input class="form-check-input" type="radio" name="option" id="option" value="dataCreatedAtDesc">
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
