@section('searchmessagebar')

    <?php $categories = App\Category::all(); ?>
<div class="border p-2" style="font-size:85%">
<form method="POST" action="{{ route('messages.filter') }}" enctype="multipart/form-data" class="py-2"> @csrf
    <div class="row">
        <div class="col-3" id="Nome/Descrição">
            Nome do Documento:
            <input
                class="form-control col-sm-10"
                type="text" name="word" id="word"
                value="{{ request()->input('word') }}">
        </div>

        <div class="col-sm-2" id="Categorias">
            Categorias:<br>
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Selecione...
            </a>

            <ul class="dropdown-menu">
                <li>
                    <div class="checkbox">
                        <label>
                            @forelse($categories as $category)
                                <div class="col-sm">
                                    <label class="checkbox-inline">
                                        <input
                                            type="checkbox" value=" {{ $category->id }} "
                                            id="categories" name="categories[]"
                                            style="transform: scale(1.5);"
                                            placeholder="Selecionado">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse
                        </label>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-sm-4" id="Data">
            <i class="fas fa-calendar-alt p-2"></i>Data da Mensagem:<br>
            <div style="font-size:90%">
            <label class="px-1 small">De</label>
            <input
                name="first_date" id="first_date" type="date"
                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                value="{{ request()->input('first_date') }}">
            <label class="px-1 small">a</label>
            <input
                name="last_date" id="last_date" type="date"
                data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                value="{{ request()->input('last_date') }}"></div>
        </div>

        <div class="col-2" id="Verificada">
            <div class="control" id="is_checked">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_checked" id="is_checked" value="1">
                    <label class="form-check-label" for="inlineRadio1">Verificada</label>
                </div><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_checked" id="is_checked" value="-1">
                    <label class="form-check-label" for="inlineRadio2">Não verificada</label>
                </div><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_checked" id="is_checked" value="2">
                    <label class="form-check-label" for="inlineRadio2">Todas</label>
                </div>
            </div>
        </div>
    </div>
        <div class="field is-grouped">
            <div class="control float-md-right py-2">
                <button class="btn btn-light border btn-sm" type="submit"  action="{{ route('messages.index') }}">
                    <a href="{{ route('messages.index') }}">
                        <i class="fas fa-eraser px-2" data-toggle="tooltip" title="limpar campos"></i>
                    </a>
                </button>
                <button class="btn btn-dark border btn-sm" type="submit" >
                    <i class="fas fa-search px-2" data-toggle="tooltip" title="filtrar"></i>
                </button>
            </div>
        </div>

</form>
</div>
<br>

@if (request()->input('word') || request()->input('categories') || request()->input('first_date') || request()->input('last_date') || request()->input('is_checked'))
    <div class="border p-2">
        <b>Filtro aplicado:</b>
    @if (request()->input('word'))
        <br>Nome do Documento / Descrição:<b class="px-2">{{ request()->input('word') }}</b>
    @endif

    @if (request()->input('categories'))
        <br>Categorias:
        @foreach ( request()->input('categories')  as $cat)
            <b class="p-1">{{ $category = $categories->where('id', $cat)->first()->name }}</b>
        @endforeach
    @endif

    @if (request()->input('first_date') || request()->input('last_date'))
        <?php
        $first_date = date('d/m/Y', strtotime(request()->input('first_date')));
        $last_date = date('d/m/Y', strtotime(request()->input('last_date')));
        ?>

        @if (request()->input('first_date') && request()->input('last_date'))
            <br>Data da mensagem:
            <b class="px-2">de {{ $first_date }}
            ate {{ $last_date }} </b>
        @elseif (request()->input('first_date'))
             <br>Mensagens recebidas:
             <b class="px-2">a partir de
             {{ $first_date }}</b>
             até a data de hoje.
        @elseif (request()->input('last_date'))
              <br>Mensagens recebidas:
              <b class="px-2">até {{ $last_date }}</b>
        @endif
    @endif

    @if (request()->input('is_checked'))
        <br>Mensagens
        <b class="p-1">
            @if(request()->input('is_checked') == "1")
                verificadas
            @elseif(request()->input('is_checked') == "-1")
                não verificadas
            @else
                verificadas e não verificadas
            @endif
        </b>
    @endif

    </div>
    <br>
@endif

@endsection
