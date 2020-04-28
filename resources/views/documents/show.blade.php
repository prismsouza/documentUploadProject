@extends ('layout')

@section ('content')
    <b>Title</b>
    <div class="title">
        <h2>{{ $document->title }}</h2>
    </div>

    <p><b>Excerpt: </b>{{ $document->excerpt }}</p>
    <p><b>File Path:</b> {{ $document->file_path }}</p>
    <p><b>Author Cod:</b> {{ $document->user_id }}</p>

    <a href="{{ url('/view/'.$document->file_path)}}" > Download</a>
@endsection
