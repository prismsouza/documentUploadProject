@extends('layout_admin')
@section('content')

<div id="content">

    <a href="{{ route('categories.create') }}">
        <button class="btn btn-dark btn-outline-light" type="submit">
            Nova Categoria
        </button>
    </a><p></p>

    <table class=" py-10" width="100%">
@foreach($categories->chunk(3) as $chunked_category)
            <tr class="d-flex">
        @foreach( $chunked_category as $category )
                    <td class="col-sm-4 border py-2">
    <div class="title">
        <h5>
            <a href="{{ $category->path()  }}">

                {{ $category->name }}
                <div class="btn-group float-md-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info float-md-right btn-outline-secondary btn-sm">
                    <a href="{{ route('categories.edit', $category->name) }}" style="color:white">
                            <i class="fas fa-edit"></i>
                        </a>
                    </button>
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
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </button>
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
    </table>
</div>
@endsection
