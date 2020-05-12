<div class="row py-3">
    <div class="col-sm-4">
        <form action="{{ route('documents.filter' , 'searchbyword') }}" method="POST" role="search" class="form-inline">
            {{ csrf_field() }}
            <label class="px-2">Documento: </label>
            <input class="form-control col-sm-6" type="text" name="word" id="word">
            <button type="submit" id="searchbyword"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
        </form>
    </div>
    <div class="col-sm-5">
        <form action="{{ route('documents.filter' , 'searchbydate') }}" method="POST" role="search" class="form-inline">
            {{ csrf_field() }}
            <i class="fas fa-calendar p-2"></i>
            <label class="px-2">De</label> <input name="first_date" id="first_date" type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">
            <label class="px-2">a</label> <input name="last_date" id="last_date" type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">
            <button type="submit" id="searchbydate"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
        </form>
    </div>

    <div class="col-sm-3">
        <form class="form-inline" action="{{ route('documents.filter' , 'searchbyyear') }}" method="POST" role="search" >
            {{ csrf_field() }}
            <label class="col-2">Ano: </label>
            <input class="form-control col-sm-4" type="text" name="year" id="year">
            <button type="submit" id="searchbyyear"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="container">
        <form action="{{ route('documents.filter' , 'searchbytags') }}" method="POST" role="search">
            {{ csrf_field() }}

            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Tags<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><div class="checkbox">
                <label>
                @forelse($tags as $tag)
                    <div class="col-sm">
                        <label class="checkbox-inline">
                            <input type="checkbox" value="{{ $tag->id }}" id="tags" name="tags[]">
                            {{ $tag->name }}
                            </label>

                    </div>
                @empty
                     <p><h5>Nao ha tags cadastradas</h5></p>
                @endforelse
                </label>
                </div></li>
            </ul>
        <button type="submit" id="searchbytags"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
        </form>
</div>
