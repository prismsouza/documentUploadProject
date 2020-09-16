@extends('layout_admin')

<?php $user = "admin_master"; // admin
        $documents = App\Document::all(); ?>

@section('content')
    <a onclick="goBack()" class="btn btn-light border float-md-right">Voltar</a>
    <h3>Logs</h3>
    @if ($logs->isNotEmpty())
        <table class="table table-bordered bg-white table-striped" id="myTable">
            <thead class="text-center">
            <th scope="col" style="width: 5%; text-align: center"> #</th>
            <th scope="col" style="width: 8%; text-align: center"> ID Log</th>
            <th scope="col" style="width: 12%; text-align: center"> Usuário</th>
            <th scope="col" style="width: 15%; text-align: center"> ID Documento</th>
            <th scope="col" style="width: 32%; text-align: center"> Documento</th>
            <th scope="col" style="width: 10%; text-align: center"> Ação</th>
            <th scope="col" style="width: 18%; text-align: center"> Data</th>

            </thead>
            <tbody>
            @endif

            <?php $c = 0;
            if(!$logs instanceof Illuminate\Support\Collection)
                $page = $logs>currentPage();
            ?>

            @forelse($logs as $log)
                <?php   if(!$logs instanceof Illuminate\Support\Collection)
                    $count = ($c + 1) + $page*10 - 10;
                else
                    $count = $c+1;
                $c = $c + 1; ?>
                <tr class="small">
                    <td class="text-center">{{$count}}</td>
                    <td class="text-center">{{ $log->id }}</td>
                    <td class="text-center">
                        {{ $log->user_masp }}
                    </td>
                    <td class="text-center">
                        @if ($documents->where('id', $log->document_id)->first() != null)
                            <a href="{{ route ('documents.show', [ $log->document_id ]) }}">
                                {{ $log->document_id }}
                            </a>
                        @else
                            <span style="color: darkred"> {{ $log->document_id }} </span>
                        @endif

                    </td>
                    <td class="text-center">
                        @if ($documents->where('id', $log->document_id)->first() != null)
                            {{ $documents->where('id', $log->document_id)->first()->name }}
                        @else
                            {{ App\Document::onlyTrashed()->where('id', $log->document_id)->first()->name }}
                         @endif
                     </td>
                     <td class="text-center">
                         @if ($log->action == "delete")
                             <span style="color: darkred"> {{ $log->action }} </span>
                         @else
                            {{ $log->action }}
                         @endif
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y - h:m:s', strtotime($log->created_at)) }}
                    </td>
                </tr>

            @empty
                <p><h5>Nao ha resultados para esta pesquisa</h5></p>
            @endforelse

            </tbody>
        </table>
        @if(!$logs instanceof Illuminate\Support\Collection)
            @if ($logs->total()>0)
                {{ $logs->links() }}
            @endif
        @endif
@endsection
