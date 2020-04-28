@extends ('layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
@endsection

@section ('content')
    <div id="content">
            <h1 class="heading has-text-weight-bold is-size-4">New Document</h1>

            <form method="POST" action="/documents">
                @csrf
                <div class="field">
                    <label class="label" for="theme_id">Theme ID</label>

                    <div class="control">
                        <input
                            class="input @error('theme_id') is-danger @enderror"
                            type="text"
                            name="theme_id"
                            id="theme_id"
                            value="{{ old('theme_id') }}">

                        @error('theme_id')
                        <p class="help is-danger">{{ $errors->first('theme_id') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="title">Title</label>

                    <div class="control">
                        <input
                            class="input @error('title') is-danger @enderror"
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title') }}">

                        @error('title')
                            <p class="help is-danger">{{ $errors->first('title') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="excerpt">Excerpt</label>

                    <div class="control">
                        <input
                            class="input @error('excerpt') is-danger @enderror"
                            type="text"
                            name="excerpt"
                            id="excerpt"
                            value="{{ old('excerpt') }}">

                        @error('excerpt')
                            <p class="help is-danger">{{ $errors->first('excerpt') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="file_path">Upload a document</label><br>
                    <input
                        class="input @error('file_path') is-danger @enderror form-control"
                        type="file"
                        name="file_path"
                        id="file_path"
                        value="{{ old('file_path') }}">
                </div>

                <div class="field">
                    <label class="label" for="user_id">User ID</label>

                    <div class="control">
                        <input
                            class="input @error('user_id') is-danger @enderror"
                            type="text"
                            name="user_id"
                            id="user_id"
                            value="{{ old('user_id') }}">

                        @error('user_id')
                        <p class="help is-danger">{{ $errors->first('user_id') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" type="submit">Submit</button>
                    </div>
                </div>

            </form>

    </div>
@endsection
