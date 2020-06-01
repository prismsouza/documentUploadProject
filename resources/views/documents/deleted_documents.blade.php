@extends('layout_admin')

<?php $user = "admin_master"; // admin ?>

@section('content')
    <h3>Documentos Deletados</h3>
    @if ($documents->isNotEmpty())
        <table class="table table-bordered bg-white table-striped" id="myTable">
            <thead class="text-center">
            <th onclick="sortTable(1)" scope="col" style="cursor: pointer;">
                #
            </th>
            <th onclick="sortTable(2)" scope="col" style="cursor: pointer;">
                Nome <i class="fas fa-sort"></i>
            </th>
            <th onclick="sortTable(2)" scope="col" style="cursor: pointer; width: 25%">
                Descricao <i class="fas fa-sort"></i>
            </th>
            <th onclick="sortTable(3)" scope="col" style="cursor: pointer;width: 15%">
                Categoria <i class="fas fa-sort"></i>
            </th>
            <th scope="col" style="width: 8%; text-align: center">Data Publicação</th>
            <th scope="col" style="width: 8%; text-align: center">Excluído por</th>
            <th scope="col" style="width: 8%; text-align: center">Data Exclusão</th>

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
                        {{ $document->user->masp }}
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


        <script>
            function sortTable(n) {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("myTable");
                switching = true;
                //Set the sorting direction to ascending:
                dir = "asc";
                while (switching) {
                    switching = false;
                    rows = table.rows;
                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];

                        if (dir == "asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch= true;
                                break;
                            }
                        } else if (dir == "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    if (shouldSwitch) {
                        /*If a switch has been marked, make the switch
                        and mark that a switch has been done:*/
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        //Each time a switch is done, increase this count by 1:
                        switchcount ++;
                    } else {
                        /*If no switching has been done AND the direction is "asc",
                        set the direction to "desc" and run the while loop again.*/
                        if (switchcount == 0 && dir == "asc") {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }
            }
        </script>
@endsection
