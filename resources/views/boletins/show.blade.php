@extends ('layout')

<?php $user_id = 1; // admin ?>

@section ('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

<style>p {font-size: 110%;}</style>
<div class="border p-5">
    <div class="border-bottom border-top py-4">
        <div class="row">
            <div class="col">
                <p><b>Categoria: </b>
                <a href="categorias/{{$boletim->category->name}}" >
                    {{ $boletim->category->name }}
                </a>
                </p>
                <div class="title">
                    <h1>{{ $boletim->name }}</h1>
                </div>
                <h4>{{ $boletim->description }}</h4><br>
            </div>

            <div class="col-4">
                <div class="float-right">
                    <label class="px-2"> Download </label> <label class="px-4"> Visualizar</label><br>
                    <a class="btn border" data-toggle="tooltip" title="download {{ $pdf_file->alias }}"
                       href="{{ route('boletins.download', [$boletim->id , $pdf_file->hash_id]) }}">
                        <i class="fas fa-download fa-4x" style="color:darkseagreen"></i>
                    </a>
                    <a class="btn border" data-toggle="tooltip" title="visualizar {{ $pdf_file->alias }}"
                       href="{{ route('boletins.viewfile', [$boletim->id, $pdf_file->id]) }}" target="_blank">
                        <i class="fas fa-eye fa-4x" style="color:cadetblue"></i>
                    </a>
                </div>
            </div>
        </div><br>
        <p><b>Publicado em </b>
            <span class="border p-3">
                {{ date('d/m/Y', strtotime($boletim->date)) }}
            </span>
        </p><br>

        @if (!empty($files))
            <p><b>Anexos:</b></p>
            <ul>
                @foreach ($files as $file)
                    <li class="px-2 py-1">
                        {{ $file->name }} <span class="px-2"></span>
                        <a  data-toggle="tooltip" title="download {{ $file->name }}"
                            href="{{ route('boletins.download', [$boletim->id , $file->hash_id]) }}"
                            class="btn btn-light" >
                            <i class="fas fa-download" style="color:darkseagreen"></i>
                        </a>
                        @if ($file->type == "application/pdf")
                        <a  data-toggle="tooltip" title="visualizar {{ $file->name }}"
                            href="{{ route('boletins.viewfile', [$boletim->id , $file->id]) }}" target="_blank"
                            class="btn btn-light">
                            <i class="fas fa-eye" style="color:cadetblue"></i>
                        </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
</div>
</div>


    @if ($user_id == 0)
        @include('documents/message_report')
    @else
        <br>
        <button type="button" class="btn btn-info">
                <a href="{{ route('boletins.edit', $boletim->id) }}" style="color:white">
                    Editar Documento  <i class="fas fa-edit" style="color: black"></i>
                </a>
        </button>

        <form method="POST" id="delete-form-{{ $boletim->id }}"
              action="{{ route('boletins.destroy', $boletim) }}"
              style="display: none;">
            {{ csrf_field() }}
            {{ method_field('delete') }}
        </form>
        <button type="button" class="btn btn-danger">
            <a onclick="if (confirm('Tem certeza que deseja DELETAR esse documento?')){
                event.preventDefault();
                document.getElementById('delete-form-{{ $boletim->id }}').submit();
                } else {
                event.preventDefault();
                }"
               href=" {{ route ('boletins.index') }}" style="color:white">
               Excluir documento <i class="far fa-trash-alt" style="color:black" aria-hidden="true"></i>
            </a>
        </button>
    @endif
@endsection
