@extends('layout_admin')

@include('searchmessagebar')
@section('content')

    <a onclick="goBack()" class="btn btn-light border float-md-right">Voltar</a>

    <div id="content">
        @if ($contacts->isNotEmpty())
            <div class=" border p-2 text-center">
                <b>Contatos Recebidos</b>
            </div>

            <table class="border table table-bordered table-striped">
                <tr>
                    <th  style="width: 5%" >#</th>
                    <th style="width: 75%" >Mensagem</th>
                    <th style="width: 20%" >Data</th>
                </tr>

                @foreach($contacts as $contact)
                    <div class="px-2">
                        <tr class="">
                            <td> </td>
                            <td>{{ $contact->message }}</td>
                            <td>
                                <?php $date= date('d/m/Y', strtotime($contact->created_at)); ?>
                                {{ $date }}
                            </td>

                        </tr>
                    </div>
                @endforeach
            </table>
        @else
            <p><h4>Não há resultados para esta pesquisa</h4></p>
        @endif
    </div>
@endsection
