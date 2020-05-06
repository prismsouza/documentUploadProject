<div class="container py-3">
        <div class="row">
            <div class="col-sm-5">
                <form action="{{ route('documents.search_word') }}" method="POST" role="search" class="form-inline">
                    {{ csrf_field() }}
                    <label class="px-2">Pesquisar nome/descricao: </label>
                        <input class="form-control" type="text" name="word" id="word">
                        <button type="submit" id="searchbyword"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="col-sm-4">
                    <form action="{{ route('documents.search_date') }}" method="POST" role="search" class="form-inline">
                        {{ csrf_field() }}
                        <i class="fas fa-calendar p-2"></i>
                        De <input name="first_date" id="first_date" type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">
                        a <input name="last_date" id="last_date" type="date" data-display-mode="inline" data-is-range="true" data-close-on-select="false">
                        <button type="submit" id="searchbydate"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
                    </form>

            </div>
            <div class="col-sm-3">
                <form action="{{ route('documents.search_year') }}" method="POST" role="search" class="form-inline">
                    {{ csrf_field() }}
                    <label class="px-2">Ano: </label>
                    <input class="form-control" type="text" name="year" id="year">
                    <button type="submit" id="searchbyyear"><i class="fa fa-search py-2" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
</div>
