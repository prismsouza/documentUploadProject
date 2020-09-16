<button class="btn btn-info float-md-right btn-sm" type="button" data-toggle="collapse"
        data-target="#collapseEdit{{$category->id}}" aria-expanded="false" aria-controls="collapseEdit{{$category->id}}">
    <a style="color:white" data-toggle="tooltip" title="editar">
        <i class="fas fa-edit" style="color: black"></i>
    </a>
</button><br>

<div class="collapse" id="collapseEdit{{$category->id}}"><br>
            <form method="POST" action="{{route('categories.update', $category)}}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="name" style="font-size: 80%; color: dimgrey">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="name" id="name" value="{{ $category->name }}" minlength="2" maxlength="35">
                    </div>
                </div>

                <div class="field">
                    <label for="description" style="font-size: 80%; color: dimgrey" >Descrição</label>
                    <div class="control">
                        <textarea class="textarea" name="description" id="description" maxlength="100">{{ $category->description }}</textarea>
                    </div>
                </div>

                <div class="field">
                    <label for="hint" style="font-size: 80%; color: dimgrey" >Seguir padrão...</label>
                    <div class="control">
                        <textarea class="textarea" name="hint" id="hint" maxlength="200">{{ $category->hint}}</textarea>
                    </div>
                </div>

                <button class="btn btn-light float-md-right border" style="color: black" type="submit">
                    <i class="fas fa-save" data-toggle="tooltip" title="salvar"></i>
                </button>
            </form>
        </div>
    </div>

