@extends(($admin) ? 'layout_admin' : 'layout')

@include('searchbar')

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

        @if($admin)
            <a href="{{ route('boletins.create') }}">
                <button class="btn btn-dark border btn-outline-light" type="submit">
                    Novo BGBM / BEBM
                </button>
            </a><p></p>
        @endif

        @if($category_option)
            <div class="border p-2">
                Categoria: <b>{{ $category_option }}</b>
            </div>
        @endif

    @if ($boletins->isNotEmpty())
    <table class="table table-bordered bg-white table-striped" id="myTable">
        <thead class="text-center">
            <th scope="col" style="cursor: pointer; width: 3%">
                #
            </th>
            <th  scope="col" style="cursor: pointer; width: 22%">
                Nome <i class="fas fa-sort"></i>
            </th>
            <th style="cursor: pointer; width: 33%">
                Descricao <i class="fas fa-sort"></i>
            </th>
            <th scope="col" style="cursor: pointer; width: 14%">
                Categoria <i class="fas fa-sort"></i>
            </th>
            <th scope="col" style="width: 10%; text-align: center">Data</th>
            <th scope="col" style="width: 5%; text-align: center">
                <i class="fas fa-file-download"></i>
            </th>
            @if ($admin)
                <th scope="col" style="width: 10%; text-align: center" colspan="2">
                    <i class="far fa-eye-slash" data-toggle="tooltip" title="visível apenas para Perfil Administrador" style="color:black"></i>
                </th>
            @endif
        </thead>
        <tbody>
    @endif

    <?php $c = 0;
    if(!$boletins instanceof Illuminate\Support\Collection)
        $page = $boletins->currentPage();
    ?>

    @forelse($boletins as $boletim)

        <?php   if(!$boletins instanceof Illuminate\Support\Collection)
                    $count = ($c + 1) + $page*10 - 10;
                else
                    $count = $c+1;
            $c = $c + 1; ?>
        <tr class="small">
            <td class="text-center">{{$count}}</td>
            <td>
                <a href="{{ $boletim->path()  }}" data-toggle="tooltip" title="acessar documento">
                    {{ $boletim->name }}
                </a>
            </td>
            <td> {{ $boletim->description }}</td>
            <td>
                <?php $category_name = $boletim->category->name; ?>
                <a href="{{ $boletim->category->path() }}"  data-toggle="tooltip" title="acessar documentos dessa categoria">
                    {{ $category_name }}
                </a>
            </td>
            <td class="text-center">
                {{ date('d/m/Y', strtotime($boletim->date)) }}
            </td>

            <?php $file_pdf = $boletim->files->whereNotNull('alias')->first();?>
                <td class="text-center px-0">
                    <a href="{{ route('boletins.download', [$boletim->id , $file_pdf->hash_id]) }}"
                       data-toggle="tooltip" title="{{$file_pdf->size}}"
                       class="btn border">
                        <i class="fa fa-file-pdf fa-lg" style="color: black" aria-hidden="true"></i>
                    </a>
                </td>

            @if ($admin)
                <div id="admin_view">
                <td class="text-center px-0">
                        <a href="{{ route('boletins.edit', $boletim->id) }}"
                           class="btn btn-info">
                            <i class="fas fa-edit" style="color: black"></i>
                        </a>
                </td>
                <td class="text-center px-0">
                    <form method="POST" id="delete-form-{{ $boletim->id }}"
                          action="{{ route('boletins.destroy', $boletim) }}"
                          style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                    </form>
                        <a onclick="if (confirm('Tem certeza que deseja DELETAR esse documento?')){
                            event.preventDefault();
                            document.getElementById('delete-form-{{ $boletim->id }}').submit();
                            } else {
                            event.preventDefault();
                            }"
                            href=" {{ route ('boletins.index') }}"
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
    @if(!$boletins instanceof Illuminate\Support\Collection)
        @if ($boletins->total()>0)
            {{ $boletins->links() }}
        @endif
    @endif

@endsection
