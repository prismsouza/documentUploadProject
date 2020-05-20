@extends ('layout_standalone')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
@endsection

@section ('content')

    <div id="content">
        <a href="{{ route('categories.index') }}">
            <button class="btn btn-light btn-outline-dark float-md-right" type="submit">
                Voltar
            </button>
        </a>
            <h1 class="heading has-text-weight-bold is-size-4">Nova Categoria</h1>



            <form method="POST" action="/categorias">
                @csrf
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

                        @error('description')
                            <p class="help is-danger">{{ $errors->first('description') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" type="submit">Criar</button>
                    </div>
                </div>

            </form>

    </div>
@endsection
