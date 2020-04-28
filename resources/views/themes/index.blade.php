@extends('layout')
@section('content')

<div id="content">
@foreach($themes as $theme)
    <div class="title">
        <h3>
            <a href="{{ $theme->path()  }}">
                {{ $theme->title }}
            </a>
        </h3>
     </div>
    <p>
        {{ $theme->description }}
    </p>

@endforeach
</div>
@endsection
