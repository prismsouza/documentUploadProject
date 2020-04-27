@extends('layout')
@section('content')

<div id="content">
@foreach($documents as $document)
    <div class="title">
        <h3>
            <a href="{{ $document->path()  }}">
                {{ $document->title }}
            </a>
        </h3>
     </div>
    <p>
        {{ $document->excerpt }}
    </p>

@endforeach
</div>
@endsection
