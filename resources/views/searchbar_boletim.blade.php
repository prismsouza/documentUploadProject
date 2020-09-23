@section('searchbar')
<?php
    $tags = App\Tag::all();
    $tags_array = request('tags') ? request('tags') : [];
    $categories = App\Category::all()->sortBy('name');
    $categories_array = request('categories') ? request('categories') : [];
?>

<div class="border p-2">

<form method="POST" action="{{ route('boletins.index') }}" enctype="multipart/form-data" class="py-2"> @csrf
    <div class="row">
        <div class="col-sm-3" id="name_description">
            Nome/Descrição:
            <input
                class="form-control col-sm-12"
                type="text" name="word" id="word"
                value="{{ request()->input('word') }}">
        </div>

        <div class="col-sm-3" id="categories">
            Pesquisar por Categoria:<br>
            <button id="categories_btn" role="button" href="#" class="btn btn-light border px-5"
                    data-toggle="dropdown" data-target="#" >
                Selecione... <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu" style="width: 130%">
                <input class="form-control " id="categories_input" type="text" placeholder="Search..">



                <script>
                    $("#check_all_categories").click(function(){
                        $('#categories input:checkbox').not(this).prop('checked', this.checked);
                    });
                </script>


                @for($id=1; $id<=3; $id++)
                    <li class="px-4 p-1">
                        <label class="box px-5 checkbox-inline">
                            <input
                                type="checkbox" value="{{ $id }}"
                                id="{{ $id }}" name="categories[]"
                                placeholder="Selecionado"
                            <?php echo (in_array($id,$categories_array)) ?'checked':'' ?>>
                            {{ App\Category::where('id', $id)->first()->name }}
                            <span class="checkmark"></span>
                        </label>
                    </li>
                @endfor

            </ul>
        </div>

        <div class="col-sm-4" id="data_publicação">
            <i class="fas fa-calendar-alt p-2"></i>Data de Publicação:<br>
            <div>
                <label class="px-1 small">De</label>
                <input
                    name="first_date" id="first_date" type="date"
                    data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                    value="{{ request()->input('first_date') }}">
                <label class="px-1 small">a</label>
                <input
                    name="last_date" id="last_date" type="date"
                    data-display-mode="inline" data-is-range="true" data-close-on-select="false"
                    value="{{ request()->input('last_date') }}">
            </div>
        </div>
        <div class="col">

            <div class="field is-grouped">
                <div class="control py-2">
                    <button class="btn btn-dark border btn-outline-light float-md-right" type="submit" >
                        <i class="fas fa-search px-2"></i>
                    </button>

                    <a class="btn btn-light border float-md-right"
                        href="{{ route('boletins.refresh_session') }}">
                        <i class="fas fa-eraser px-2"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
</form>
</div>
<br>

@include('request')
    <script src="{{ asset('site/searchbar.js') }}"></script>
@endsection
