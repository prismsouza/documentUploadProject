@section('searchbar')
<?php
    $tags = App\Tag::all()->sortBy('name');
    $tags_array = (Session::has('tags') && request('tags') != NULL) ? Session::get('tags') : [];
    $categories = App\Category::orderBy('name', 'asc')->get()
            ->whereNotIn('id', [1, 2, 3]);
    $categories_array = (Session::has('categories') && request('categories') != NULL) ? Session::get('categories') : [];
?>

<div class="border p-2">

<form method="POST" action="{{ route('documents.index') }}" enctype="multipart/form-data" class="py-2"> @csrf
    <div class="row">
        <div class="col-sm-3" id="name_description">
            Nome/Descrição:
            <input
                class="form-control col-sm-12"
                type="text" name="word" id="word"
                value="{{ Session::get('word') }}">
        </div>

        <div class="col-sm" id="categories">
            Pesquisar por Categoria:<br>
            <button id="categories_btn" href="#" class="btn btn-light border px-5"
                    data-toggle="dropdown" data-target="#" >
                Selecione... <span class="caret"></span>
            </button>

            <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 130%">
                <input class="form-control" id="categories_input" type="text" placeholder="Search..">

                <li class="px-4 p-1">
                    <label class="box px-5 checkbox-inline">
                        <input
                            type="checkbox" value="0"
                            id="check_all_categories" name="all"
                            placeholder="Selecionado"
                            <?php if (count($categories) == count($categories_array)) echo "checked"; ?>>
                        Todas
                        <span class="checkmark"></span>
                    </label>
                </li>
                <script>
                    $("#check_all_categories").click(function(){
                        $('#categories input:checkbox').not(this).prop('checked', this.checked);
                    });
                </script>
                @forelse($categories as $category)
                    @if($category->id == 1 || $category->id == 2 || $category->id == 3) @continue @endif
                                @if (count($category->hasparent)==0)
                                    <li class="px-4 p-1">
                                    <label class="box px-5 checkbox-inline">
                                        <input
                                            type="checkbox" value="{{ $category->id }}"
                                            id="{{ $category->id }}" name="categories[]"
                                            placeholder="Selecionado"
                                            <?php echo (in_array($category->id,$categories_array)) ?'checked':'' ?>>
                                        {{ $category->name }}
                                        <span class="checkmark"></span>
                                    </label>
                                        @if (count($category->hassubcategory)>0)
                                            @foreach($category->hassubcategory as $sub_cat)<br>
                                        <span class="px-4"></span>
                                                    <label class="box px-5 checkbox-inline">
                                                        <input
                                                            type="checkbox" value=" {{ $sub_cat->id }} "
                                                            id="{{ $sub_cat->id }}" name="categories[]"
                                                            placeholder="Selecionado"
                                                        <?php echo (in_array($category->id,$categories_array)) ?'checked':'' ?>>
                                                        {{ $sub_cat->name }}
                                                        <span class="checkmark"></span>
                                                    </label>
                                            @endforeach
                                            @endif
                                    </li>
                                @endif
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse
            </ul>
        </div>

        <div class="col-sm" id="tags">
            Pesquisar por Assunto: <br>
            <button id="tags_btn" role="button" href="#" class="btn btn-light border px-5"
                    data-toggle="dropdown" data-target="#" >
                Selecione... <span class="caret"></span>
            </button>

            <ul class="dropdown-menu scrollable-menu" role="menu" style="width: 110%">
                <input class="form-control" id="tags_input" type="text" placeholder="Search..">

                <li class="px-4 p-1">
                    <label class="box px-5 checkbox-inline">
                        <input
                            type="checkbox" value="0"
                            id="check_all_tags" name="all"
                            placeholder="Selecionado"
                        <?php if (count($tags) == count($tags_array)) echo "checked"; ?>>
                        Todas
                        <span class="checkmark"></span>
                    </label>
                </li>
                <script>
                    $("#check_all_tags").click(function(){
                        $('#tags input:checkbox').not(this).prop('checked', this.checked);
                    });
                </script>

                    @forelse($tags as $tag)
                         <li class="px-4 p-1">
                            <label class="box px-5 checkbox-inline">
                                <input
                                    type="checkbox" value="{{ $tag->id }}"
                                    id="{{ $tag->id }}" name="tags[]"
                                    placeholder="Selecionado"
                                    <?php echo (in_array($tag->id,$tags_array)) ?'checked':'' ?>>
                                {{ $tag->name }}
                                <span class="checkmark"></span>
                            </label>
                            </li>

                    @empty
                         <p><h5>Nao ha tags cadastradas</h5></p>
                    @endforelse
            </ul>
        </div>

        <div class="col-sm-5" id="data_publicação">
            <i class="fas fa-calendar-alt p-2"></i>Data de Publicação:<br>
            <div>
                <label class="px-1 small">De</label>
                <input
                    name="first_date" id="first_date" type="date"
                    data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                    value="{{ Session::get('first_date') }}">
                <label class="px-1 small">a</label>
                <input
                    name="last_date" id="last_date" type="date"
                    data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                    value="{{ Session::get('last_date') }}">
            </div>
        </div>
    </div><br>
    <div class="row">
        <div id="is_active" class="col">
            <div class="row px-4">Documento:
                <div class="form-check form-check-inline px-4">
                    <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1"
                    <?php if(Session::get('is_active') == 1)  echo ' checked="checked"';?>>
                    Está vigente
                </div>
                <div class="form-check form-check-inline px-3">
                    <input class="form-check-input" type="radio" name="is_active" id="is_active" value="-1"
                    <?php if(Session::get('is_active') == -1)  echo ' checked="checked"';?>>
                    Não está vigente
                </div>
            </div>
        </div>

        <div class="col">
            <div class="field is-grouped">
                <div class="control">
                    <button class="btn btn-dark border btn-outline-light float-md-right" type="submit" >
                        Pesquisar <i class="fas fa-search px-2"></i>
                    </button>

                    <a class="btn btn-light border float-md-right"
                        href="/refresh">
                        Limpar <i class="fas fa-eraser px-2"></i>
                    </a>

                    <a class="btn btn-light border float-md-right"
                       href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
<script>
    var grd = function(){
        $("input[type='radio']").click(function() {
            var previousValue = $(this).attr('previousValue');
           // console.log(previousValue);
            var name = $(this).attr('value');
            //console.log(name);
            <?php Session::put('is_active', 0); ?>

            if (previousValue == 'checked') {
                $(this).prop("checked", false);
                $(this).attr('previousValue', false);
            } else {
                $("input[name="+name+"]:radio").attr('previousValue', false);
                $(this).prop("checked", true);
                $(this).attr('previousValue', 'checked');
                <?php Session::put('is_active', request('is_active')); ?>
            }

        });
    };
    grd('1');
</script>
</form>
</div>
<br>
@include('request')
<script src="{{ asset('site/searchbar.js') }}"></script>
@endsection
