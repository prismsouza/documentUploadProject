@extends('layout')
@section('content')

<div id="content">
@foreach($tags as $tag)
    <div class="title">
        <h3>
            <a href="{{ $tag->path()  }}">
                {{ $tag->name }}
            </a>
        </h3>
     </div>
@endforeach
</div>
@endsection
