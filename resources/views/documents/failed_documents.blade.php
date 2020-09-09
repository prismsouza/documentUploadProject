@extends('layout_admin')

<?php $user = "admin_master"; // admin ?>

@section('content')
    <h3>Documentos com Falha</h3>
    @if ($documents->isNotEmpty())
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
            if(!$documents instanceof Illuminate\Support\Collection)
                $page = $documents->currentPage();
            ?>

            @forelse($documents as $document)
                @if (count($document->files->where('alias')->all()) == 0)
                <?php
                if(!$documents instanceof Illuminate\Support\Collection)
                    $count = ($c + 1) + $page*10 - 10;
                else
                    $count = $c+1;
                $c = $c + 1;
                ?>
                <tr class="small">
                    <td class="text-center">{{$count}}</td>
                    <td>
                        {{ $document->name }}
                    </td>
                    <td> {{ $document->description }}</td>
                    <td style="text-align: center">
                        {{ $document->category->name }}
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y', strtotime($document->date)) }}
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y - h:m:s', strtotime($document->created_at)) }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('documents.edit', $document->id) }}"
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
        @if(!$documents instanceof Illuminate\Support\Collection)
            @if ($documents->total()>0)
                {{ $documents->links() }}
            @endif
        @endif
@endsection
