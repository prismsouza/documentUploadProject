@extends('layout_admin')

@include('searchmessagebar')
@section('content')

<a onclick="goBack()" class="btn btn-light border float-md-right">Voltar</a>

<div id="content">

    @if ($messages->isNotEmpty())
        Número de mensagens: <b>{{ $messages->total() }} </b>

        <div class="border p-2 text-center">
        <b>Mensagens Recebidas</b>
    </div>

    <table class="table table-bordered table-striped">
        <tr>
            <th style="width: 4%" >#</th>
            <th>Documento</th>
            <th style="width: 10%">Categoria</th>
            <th style="width: 40%" >Mensagem</th>
            <th style="width: 10%" >Data</th>
            <th style="width: 5%">Verificada</th>
        </tr>
    @endif
    <?php
        use App\Category;$c = 0;
        $page = $messages->currentPage();
    ?>

    @forelse($messages as $message)
            <?php
                $count = ($page*20 - 19) + $c;
                $c = $c + 1;
            ?>
        <div class="px-2">
            <tr class="">
                <td>{{$count}}</td>
                <td>
                    <a href='{{route('documents.show', $message->document_id) }}' target="_blank">
                        {{ $message->document->name }}
                    </a>
                </td>
                <td>
                    <?php $category_name = Category::where('id', $message->document->category_id )->first()->name; ?>
                    <a href='{{ route('documents_category.index', $category_name) }}' target="_blank">
                        {{ $category_name }}
                    </a>
                </td>
                <td>{{ $message->message }}</td>
                <td>
                    <?php $date= date('d/m/Y', strtotime($message->created_at)); ?>
                    {{ $date }}
                </td>
                <td class="text-center">
                    <a class="btn-sm border btn-outline-secondary" href="{{ route('messages.update', $message->id) }}" id="a_click"
                       onclick="myFunction()">
                    <?php echo ($message->is_checked) ?
                        "<i class='far fa-check-circle' style='color: green' data-toggle='tooltip' title='desmarcar'></i>"
                        : "<i class='far fa-times-circle' style='color: red' data-toggle='tooltip' title='marcar como verificado'></i> "  ?>
                    </a>
                </td>
            </tr>
         </div>

        @empty
            <br><p><h4>Não há resultados para esta pesquisa</h4></p>
    @endforelse
    </table>
        @if ($messages->total()>0)
            {{ $messages->links() }}
        @endif

<script>
    function myFunction() {
        document.getElementById("a_click").innerHTML = alert("Status atualizado");
    }
</script>
</div>
@endsection
