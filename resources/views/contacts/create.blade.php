<a class="btn border btn-outline-light" type="button" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
    <span style="color: black" > Para Sugestões ou Comentários, clique aqui e mande uma mensagem.</span>
    <i class="fa fa-envelope" aria-hidden="true"></i>
</a>

<form method="POST" action="{{ route ('contacts.store') }}">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h3 class="modal-title" id="exampleModalLabel">Fale conosco</h3>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span style="color: dimgray"> Número máximo de caracteres: 1000 </span>
                    <form>
                        <div class="form-group">
                            <textarea class="form-control"
                                      id="message"
                                      name="message"
                                      value="{{ old('message') }}"
                                      maxlength="1000"
                                      rows="6"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary button is-link" id="send_contact_button">Enviar </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#send_contact_button").click(function(){
            alert("Sua mensagem foi enviada com sucesso");
        });
    });
</script>
