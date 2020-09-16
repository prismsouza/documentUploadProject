<button class="btn btn-info float-md-right btn-sm" type="button" data-toggle="collapse"
        data-target="#collapseEdit{{$tag->id}}" aria-expanded="false" aria-controls="collapseEdit{{$tag->id}}">
    <a style="color:white" data-toggle="tooltip" title="editar">
        <i class="fas fa-edit" style="color: black"></i>
    </a>
</button><br>

<div class="collapse" id="collapseEdit{{$tag->id}}"><br>
    <form method="POST" action="{{route('tags.update', $tag)}}">
        @csrf
        @method('PUT')
        <div class="field row py-2">
            <div class="control">
                <input class="input" type="text" name="name" id="name" value="{{ $tag->name }}" minlength="2" maxlength="24">
            </div>
            <button class="btn btn-light float-md-right border btn-sm" style="color: black" type="submit">
                <i class="fas fa-save" data-toggle="tooltip" title="salvar" style="color: black"></i>
            </button><span class="px-3"></span>
        </div>
    </form>
</div>
</div>

