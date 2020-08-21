@extends('layout_admin')

@include('searchmessagebar')
@section('content')

<div id="content">
    @if ($messages->isNotEmpty())
    <div class=" border p-2 text-center">
        <b>Mensagens Recebidas</b>
    </div>

    <table class="border table table-bordered table-striped">
        <tr>
            <th  style="width: 4%" >#</th>
            <th>Documento</th>
            <th style="width: 50%" >Mensagem</th>
            <th style="width: 10%" >Data</th>
            <th style="width: 5%">Verificada</th>
        </tr>

        <?php $c = 0;
        if(!$messages instanceof Illuminate\Support\Collection)
            $page = $messages->currentPage();
        ?>

    @foreach($messages as $message)
            <?php
            if(!$messages instanceof Illuminate\Support\Collection)
                $count = ($c + 1) + $page*10 - 10;
            else
                $count = $c+1;
            $c = $c + 1; ?>
        <div class="px-2">
            <tr class="">
                <td>{{$count}}</td>
                <td>
                    <a href='/documentos/{{ $message->document_id }}' target="_blank">
                        {{ $message->document->name }}
                    </a>
                </td>
                <td>{{ $message->message }}</td>
                <td>
                    <?php $date= date('d/m/Y', strtotime($message->created_at)); ?>
                    {{ $date }}
                </td>
                <td class="text-center">
                    <a href="{{ route('messages.update', $message->id) }}" id="a_click"
                       class="btn border" onclick="myFunction()">
                    <?php echo ($message->is_checked) ?
                        "<i class='far fa-check-circle' style='color: green' data-toggle='tooltip' title='desmarcar'></i>"
                        : "<i class='far fa-times-circle' style='color: red' data-toggle='tooltip' title='marcar como verificado'></i> "  ?>
                    </a>
                </td>
            </tr>
         </div>
    @endforeach
    </table>
    @if(!$messages instanceof Illuminate\Support\Collection)
        @if ($messages->total()>0)
            {{ $messages->links() }}
        @endif
    @endif
    @else
    <p><h4>Não há resultados para esta pesquisa</h4></p>
    @endif

<script>
    function myFunction() {
        document.getElementById("a_click").innerHTML = alert("Status atualizado");
    }
</script>
</div>
@endsection
