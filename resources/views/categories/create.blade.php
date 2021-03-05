@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

    <form method="POST" action="{{ route ('categories.store') }}">
        @csrf
        <div class="row">
            <div class="col-4 field">
                <label for="name">Nome *</label>
                <input
                    class="input @error('name') is-danger @enderror col-8"
                    type="text" minlength="2" maxlength="35"
                    name="name"
                    id="name"
                    value="{{ old('name') }}">
            </div>
            <div class="col-6 field">
                <label for="description">Descrição *</label>
                <input
                    class="input @error('description') is-danger @enderror col-8"
                    type="text" maxlength="100"
                    name="description"
                    id="description"
                    value="{{ old('description') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-9 py-3 field">
                <label for="hint">Seguir padrão:</label>
                <input
                    class="input @error('hint') is-danger @enderror col-10"
                    type="text" maxlength="200"
                    name="hint"
                    id="hint"
                    value="{{ old('hint') }}">
            </div>
            <div class="col">
                <div class="field is-grouped" id="btn_create_document">
                    <button class="btn btn-dark btn-outline-light border" type="submit">Criar Categoria</button>
                </div>
            </div>
        </div>
    </form>
