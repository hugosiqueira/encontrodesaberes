  <?php include ("header.php");?>
   <style>
      ul {         
          padding:0 0 0 0;
          margin:0 0 0 0;
      }
      ul li {     
          list-style:none;
          margin-bottom:25px;           
      }
      ul li img {
          cursor: pointer;
      }
      .modal-body {
          padding:5px !important;
      }
      .modal-content {
          border-radius:0;
      }
      .modal-dialog img {
          text-align:center;
          margin:0 auto;
      }
    .controls{          
        width:50px;
        display:block;
        font-size:11px;
        padding-top:8px;
        font-weight:bold;          
    }
    .next {
        float:right;
        text-align:right;
    }
      /*override modal for demo only*/
      .modal-dialog {
          max-width:500px;
          padding-top: 90px;
      }
      @media screen and (min-width: 768px){
          .modal-dialog {
              width:500px;
              padding-top: 90px;
          }          
      }
      @media screen and (max-width:1500px){
          #ads {
              display:none;
          }
      }
  </style>

  <div id="highlighted">

    <div class="container">

      <div class="header">

        <h2 class="page-title">

          <span>Sobre Ouro Preto</span> 

        </h2>

      </div>

    </div>

  </div>
<div id="content">
  <div class="container">
      <p class="text-justify">Ouro Preto, cidade mineira, Patrim&ocirc;nio Hist&oacute;rico e Cultural da Humanidade, titulo este concedido pela Organiza&ccedil;&atilde;o das Na&ccedil;&otilde;es Unidas para Educa&ccedil;&atilde;o, Ci&ecirc;ncia e Cultura - UNESCO, em 1980. Foi a primeira capital da Capitania das Minas Gerais, seu territ&oacute;rio tem &aacute;rea de 1.245km&sup2;, compreende, atualmente, onze distritos e v&aacute;rios subdistritos rurais. Situada na regi&atilde;o sudeste do Brasil e distante 96 km da atual capital de Minas Gerais, Belo Horizonte. &Eacute; considerada, nos dias de hoje, uma das mais importantes cidades hist&oacute;ricas brasileiras.</p>
      <p><strong>Centro de Atendimento ao Turista de Ouro Preto (CAT-OP)</strong></p>
      <p>Gest&atilde;o Compartilhada entre a <a href="http://www.ouropreto.mg.gov.br/turismo-industria-e-comercio" target="_blank"><u>Secretaria de Turismo, Ind&uacute;stria e Com&eacute;rcio</u></a> da Prefeitura Municipal de Ouro Preto e o <a href="http://www.turismo.ufop.br/" target="_blank"><u>Departamento de Turismo</u></a> da Universidade Federal de Ouro Preto <br />
	<br />
	Terminal Rodovi&aacute;rio 8 de Julho<br />
	Rua Padre Rolim, 661, S&atilde;o Crist&oacute;v&atilde;o, Ouro Preto, MG, CEP 35400-000<br />
	Telefones: (31) 3551-5552 / (31) 3551-7329 <br />
	email: cat-op@turismo.ufop.br</p>

      <p><strong>Hospedagem</strong></p>
      <p>A cidade de Ouro Preto possui v&aacute;rias op&ccedil;&otilde;es de hot&eacute;is e pousadas. <a href="hospedagem.php"><u>Saiba Mais</u></a></p>
      <p><strong>Rep&uacute;blicas de Estudantes</strong></p>
      <p>Uma lista com os contatos das rep&uacute;blicas de estudantes da UFOP est&aacute; dispon&iacute;vel em <a href="http://u2.ufop.br/scripts/sme/smeweb.exe/pesquisa?cidade=1&amp;situacao=UFOP" target="_blank"><u>Lista de Rep&uacute;blicas Estudantis</u></a></p>
      <p><strong>Alimenta&ccedil;&atilde;o</strong></p>
      <p>Ouro Preto apresenta uma rica culin&aacute;ria, os turistas e visitantes podem se deliciar com a gastronomia local. <a href="alimentacao.php"><u>Saiba Mais</u></a></p>

      <ul class="row">
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <img class="img-responsive" src="img/ouropreto/1.jpg">
            </li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <img class="img-responsive" src="img/ouropreto/2.jpg">
            </li>
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <img class="img-responsive" src="img/ouropreto/3.jpg">
            </li>
     </ul>

  </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">         
          <div class="modal-body">                
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>



      </div>

    </div>

  </div>

  <?php include "bibliotecas.php"; ?>

  <?php include ("footer.php");?>
