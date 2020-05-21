@extends('layout')
@section('content')

<div id="content">

    <a href="{{ route('categories.create') }}">
        <button class="btn btn-light btn-outline-dark" type="submit">
            Criar Categoria
        </button>
    </a><p></p>

@foreach($categories as $category)
    <div class="title">
        <h3>
            <a href="{{ $category->path()  }}">

                {{ $category->name }}
                    <button type="button" class="btn btn-info float-md-right">
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
                    <button type="button" class="btn btn-danger float-md-right">
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
            </a>
        </h3>
     </div>
    <p>
        {{ $category->description }}
    </p>

@endforeach
</div>
@endsection
