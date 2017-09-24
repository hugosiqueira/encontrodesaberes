<?php
// Inclui o arquivo de configuração
include('../login/config.php');
// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');

if ( $_SESSION['logado'] === true ) {
    include "header.php";
    include "menu.php";
?>
<div class="page-inner">
                <div class="page-title">
                    <h3>Encontro de Saberes</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="monitoria.php">Semin&aacute;rio de Monitoria</a></li>
                        </ol>
                    </div>
                </div>
                            
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Aguarde, este módulo está sofrendo uma breve manutenção e em instantes estará novamente no ar. <br> Agradecemos a compreensão.</h4>
                                </div>
                           
                            </div>
                        </div>
<?php
    include "footer.php";
?>
   
    </body>
</html>
<?php } ?>