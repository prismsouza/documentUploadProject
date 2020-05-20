@extends('layout')
@section('content')

<div id="content">
    <a href="{{ route('tags.create') }}">
        <button class="btn btn-light btn-outline-dark" type="submit">
            Criar Tag
        </button>
    </a><p></p>

    <table>
    @foreach($tags->chunk(2) as $chunked_tag)
        <tr>
        @foreach( $chunked_tag as $tag )
            <td class="col-sm-4">
            <div class="px-2">
                <a href='/documentos?tag={{ $tag->name }}'>
                    {{ $tag->name }}

                    <button type="button" class="btn btn-info float-md-right">
                        <a href="{{ route('tags.edit', $tag->id) }}" style="color:white">
                            <i class="fas fa-edit"></i>
                        </a>
                    </button>
                    <form method="POST" id="delete-form-{{ $tag->id }}"
                          action="{{ route('tags.destroy', $tag) }}"
                          style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                    </form>
                    <button type="button" class="btn btn-danger float-md-right">
                        <a onclick="if (confirm('Tem certeza que deseja DELETAR esse documento?')){
                            event.preventDefault();
                            document.getElementById('delete-form-{{ $tag->id }}').submit();
                            } else {
                            event.preventDefault();
                            }"
                           href=" {{ route ('tags.index') }}" style="color:white">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </button>
                </a>
             </div>
            <p></p>
            </td>
            @endforeach
        </tr>
    @endforeach
    </table>
</div>
@endsection
