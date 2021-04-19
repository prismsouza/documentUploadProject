@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<button type="button" class="btn btn-default add-new"
        data-toggle="collapse" data-target="#collapseCreate" aria-expanded="false" aria-controls="collapseCreate">
    <i class="fa fa-plus" style="color: black"></i>
</button>

<div class="collapse" id="collapseCreate"><br>
    <form method="POST" action="{{route('admin.store')}}">
        @csrf
        <div class="row px-3">
                <input
                    class="input @error('masp') is-danger @enderror col-2"
                    type="text"
                    name="masp" minlength="7" maxlength="7"
                    id="masp" placeholder="MASP"
                    value="{{ old('masp') }}">
                    @error('masp')<p class="help is-danger">{{ $errors->first('name') }}</p>@enderror

            <span class="px-3"></span>
                    <button class="add btn btn-success" title="Salvar" id="create" name="create"
                            data-toggle="tooltip" type="submit">
                        <i class="fas fa-save" style="color: black"></i>
                    </button>

        </div>
    </form>
    <br>
</div>
