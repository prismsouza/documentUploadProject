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
            <th scope="col" style="width: 33%">Descricao</th>
            <th scope="col" style="width: 14%">Categoria</th>
            <th scope="col" style="width: 9%">Data</th>
            <th scope="col" style="width: 16%" colspan="3">Download</th>
        </tr>
        </thead>
        <tbody>
    @endif

    <?php $count = 0; ?>
    @forelse($documents as $document)
        <?php $count += 1; ?>
        <tr class="small">
            <td class="text-center">{{$count}}</td>
            <td><a href="{{ $document->path()  }}" data-toggle="tooltip" title="acessar documento">
                    {{ $document->name }} </a>
            </td>
            <td> {{ $document->description }}</td>
            <td><a href="{{ $document->category->path() }}"  data-toggle="tooltip" title="acessar documentos dessa categoria">
                    {{ $document->category->name }}</a>
            </td>
            <td class="text-center">{{ $document->date }}</td>
            <?php $file = $document->files->where('extension','pdf')->first(); ?>
            <td class="text-center ">{{ $file['size'] }}</td>
            <td style="width: 2%">
                <a href="{{ route('documents.download', [$document->id , "doc"]) }}" data-toggle="tooltip" title="download em formato word">
                    <i class="fa fa-file-word" aria-hidden="true"></i>
                </a>
            </td>
                <td style="width: 2%">
                    <a href="{{ route('documents.download', [$document->id , "pdf"]) }}"  data-toggle="tooltip" title="download em formato pdf">
                    <i class="fa fa-file-pdf" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    @empty
        <p><h5>Nao ha resultados para esta pesquisa</h5></p>
    @endforelse

        </tbody>
    </table>

@endsection
