@extends('trash.version2.search.searchview')
@section('index_content')

<?php $user = "notadmin"; // admin ?>

    @if ($documents->isNotEmpty())
    <table class="table table-bordered bg-white" id="myTable">
        <span style="font-size: 18px" class="py-4">Mostrando de <b>1</b> a <b>{{ count($documents) }}</b> de <b>{{ $total }}</b> resultados</span>
        <p></p>
            <tr>
                <td colspan="3"><i class="fas fa-print float-md-right"></i></td>
            </tr>

        @forelse($documents as $document)
            <tr>
                <td>
                    <b style="color: darkred; font-size: 20px"><a href="" data-toggle="tooltip" title="acessar documento">
                            {{ $document->name }},
                            {{  strftime('%d de %B de %Y', strtotime($document->date)) }}
                        </a></b><br>
                    <span style="color: dimgrey; font-size: 16px">{{ $document->description }}</span>
                </td>
                <td class="col-2">
                    <i class="far fa-file-alt"></i>
                    <a href="{{ route('documents.download', [$document->id , "pdf"]) }}" data-toggle="tooltip" title="download word">
                        Texto Original
                    </a>
                </td>
                <td class="col-2">
                    <i class="fas fa-file-alt"></i>
                    <a href="{{ route('documents.download', [$document->id , "pdf"]) }}" data-toggle="tooltip" title="download word">
                        Texto Atualizado
                    </a>
                </td>
            </tr>

        @empty
            <p><h5>Nao ha resultados para esta pesquisa</h5></p>
        @endforelse
        </table>
    @else
        <p>No results</p>
    @endif

<style>
rvidor nao    .pagination a:hover:not(.active) {background-color: darkred; color: white}
    .pagination span:hover:not(.active) {background-color: white; color: black}
</style>

    @if(!$documents instanceof Illuminate\Support\Collection)
        @if ($documents->total()>0)
            {{ $documents->links() }}</spam>
        @endif
    @endif



@endsection


