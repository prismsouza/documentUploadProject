@extends('layout')
@section('content')

<div id="content">
@foreach($categories as $category)
    <div class="title">
        <h3>
            <a href="{{ $category->path()  }}">
                {{ $category->name }}
            </a>
        </h3>
     </div>
    <p>
        {{ $category->description }}
    </p>

@endforeach
</div>
@endsection
