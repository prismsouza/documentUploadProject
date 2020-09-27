@extends('layout_admin')
@section('content')

    <a onclick="goBack()" class="btn btn-light border float-md-right">Voltar</a>

    <div id="content">
        Número de contatos: <b>{{ $contacts->total() }} </b>

        @if ($contacts->isNotEmpty())
            <div class="border p-2 text-center">
                <b>Contatos Recebidos</b>
            </div>

            <table class="table table-bordered bg-white table-striped">
                <tr class="text-center">
                    <th style="width: 8%; text-align: center">#</th>
                    <th style="width: 65%; text-align: center">Mensagem</th>
                    <th style="width: 10%; text-align: center">Usuário</th>
                    <th style="width: 17%; text-align: center">Data</th>
                </tr>

                <?php
                $c = 0;
                $page = $contacts->currentPage(); ?>

                @foreach($contacts as $contact)
                <?php
                    $count = ($page*20 - 19) + $c;
                    $c = $c + 1;
                ?>

                    <div class="px-2">
                        <tr class="">
                            <td>{{$count}}</td>
                            <td>{{ $contact->message }}</td>
                            <td>{{ $contact->user_masp }}</td>
                            <td>
                                <?php $date= date('d/m/Y - H:i:s', strtotime($contact->created_at)); ?>
                                {{ $date }}
                            </td>

                        </tr>
                    </div>
                @endforeach

        @else
            <p><h4>Não há resultados para esta pesquisa</h4></p>
        @endif

            </table>


        @if ($contacts->total()>0)
            {{ $contacts->links() }}
        @endif

    </div>
@endsection
