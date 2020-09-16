<button class="btn btn-dark btn-outline-light border" type="button" data-toggle="collapse"
        data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Nova tag
</button><br>


<div class="collapse" id="collapseExample"><br>
    <form method="POST" action="/tags">
        @csrf
        <div class="row">
            <div class="col-10 field">
                <label for="name">Nome *</label>
                <input
                    class="input @error('name') is-danger @enderror col-5"
                    type="text" minlength="2" maxlength="24"
                    name="name"
                    id="name"
                    value="{{ old('name') }}">
                @error('name')<p class="help is-danger">{{ $errors->first('name') }}</p>@enderror

                <button class="btn btn-dark btn-outline-light border" type="submit">Criar</button>
                <span class="px-2"></span>
                <a href="{{ route('home') }}" class="btn btn-light border">
                    <i class="fas fa-home"></i>
                </a>
            </div>
        </div>
    </form><br>
</div>
