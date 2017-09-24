<?php include ("header.php"); ?>

  

  <!-- ======== @Region: #highlighted ======== -->

  <div id="highlighted">

    <div class="container">

      <div class="header">

        <h2 class="page-title">

          <span>Contato</span> 

        </h2>

      </div>

    </div>

  </div>

  

  <!-- ======== @Region: #content ======== -->

  <div id="content">

    <div class="container">

      <div class="block">

        <div class="row">

          <div class="col-sm-6">
            

            <form id="contato" action="javascript:func()">
              <div id="aguarde" class="modal fade modal" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Encontro de Saberes</h4>
                      </div>
                      <div class="modal-body">
                          Aguarde, enviando...
                      </div>
                  </div>

                </div>
              </div>
              <div id="sucesso"></div>

              <div class="form-group">

                <input type="text" class="form-control" placeholder="Nome Completo" id="nome" required>

              </div>

              <div class="form-group">

                <input type="email" class="form-control" placeholder="Email" id="email" required>

              </div>

              <div class="form-group">

                <input type="text" class="form-control" placeholder="Telefone" data-mask="(00) 0000-00000"  id="telefone">

              </div>

              <div class="form-group">

                <input type="text" class="form-control" placeholder="Assunto" id="assunto" required>

              </div>

              <div class="form-group">

                <textarea rows="22" class="form-control" placeholder="Mensagem" id="mensagem" required></textarea>

              </div>

              <button class="btn btn-primary btn-large" id="button_enviar" type="submit">Enviar</button>

            </form>

          </div>

          <div class="col-sm-6">
            <h3 class="block-title sub-title">
            <span>Endere&ccedil;o da Secretaria do Encontro de Saberes</span>
            </h3>
	    <img src="img/topazio.png" style="padding:10px 0 0 0" alt="Logo Topázio"/>
	    <p><strong>Topazio Imperial Organização de Eventos </strong></p>
            <p><abbr title="Endereço">End</abbr>: R. São Miguel Arcanjo,328- Água Limpa - Ouro Preto-MG</p>
            <p><abbr title="Telefone">Tel</abbr>: (31) 3551-4006 / (31) 99917-5683</p>
            <p><abbr title="E-mail">Email</abbr>: encontrodesaberes@ufop.br</p>

            <h3 class="block-title sub-title">

              <span>Local de realiza&ccedil;&atilde;o do Encontro de Saberes</span>

            </h3>

          <p><abbr title="Endereço">End</abbr>: Parque Metal&uacute;rgico Augusto Barbosa Centro de Artes e Conven&ccedil;&otilde;es da UFOP  Rua Diogo Vasconcelos n 328 Pilar | Ouro Preto - MG</p>

          

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3739.8495306036375!2d-43.50706100000001!3d-20.389093000000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4ab4279eed486bff!2sCentro+de+Artes+e+Conven%C3%A7%C3%B5es+em+Ouro+Preto!5e0!3m2!1spt-BR!2sbr!4v1432909163628" width="600" height="400" frameborder="0" style="border:0"></iframe>

          </div>

        </div>

      </div>

    </div>

  </div>


<?php include "bibliotecas.php"; ?>

<script type="text/javascript">
$(document).ready(function() {
  var $validator = $("#contato").validate({
        rules: {
           
            nome: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            assunto: {
                required: true
            },
            mensagem: {
                required: true
            }
        }
    });
  $("#button_enviar").click(function() {
    $("#contato").validate();
    if($("#contato").valid())
    {
      $("#aguarde").modal('show');
      $("#contato").submit(function() {
          // Colocamos os valores de cada campo em uma váriavel para facilitar a manipulação
          var nome = $("#nome").val();
          var email = $("#email").val();
          var telefone = $("#telefone").val();
          var assunto = $("#assunto").val();
          var mensagem = $("#mensagem").val();


          // Fazemos a requisão ajax com o arquivo envia.php e enviamos os valores de cada campo através do método POST
          $.post('envio_contato.php', { nome: nome, email: email,  telefone: telefone,assunto: assunto,
            mensagem: mensagem }, 
            function(resposta) {
                  // Quando terminada a requisição
                  // Exibe a div status
                  // Se a resposta é um erro
                  if (resposta != false) {
                      var nome = $("#nome").val('');
                      var email = $("#email").val('');
                      var telefone = $("#telefone").val('');
                      var assunto = $("#assunto").val('');
                      var mensagem = $("#mensagem").val('');
                      $("#sucesso").html(resposta);
                      $("#aguarde").modal('hide');
                    } 
                  // Se resposta for false, ou seja, não ocorreu nenhum erro
                  else {
                      var nome = $("#nome").val('');
                      var email = $("#email").val('');
                      var telefone = $("#telefone").val('');
                      var assunto = $("#assunto").val('');
                      var mensagem = $("#mensagem").val('');
                      $("#sucesso").html(resposta);
                      $("#aguarde").modal('hide');

                    }
                  });
        });
    }
});
});
</script>
  
<?php include "footer.php"; ?>
