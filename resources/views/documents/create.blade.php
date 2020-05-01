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
                    <label class="label" for="name">Nome</label>

                    <div class="control">
                        <input
                            class="input @error('name') is-danger @enderror"
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}">

                        @error('name')
                            <p class="help is-danger">{{ $errors->first('name') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="description">Descricao</label>

                    <div class="control">
                        <input
                            class="input @error('description') is-danger @enderror"
                            type="text"
                            name="description"
                            id="description"
                            value="{{ old('description') }}">

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
                        accept=".pdf, application/pdf"
                        name="file_path"
                        id="file_path"
                        value="{{ old('file_path') }}">
                </div>

                <div class="field">
                    <label class="label" for="tags">Tags</label>

                    <div class="select is-multiple control">
                        <select name="tags[]" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        @error('tags')
                        <p class="help is-danger">{{ $message }}</p>
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
