<button type="button" class="btn btn-dark btn-sm float-md-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
    Reportar erro ou fazer sugestao
</button>

<form method="POST" action="{{ route ('message.store', $document->id) }}">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h3 class="modal-title" id="exampleModalLabel">Contato</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <h4 class="text-center"><b>{{ $document->name }}</b></h4>
                            <span class="col-form-label">
                                Deseja reportar algum erro na página ou fazer alguma sugestão/alerta para correção do conteúdo? (número máximo de caracteres: 800)
                            </span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control"
                                    id="message"
                                    name="message"
                                    value="{{ old('message') }}"
                                    maxlength="800"
                                    rows="6"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary button is-link" id="send_button">Enviar </button>
                </div>
            </div>
        </div>
    </div>
</form>
