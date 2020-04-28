@extends ('layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
@endsection

@section('content')
            <h1 class="heading has-text-weight-bold is-size-4">Update Document</h1>

            <form method="POST" action="/documents/{{ $document->id }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label class="label" for="theme_id">Theme ID</label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="theme_id"
                            id="theme_id"
                            value="{{ $document->theme_id }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="title">Title</label>

                    <div class="control">
                        <input class="input" type="text" name="title" id="title" value="{{ $document->title }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="excerpt">Excerpt</label>

                    <div class="control">
                        <textarea class="textarea" name="excerpt" id="excerpt">{{ $document->excerpt }}</textarea>
                    </div>
                </div>

                <div class="field">
                    <label for="file_path">Upload a document</label><br>
                    <input
                        class="input"
                        type="text"
                        name="file_path"
                        id="file_path"
                        value="{{ $document->file_path }}">
                </div>

                <div class="field">
                    <label class="label" for="user_id">User ID</label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="user_id"
                            id="user_id"
                            value="{{ $document->user_id }}">
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" type="submit">Submit</button>
                    </div>
                </div>

            </form>
@endsection
