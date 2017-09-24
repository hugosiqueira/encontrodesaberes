<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais Mostra Pró-Ativa</span> 
				<small>Programa&ccedil;&atilde;o</small>
			</h2>
		</div>
	</div>
</div>

<div id="content">
	<div class="container" style="overflow: hidden;">
		<div class="row">
			<div class="alert alert-danger">
				<strong>Aten&ccedil;&atilde;o!</strong> A programa&ccedil;&atilde;o poder&aacute; sofrer altera&ccedil;&otilde;es at&eacute; a data do evento.
			</div>
			<div class="alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
				<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>  Caso deseje baixar a programação em PDF <a href="apresentacoes_pet_2016.pdf">clique aqui.</a>
			</div>
			<div class="col-md-6">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Pesquisar Apresentações</h3>
					</div>
					<div class="panel-body">
						<div class="col-md-12">
							<div class="row">
								<div class="form-group col-md-12">
									<label for="apresentador">Apresentador</label>
									<input type="text" class='form-control' id="apresentador" />
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="titulo">Título</label>
									<input type="text" class='form-control' id="titulo" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive">
				<table id="apresentacoes" class="table table-striped table-bordered display select" style="width:99%">
						<thead>
							<tr>
								<td width="77">DATA</td>
								<td width="145">HORARIO</td>
								<td width="179">LOCAL</td>
								<td width="342">TRABALHO</td>
								<td width="422">APRESENTADOR</td>
							</tr>
						</thead>


						<tbody>
							<tr>
								<td width="77">23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">A UTILIZA&Ccedil;&Atilde;O DE UM MANUAL COM OS MODELOS DE GEST&Atilde;O DO CONHECIMENTO PARA O AUXILIO DO PROCESSO DE ENSINO-APRENDIZAGEM.</td>
								<td width="422">LAURO HENRIQUE MOTTA PRANDINI</td>
							</tr>
		
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">ADEQUA&Ccedil;&Atilde;O DE BANCADAS DID&Aacute;TICAS DE CONTROLE E AUTOMA&Ccedil;&Atilde;O DE PROCESSOS</td>
								<td width="422">LUCAS MANUEL FONSECA OLIVEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">AMPLIA&Ccedil;&Atilde;O DA COLE&Ccedil;&Atilde;O DE MICROF&Oacute;SSEIS DO ACERVO DO LABORAT&Oacute;RIO DE PALEONTOLOGIA DO DEPARTAMENTO DE GEOLOGIA DA UFOP</td>
								<td width="422">MARIANA LETICIA CAIXETA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">AN&Aacute;LISE CURRICULAR DAS EMENTAS DO CICLO B&Aacute;SICO DAS ENGENHARIAS USANDO TEORIA DE REDES COMPLEXAS</td>
								<td width="422">SUZANE FERREIRA PINTO, LARISSA MENDES SOARES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">APERFEI&Ccedil;OAMENTO E CRIA&Ccedil;&Atilde;O DE NOVAS PR&Aacute;TICAS PARA A DISCIPLINA MIN258</td>
								<td width="422">MARIANA BATISTA LOBATO, FERNANDA PARREIRAS DE PAULA DIAS</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">APLICA&Ccedil;&Atilde;O DE UM SOFTWARE GRATUITO PARA ENSINO DOS CONCEITOS DE ENGENHARIA DE CONTROLE</td>
								<td width="422">LUCAS DE GODOI TEIXEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">CATALOGA&Ccedil;&Atilde;O E REPOSI&Ccedil;&Atilde;O DO ACERVO DE AMOSTRAS/L&Acirc;MINAS DELGADAS DO CURSO DE PETROLOGIA MAGM&Aacute;TICA &ndash; GEO232</td>
								<td width="422">THIAGO CRISPIM FAUSTINO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE APPLETS PARA AUXILIAR O ENSINO DO CURSO DE EENGENHARIA EL&Eacute;TRICA</td>
								<td width="422">VINICIUS DA SILVA LANZIOTTI</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE METODOLOGIAS DE APOIO &Agrave; APRENDIZAGEM NO CURSO DE ENGENHARIA DE CONTROLE E AUTOMA&Ccedil;&Atilde;O</td>
								<td width="422">HIGOR PEREIRA LOPES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE M&Oacute;DULOS DID&Aacute;TICOS PARA ENSINO DE AN&Aacute;LISE E CONTROLE DE SISTEMAS DIN&Acirc;MICOS SUJEITOS &Agrave; INCERTEZA</td>
								<td width="422">NATALIA AUGUSTO KELES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE TUTORIAL E CO-AUTORULA&Ccedil;&Atilde;O NO SOFTWARE PLANTDESIGNER</td>
								<td width="422">VITOR KENDY VATANABLE</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE UM SISTEMA DE REGISTO, CONTROLE E AVALIA&Ccedil;&Atilde;O DE PLANO DE ENSINO</td>
								<td width="422">DEIVYSON BRUNO SILVA RIBEIRO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">CULTURA CIENT&Iacute;FICA E COMUNICA&Ccedil;&Atilde;O P&Uacute;BLICA DA CI&Ecirc;NCIA: INTERFACES DA ATUA&Ccedil;&Atilde;O DO LICENCIADO EM F&Iacute;SICA</td>
								<td width="422">LUCAS DRUMOND DE MAGALHAES CABRAL</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DESENVOLVIMENTO DE RECURSOS MEDIACIONAIS PARA ABORDAGEM DE ENSINO</td>
								<td width="422">ALEXANDRE CARDOSO BALBINO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">EXPERIMENTOS DE F&Iacute;SICA RELACIONADOS &Agrave; ARQUITETURA</td>
								<td width="422">LETICIA ROSSETTI PEREIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">IMPACTOS DO ALTO &Iacute;NDICE DE REPROVA&Ccedil;&Atilde;O NA DISCIPLINA C&Aacute;LCULO DIFERENCIAL E INTEGRAL PARA ALUNOS, PROFESSORES E A ORGANIZA&Ccedil;&Atilde;O DA GRADUA&Ccedil;&Atilde;O NA UFOP</td>
								<td width="422">CARLOS ANTONIO FELICIO TEODORO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">O USO DO SOFTWARE MATEM&Aacute;TICO (LIVRE) GEOGEBRA NO ENSINO DE C&Aacute;LCULO DIFERENCIAL E INTEGRAL I</td>
								<td width="422">MARIA LAURA COUTO COSTA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">COLETA E AN&Aacute;LISE DE DADOS PARA SUBSIDIAR A AVALIA&Ccedil;&Atilde;O DO CURSO DE BACHARELADO EM ESTAT&Iacute;STICA DA UFOP</td>
								<td width="422">GLEIZER RICHARDI PARO GARRIDO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">CONFEC&Ccedil;&Atilde;O DE APOSTILA PARA A DISCIPLINA DE QUIMICA ANAL&Iacute;TICA I</td>
								<td width="422">RODRIGO CHAVES AMARO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DESENVOLVIMENTO DE UMA APOSTILA CONTENDO TEORIA E ROTEIROS PARA AULAS PR&Aacute;TICAS DA DISCIPLINA PACOTES ESTAT&Iacute;STICOS I</td>
								<td width="422">WILSON MANOEL LOPES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">INTRODU&Ccedil;&Atilde;O A TEORIA DE PONTOS FIXOS</td>
								<td width="422">LUCAS MARTINS ROCHA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">ELABORA&Ccedil;&Atilde;O DE MATERIAL PARA AUXILIAR OS ALUNOS INGRESSANTES NO CURSO DE ESTAT&Iacute;STICA</td>
								<td width="422">MATHEUS JOSE CAMPOS GAVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">ESTUDO DA DISTRIBUI&Ccedil;&Atilde;O DOS DADOS PARA AUXILIAR NO COMBATE &Agrave; EVAS&Atilde;O NO ICEB-UFOP</td>
								<td width="422">ANA CAROLINA ROMANELLI CEOLIN</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">8:00 &ndash; 10:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">PROPOSTA DE NIVELAMENTO PARA ALUNOS INGRESSANTES NO CURSO DE QU&Iacute;MICA INDUSTRIAL</td>
								<td width="422">ISABELLA SANTIAGO SILVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">IMPLEMENTA&Ccedil;&Atilde;O DE ROTEIROS PARA A DISCIPLINA DE PRINC&Iacute;PIOS DE ELETR&Ocirc;NICA DIGITAL</td>
								<td width="422">ITALO RAFAEL DE NATAL CAMPOS</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">MATERIAL DE APOIO &Agrave; INCLUS&Atilde;O DE NOVOS SOFTWARES NAS AULAS PR&Aacute;TICAS DA DISCIPLINA DE MODELAGEM DE SISTEMAS PRODUTIVOS E LOG&Iacute;STICOS I</td>
								<td width="422">ELISA REIS DE MELLO PINTO SILVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">MATERIAL DE APOIO &Agrave;S AULAS DA DISCIPLINA ENP567-M&Eacute;TODOS ESTAT&Iacute;STICOS EM CONFIABILIDADE</td>
								<td width="422">ISABELA GORETTI SCARAMELO DE CARVALHO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">PAIN&Eacute;IS INTERATIVOS E PR&Aacute;TICOS PARA CONTROLE E AUTOMA&Ccedil;&Atilde;O POR MEIO DE PLCS</td>
								<td width="422">LUIZA SERNIZON GUIMARAES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">APOSTILA PARA AS AULAS PR&Aacute;TICAS DE QU&Iacute;MICA GERAL DO ICEA/JM: ATUALIZA&Ccedil;&Atilde;O EM RELA&Ccedil;&Atilde;O &Agrave; NOVA EMENTA IMPLEMENTADA</td>
								<td width="422">TAMIRES NUNES FERREIRA, LUCILIA ALVES LINHARES MACHADO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">IMPLEMENTA&Ccedil;&Atilde;O E APERFEI&Ccedil;OAMENTO DO BANCO DE DADOS INFORMATIZADO DO ACERVO DE AMOSTRAS DO LABORAT&Oacute;RIO DE GEOLOGIA ECON&Ocirc;MICA</td>
								<td width="422">VITOR HUGO RIOS BERNARDES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">CRIA&Ccedil;&Atilde;O DE MATERIAL GR&Aacute;FICO PARA AS DICIPLINAS PO1 E PO2</td>
								<td width="422">BRUNO MORAIS DA FONSECA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE FRAMEWORKS PARA MODELAGEM E SIMULA&Ccedil;&Atilde;O DE SISTEMAS DIN&Acirc;MICOS</td>
								<td width="422">GUILHERME BAUMGRATZ FIGUEIROA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">METODOLOGIA DE ENSINO E APRENDIZAGEM BASEADA EM SIMULA&Ccedil;&Otilde;ES COMPUTACIONAIS DE TURBINAS A G&Aacute;S PARA A ENGENHARIA MEC&Acirc;NICA</td>
								<td width="422">JOSE ARTHUR GONCALVES DA SILVA TEIXEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">PRODU&Ccedil;&Atilde;O DE V&Iacute;DEO AULA DA DISCIPLINA PROCESSAMENTO DE MINERAIS I</td>
								<td width="422">ISABELA DOS SANTOS STOPA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">EDUCA&Ccedil;&Atilde;O E T&Eacute;CNICA: ORGANIZA&Ccedil;&Atilde;O DE MATERIAL DID&Aacute;TICO PARA ESTUDO DE CANTO</td>
								<td width="422">MICHELE PFEIFFER RAFAEL DE LIMA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">EGRESSOS DO CURSO DE M&Uacute;SICA DA UFOP E MERCADO DE TRABALHO: 2002 - 2015</td>
								<td width="422">THATSOM ISNARDS SILVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">LABORAT&Oacute;RIO DE PRODU&Ccedil;&Atilde;O DO CONHECIMENTO: OS MUNDOS DA VIDA NA D&Eacute;CADA DE 1980 EM BLOG E LIVRO PRODUZIDOS POR DISCENTES DO CURSO DE HIST&Oacute;RIA</td>
								<td width="422">RAFAELA TONIN MARTINS</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">OFICINA DE RECURSOS DID&Aacute;TICOS INCLUSIVOS</td>
								<td width="422">RACHEL APARECIDA DA SILVA ARAUJO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">OFICINAS E PROJETOS PEDAG&Oacute;GICOS NO LAPP: ARTICULANDO EST&Aacute;GIOS CURRICULARES NO ENSINO FUNDAMENTAL E EDUCA&Ccedil;&Atilde;O INFANTIL</td>
								<td width="422">ELAYNE NEVES DA COSTA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">PROPOSTAS PARA A DISCIPLINA INTRODU&Ccedil;&Atilde;O AO ESTUDO DA HIST&Oacute;RIA (HIS104)</td>
								<td width="422">LARISSA KARLA GUIMARAES BRANDAO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">A AN&Aacute;LISE COLETIVA DO ESPET&Aacute;CULO TEATRAL COMO PROCEDIMENTO TRANSVERSAL PARA O ENSINO E A APRENDIZAGEM NOS CURSOS DE ARTES C&Ecirc;NICAS DO DEART/IFAC/UFOP</td>
								<td width="422">BRUNO MACIEL SOUZA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">APOSTILA TE&Oacute;RICA DE QU&Iacute;MICA GERAL "UMA PROPOSTA DIFERENCIADA DE ENSINO DA QU&Iacute;MICA PARA OS CURSOS DE ENGENHARIA DO ICEA/UFOP"</td>
								<td width="422">PATRICK TREVIZANI BARBOSA, KARLA MOREIRA VIEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DESENVOLVENDO A LINGUAGEM ACAD&Ecirc;MICA: CURSO DE REDA&Ccedil;&Atilde;O E LEITURA PARA OS ALUNOS DO CURSO DE LICENCIATURA EM HIST&Oacute;RIA</td>
								<td width="422">PLINIO CARVALHO DE SOUZA JUNIOR</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">PESQUISA E AVALIA&Ccedil;&Atilde;O DO CURSO DE BACHARELADO EM ARTES C&Ecirc;NICAS</td>
								<td width="422">ISABELA FREIRIA YEDA MACEDO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">REFLEX&Otilde;ES SOBRE O PONTO DE VISTA DE DOCENTES EGRESSOS DO CURSO DE PEDAGOGIA/ICHS/UFOP EM RELA&Ccedil;&Atilde;O AO PROCESSO DE ENSINO E DE APRENDIZAGEM DE SEUS ALUNOS POR MEIO DE REPRESENTA&Ccedil;&Atilde;O TRIDIMENSIONAL DO ESPA&Ccedil;O GEOGR&Aacute;FICO</td>
								<td width="422">ELAINE LUCIANA REIS DA SILVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">CONTE&Uacute;DOS AUDIOVISUAIS NO ENSINO DAS DISCIPLINAS SEMIPRESENCIAIS DOS CURSOS DE EDUCA&Ccedil;&Atilde;O F&Iacute;SICA DA UFOP</td>
								<td width="422">ALEXANDRE LUCAS DA SILVA PEREIRA, MATHEUS HENRIQUE DE ABREU LORETO, FRANCISCO ZACARON WERNECK, RENATO MELO FERREIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE DISCIPLINA DO CURSO DE MEDICINA PARA ADEQUA&Ccedil;&Atilde;O DA PLATAFORMA ANDROID AO ANDROID APP: UMA FERRAMENTA DE ORGANIZA&Ccedil;&Atilde;O E APOIO AO APRENDIZADO EM INTERFACE COM O MOODLE</td>
								<td width="422">DANIEL MAGALHAES NOBRE</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE APLICATIVO PARA SMARTPHONE PARA AUX&Iacute;LIO NA TOMADA DE DECIS&Otilde;ES CL&Iacute;NICAS POR ESTUDANTES DE MEDICINA</td>
								<td width="422">VICTOR HERNANDEZ CHISTE CORDEIRO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE NOVOS ROTEIROS DE PR&Aacute;TICAS ANAL&Iacute;TICAS APLICADOS &Agrave; DISCIPLINA DE TOXICOLOGIA PARA ALUNOS DO CURSO DE FARM&Aacute;CIA</td>
								<td width="422">DANILO GUIMARAES COSTA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO E IMPLANTA&Ccedil;&Atilde;O DE UM WEBSITE DE APOIO &Agrave; DISCIPLINA DE SEMIOLOGIA II (MED 129) DO CURSO DE MEDICINA DA UFOP</td>
								<td width="422">ALINE SANCHES OLIVEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">ELABORA&Ccedil;&Atilde;O DE MATERIAIS DID&Aacute;TICOS TE&Oacute;RICOS E PR&Aacute;TICOS PARA ASSIST&Ecirc;NCIA NUTRICIONAL A PACIENTES HOSPITALIZADOS</td>
								<td width="422">LIVIA DE PAULA DIAS BITENCOURT ALVES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">ELABORA&Ccedil;&Atilde;O DE UM REGISTRO FOTOGR&Aacute;FICO DOS CARD&Aacute;PIOS DE UM RESTAURANTE DE UMA UNIVERSIDADE P&Uacute;BLICA BRASILEIRA</td>
								<td width="422">IARA SAEZ ARANDA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">GUIA DE COMPLICA&Ccedil;&Otilde;ES EM CIRURGIA: PREVEN&Ccedil;&Atilde;O E TRATAMENTO-PARTE III</td>
								<td width="422">LUANA ALMEIDA SILVEIRA, FRANCISCO PATRUZ ANANIAS DE ASSIS PIRES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">PROJETOS PEDAG&Oacute;GICOS DOS CURSOS DE EDUCA&Ccedil;&Atilde;O F&Iacute;SICA: UMA VIS&Atilde;O MULTIDIMENSIONAL</td>
								<td width="422">ISADORA PENA ARAUJO, EMERSON CRUZ DE OLIVEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">TECNOLOGIAS DA INFORMA&Ccedil;&Atilde;O E COMUNICA&Ccedil;&Atilde;O NA FORMA&Ccedil;&Atilde;O M&Eacute;DICA: CONSTRU&Ccedil;&Atilde;O DE UM AMBIENTE VIRTUAL DE APRENDIZAGEM (AVA) PARA A PR&Aacute;TICA PEDAG&Oacute;GICA</td>
								<td width="422">ARTHUR VIEIRA PIAU, JOAO LUCAS DE CARVALHO GOMES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DISCIPLINA ELETIVA INGL&Ecirc;S JUR&Iacute;DICO</td>
								<td width="422">ISABELA FRANCA DE VASCONCELOS COSTA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">O TRABALHO DE CONCLUS&Atilde;O DE CURSO COMO PARTE DA FORMA&Ccedil;&Atilde;O EM SERVI&Ccedil;O SOCIAL: REVIS&Atilde;O DE CONHECIMENTOS, DESCOBERTAS E CRIA&Ccedil;&Otilde;ES POSS&Iacute;VEIS A PARTIR DA PR&Aacute;TICA INVESTIGATIVA</td>
								<td width="422">LUIZ FELIPE DE ALMEIDA MARTINS DE VASCONCELOS, RAFAELA SOUZA REIS AGUIAR, CAROLINA ALCANTARA DA COSTA PRATAROTTI, THAINA TAUFNER COSTA, DANIELE CRISTINA DE BRITO MORAIS OLIVEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">PERFIL DAS MAIORES CORPORA&Ccedil;&Otilde;ES CAPITALISTAS EM ATIVIDADE NO BRASIL NA ATUALIDADE</td>
								<td width="422">PEDRO LOPES BUI, RENATA CARDOSO GONTIJO BUI</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">POL&Iacute;TICA-PILOTO DE EGRESSOS DO CURSO DE DIREITO DA UFOP</td>
								<td width="422">PEDRO MACEDO PEREIRA MIRAS FERRON</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DIREITO, C&Acirc;MERA E A&Ccedil;&Atilde;O</td>
								<td width="422">JOAO PAULO RODRIGUES ALMEIDA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">PRATAS DA CASA E MONITORAMENTO DE EGRESSOS</td>
								<td width="422">NARAYHANE OLIVEIRA GONZAGA DELABRIDA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DESCONSTRUINDO TABUS</td>
								<td width="422">GABRIELA BARROS LUZ</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DIREITO E DIVERSIDADE</td>
								<td width="422">SAMUEL JUNIOR DA SILVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">DIREITO E LEG&Iacute;STICA</td>
								<td width="422">POLLYANNA MENDES DE ASSIS, JULIA MYSKO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">OBSERVAT&Oacute;RIO DA JURISPRUD&Ecirc;NCIA</td>
								<td width="422">MARCELO ERASMO PONTES, EDUARDO PEREIRA NOBRE, SAMUEL PAIVA COTA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">CONSTRU&Ccedil;&Atilde;O DE MODELOS DID&Aacute;TICOS PARA ENSINO COMPLEMENTAR DE BIOLOGIA CELULAR</td>
								<td width="422">FLAVIO PIGNATARO OSHIRO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">DESENVOLVIMENTO DE MATERIAL DID&Aacute;TICO SOBRE COMPONENTES DO LEITE: ASPECTOS QU&Iacute;MICOS E TECNOL&Oacute;GICOS</td>
								<td width="422">LEONARDO DE OLIVEIRA PENNA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">ELABORA&Ccedil;&Atilde;O DE APOSTILA COM ROTEIROS DE AULAS PR&Aacute;TICAS DE TECNOLOGIA DE ALIMENTOS</td>
								<td width="422">VITORIA REGINA PINTO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">ELABORA&Ccedil;&Atilde;O DE APOSTILA ILUSTRADA PARA USO NAS AULAS PR&Aacute;TICAS DE MICROBIOLOGIA DE ALIMENTOS</td>
								<td width="422">GUSTAVO HENRIQUE MOREIRA SANTOS</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">ELABORA&Ccedil;&Atilde;O DE APOSTILA PARA UTILIZA&Ccedil;&Atilde;O EM AULAS PR&Aacute;TICAS DA DISCIPLINA ALI2016-T&Eacute;CNICA DIET&Eacute;TICA</td>
								<td width="422">ANA LUIZA ALMEIDA UMBELINO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">ESTUDOS DE CASOS PARA O TRABALHO COM QUEST&Otilde;ES BIO&Eacute;TICAS RELACIONADAS &Agrave; ATIVIDADE DE MINERA&Ccedil;&Atilde;O</td>
								<td width="422">CAMILA DE PAULA DIAS</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">PRO ATIVA: DO B&Aacute;SICO AO APLICADO SE FAZ UM BOM PROFISSIONAL</td>
								<td width="422">SAMARA SILVA DE MOURA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">O HORTO BOT&Acirc;NICO DA UFOP COMO INSTRUMENTO AO APRIMORAMENTO DO ENSINO DE BOT&Acirc;NICA</td>
								<td width="422">LORENA CARLA DO NASCIMENTO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">EXPECTATIVA X REALIDADE: CONHECENDO O PERFIL DOS INGRESSANTES DO CURSO DE ADMINISTRA&Ccedil;&Atilde;O DA UFOP</td>
								<td width="422">CAROLINA DE OLIVEIRA GONCALVES</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">JORNAL LAMPI&Atilde;O: BANCO DE FONTES E MANUAL DE REDA&Ccedil;&Atilde;O</td>
								<td width="422">CAROLINE SILVA HARDT</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">ATIVISMO URBANO - NOVAS PR&Aacute;TICAS DE PRODU&Ccedil;&Atilde;O DO ESPA&Ccedil;O</td>
								<td width="422">LUIS ROBERTO ALFONSO PRADO JUNIOR</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">O COMPROMISSO E A PERMAN&Ecirc;NCIA DOS ESTUDANTES MEMBROS DE EJS DOS CURSOS DE GRADUA&Ccedil;&Atilde;O</td>
								<td width="422">LAIS CRISTINA FARIA CORDEIRO, LUIZ FELIPE PINHEIRO TRINDADE ZANETTI</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">UMA AN&Aacute;LISE DO PERCURSO DOS EGRESSOS DAS LETRAS/PER&Iacute;ODO 2005-2015</td>
								<td width="422">JULIANA MOREIRA DE SOUSA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">ACERVO DE JORNAIS MARIANENSES DO S&Eacute;CULO XIX E XX PARA O ENSINO E PESQUISA NO CURSO DE LETRAS E &Aacute;REAS AFINS</td>
								<td width="422">GUILHERME DE CARVALHO EUZEBIO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">AUDIOVISUAL.UFOP.BR</td>
								<td width="422">ANA AMELIA DE MELO MACIEL</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">A INSER&Ccedil;&Atilde;O DE MATERIAL DID&Aacute;TICO BASE PARA O ESTUDO DA DISCIPLINA DIREITO DO CONSUMIDOR: ANOTA&Ccedil;&Otilde;ES DOS ARTIGOS 1&ordm; A 54 DO C&Oacute;DIGO DE DEFESA DO CONSUMIDOR</td>
								<td width="422">MALUHA SOARES DE MIRANDA SILVA, BARBARA FERNANDES VIEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">CARTOGRAFIAS PATRIMONIAIS: OS USOS DAS TECNOLOGIAS DE GEORREFERENCIAMENTO NO CADASTRO DE BENS CULTURAIS MATERIAIS E IMATERIAIS</td>
								<td width="422">PAULO OTAVIO DE LAIA</td>
							</tr>
						</tbody>



					</table>
				</div>
			</div>
		</div>
	</div>
	<?php include "bibliotecas.php"; ?>
	<script type="text/javascript" language="javascript" src="plugins/datatables/media/js/jquery.dataTables.min.js"></script>
	<script>
		var table = $('#apresentacoes').DataTable({
			"dom": 'T<"top"i>rt<"clear">lp',
			"order": [[ 1, "asc" ]],
			"lengthMenu": [[8, 16, -1], [8, 16, "Todas"]],
			"oLanguage": {
				"sUrl": "datables_portugues.json"
			},
			"aoColumns": [
			{ "sClass": "text-center text-uppercase", "sWidth": "13%" },
			{ "sClass": "text-center text-uppercase", "sWidth": "12%" },
			{ "sClass": "text-center text-uppercase", "sWidth": "10%" },
			{ "sClass": "text-left text-uppercase", "sWidth": "22%" },
			{ "sClass": "text-justify", "sWidth": "45%" }

			]
		});
		$('#apresentador').on( 'keyup', function () {
			table.column(4).search( this.value ).draw();
		} );
		$('#titulo').on( 'keyup', function () {
			table.column(3).search( this.value ).draw();
		} );
	</script>
	<?php include ("footer.php"); ?>
