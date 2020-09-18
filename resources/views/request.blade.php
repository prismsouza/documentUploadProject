

@if (Session::has('word') || request()->input('categories') || request()->input('first_date') || request()->input('last_date') || request()->input('tags') || request()->input('is_active'))
    <div class="border p-2">
        <b>Filtro aplicado:</b>
        @if (Session::get('word'))
            <br>Nome Documento / Descrição:
            <b class="px-2"> {{ request()->input('word') }} </b>
        @endif

        @if (Session::get('categories'))
            <br>Categorias:
            @foreach (Session::get('categories')  as $cat)
                <b class="p-1">{{ $category = $categories->where('id', $cat)->first()->name }}</b>
            @endforeach
        @endif

        @if (Session::get('first_date') || Session::get('last_date'))
            <?php
            $first_date = date('d/m/Y', strtotime(request()->input('first_date')));
            $last_date = date('d/m/Y', strtotime(request()->input('last_date')));
            ?>

            @if (Session::get('first_date') && Session::get('last_date'))
                <br>Data de publicação:
                <b class="px-2">de {{ $first_date }}
                    ate {{ $last_date }} </b>
            @elseif (Session::get('first_date'))
                <br>Documentos publicados:
                <b class="px-2">a partir de
                    {{ $first_date }}</b>
                ate a data de hoje.
            @endif
        @endif
    </div>
    <br>
@endif
