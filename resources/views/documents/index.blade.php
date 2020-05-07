@extends('layout')

@section('content')
    @if($category_option)
        <h2>{{ $category_option }}</h2><br>
    @elseif(isset($details))
        <h2>Resultados</h2><br>
        <p> Os resultados para a consulta <b> {{ $query }} </b> sao :</p>
    @else
        <h2>Todos Documentos</h2><br>
    @endif

    @if($documents!='[]')
    <table class="table table-bordered bg-white table-striped">
        <thead class="text-center">
        <tr>
            <th scope="col" style="width: 3%">#</th>
            <th scope="col" style="width: 25%">Nome</th>
            <th scope="col" style="width: 35%">Descricao</th>
            <th scope="col" style="width: 16%">Categoria</th>
            <th scope="col" style="width: 9%">Data</th>
            <th scope="col" style="width: 12%" colspan="2">Download</th>
        </tr>
        </thead>
        <tbody>
    @endif

    <?php $count = 0; ?>
    @forelse($documents as $document)
        <?php $count += 1; ?>
        <tr class="small">
            <td class="text-center">{{$count}}</td>
            <td><a href="{{ $document->path()  }}">{{ $document->name }}</a></td>
            <td> {{ $document->description }}</td>
            <td><a href="{{ $document->category->path()  }}">{{ $document->category->name }}</td>
            <td class="text-center">{{ $document->date }}</td>
            <td class="text-center">{{ $document->size }}
            <a href="{{ route('documents.download', $document->id) }}">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    @empty
        <p><h5>Nao ha resultados para esta pesquisa</h5></p>
    @endforelse

        </tbody>
    </table>

@endsection
