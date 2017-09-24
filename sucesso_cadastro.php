<?php include "header.php"; 
$nome = $_GET['nome'];
$email = $_GET['email'];
$link = $_GET['link'];
?>
<div id="highlighted">

    <div class="container">

        <div class="header">

            <h2 class="page-title">

                <span>Cadastro realizado com sucesso</span> 
            
            </h2>

        </div>

    </div>

</div>
<div id="content">

    <div class="container">
    	<div id ="status" class="modal-body">
            <p>Prezado(a) <?=$nome;?>,</strong></p>
            <p>O seu cadastro foi realizado com sucesso, porém ainda é necessária a ativação da sua conta para acessar o sistema. Para isto, acesse o e-mail <?=$email;?> e siga as instruções informadas. Caso não tenha recebido o e-mail, por favor verifique em sua caixa de spam.</p>
            <p> Lembramos que para efetivar a sua participação no evento, você deverá efetuar o pagamento do boleto até o dia 05 de novembro de 2015. Caso já queira efetuar o pagamento, clique no link abaixo para gerar o seu boleto:</p>
            <p> <a href="<?=$link; ?>" target="_blank"><?=$link;?></a></p> 
    
    </div>



      </div>

    </div>

  </div>

  <?php include "bibliotecas.php"; ?>
  
  <?php include ("footer.php");?>