@extends ('version2.layout_versao2')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
@endsection

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <h1 class="heading has-text-weight-bold is-size-4">Editar Categoria</h1>

            <form method="POST" action="/tags/{{ $tag->id }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label class="label" for="name">Nome</label>

                    <div class="control">
                        <input class="input" type="text" name="name" id="name" value="{{ $tag->name }}">
                    </div>
                </div><br>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="btn btn-dark" type="submit">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
