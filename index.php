<?php include ("header.php"); ?>


<!-- ======== @Region: #highlighted ======== -->

<div id="highlighted">

  <div class="inner">

    <div class="container">

      <!-- Carousel - May use standard Bootstrap markup within slides - For best results use images all the same size (in this example they are 600px x 400px) -->

      <div class="row-fluid">

        <div class="col-sm-12">

          <div id="carousel-front" class="carousel slide carousel-featured">

            <div class="carousel-inner">

              <!--Slide 1-->

              <div class="item active">


                <div class="col-sm-6 pull-center animated fadeInUpBig hidden-xs">

                  <img src="img/slides/5.jpg" alt="Imagem1" class="img-responsive hidden-xs"/>

                </div>

                <div class="col-sm-6 animated fadeInDownBig col-xs-12">

                  <div class="col-xs-12 col-sm-9 col-md-9  col-xs-offset-3 col-md-offset-3">

                   <?php include "form_login.php";?>

                 </div>

               </div>


             </div>



           </div>
           </div></div></div></div></div></div>



           <!-- ======== @Region: #content ======== -->

           <div id="content">

            <div class="container">

              <div class="row">
                <div class="mission">

                  <div class="inner">

                    <h3>Encontro de Saberes 2016 - Universidade Federal de Ouro Preto</h3>

                  </div>
                  <div>

                    <br>
                    <h4 class="text-center">Rumos da Universidade Pública</h4>
                    <br>

                    <p class="text-justify">As universidades são instituições sociais? Conjunturas políticas e econômicas podem afetar o ensino, a pesquisa e a extensão: para melhor ou para pior? A qualidade da universidade depende da sua capacidade de se adaptar ao contexto? Toda turbulência externa merece ação interna? A universidade deve trilhar seus caminhos com atenção às novidades cotidianas e às sabedorias da história?</p>
                    <a href="rumos_universidade.php" class="btn btn-danger">Leia mais</a>

                    <hr>
                  </div>

                </div>

                <div class="block portfolio">

                  <ul class="thumbnails row projects">

                    <li class="col-md-4">

                      <div>
                        <h3 class="title">

                          <a href="seic.php">SEIC</a>

                          <small class="pull-right"></small>

                        </h3><br />

                        <div class="project" style="height: 480px;">

                          <a class="lnk-polaroid" href="seic.php">

                            <img src="img/proreitorias/propp.png" alt="Propp" class="img-responsive" />

                          </a><br />
                          <?php
                          $max = 585;
                          $str = "O SEIC tem por objetivo promover o interc&acirc;mbio entre estudantes de gradua&ccedil;&atilde;o que participam de Programas de Inicia&ccedil;&atilde;o Cient&iacute;fica em Institui&ccedil;&otilde;es de Ensino e Pesquisa, p&uacute;blicas ou privadas, em todas as &aacute;reas de conhecimento. A import&acirc;ncia do SEIC no desenvolvimento da pesquisa na UFOP se reflete no aumento crescente de projetos de inicia&ccedil;&atilde;o cient&iacute;fica, sendo que muitos desses projetos t&ecirc;m sido embri&otilde;es para projetos mais sofisticados de p&oacute;s-gradua&ccedil;&atilde;o.";

                          ?>

                          <p class="text-justify"><?= substr_replace($str, (strlen($str) > $max ? '...' : ''), $max); ?></p>
                          <a href="seic.php" class="btn btn-danger">Saiba mais</a>

                        </div>

                      </div>

                    </li>


                    <li class="col-md-4 ">

                      <div>
                        <h3 class="title">

                          <a href="sext.php">SEXT</a>

                          <small class="pull-right"></small>

                        </h3><br />

                        <div class="project" style="height: 480px;">

                          <a class="lnk-polaroid" href="sext.php">

                            <img src="img/proreitorias/proex.jpg" alt="Proex" class="img-responsive" />

                          </a><br />

                          <?php
                          $max = 590;
                          $str = "A Extensão Universitária apresenta-se, no cenário nacional, reconhecida, sob o princípio constitucional da indissociabilidade entre ensino, pesquisa e extensão e mediante de debates no 27º e 28º Encontros Nacionais de Pró-Reitores de Extensão das Universidades Públicas Brasileiras, realizados em 2009 e 2010 foi reconhecida como um processo interdisciplinar, educativo, cultural, científico e político que promove a interação transformadora entre Universidade e outros setores da sociedade.";

                          ?>

                          <p class="text-justify"><?= substr_replace($str, (strlen($str) > $max ? '...' : ''), $max); ?></p>
                          <a href="sext.php" class="btn btn-danger">Saiba mais</a>

                        </div>

                      </div>

                    </li>


                    <li class="col-md-4 ">

                      <div>
                        <h3 class="title">

                          <a href="proativa.php">Mostra Pr&oacute;-Ativa</a>

                          <small class="pull-right"></small>

                        </h3><br />

                        <div class="project" style="height: 480px;">

                          <a class="lnk-polaroid" href="proativa.php">

                            <img src="img/proreitorias/prograd.png" alt="Prograd" class="img-responsive" />

                          </a><br />
                          <?php
                          $max = 625;
                          $str = "O programa Pró-Ativa, criado em 1999, é uma ação inovadora da Pró-Reitoria de Graduação (PROGRAD) destinado a contribuir para a melhoria do ensino de graduação por meio de Projetos relacionados,principalmente, ao desenvolvimento de metodologias e tecnologias de apoio aprendizagem; à elaboração e organização de materiais e coleções didáticas de auxílio as disciplinas; ações para redução da evasão e retenção na graduação; propostas associadas ao Projetos Pedagógicos dos cursos e à temática da acessibilidade e inclusão.";

                          ?>

                          <p class="text-justify"><?= substr_replace($str, (strlen($str) > $max ? '...' : ''), $max); ?></p>
                          <a href ="proativa.php" class="btn btn-danger">Saiba mais</a>


                        </div>

                      </div>

                    </li>

                  </ul>

                </div>

                <div class="col-md-3">
                  <h4 class="title"><a href="seinter.php">SEINTER</a></h4>
                  <a href="seinter.php"><img src="img/proreitorias/caint.png" class="img-responsive text-left" alt="Logo SEINTER"/></a>
                </div>


                <div class="col-md-9 ">
                  <br><br>
                  <p class="text-justify">Pelo segundo ano, o Encontro dos Saberes, realizado pela Universidade Federal de Ouro Preto ter&aacute; um evento espec&iacute;fico dedicado &agrave; internacionaliza&ccedil;&atilde;o: O SEINTER (Semin&aacute;rio de Internacionaliza&ccedil;&atilde;o, edi&ccedil;&atilde;o 2016).</p>

                  <p class="text-justify">Um dos principais desafios do intenso processo de internacionaliza&ccedil;&atilde;o vivido pelas Universidades Federais a partir do Programa Ci&ecirc;ncia sem Fronteiras, inaugurado em 2012, refere-se aos meios de democratizar as experi&ecirc;ncias acad&ecirc;micas adquiridas pelos alunos, especialmente na gradua&ccedil;&atilde;o, que tiveram a oportunidade de estudar no exterior.</p>
                  <a href="seinter.php" class="btn btn-danger pull-right">Leia mais</a>
                </div>


                <div class="col-md-3">
                  <h4 class="title"><a href="pibid.php">Mostra PIBID UFOP</a></h4>
                  <a href="pibid.php"><img src="img/proreitorias/pibid.png" class="img-responsive text-left" alt="Logo PIBID UFOP" /></a>
                </div>

                <div class="col-md-9">
                  <br><br>
                  <p class="text-justify">O PIBID UFOP, Programa de Bolsa de Iniciação à Docência na UFOP, é um programa da Coordenação de Aperfeiçoamento de Pessoal de Nível Superior (Capes) que tem por finalidade fomentar a iniciação à docência, contribuindo para o aperfeiçoamento da formação de docentes em nível superior e para a melhoria da qualidade da educação básica pública brasileira. </p>
                  <a href="pibid.php" class="btn btn-danger pull-right">Leia mais</a>
                </div>
              </div>
              <br><br>
              <div class="row">

                <div class="col-md-3">
                  <h4 class="title"><a href="seminario.php">Mostra Monitoria</a></h4>
                  <a href="seminario.php"><img src="img/proreitorias/seminario.png" class="img-responsive text-left" alt="Logo Seminário de Monitoria" /></a>
                </div>
                <div class="col-md-9">
                  <br><br>
                  <p class="text-justify">Em 2014, a Pró-Reitoria de Graduação promoveu um seminário com o objetivo de discutir, avaliar e pensar estratégias de acompanhamento do Programa de Monitoria na UFOP.
                  </p>
                  <p class="text-justify">A partir de 2015, decidiu-se que as experiências de monitoria seriam apresentadas como relatos no Encontro de Saberes. Monitores e professores tiveram a oportunidade de dialogar nas sessões de comunicação oral sobre o que vem sendo desenvolvido no Programa, socializando iniciativas inovadoras.</p>
                  <a href="seminario.php" class="btn btn-danger pull-right">Leia mais</a>
                </div>

                <div class="col-md-3">
                  <h4 class="title"><a href="pet.php">Mostra PET</a></h4>
                  <a href="pet.php"><img src="img/proreitorias/pet.png" class="img-responsive text-left" alt="Logo Pet" /></a>

                </div>
                <div class="col-md-9">
                  <br><br>
                  <p class="text-justify">Na UFOP, o Programa de Educação Tutorial foi implantado em meados de 1992, com a criação de 5 (cinco) grupos: Nutrição, Engenharias Civil e Geológica, Farmácia e História, sendo que este último acabou sendo extinto posteriormente. Mais recentemente, em 2008 e 2009, na UFOP, foram aprovados pelo MEC/SESu, respectivamente, os Grupos PET da Matemática (Licenciatura) e o primeiro PET de Engenharia Ambiental do Brasil. Posteriormente foram criados o PET Conexão de Saberes, o PET Pedagogia e o PET Física.</p>
                  <a href="pet.php" class="btn btn-danger pull-right">Leia mais</a>
                </div>





              </div>

            </div>
          </div>



          <!-- ======== @Region: #content-below ======== -->

          <?php include "bibliotecas.php"; ?>


          <?php include ("footer.php"); ?>
