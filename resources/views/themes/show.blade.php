@extends ('layout')

@section ('content')
<div id="content">
    <b>Title</b>
    <div class="title">
        <h2>{{ $theme->name }}</h2>
    </div>

    <p><b>Description: </b>{{ $theme->description }}</p>
</div>
@endsection
