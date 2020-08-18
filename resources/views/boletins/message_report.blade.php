<button type="button" class="btn btn-dark btn-sm float-md-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
    Reportar erro ou fazer sugestao
</button>

<form method="POST" action="{{ route ('message.store', $boletim->id) }}">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <p class="text-center"><b>{{ $boletim->name }}</b></p>
                            <label for="recipient-name" class="col-form-label">
                                Deseja reportar algum erro na norma ou fazer alguma sugestao/alerta para correcao do conteudo?
                            </label>
                        </div>
                        <div class="form-group">
                                <textarea
                                    class="form-control"
                                    id="message"
                                    name="message"
                                    value="{{ old('message') }}"
                                    rows="5">
                                </textarea>
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

<script>
    $(document).ready(function(){
        $("#send_button").click(function(){
            alert("Sua mensagem foi enviada com sucesso");
        });
    });
</script>
