<div class="row">
                        <div class="col-sm" id="Categorias">
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
