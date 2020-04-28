@extends('layout')
@section('content')

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
    </p><br>

@endforeach
@endsection
