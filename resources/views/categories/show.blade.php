@extends ('version2.layout_versao2')

@section ('content')
<div id="content">
    <b>Title</b>
    <div class="title">
        <h2>{{ $category->name }}</h2>
    </div>

    <p><b>Description: </b>{{ $category->description }}</p>
</div>
@endsection
