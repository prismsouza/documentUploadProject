    <form method="POST" action="{{ route('tags.index') }}">
        @csrf
        <div class="row">
            <div class="col-4 field">
                <label for="name">Nome *</label>
                <input
                    class="input @error('name') is-danger @enderror col-10"
                    type="text" minlength="2" maxlength="24"
                    name="name"
                    id="name"
                    value="{{ old('name') }}">
                @error('name')<p style="color: darkred">{{ $errors->first('name') }}</p>@enderror
            </div>
            <div class="col field">
                <button class="btn btn-dark btn-outline-light border" type="submit">Criar Tag</button>
            </div>
        </div>
    </form>
</div>
