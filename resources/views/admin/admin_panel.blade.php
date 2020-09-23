@extends ('layout_admin')
<?php $categories = App\Category::all();?>

@section ('content')
    <a href="{{ route('documents.index') }}">
        <button class="btn btn-light btn-outline-dark float-md-right" type="submit">
            Voltar
        </button>
    </a><p class="py-4"></p>

    <div id="wrapper">
        <div class="row">
            <div class="col-7">
                <h2 style="display: inline-block;">Administradores</h2>
                @include('admin.admins_create')

                <table class="table table-striped" id="table_admin">
                    <thead>
                        <tr>
                            <th style="text-align: center">MASP</th>
                            <th style="text-align: center">Unidade (quando inserido como admin)</th>
                            <th style="text-align: center">Unidade Atual</th>
                            <th style="text-align: center; width: 20%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        @if ($user->admin == -1) @continue @endif
                        <tr>
                            <td>{{$user->masp}}</td>
                            <td>{{$user->unit_oncreate}}</td>
                            <td>{{$user->unit_current}}</td>
                            <td>
                                <span class="btn-group">
                                    <a class="add btn btn-success" title="Salvar" id="create" name="create" data-toggle="tooltip"
                                       href=" {{ route ('admins.create') }}" type="submit">
                                        <i class="fas fa-save" style="color: black"></i>

                                    </a>
                                    <a class="cancel btn btn-default" title="Cancelar" name="cancel" data-toggle="tooltip"
                                       style="display: none">
                                        <i class="fa fa-window-close" style="color: black;"></i>
                                    </a>

                                </span>

                                <form class="btn-group" method="POST" action="{{ route('admins.destroy', $user) }}" id="delete-form-{{ $user->id }}">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                </form>

                                <a type="submit" class="delete btn btn-danger" title="Deletar" id="destroy" name="destroy" data-toggle="tooltip"
                                           onclick="if (confirm('Tem certeza que deseja DELETAR esse usuário?')){
                                            event.preventDefault();
                                            document.getElementById('delete-form-{{ $user->id }}').submit();
                                            } else {
                                            event.preventDefault();
                                            }"
                                           href=" {{ route ('admins.index') }}" style="color:white">
                                    <i class="far fa-trash-alt" style="color: black" aria-hidden="true" data-toggle="tooltip" title="excluir"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <script>
                $(document).ready(function(){
                    $(document).on("click", ".delete", function(){
                        $(this).parents("tr").remove();
                        $(".add-new").removeAttr("disabled");
                    });
                });
            </script>

            <div class="menu col-1"></div>

            <div class="menu col-4 text-center light lighten-1">
                <ul class="nav nav-tabs flex-column lighten-4 list-group">
                    <li style="text-align: center">
                        <h2>Acesso Rápido</h2>
                    </li>
                    <span class="py-2"></span>
                    <li class="nav-item border">
                        <a class="btn btn-link" href="{{route('documents.index')}}">
                            Listar documentos
                        </a>
                    </li>
                    <li class="nav-item border">
                        <a class="btn btn-link" href="{{route('documents.failed_documents')}}" target="_blank">
                            Listar documentos com falha no PDF
                        </a>
                    </li>
                    <li class="nav-item border">
                        <a class="btn btn-link" href="{{route('boletins.failed_boletins')}}" target="_blank">
                            Listar boletins com falha no PDF
                        </a>
                    </li>
                    <li class="nav-item border">
                        <a class="btn btn-link" href="{{route('documents.deleted_documents')}}" target="_blank">
                            Listar documentos deletados
                        </a>
                    </li>
                    <li class="nav-item border">
                        <a class="btn btn-link" href="{{route('documents.logs')}}" target="_blank">
                            Ver logs de documentos
                        </a>
                    </li>
                    <li class="nav-item border">
                        <a class="btn btn-link" href="{{route('boletins.logs')}}" target="_blank">
                            Ver logs de boletins/separatas
                        </a>
                    </li>
                    <li class="nav-item border">
                        <a class="btn btn-link" href="{{route('boletins.index')}}" target="_blank">
                            Listar todos boletins e separatas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


@endsection
