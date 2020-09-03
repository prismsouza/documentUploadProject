@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<button class="btn btn-dark btn-outline-light border" type="button" data-toggle="collapse"
        data-target="#collapseCreate" aria-expanded="false" aria-controls="collapseCreate">
    Nova categoria
</button><br>

<div class="collapse" id="collapseCreate"><br>
    <form method="POST" action="/categorias">
        @csrf
        <div class="row">
            <div class="col-4 field">
                <label for="name">Nome *</label>
                <input
                    class="input @error('name') is-danger @enderror col-12"
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}">
                    @error('name')<p class="help is-danger">{{ $errors->first('name') }}</p>@enderror
            </div>
            <div class="col-6 field">
                <label for="description">Descrição *</label>
                <input
                    class="input @error('description') is-danger @enderror col-12"
                    type="text"
                    name="description"
                    id="description"
                    value="{{ old('description') }}">
                    @error('description')<p class="help is-danger">{{ $errors->first('description') }}</p>@enderror
            </div>
            <div class="col-10 py-4 field">
                <label for="hint">Seguir padrão:</label>
                <input
                    class="input @error('hint') is-danger @enderror col-12"
                    type="text"
                    name="hint"
                    id="hint"
                    value="{{ old('hint') }}">
                @error('hint')<p class="help is-danger">{{ $errors->first('hint') }}</p>@enderror
            </div>
            <div class="col-2 py-4 "><br>
                <div class="field is-grouped float-md-right" id="btn_create_document">
                    <button class="btn btn-dark btn-outline-light border" type="submit">Criar</button>
                    <a href="{{ route('home') }}" class="btn btn-light border">
                        <i class="fas fa-home"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
