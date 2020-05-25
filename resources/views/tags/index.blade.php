@extends('layout_admin')
@section('content')

<div id="content">
    <a href="{{ route('tags.create') }}">
        <button class="btn btn-dark btn-outline-light" type="submit">
            Nova Tag
        </button>
    </a><p></p>

    <table width="100%">
    @foreach($tags->chunk(4) as $chunked_tag)
        <tr class="d-flex">
        @foreach( $chunked_tag as $tag )
            <td class="col-sm-3 border">
            <div class="py-2">
                <a href='/documentos?tag={{ $tag->name }}'>
                    {{ $tag->name }}

                <div class="btn-group float-md-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info float-md-right btn-outline-secondary btn-sm">
                        <a href="{{ route('tags.edit', $tag->id) }}" style="color:white">
                            <i class="fas fa-edit fa-resize-small"></i>
                        </a>
                    </button>
                    <form method="POST" id="delete-form-{{ $tag->id }}"
                          action="{{ route('tags.destroy', $tag) }}"
                          style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                    </form>
                    <button type="button" class="btn btn-danger btn-outline-secondary btn-sm float-md-right">
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
                </div>
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
