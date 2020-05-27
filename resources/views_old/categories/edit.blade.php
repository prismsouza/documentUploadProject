@extends ('layout_standalone')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css"/>
@endsection

@section('content')
    <div id="wrapper">
        <div id="page" class="container">
            <a href="{{ route('categories.index') }}">
                <button class="btn btn-light btn-outline-dark float-md-right" type="submit">
                    Voltar
                </button>
            </a>
            <h1 class="heading has-text-weight-bold is-size-4">Update Category</h1>

            <form method="POST" action="/categorias/{{ $category->name }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label class="label" for="name">Nome</label>

                    <div class="control">
                        <input class="input" type="text" name="name" id="name" value="{{ $category->name }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="description">Description</label>

                    <div class="control">
                        <textarea class="textarea" name="description" id="description">{{ $category->description }}</textarea>
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
