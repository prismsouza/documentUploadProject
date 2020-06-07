<?php $user = "notadmin"; // admin ?>
@extends('layout')
@include('searchbar')

@section('content')
    @if($category_option)
        @if($category_option == "Boletim Geral" && $user == "admin")
            <a href="{{ route('documents.create_boletim') }}">
                <button class="btn btn-dark btn-outline-light" type="submit">
                    Novo Boletim Geral
                </button>
            </a><p></p>

        @else
            <div class="border p-2">
                Categoria: <b>{{ $category_option }}</b>
            </div>
        @endif
    @else
        @if ($user == "admin")
            <a href="{{ route('documents.create') }}">
                <button class="btn btn-dark btn-outline-light" type="submit">
                    Novo Documento
                </button>
            </a><p></p>
        @endif
    @endif

    @if ($documents->isNotEmpty())
        <table class="table table-bordered bg-white table-striped" id="myTable">
            <thead class="text-center">
            <th onclick="sortTable(1)" scope="col" style="cursor: pointer; width: 3%">
                #
            </th>
            <th onclick="sortTable(2)" scope="col" style="cursor: pointer; width: 22%">
                Nome <i class="fas fa-sort"></i>
            </th>
            <th onclick="sortTable(2)" scope="col" style="cursor: pointer; width: 33%">
                Descricao <i class="fas fa-sort"></i>
            </th>
            <th onclick="sortTable(3)" scope="col" style="cursor: pointer; width: 14%">
                Categoria <i class="fas fa-sort"></i>
            </th>
            <th scope="col" style="width: 10%; text-align: center">Data</th>
            <th scope="col" style="width: 5%; text-align: center">
                <i class="fas fa-file-download"></i>
            </th>
            @if ($user == "admin")
                <th scope="col" style="width: 10%; text-align: center" colspan="2">
                    <i class="far fa-eye-slash" data-toggle="tooltip" title="visível apenas para Perfil Administrador" style="color:black"></i>
                </th>
            @endif
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
                        <a href="{{ $document->path()  }}" data-toggle="tooltip" title="acessar documento">
                            {{ $document->name }}
                        </a>
                        @if ($document->is_active )
                            <a data-toggle="tooltip" title="vigente">
                                <i class="far fa-check-circle" style="color: green"></i>
                            </a>
                        @else
                            <a data-toggle="tooltip" title="revogado">
                                <i class="far fa-times-circle" style="color: red"></i>
                            </a>
                        @endif
                    </td>
                    <td> {{ $document->description }}</td>
                    <td>
                        <?php $category_name = $document->category->name; ?>
                        <a href="{{ $document->category->path() }}"  data-toggle="tooltip" title="acessar documentos dessa categoria">
                            {{ $category_name }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y', strtotime($document->date)) }}
                    </td>

                    <?php $file_pdf = $document->files->whereNotNull('alias')->first();?>
                    <td class="text-center px-0">
                        <a href="{{ route('documents.download', [$document->id , $file_pdf->hash_id]) }}"
                           data-toggle="tooltip" title="{{$file_pdf->size}}"
                           class="btn border">
                            <i class="fa fa-file-pdf fa-lg" style="color: black" aria-hidden="true"></i>
                        </a>
                    </td>

                    @if ($user == "admin")
                        <div id="admin_view">
                            <td class="text-center px-0">
                                <a href="{{ route('documents.edit', $document->id) }}"
                                   class="btn btn-info">
                                    <i class="fas fa-edit" style="color: black"></i>
                                </a>
                            </td>
                            <td class="text-center px-0">
                                <form method="POST" id="delete-form-{{ $document->id }}"
                                      action="{{ route('documents.destroy', $document) }}"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                </form>
                                <a onclick="if (confirm('Tem certeza que deseja DELETAR esse documento?')){
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $document->id }}').submit();
                                    } else {
                                    event.preventDefault();
                                    }"
                                   href=" {{ route ('documents.index') }}"
                                   class="btn btn-danger btn-outline-secondary">
                                    <i class="far fa-trash-alt" style="color: black" aria-hidden="true"></i>
                                </a>
                            </td>
                        </div>
                    @endif
                </tr>

            @empty
                <p><h4>Não há resultados para esta pesquisa</h4></p>
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
