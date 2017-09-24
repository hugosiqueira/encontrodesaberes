<?php 

//include "../config.php"; 

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Encontro de Saberes 2017 - Universidade Federal de Ouro Preto </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @todo: fill with your company info or remove -->
    <meta name="description" content="">
    <meta name="author" content="Hugo Siqueira">
    <!-- Bootstrap CSS -->
    <link href="plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- animate.css CSS -->
    <link href="plugins/animate/animate.min.css" rel="stylesheet">
    <!-- Flexslider -->
    <link href="plugins/flexslider/flexslider.css" rel="stylesheet">
    <!-- Theme style -->
    <link href="css/theme-style.css" rel="stylesheet">
    <!-- Your custom override -->
    <link href="css/custom-style.css" rel="stylesheet">
    <!-- @option: Colour skins, choose from: 1. colour-blue.css 2. colour-red.css 3. colour-grey.css 4. colour-purple 5. colour-green.css Uncomment line below to enable -->
    <link href="css/colour-red.css" rel="stylesheet" id="colour-scheme">
    <link href="css/bootstrap-dialog.min.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="plugins/html5shiv/dist/html5shiv.js"></script>
    <script src="plugins/respond/respond.min.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons - @todo: fill with your icons or remove -->
    <link rel="shortcut icon" href="img/icons/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/icons/114x114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/icons/72x72.png">
    <link rel="apple-touch-icon-precomposed" href="img/icons/default.png">
    <link href='http://fonts.googleapis.com/css?family=Monda:400,700' rel='stylesheet' type='text/css'>
    
    <style type="text/css">
        .colorgraph {
            height: 5px;
            border-top: 0;
            background: #c4e17f;
            border-radius: 5px;
            background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
            background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
          }
          .pager > li a:focus,
          .pager > li a:hover, 
          .pager .disabled {
              color: #fff;
              background-color: #cc0000;
          }
    </style>
  </head>
  
  <!-- ======== @Region: body ======== -->
  <body class="has-navbar-fixed-top page-index">
    
    <!-- ======== @Region: #navigation ======== -->
    <div id="navigation" class="wrapper">
      <div class="navbar navbar-fixed-top" id="top">
        <div class="navbar-inner">
          <div class="inner">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle btn btn-navbar" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Navega&ccedil;&atilde;o</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="index.php" title="Inicio">
                    <img src="img/slides/encontro.png" class="img-responsive" style="margin-top:-5px" alt="Logo Encontro de saberes"/>
                </a>
              </div>

            <div class="collapse navbar-collapse">
              <ul class="nav navbar-right" id="main-menu">
                <li class="dropdown">
                    <a href="index.php" class="dropdown-toggle" id="apresentacao-drop" data-toggle="dropdown">Apresenta&ccedil;&atilde;o</a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="apresentacao-drop">
                    <li role="menuitem"><a href="seic.php" tabindex="-1">Seic</a></li>
                    <li role="menuitem"><a href="sext.php" tabindex="-1">Sext</a></li>
                    <li role="menuitem"><a href="proativa.php" tabindex="-1">Mostra Pr&oacute;-Ativa</a></li>
                    <li role="menuitem"><a href="seinter.php" tabindex="-1">SEINTER</a></li>
                    <li role="menuitem"><a href="pibid.php" tabindex="-1">PIBID UFOP</a></li>
                    <li role="menuitem"><a href="seminario.php" tabindex="-1">Semin&aacute;rio de Monitoria</a></li>
                    <li role="menuitem"><a href="comissao.php" tabindex="-1">Comiss&atilde;o Organizadora</a></li>

                  </ul></li>
                <!--li class="dropdown">
                  <a href="#" class="dropdown-toggle" id="inscricao-drop" data-toggle="dropdown" >Inscri&ccedil;&otilde;es</a>
                   <ul class="dropdown-menu" role="menu" aria-labelledby="inscricao-drop">
                     <li role="menuitem"><a href="cadastros.php" tabindex="-1">Inscrever no evento</a></li>
                     <!--li role="menuitem"><a href="inscrever_minicurso.php" tabindex="-1">Inscrever em minicurso</a></li>
                     <li role="menuitem"><a href="submeter_resumo.php" tabindex="-1">Submeter Resumo</a></li>
                    <li role="menuitem"><a href="submissao.php" tabindex="-1">Informa&ccedil;&otilde;es de Submiss&atilde;o</a></li>
                   </ul>
                </li-->

                <!--li class="dropdown">
                  <a href="#" class="dropdown-toggle" id="programacao-drop" data-toggle="dropdown">Programa&ccedil;&atilde;o</a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="programacao-drop">
                     <li role="menuitem"><a href="programacao_geral.xls" target="_blank" tabindex="-1">Programa&ccedil;&atilde;o Geral</a></li>
                     <li role="menuitem"><a href="apresentacoes_poster.php" tabindex="-1">Apresenta&ccedil;&otilde;es P&ocirc;steres</a></li>
                     <!--li role="menuitem"><a href="apresentacoes_cet.php" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - CET</a></li>
                     <li role="menuitem"><a href="apresentacoes_chla.php" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - CHLA</a></li>
                     <li role="menuitem"><a href="apresentacoes_csa.php" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - CSA</a></li>
                     <li role="menuitem"><a href="apresentacoes_cv.php" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - CV</a></li>
                     <li role="menuitem"><a href="apresentacoes_eng.php" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - ENG</a></li-->
                     <!--li role="menuitem"><a href="apresentacoes_seic.php" target="_blank" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - SEIC</a></li>
                     <li role="menuitem"><a href="apresentacoes_proativa.php" target="_blank" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - Mostra Pr&oacute;-Ativa</a></li>
                     <li role="menuitem"><a href="apresentacoes_proativa.php" target="_blank" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - Mostra PET</a></li>
                     <li role="menuitem"><a href="apresentacoes_proex.php" target="_blank" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - PROEX</a></li>
                     <li role="menuitem"><a href="apresentacoes_seinter.php" tabindex="-1">Apresenta&ccedil;&otilde;es Orais - SEINTER</a></li>
                     <li role="menuitem"><a href="apresentacoes_monitoria_2016.pdf" target="_blank" tabindex="-1">Apresenta&ccedil;&otilde;es em Pôsteres - Mostra Monitoria</a></li>
                     <li role="menuitem"><a href="apresentacoes_pibid_2016.pdf" target="_blank" tabindex="-1">Apresenta&ccedil;&otilde;es em Pôsteres - Mostra PIBID</a></li>
                     <li role="menuitem"><a href="materiais_pedagogicos.pdf" target="_blank" tabindex="-1">Exposição de Materiais Pedagógicos</a></li>
                     <li role="menuitem"><a href="programacao_cultural.pdf" tabindex="-1">Programa&ccedil;&atilde;o Cultural</a></li>
                   </ul>
                </li-->
                <li class="dropdown">
                  <a a href="#" class="dropdown-toggle" id="premiacao-drop" data-toggle="dropdown">Trabalhos Premiados</a>
                   <ul class="dropdown-menu" role="menu" aria-labelledby="premiacao-drop">
                   <li role="menuitem"><a href="melhores_trabalhos_poster.pdf" tabindex="-1">Pôsteres</a></li>
                   <li role="menuitem"><a href="melhores_trabalhos_oral.pdf" tabindex="-1">Trabalhos Orais</a></li>
                   </ul>
                </li>
                <li>
                  <a href="anais.php">Anais</a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" id="certificado-drop" data-toggle="dropdown">Certificados</a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="certificado-drop">
                    <li role="menuitem"><a href="buscar_certificados.php" tabindex="-1">Baixar Certificado</a></li>
                    <li role="menuitem"><a href="autenticar_certificado.php" tabindex="-1">Verificar Autenticidade</a></li>
                  </ul>
                </li>
                <!--li>
                  <a href="datas.php">Datas</a>
                </li-->
                <li>
                  <a href="ouropreto.php">Ouro Preto</a>
                </li>
                <!--li class="dropdown">
                  <a href="#" class="dropdown-toggle" id="certificado-drop" data-toggle="dropdown">Certificados</a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="certificado-drop">
                     <li role="menuitem"><a href="#" tabindex="-1">Baixar Certificado</a></li>
                     <li role="menuitem"><a href="#" tabindex="-1">Verificar Autencidade</a></li>
                   </ul>
                </li-->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" id="contato-drop" data-toggle="dropdown">Contato</a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="contato-drop">
                    <li role="menuitem"><a href="contato.php" tabindex="-1">Fale Conosco</a></li>
                    <li role="menuitem" tabindex="-1"><a href="duvidas.php">D&uacute;vidas Frequentes</a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <!--/.nav-collapse -->
          </div>
        </div>
      </div>
    </div>
  </div>
