@extends('layout')
@section('content')

<div id="content">
        <div class=" border p-2">
            Tags cadastradas:
        </div>
    <div class="field is-grouped col" id="btn_create_document">
        <div class="control float-md-right">
            <button class=" btn btn-dark float-md-right" type="submit">
                <a href="/tags/novo" style="color:white"> Criar nova Tag</a>
            </button>
        </div>
    </div><br>

@foreach($tags as $tag)
    <div class="px-2">
            <a href='/documentos?tag={{ $tag->name }}'>
                {{ $tag->name }}
            </a>
     </div>
@endforeach
</div>
@endsection
