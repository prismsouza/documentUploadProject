@if (Session::has('word') || Session::has('categories') || Session::has('first_date') || Session::has('last_date') || Session::has('tags') || Session::has('is_active'))
    <div class="border p-2">
        <b>Filtro aplicado:</b>
        @if (Session::get('word'))
            <br>Nome Documento / Descrição:
            <b class="px-2"> {{ Session::get('word') }} </b>
        @endif

        @if (Session::get('categories'))
            <br>Categorias:
            @foreach (Session::get('categories')  as $cat)
                <b class="p-1">{{ $category = $categories->where('id', $cat)->first()->name }}</b>
            @endforeach
        @endif

        @if (Session::get('first_date') || Session::get('last_date'))
            <?php
            $first_date = date('d/m/Y', strtotime(Session::get('first_date')));
            $last_date = date('d/m/Y', strtotime(Session::get('last_date')));
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
            @elseif (Session::get('last_date'))
                <br>Documentos publicados até
                <b class="px-2">
                    {{ $last_date }}</b>
            @endif
        @endif

        @if (Session::get('tags') && (request('tags') != NULL))
            <br>Tags:
            @foreach (Session::get('tags')  as $t)
                <b class="p-1">{{ $tag = $tags->where('id', $t)->first()->name }} </b>
            @endforeach
        @endif

        @if (Session::get('is_active'))
            <br>Vigencia:
            <b class="p-1">{{ Session::get('is_active') == "1" ? "Vigente" : "Revogado" }}</b>
        @endif
    </div>
    <br>
@endif
