<?php
include ("../config.php");


foreach ($_POST as $campo => $valor) { $$campo = trim(strip_tags($valor));}
try {
	$salt = base64_encode($cpf);
    $senha = crypt($senha, $salt);
  
  $dados = array(
        'password' => $senha,
        'salt' => $salt
    );
   
    $stmt = $db->atualizar('es_inscritos', $dados, 'cpf', $cpf); 

    if($stmt)
    echo'<div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Encontro de Saberes</h4>
          </div>
          <div id ="status" class="modal-body">
            <p>Sua senha foi redefinida com sucesso. Aguarde você será redirecionado para a página de login.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>

      </div>
      ';
      else
        echo'<div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Encontro de Saberes</h4>
          </div>
          <div id ="status" class="modal-body">
            <p>Houve um erro ao redefinir sua senha. Tente novamente</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>

      </div>
      ';
} catch (PDOException $e) {
	echo $e->getMessage();
}
