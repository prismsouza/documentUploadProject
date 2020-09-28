@extends('layout_admin')

@section('content')
    <a onclick="goBack()" class="btn btn-light border float-md-right">Voltar</a>
    <h3>Logs</h3>
    @if ($logs->isNotEmpty())
        <table class="table table-bordered bg-white table-striped" id="myTable">
            <thead class="text-center">
            <th scope="col" style="width: 5%; text-align: center"> #</th>
            <th scope="col" style="width: 12%; text-align: center"> Usuário</th>
            <th scope="col" style="width: 10%; text-align: center"> ID Boletim/Separata</th>
            <th scope="col" style="width: 37%; text-align: center"> Nome Documento</th>
            <th scope="col" style="width: 10%; text-align: center"> Ação</th>
            <th scope="col" style="width: 18%; text-align: center"> Data</th>

            </thead>
            <tbody>
            @endif

            <?php $c = 0; $page = $logs->currentPage(); ?>

            @forelse($logs as $log)
                <?php
                $count = ($page*20 - 19) + $c;
                $c = $c + 1;
                ?>
                <tr class="small">
                    <td class="text-center">{{$count}}</td>
                    <td class="text-center">
                        {{ $log->user_masp }}
                    </td>
                    <td class="text-center">
                        @if (App\Boletim::where('id', $log->boletim_id)->first() != null)
                            <a href="{{ route ('boletins.show', [ $log->boletim_id ]) }}">
                                {{ $log->boletim_id }}
                            </a>
                        @else
                            <span style="color: darkred"> {{ $log->boletim_id }} </span>
                        @endif

                    </td>
                    <td class="text-center">
                        @if (App\Boletim::where('id', $log->boletim_id)->first() != null)
                            {{ App\Boletim::where('id', $log->boletim_id)->first()->name }}
                        @else
                            {{ App\Boletim::onlyTrashed()->where('id', $log->boletim_id)->first()->name }}
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
                        {{ date('d/m/Y - H:i:s', strtotime($log->created_at)) }}
                    </td>
                </tr>

            @empty
                <p><h5>Nao ha resultados para esta pesquisa</h5></p>
            @endforelse

            </tbody>
        </table>
        @if ($logs->total()>0)
            {{ $logs->links() }}
        @endif
@endsection

173 168
conf
