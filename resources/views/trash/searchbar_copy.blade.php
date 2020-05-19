<div class="row">
    <div class="col-sm">
        <label for="documents">Documento: </label><br>
    </div>
    <div class="col-sm">
        <label for="categories">Categoria:</label>
    </div>
    <div class="col-sm-4">
        <i class="fas fa-calendar p-2"></i> <label for="date">Data de Publicacao </label>
    </div>
    <div class="col-sm">
        <label for="tags">Tags </label>
    </div>
</div>

<div class="row">
    <div class="col-sm">
        <form action="{{ route('documents.filter' , 'searchbyword') }}" method="POST" role="search" class="form-inline">
            {{ csrf_field() }}
            <input class="form-control col-sm-10" type="text" name="word" id="word">
            <button type="submit" id="searchbyword"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
        </form>
    </div>

    <div class="col-sm">
        <form action="{{ route('documents.filter' , 'searchbycategories') }}" method="POST" role="search">
            {{ csrf_field() }}

            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                <label for="categories" class="form-control-label  border col-sm-6"></label>
                <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
                <li><div class="checkbox">
                        <label>
                            @forelse($categories as $category)
                                <div class="col-sm">
                                    <label class="checkbox-inline">
                                        <input type="checkbox"  value=" {{ $category->id }} " id="categories" name="categories[]" style="transform: scale(1.5);">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @empty
                                <p><h5>Nao ha categorias cadastradas</h5></p>
                            @endforelse
                        </label>
                    </div></li>
            </ul>
            <button type="submit" id="searchbycategories">
                <i class="fa fa-search py-2" aria-hidden="true"></i>
            </button>
        </form>
    </div>

    <div class="col-sm-4">
        <form action="{{ route('documents.filter' , 'searchbydate') }}" method="POST" role="search" class="form-inline">
            {{ csrf_field() }}

            <label class="px-1 small">De</label> <input name="first_date" id="first_date" type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">
            <label class="px-1 small">a</label> <input name="last_date" id="last_date" type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">
            <button type="submit" id="searchbydate"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
        </form>
    </div>

    <div class="col-sm">
        <form action="{{ route('documents.filter' , 'searchbytags') }}" method="POST" role="search">
            {{ csrf_field() }}

            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                <label for="tags" class="form-control-label  border col-sm-6"></label>
                <b class="caret"></b>
            </a>

            <ul class="dropdown-menu">
                <li><div class="checkbox">
                <label>
                    <input type="text" placeholder="Pesquisar..." id="myInput" onkeyup="filterFunction()">
                @forelse($tags as $tag)
                    <div class="col-sm">
                        <label class="checkbox-inline">
                            <input type="checkbox" value="{{ $tag->id }}" id="tags" name="tags[]" style="transform: scale(1.5);">
                            {{ $tag->name }}
                        </label>
                    </div>
                @empty
                     <p><h5>Nao ha tags cadastradas</h5></p>
                @endforelse
                </label>
                </div></li>
            </ul>
        <button type="submit" id="searchbytags">
            <i class="fa fa-search py-2" aria-hidden="true"></i>
        </button>
        </form>
    </div>
</div>


