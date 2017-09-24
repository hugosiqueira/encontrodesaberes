<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais CET</span> 
				<small>Programa&ccedil;&atilde;o</small>
			</h2>
		</div>
	</div>
</div>

<div id="content">
	<div class="container" style="overflow: hidden;">
		<div class="row">
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			<strong>Aten&ccedil;&atilde;o!</strong> A programa&ccedil;&atilde;o poder&aacute; sofrer altera&ccedil;&otilde;es at&eacute; a data do evento.
		</div>
		<div class="alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>  As apresenta&ccedil;&otilde;es ter&atilde;o 10 minutos e 5 minutos de debate.
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
						<tr class="danger">
							<th></th>
							<th>Data</th>
							<th>Horário</th>
							<th>Local</th>
							<th>Apresentador</th>
							<th>Título</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>SAMIRA OLIVEIRA REIS RODRIGUES</td>
							<td>NOVO M&Eacute;TODO DE S&Iacute;NTESE E CARACTERIZA&Ccedil;&Atilde;O DE NANOPART&Iacute;CULAS DE MAGNETITA OBTIDAS POR REDU&Ccedil;&Atilde;O DA HEMATITA COM SACAROSE PARA USO EM TRATAMENTO HIPERT&Eacute;RMICO</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>STEFANI CAROLINE TELES</td>
							<td>NOVO M&Eacute;TODO DE S&Iacute;NTESE E CARACTERIZA&Ccedil;&Atilde;O DE NANOPART&Iacute;CULAS DE MAGNETITA OBTIDAS POR REDU&Ccedil;&Atilde;O DA HEMATITA COM SACAROSE PARA USO EM TRATAMENTO HIPERT&Eacute;RMICO</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>ARIANE MARIA ARLINDO DE SOUZA</td>
							<td>INFLU&Ecirc;NCIA DA ADI&Ccedil;&Atilde;O DE PLASTIFICANTES NA CIN&Eacute;TICA DE FOTODEGRADA&Ccedil;&Atilde;O DE POL&Iacute;MEROS LUMINESCENTES: APLICA&Ccedil;&Atilde;O EM DOSIMETRIA DE RADIA&Ccedil;&Otilde;ES</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>RAFAELA MARIA QUEIROZ SILVA</td>
							<td>S&Iacute;NTESE E CARACTERIZA&Ccedil;&Atilde;O DE MATERIAIS PARA APLICA&Ccedil;&Otilde;ES AMBIENTALMENTE SEGURAS EM REMO&Ccedil;&Atilde;O DE &Acirc;NIONS</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>MAIRA VIEIRA DA SILVA</td>
							<td>DESENVOLVIMENTO DE BIOSSORVENTE DE CABELO HUMANO PARA ADSOR&Ccedil;&Atilde;O DE ARS&Ecirc;NIO E MERC&Uacute;RIO</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>MARIANA PIEROTTI DE SOUZA</td>
							<td>OZONIZA&Ccedil;&Atilde;O NO TRATAMENTO DE F&Aacute;RMACOS EM &Aacute;GUA: IDENTIFICA&Ccedil;&Atilde;O E AVALIA&Ccedil;&Atilde;O DA TOXIDADE DOS PRODUTOS DA DEGRADA&Ccedil;&Atilde;O</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>ANA LUISA DA SILVA LAGE MOREIRA</td>
							<td>S&Iacute;NTESE DE BAGA&Ccedil;OS DE CANA BI-FUNCIONALIZADOS IN&Eacute;DITOS PARA ADSOR&Ccedil;&Atilde;O DE METAIS PESADOS E OXI&Acirc;NIONS EM SOLU&Ccedil;&Atilde;O AQUOSA</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>Sala C</td>
							<td>HERCULES GIDEL LUCENA DE SOUSA</td>
							<td>POLIGLICEROL NO PREPARO DE MICRO E/OU NANOPART&Iacute;CULAS PARA LIBERA&Ccedil;&Atilde;O CONTROLADA DE C&Aacute;TIONS MET&Aacute;LICOS</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>Sala C</td>
							<td>ARETA FERREIRA ALVES</td>
							<td>MONITORAMENTO DE MODELOS DE CLASSIFICA&Ccedil;&Atilde;O DE RISCOS</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>Sala C</td>
							<td>ANGELO PINHEIRO BORGES</td>
							<td>DETEC&Ccedil;&Atilde;O DE CLUSTERS ESPACIAIS DE HOMIC&Iacute;DIOS CAUSADOS POR ARMA DE FOGO ATRAV&Eacute;S DA ESTAT&Iacute;STICA SCAN ESPACIAL SELETIVA</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>Sala C</td>
							<td>JOSUE BORTOLINI SETTE DA SILVA</td>
							<td>DESEMPENHO DE CARTAS DE CONTROLE PARA MEDIDAS INDIVIDUAIS BASEADAS EM PROCEDIMENTOS BOOTSTRAP.</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>Sala C</td>
							<td>Sandro Geraldo Alves Sobreira</td>
							<td>ESTRATEGIAS EVOLUTIVAS PARA PROBLEMAS DE OTIMIZA&Ccedil;&Atilde;O MULTIOBJETIVO</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>Sala C</td>
							<td>AMANDA EUGENIA COSTA</td>
							<td>DESENVOLVIMENTO DE ADSORVENTES MAGN&Eacute;TICOS PARA REMO&Ccedil;&Atilde;O DE MN2+ DE<br />
								EFLUENTE DA FABRICA&Ccedil;&Atilde;O DE LIGAS FERRO-MANGANES</td>
							</tr>
							<tr>
								<td>6</td>
								<td>QUARTA-FEIRA 18/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>Sala C</td>
								<td>DAVI DALFIOR BALTAR</td>
								<td>UMA ESTRAT&Eacute;GIA DE ACEITA&Ccedil;&Atilde;O TARDIA EM SUBIDA DA ENCOSTA PARA O PROBLEMA DE ESCALONAMENTO DE M&Uacute;LTIPLOS PROJETOS COM M&Uacute;LTIPLOS MODOS E RESTRI&Ccedil;&Atilde;O DE RECURSOS</td>
							</tr>
							<tr>
								<td>7</td>
								<td>QUARTA-FEIRA 18/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>Sala C</td>
								<td>WASHINGTON SENA DE FRANCA E SILVA</td>
								<td>VISUAL TERRAME: UM AMBIENTE DE PROGRAMA&Ccedil;&Atilde;O VISUAL PARA DESENVOLVIMENTO E SIMULA&Ccedil;&Atilde;O DE MODELOS GEOESPACIAIS</td>
							</tr>
							<tr>
								<td>8</td>
								<td>QUARTA-FEIRA 18/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>Sala C</td>
								<td>ANNA CECILIA COTTA NADER</td>
								<td>OTIMIZA&Ccedil;&Atilde;O DE PROCEDIMENTO ANAL&Iacute;TICO PARA DETERMINA&Ccedil;&Atilde;O DE OURO USANDO CIANETA&Ccedil;&Atilde;O, CONCENTRA&Ccedil;&Atilde;O EM CARV&Atilde;O ATIVADO E DETERMINA&Ccedil;&Atilde;O POR FLUORESC&Ecirc;NCIA DE RAIO-X</td>
							</tr>
							<tr>
								<td>1</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>JUNIOR RHIS LIMA</td>
								<td>ALGORITMOS HEUR&Iacute;STICOS E METAHEUR&Iacute;STICOS PARA O PROBLEMA DE MINIMIZA&Ccedil;&Atilde;O DE PILHAS ABERTAS</td>
							</tr>
							<tr>
								<td>2</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>MICHELE MARCIA DE SOUZA</td>
								<td>PADR&Otilde;ES DE MICROTRAMA EM GRANIT&Oacute;IDES PR&Eacute; A SIN-COLISIONAIS: A HIST&Oacute;RIA EVOLUTIVA DA SUPERSU&Iacute;TE G1, ARCO MAGM&Aacute;TICO RIO DOCE, OR&Oacute;GENO ARA&Ccedil;UA&Iacute;.</td>
							</tr>
							<tr>
								<td>3</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>SUELLEN ALIANI LOPES</td>
								<td>MODIFICA&Ccedil;&Atilde;O QU&Iacute;MICA DO POLIETILENOGLICOL E SEU USO NA LIBERA&Ccedil;&Atilde;O CONTROLADA DE F&Aacute;RMACOS</td>
							</tr>
							<tr>
								<td>4</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>MARIANA SAMPAIO RODRIGUES DE LIMA</td>
								<td>A APLICA&Ccedil;&Atilde;O DA CAT&Aacute;LISE POR &Aacute;CIDOS NO DESENVOLVIMENTO DE PROCESSO PARA O BENEFICIAMENTO DE DERIVADOS DE &Oacute;LEOS ESSENCIAIS</td>
							</tr>
							<tr>
								<td>5</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>RAYANE ROCHA SILVA</td>
								<td>VALORIZA&Ccedil;&Atilde;O DE COMPOSTOS TERP&Ecirc;NICOS VIA TRANSFORMA&Ccedil;&Otilde;ES CATAL&Iacute;TICAS</td>
							</tr>
							<tr>
								<td>6</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>FILIPPE OVIDIO FERREIRA</td>
								<td>INVESTIGA&Ccedil;&Atilde;O DOS TIPOS DE BORDAS DE GR&Atilde;OS EST&Aacute;VEIS EM FORMA&Ccedil;C&Otilde;ES FERR&Iacute;FERAS E SUAS IMPLICA&Ccedil;C&Otilde;ES NOS PROCESSOS DE LIBERA&Ccedil;&Atilde;O MINERAL</td>
							</tr>
							<tr>
								<td>7</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>VINICIUS MAURICIO DE ALMEIDA</td>
								<td>ACOMPANHAMENTO AUT&Ocirc;NOMO DE ALVOS M&Oacute;VEIS ATRAV&Eacute;S DE UM VANT - VE&Iacute;CULO A&Eacute;REO N&Atilde;O TRIPULADO</td>
							</tr>
							<tr>
								<td>8</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>08:00 - 10:00</td>
								<td>Sala C</td>
								<td>ISABELLA FERREIRA DE OLIVEIRA</td>
								<td>ACOMPANHAMENTO AUT&Ocirc;NOMO DE ALVOS M&Oacute;VEIS ATRAV&Eacute;S DE UM VANT - VE&Iacute;CULO A&Eacute;REO N&Atilde;O TRIPULADO</td>
							</tr>
							<tr>
								<td>1</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>FILIPE EDUARDO MATA DOS SANTOS</td>
								<td>DESENVOLVIMENTO E VALIDA&Ccedil;&Atilde;O DE UM SERVI&Ccedil;O DE BUSCA NA WEB POR DOCUMENTOS SIMILARES AOS TRABALHOS CATALOGADOS NA BIBLIOTECA DIGITAL DO CURSO DE CI&Ecirc;NCIA DA COMPUTA&Ccedil;&Atilde;O DA UNIVERSIDADE FEDERAL DE OURO PRETO</td>
							</tr>
							<tr>
								<td>2</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>CEZAR AUGUSTO NASCIMENTO E SILVA</td>
								<td>DIAGRAMA&Ccedil;&Atilde;O DE GRAFOS UTILIZANDO INTELIG&Ecirc;NCIA COMPUTACIONAL</td>
							</tr>
							<tr>
								<td>3</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>VICTOR LUIZ GUIMARAES</td>
								<td>PLANEJAMENTO OPERACIONAL DE LAVRA: UM ESTUDO DE CASO &ndash; PARTE III</td>
							</tr>
							<tr>
								<td>4</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>JANDEILSON ROLDAO BORGES</td>
								<td>RADIALIZE: UMA FERRAMENTA PARA DESCOBERTA DE CONTE&Uacute;DO EM &Aacute;UDIO NA WEB.</td>
							</tr>
							<tr>
								<td>5</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>JOSE ESTEVAO EUGENIO DE RESENDE</td>
								<td>MUSICOLLA: PLATAFORMA M&Oacute;VEL COLABORATIVA PARA REPRODU&Ccedil;&Atilde;O DE CONTE&Uacute;DO MULTIM&Iacute;DIA EM REDES AD HOC</td>
							</tr>
							<tr>
								<td>6</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>HENRIQUE COTA CAMELLO</td>
								<td>COMPONENTES PARA MONITORAMENTO E PUBLICA&Ccedil;&Atilde;O PERI&Oacute;DICA DE DADOS COLETADOS POR SENSORES EMBARCADOS EM DISPOSITIVOS M&Oacute;VEIS.</td>
							</tr>
							<tr>
								<td>7</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>Joao Vitor Quintao Mattos</td>
								<td>COLLA: UMA PLATAFORMA COLABORATIVA PARA PROGRAMADORES DE COMPUTADOR E TOMADORES DE DECIS&Atilde;O</td>
							</tr>
							<tr>
								<td>8</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>Sala C</td>
								<td>Diogo Matos da Silva</td>
								<td>COLLA: UMA PLATAFORMA COLABORATIVA PARA PROGRAMADORES DE COMPUTADOR E TOMADORES DE DECIS&Atilde;O.</td>
							</tr>
							<tr>
								<td>1</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>Sala C</td>
								<td>Joao Henrique Rocha Matos</td>
								<td>PROT&Oacute;TIPOS DE DISPOSITIVOS OPTOELETR&Ocirc;NICOS PARA MAXIMIZAR A DEGRADA&Ccedil;&Atilde;O DA BILIRRUBINA</td>
							</tr>
							<tr>
								<td>2</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>Sala C</td>
								<td>EMYLLE EMEDIATO SANTOS</td>
								<td>DESENVOLVIMENTO E APLICA&Ccedil;&Atilde;O DE BIOMASSA VEGETAL NA REMO&Ccedil;&Atilde;O DE &Iacute;ONS MET&Aacute;LICOS DE EFLUENTES</td>
							</tr>
							<tr>
								<td>3</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>Sala C</td>
								<td>PAULO HENRIQUE DE ALMEIDA</td>
								<td>DESENVOLVIMENTO DE UMA ABORDAGEM EVOLUTIVA H&Iacute;BRIDA COM VARIABLE NEIGHBOURHOOD SEARCH E T&Eacute;CNICAS DE ESCALONAMENTO RANKING PARA MANUTEN&Ccedil;&Atilde;O DE DIVERSIDADE EM ALGORITMOS MEM&Eacute;TICOS PARA O PROBLEMA DA MOCHILA: OPERADORES DE SELE&Ccedil;&Atilde;O</td>
							</tr>
							<tr>
								<td>4</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>Sala C</td>
								<td>GABRIEL FRANCISCO ALVES MATEUS</td>
								<td>CARACTERIZA&Ccedil;&Atilde;O MEC&Acirc;NICA E EL&Eacute;TRICA DE SENSORES DE PRESS&Atilde;O DE BAIXO CUSTO</td>
							</tr>
							<tr>
								<td>5</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>Sala C</td>
								<td>THAIS DHAIANY DA SILVA</td>
								<td>INFLU&Ecirc;NCIA DO USO DE ADITIVOS NA POLIMERIZA&Ccedil;&Atilde;O DO &Oacute;LEO DE MORINGA OLEIFERA</td>
							</tr>
							<tr>
								<td>6</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>Sala C</td>
								<td>VICTOR LEONE DE OLIVEIRA</td>
								<td>DESENVOLVIMENTO DE NOVOS FOTOCATALISADORES BASEADOS EM FERRO PARA REMO&Ccedil;&Atilde;O DE<br />
									CONTAMINANTES EMERGENTES EM &Aacute;GUA</td>
								</tr>
								<tr>
									<td>7</td>
									<td>QUINTA-FEIRA 19/11/2015</td>
									<td>13:30 - 15:30</td>
									<td>Sala C</td>
									<td>GLEICEKELLY SILVA COELHO</td>
									<td>APLICA&Ccedil;&Atilde;O DA REA&Ccedil;&Atilde;O DE HECK NA S&Iacute;NTESE DE NOVOS AN&Aacute;LOGOS DE NUCLE&Oacute;SIDOS</td>
								</tr>
								<tr>
									<td>1</td>
									<td>QUINTA-FEIRA 19/11/2015</td>
									<td>16:00 - 18:00</td>
									<td>Sala C</td>
									<td>CAMILA BARBARA PENA</td>
									<td>DESENVOLVIMENTO DE UM CARTUCHO PARA MICRO EXTRA&Ccedil;&Atilde;O SELETIVA E ESPEC&Iacute;FICA EM FASE S&Oacute;LIDA PARA O &Aacute;CIDO S &ndash; PHENYL MERCAPT&Uacute;RIO UTILIZANDO TECNOLOGIA DE IMPRESS&Atilde;O MOLECULAR</td>
								</tr>
								<tr>
									<td>2</td>
									<td>QUINTA-FEIRA 19/11/2015</td>
									<td>16:00 - 18:00</td>
									<td>Sala C</td>
									<td>ROMEU MARRA NETO GIARDINI</td>
									<td>DESENVOLVIMENTO DE UM M&Eacute;TODO ECONOMICAMENTE VI&Aacute;VEL PARA REMO&Ccedil;&Atilde;O DE FLUORETO DE &Aacute;GUAS SUBTERR&Acirc;NEAS</td>
								</tr>
								<tr>
									<td>3</td>
									<td>QUINTA-FEIRA 19/11/2015</td>
									<td>16:00 - 18:00</td>
									<td>Sala C</td>
									<td>JULIA CRISTINA SOARES</td>
									<td>MATERIAIS CER&Acirc;MICOS ELETR&Ocirc;NICOS NANOESTRUTURADOS PARA APLICA&Ccedil;&Atilde;O EM DISPOSITIVOS LUMINESCENTES</td>
								</tr>
								<tr>
									<td>4</td>
									<td>QUINTA-FEIRA 19/11/2015</td>
									<td>16:00 - 18:00</td>
									<td>Sala C</td>
									<td>DALILA RODRIGUES BAESSO</td>
									<td>DESENVOLVIMENTO DE NOVAS T&Eacute;CNICAS DE EXTRA&Ccedil;&Atilde;O E AN&Aacute;LISE POR GC-MS DO EXTRATO DAS FLORES DE ROSA ALBA L.</td>
								</tr>
								<tr>
									<td>5</td>
									<td>QUINTA-FEIRA 19/11/2015</td>
									<td>16:00 - 18:00</td>
									<td>Sala C</td>
									<td>ALINE XAVIER FIDENCIO</td>
									<td>DESENVOLVIMENTO DE T&Eacute;CNICAS DE CLASSIFICA&Ccedil;&Atilde;O HIER&Aacute;RQUICA PARA PREDI&Ccedil;&Atilde;O DE FUN&Ccedil;&Otilde;ES DE PROTE&Iacute;NAS</td>
								</tr>
								<tr>
									<td>6</td>
									<td>QUINTA-FEIRA 19/11/2015</td>
									<td>16:00 - 18:00</td>
									<td>Sala C</td>
									<td>THAIS MARA ANASTACIO OLIVEIRA</td>
									<td>RACIOC&Iacute;NIO ANAL&Oacute;GICO E MODELAGEM NO ENSINO DE QU&Iacute;MICA</td>
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
			{ "sClass": "text-center text-uppercase", "sWidth": "3%"  },
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
			table.column(5).search( this.value ).draw();
		} );
		</script>
		<?php include ("footer.php"); ?>
		