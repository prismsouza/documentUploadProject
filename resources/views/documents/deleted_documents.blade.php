@extends('layout_admin')

<?php $user = "admin_master"; // admin ?>

@section('content')
    <h3>Documentos Deletados</h3>
    @if ($documents->isNotEmpty())
        <table class="table table-bordered bg-white table-striped" id="myTable">
            <thead class="text-center">
            <th scope="col" style="width: 5%; text-align: center"> #</th>
            <th cope="col">
                Nome
            </th>
            <th scope="col" style="width: 25%">
                Descrição
            </th>
            <th scope="col" style="width: 15%">
                Categoria
            </th>
            <th scope="col" style="width: 10%; text-align: center">Data Publicação</th>
            <th scope="col" style="width: 10%; text-align: center">Excluído por</th>
            <th scope="col" style="width: 10%; text-align: center">Data Exclusão</th>

            </thead>
            <tbody>
            @endif

            <?php $c = 0;
            if(!$documents instanceof Illuminate\Support\Collection)
                $page = $documents->currentPage();
            ?>

            @forelse($documents as $document)
                <?php   if(!$documents instanceof Illuminate\Support\Collection)
                    $count = ($c + 1) + $page*10 - 10;
                else
                    $count = $c+1;
                $c = $c + 1; ?>
                <tr class="small">
                    <td class="text-center">{{$count}}</td>
                    <td>
                        {{ $document->name }}
                        @if ($document->is_active )
                            <a data-toggle="tooltip" title="vigente">
                                <i class="far fa-check-circle" style="color: green"></i>
                            </a>
                        @else
                            <a data-toggle="tooltip" title="revogado">
                                <i class="far fa-times-circle" style="color: red"></i>
                            </a>
                        @endif
                        <a href="{{ route('documents.index') }}"
                           class="float-md-right btn border" data-toggle="tooltip" title="restaurar documento">
                            <i class="fas fa-trash-restore"style="color: green"></i>
                        </a>
                    </td>
                    <td> {{ $document->description }}</td>
                    <td>
                        {{ $document->category->name }}
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y', strtotime($document->date)) }}
                    </td>
                    <td class="text-center">
                        {{ $document->user_masp }}
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y', strtotime($document->deleted_at)) }}
                    </td>
                </tr>

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
