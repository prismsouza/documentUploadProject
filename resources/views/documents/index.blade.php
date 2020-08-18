@extends(($admin) ? 'layout_admin' : 'layout')

@include('searchbar')

@section('content')
    @if($category_option)
            <div class="border p-2">
                Categoria: <b>{{ $category_option }}</b>
            </div>
    @else
        @if ($admin)
        <a href="{{ route('documents.create') }}">
            <button class="btn btn-dark btn-outline-light border" type="submit">
               Novo Documento
            </button>
        </a><p></p>
        @endif
    @endif

    @if ($documents->isNotEmpty())
    <table class="table table-bordered bg-white table-striped" id="myTable">
        <thead class="text-center">
            <th scope="col" style="cursor: pointer; width: 3%">
                #
            </th>
            <th  scope="col" style="cursor: pointer; width: 22%">
                Nome <i class="fas fa-sort"></i>
            </th>
            <th scope="col" style="cursor: pointer; width: 33%">
                Descricao <i class="fas fa-sort"></i>
            </th>
            <th scope="col" style="cursor: pointer; width: 14%">
                Categoria <i class="fas fa-sort"></i>
            </th>
            <th scope="col" style="width: 10%; text-align: center">Data</th>

            @if ($admin)
                <th scope="col" style="width: 10%; text-align: center">
                    <i class="fas fa-file-download"></i>
                </th>
                <th scope="col" style="width: 8%; text-align: center" colspan="2">
                    <i class="far fa-eye-slash" data-toggle="tooltip" title="visível apenas para Perfil Administrador" style="color:black"></i>
                </th>
            @else
                <th scope="col" colspan="2" style="width: 10%; text-align: center">
                    <i class="fas fa-file-download"></i>
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
                    @if (isset($document->is_active))
                        <a data-toggle="tooltip" title="revogado">
                            <i class="far fa-times-circle" style="color: red"></i>
                        </a>
                    @endif
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
                    <a class="btn border" data-toggle="tooltip" title="visualizar"
                       href="{{ route('documents.viewfile', [$document->id, $file_pdf->id]) }}" target="_blank">
                        <i class="fas fa-eye fa-lg" style="color: black" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('documents.download', [$document->id , $file_pdf->hash_id]) }}"
                       data-toggle="tooltip" title="{{$file_pdf->size}}"
                       class="btn border">
                        <i class="fa fa-file-pdf fa-lg" style="color: black" aria-hidden="true"></i>
                    </a>

                </td>

            @if ($admin)
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
@endsection
