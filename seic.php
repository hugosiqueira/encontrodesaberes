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

          <span>SEIC</span> 
          <small>XXIV Seminário de Iniciação Científica</small>

        </h2>

      </div>

    </div>

  </div>
<div id="content">

    <div class="container">
      <p class="text-justify">O SEIC tem por objetivo promover o intercâmbio entre estudantes de graduação que participam de Programas de Iniciação Científica em Instituições de Ensino e Pesquisa, públicas ou privadas, em todas as áreas de conhecimento. A importância do SEIC ,no desenvolvimento da pesquisa na UFOP, se reflete no aumento crescente de projetos de iniciação científica, sendo que muitos desses projetos têm sido embriões para projetos mais sofisticados de pós-graduação. Além disso, tem contribuído significativamente para a redução do tempo médio de titulação de mestres e doutores, bem como para a formação de recursos humanos para a pesquisa. Insere-se, ainda, neste evento, a avaliação dos Programas Institucionais da UFOP de Bolsas de Iniciação Científica: PIBIC/CNPq/UFOP, PIBIC-Af/CNPq/UFOP, PIBITI/CNPq/UFOP, PROBIC/FAPEMIG/UFOP, PIP/UFOP, PROMET/Fundação Gorceix, PROMIN/Fundação Gorceix, PIBIC-EM/CNPq/UFOP, BIC-Jr/FAPEMIG/UFOP e do Programa Institucional de Voluntários de Iniciação Científica (PIVIC).</p>
<p class="text-justify">Nesta oitava edição do Encontro de Saberes, o SEIC elegerá os melhores trabalhos, sendo 02 pôsteres e 01 trabalho apresentado em comunicação ORAL por área de conhecimento.
</p>

       <ul class="row">
            <li class="col-lg-4 col-md-4 col-sm-3 col-xs-4">
                <img class="img-responsive" src="img/seic/1.jpg">
            </li>
            <li class="col-lg-4 col-md-4 col-sm-3 col-xs-4">
                <img class="img-responsive" src="img/seic/2.jpg">
            </li>
            <li class="col-lg-4 col-md-4 col-sm-3 col-xs-4">
                <img class="img-responsive" src="img/seic/3.jpg">
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