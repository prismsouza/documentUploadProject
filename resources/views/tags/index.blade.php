@extends('layout_admin')
@section('content')

<div id="content">
    @include('tags.create')
    <p></p>
    <table width="100%">
    @foreach($tags->chunk(4) as $chunked_tag)
        <tr class="d-flex">
        @foreach( $chunked_tag as $tag )
            <td class="col-sm-3 border py-2">
                <div class="title">

                        {{ $tag->name }}
                        <div class="btn-group float-md-right" role="group" aria-label="Basic example">
                            <form method="POST" id="delete-form-{{ $tag->id }}"
                                  action="{{ route('tags.destroy', $tag) }}"
                                  style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>

                                <a type="button" class="btn btn-danger btn-outline-secondary btn-sm float-md-right"
                                   onclick="if (confirm('Tem certeza que deseja DELETAR essa tag?')){
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $tag->id }}').submit();
                                    } else {
                                    event.preventDefault();
                                    }"
                                   href=" {{ route ('tags.index') }}" style="color:white">
                                    <i class="far fa-trash-alt" style="color: black" aria-hidden="true"></i>
                                </a>

                            @include('tags.edit')
                        </div>
                </div>
            </td>
            @endforeach
        </tr>
    @endforeach
    </table>
</div>
@endsection
