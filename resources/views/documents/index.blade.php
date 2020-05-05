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
        <thead class="black white-text">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Descricao</th>
            <th scope="col">Categoria</th>
            <th scope="col">Data</th>
            <th scope="col">Tamanho</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
    @endif

    <?php $count = 0; ?>
    @forelse($documents as $document)
        <?php $count += 1; ?>
        <tr>
            <td>{{$count}}</td>
            <td><a href="{{ $document->path()  }}">{{ $document->name }}</a></td>
            <td>{{ $document->description }}</td>
            <td><a href="{{ $document->category->path()  }}">{{ $document->category->name }}</td>
            <td>{{ $document->date }}</td>
            <td>{{ $document->size }}</td>
            <td><a href="{{ route('documents.download', $document->id) }}">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a></td>
        </tr>
    @empty
        <p><h5>Nao ha resultados para esta pesquisa</h5></p>
    @endforelse

        </tbody>
    </table>

@endsection
