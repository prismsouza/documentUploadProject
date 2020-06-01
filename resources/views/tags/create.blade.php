@extends ('layout_admin')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
@endsection

@section ('content')
    <div id="content">
            <h1 class="heading has-text-weight-bold is-size-4">Nova Tag</h1>

            <form method="POST" action="/tags">
                @csrf
                <div class="field">
                    <label class="label" for="name">Tag</label>

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
                </div><br>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="btn btn-dark" type="submit">Criar</button>
                    </div>
                </div>

            </form>

    </div>
@endsection
