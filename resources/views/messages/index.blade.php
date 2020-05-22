@extends('layout_admin')
@section('content')

<div id="content">
    <div class=" border p-2 text-center">
        <b>Mensagens Recebidas</b>
    </div>

    <table class="border table table-bordered table-striped">
        <tr>
            <th>#</th>
            <th class="col-sm-3">Documento</th>
            <th>Mensagem</th>
            <th class="col-sm-1 text-center">Data</th>
            <th>Verificada</th>
        </tr>
    <?php $c = 0;$page = $messages->currentPage(); ?>
    @foreach($messages as $message)
        <?php $count = ($c + 1) + $page*10 - 10;
            $c = $c + 1;?>
        <div class="px-2">
            <tr>
                <td>{{$count}}</td>
                <td>
                    <a href='/documentos/{{ $message->document_id }}' target="_blank">
                        {{ $message->document->name }}
                    </a>
                </td>
                <td>{{ $message->message }}</td>
                <td class="text-center">
                    <?php $date= date('d-m-Y', strtotime($message->created_at)); ?>
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
            <?php $count = $count + 1; ?>
    @endforeach

    </table>
    {{ $messages->links() }}
<script>
    function myFunction() {
        document.getElementById("a_click").innerHTML = alert("Status atualizado");
    }
</script>

</div>
@endsection
