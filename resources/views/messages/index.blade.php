@extends('layout_admin')

@include('searchmessagebar')
@section('content')
    
<div id="content">
    <div class=" border p-2 text-center">
        <b>Mensagens Recebidas</b>
    </div>

    <table class="border table table-bordered table-striped">
        <tr >
            <th>#</th>
            <th>Documento</th>
            <th>Mensagem</th>
            <th class="text-center">Data</th>
            <th>Verificada</th>
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
                <td class="text-center">
                    <?php $date= date('d/m/Y', strtotime($message->created_at)); ?>
                    {{ $date }}
                </td>
                <td class="text-center">

                    <a href="{{ route('messages.update', $message->id) }}" id="a_click" onclick="myFunction()">
                    <?php echo ($message->is_checked) ?
                        "<i class='far fa-check-circle' style='color: green'></i>"
                        : "<i class='far fa-times-circle' style='color: red'></i>" ?>
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
<script>
    function myFunction() {
        document.getElementById("a_click").innerHTML = alert("Status atualizado");
    }
</script>

</div>
@endsection
