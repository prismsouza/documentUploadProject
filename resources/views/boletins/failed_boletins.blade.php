@extends('layout_admin')

<?php $user = "admin_master"; // admin ?>

@section('content')
    <h3>BGBM, BEBM e Separata com Falha</h3>
    @if ($boletins->isNotEmpty())
        <table class="table table-bordered bg-white table-striped" id="myTable" >
            <thead class="text-center">
            <th scope="col" style="width: 5%; text-align: center"> #</th>
            <th cope="col" style="width: 26%; text-align: center">
                Nome
            </th>
            <th scope="col" style="width: 25%; text-align: center">
                Descrição
            </th>
            <th scope="col" style="width: 12%; text-align: center">
                Categoria
            </th>
            <th scope="col" style="width: 12%; text-align: center">Data Documento</th>
            <th scope="col" style="width: 16%; text-align: center">Data Criação</th>
            <th scope="col" style="text-align: center">Editar</th>

            </thead>
            <tbody>
            @endif

            <?php $c = 0;
            if(!$boletins instanceof Illuminate\Support\Collection)
                $page = $boletins->currentPage();
            ?>

            @forelse($boletins as $boletim)
                @if (count($boletim->files->where('alias')->all()) == 0)
                <?php
                if(!$boletins instanceof Illuminate\Support\Collection)
                    $count = ($c + 1) + $page*10 - 10;
                else
                    $count = $c+1;
                $c = $c + 1;
                ?>
                <tr class="small">
                    <td class="text-center">{{$count}}</td>
                    <td>
                        {{ $boletim->name }}
                    </td>
                    <td> {{ $boletim->description }}</td>
                    <td style="text-align: center">
                        {{ $boletim->category->name }}
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y', strtotime($boletim->date)) }}
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y - h:m:s', strtotime($boletim->created_at)) }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('boletins.edit', $boletim->id) }}"
                           class="btn btn-info">
                            <i class="fas fa-edit" style="color: black"></i>
                        </a>
                    </td>
                </tr>
                @endif
            @empty
                <p><h5>Nao ha resultados para esta pesquisa</h5></p>
            @endforelse

            </tbody>
        </table>
        @if(!$boletins instanceof Illuminate\Support\Collection)
            @if ($boletins->total()>0)
                {{ $boletins->links() }}
            @endif
        @endif
@endsection
