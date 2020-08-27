@extends('layout_admin')
@section('content')

<div id="content">
    @include('categories.create')
    <p></p>

    <table width="100%">
        <tr class="d-flex py-4">
            <td class="col-sm-4 border py-2">
                <b>Ementário</b>
                <a href="{{ route('files.view')}}" class="btn border btn-light float-md-right"
                   data-toggle="tooltip" title="visualizar" style="color:white" target="_blank">
                    <i class="fas fa-eye" style="color:cadetblue"></i>
                </a>
                <a data-toggle="tooltip" title="download"
                   href="{{ route('files.download') }}" class="btn border btn-light float-md-right">
                    <i class="fas fa-download" style="color:darkseagreen" aria-hidden="true"></i>
                </a>
                <a data-toggle="tooltip" title="editar"
                   href="{{ route('categories.ementario_edit') }}" class="btn border btn-light float-md-right">
                    <i class="fas fa-edit small" style="color: black"></i>
                </a>

            </td>
        </tr>
    </table>

    <table width="100%">
    @foreach($categories->chunk(3) as $chunked_category)
        <tr class="d-flex">
        @foreach( $chunked_category as $category )

            <td class="col-sm-4 border py-2">
                <div class="title">
                    <h5>
                        <a href="{{ $category->path()  }}">
                            @if (count($category->hasparent)>0)
                                {{  $category->hasparent->first()->name }} /
                            @endif
                            {{ $category->name }}
                        </a>
                <div class="btn-group float-md-right" role="group" aria-label="Basic example">
                    <form method="POST" id="delete-form-{{ $category->id }}"
                          action="{{ route('categories.destroy', $category) }}"
                          style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                    </form>
                    <button type="button" class="btn btn-danger float-md-right btn-outline-secondary btn-sm">
                        <a onclick="if (confirm('Tem certeza que deseja DELETAR essa categoria?')){
                            event.preventDefault();
                            document.getElementById('delete-form-{{ $category->id }}').submit();
                            } else {
                            event.preventDefault();
                            }"
                           href=" {{ route ('categories.index') }}" style="color:white">
                            <i class="far fa-trash-alt" style="color: black" aria-hidden="true" data-toggle="tooltip" title="excluir"></i>
                        </a>
                    </button>
                    @include('categories.edit')

                </div>
            </a>
        </h5>
     </div>
    <p class="small">
        {{ $category->description }}
    </p>
            </td>
        @endforeach
        </tr>
@endforeach
    </table><br>

</div>
@endsection
