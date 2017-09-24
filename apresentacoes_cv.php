<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais CV</span> 
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
							<td>SALA B</td>
							<td>ISABELA MATOSO LOPES</td>
							<td>POTENCIAL DA IPRIFLAVONA VEICULADA EM PREPARA&Ccedil;&Atilde;O AUTOEMULSION&Aacute;VEL NA FACILITA&Ccedil;&Atilde;O DA EXCITA&Ccedil;&Atilde;O SEXUAL DE RATAS WISTAR OVARIECTOMIZADAS CONSCIENTES.</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>THAIS LOPES VALENTIM DI PASCHOALE OSTOLIN</td>
							<td>IDENTIFICA&Ccedil;&Atilde;O DE ISOLADOS BACTERIANOS DE PLANTAS END&Ecirc;MICAS DO QUADRIL&Aacute;TERO FERR&Iacute;FERO E AN&Aacute;LISE DO POTENCIAL DESTES MICROORGANISMOS COMO PROMOTORES DE CRESCIMENTO VEGETAL</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>KARINE DE PADUA LUCIO</td>
							<td>ESTUDO COMPARATIVO DOS EFEITOS DO EXTRATO DAS FOLHAS E DA POLPA DE AMORA (MORUS NIGRA) SOBRE PAR&Acirc;METROS BIOQU&Iacute;MICOS EM SORO DE RATAS DIAB&Eacute;TICAS.</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>FLAVIA DE SOUZA MARQUES</td>
							<td>LES&Otilde;ES DO TRATO DIGEST&Oacute;RIO ASSOCIADAS A INFEC&Ccedil;&Atilde;O ORAL PELO TRYPANOSOMA CRUZI EM CAMUNDONGOS</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>MARINA EDUARDA SANTOS</td>
							<td>CORRELA&Ccedil;&Atilde;O ENTRE A ATIVIDADE ECTONUCLEOTID&Aacute;SICA DE ISOLADOS DE LEISHMANIA AMAZONENSIS E A MANIFESTA&Ccedil;&Atilde;O CL&Iacute;NICA DA DOEN&Ccedil;A</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>TATIANE MARTINS BARROS</td>
							<td>EFEITOS TOXICOGEN&Ocirc;MICOS DO COMPOSTO SILIBININA EM C&Eacute;LULAS DE TUMOR DE BEXIGA</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>KISSYLA CHRISTINE DUARTE LACERDA</td>
							<td>AVALIA&Ccedil;&Otilde;ES HISTOL&Oacute;GICAS E BIOQU&Iacute;MICAS NO F&Iacute;GADO E RINS DE RATOS DIAB&Eacute;TICOS TIPO 1 TRATADOS COM VILDAGLIPTINA ASSOCIADA A QUERCETINA.</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>TALITA ADRIANA PEREIRA</td>
							<td>EFEITOS DA DIETA RICA EM CARBOIDRATOS SIMPLES SOBRE A EXPRESS&Atilde;O DE MICRORNAS NO TECIDO ADIPOSO RETROPERITONEAL DE RATOS</td>
						</tr>
						<tr>
							<td>9</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA B</td>
							<td>SAMARA SILVA DE MOURA</td>
							<td>COORDENA&Ccedil;&Atilde;O MOTORA COM BOLA COMO CONTE&Uacute;DO DAS AULAS DE EDUCA&Ccedil;&Atilde;O F&Iacute;SICA ESCOLAR.</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA B</td>
							<td>BEATRIZ CRISTIANA DA SILVA</td>
							<td>AVALIA&Ccedil;&Atilde;O HISTOPATOL&Oacute;GICA DO F&Iacute;GADO E BA&Ccedil;O EM C&Atilde;ES NATURALMENTE INFECTADOS POR L. INFANTUM E IMUNOTRATADOS COM A VACINA LBMPL</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA B</td>
							<td>KARLA BITTENCOURT MADALENA</td>
							<td>AVALIA&Ccedil;&Atilde;O DOS COMPONENTES DA MATRIZ EXTRACELULAR EM CAMUNDONGOS EXPERIMENTALMENTE INFECTADOS COM DISTINTAS SUBPOPULA&Ccedil;&Otilde;ES DA CEPA POLICLONAL BE-78 DO TRYPANOSOMA CRUZI</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA B</td>
							<td>MARIANA CORREA DAIREL</td>
							<td>ESTUDO FLOR&Iacute;STICO E FITOSSOCIOLOGICO DE UM TRECHO DE FLORESTA MONTANA SOBRE CANGA NA APA DA CACHOEIRA DAS ANDORINHAS, OURO PRETO, MG</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA B</td>
							<td>LAYSA PENEDA SIMOES</td>
							<td>DIN&Acirc;MICA EVOLUTIVA DA HETEROCROMATINA NO GENOMA DAS FORMIGAS DO G&Ecirc;NERO MYCETOPHYLAX (MYRMICINAE: ATTINI) BASEADA NA AN&Aacute;LISE MORFOM&Eacute;TRICA DE CROMOSSOMOS</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA B</td>
							<td>Igor Pires Reis</td>
							<td>CONTRIBUI&Ccedil;&Atilde;O DE ESP&Eacute;CIES DOMINANTES NA PRODU&Ccedil;&Atilde;O E DECOMPOSI&Ccedil;&Atilde;O DE SERAPILHEIRA EM &Aacute;REAS REVEGETADAS DE MATA CILIAR</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA B</td>
							<td>TAYNARA CAROLINA LIMA</td>
							<td>EFEITOS DA CORRIDA VOLUNT&Aacute;RIA SOBRE DIFERENTES PAR&Acirc;METROS CARDIOVASCULARES EM RATOS COM HIPERTENS&Atilde;O RENOVASCULAR</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA B</td>
							<td>JESSICA LOHANE DIAS MARTINS</td>
							<td>AVALIA&Ccedil;&Atilde;O CIN&Eacute;TICA DO INFILTRADO INFLAMAT&Oacute;RIO NA PELE DE CAMUNDONGOS SENSIBILIZADOS COM DIFERENTES ADJUVANTES VACINAIS</td>
						</tr>
						
						<tr>
							<td>1</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>THAIS LOURENCO MARTINS</td>
							<td>EFEITOS DO LICOPENO NA MODULA&Ccedil;&Atilde;O DO DESEQUIL&Iacute;BRIO REDOX EM CAMUNDONGOS EXPOSTOS &Agrave; FUMA&Ccedil;A DE CIGARRO</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>LUCIENE DOS SANTOS</td>
							<td>IDENTIFICA&Ccedil;&Atilde;O DE MICRORNAS BIOMARCADORES DE OBESIDADE</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>Izadora Tabuso Vieira</td>
							<td>A GL&Acirc;NDULA ESOFAGIANA DO SCHISTOSOMA MANSONI: CARACTERIZA&Ccedil;&Atilde;O PROTE&Ocirc;MICA PARA A PROPOSI&Ccedil;&Atilde;O DE NOVOS ALVOS VACINAIS</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>Brehna Teixeira de Melo</td>
							<td>EFETIVIDADE DAS MATAS CILIARES DO RESERVAT&Oacute;RIO DE VOLTA GRANDE, UBERABA, MG, NA MANUTEN&Ccedil;&Atilde;O DAS COMUNIDADES DE ARTR&Oacute;PODES.</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>Leticia Aparecida de Figueiredo</td>
							<td>AVALIA&Ccedil;&Atilde;O DO POTENCIAL ANTIINFLAMAT&Oacute;RIO DO METOTREXATO INCORPORADO EM IMPLANTES POLIM&Eacute;RICOS.</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>SILVIA ELVIRA BARROS FARIAS</td>
							<td>A INTERFER&Ecirc;NCIA DO TRATAMENTO COM SINVASTATINA NO PROCESSO INFLAMAT&Oacute;RIO DA OBESIDADE NA INFEC&Ccedil;&Atilde;O EXPERIMENTAL PELO TRYPANOSOMA CRUZI</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>LUCIANA NEVES FARIA</td>
							<td>DETERMINA&Ccedil;&Atilde;O DE PAR&Acirc;METROS HEMODIN&Acirc;MICOS E DE BALAN&Ccedil;O HIDROELETROL&Iacute;TICO EM RATOS EXPOSTOS &Agrave;S RESTRI&Ccedil;&Atilde;O PROTEICA PERINATAL E ALIMENTADOS COM DIETA CONTENDO ALTOS TEORES DE SAL.</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA B</td>
							<td>JORGE FERNANDO DE SOUZA SILVA</td>
							<td>INFLU&Ecirc;NCIA DO EXTRATO DE URUCUM E DO &Beta;-CAROTENO NA MODULA&Ccedil;&Atilde;O DO ESTRESSE OXIDATIVO EM C&Eacute;LULAS SK-HEP1</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA B</td>
							<td>ANA PAULA GOMES PEREIRA</td>
							<td>EFEITO DO CONSUMO DA POLPA DE A&Ccedil;A&Iacute; (EUTERPE OLERACEA MART) SOBRE AS CONCENTRA&Ccedil;&Otilde;ES DE ADIPOCINAS (LEPTINA E ADIPONECTINA) E O PADR&Atilde;O ALIMENTAR EM MULHERES EUTR&Oacute;FICAS E COM EXCESSO DE PESO.</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA B</td>
							<td>CRISTIANE BARBOSA ALECRIM</td>
							<td>EFEITO DO CONSUMO DA POLPA DE A&Ccedil;A&Iacute; (EUTERPE OLERACEA MART.) SOBRE A VIA DE SINALIZA&Ccedil;&Atilde;O DO NF-&Kappa;&Beta; EM MULHERES COM PESO NORMAL E COM EXCESSO DE PESO: UM ESTUDO PILOTO</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA B</td>
							<td>BARBARA MAPPA FAGUNDES</td>
							<td>DESENVOLVIMENTO DE NOVOS PRODUTOS: IOGURTE CONCENTRADO SALGADO ADICIONADO DE ESPECIARIAS</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA B</td>
							<td>HENRIQUE MARTINS ARANDA CALDEIRA</td>
							<td>AVALIA&Ccedil;&Atilde;O DOS N&Uacute;CLEOS ENCEF&Aacute;LICOS NA RESPOSTA AO ESTRESSE EMOCIONAL EM RATAS<br />
								SUBMETIDAS A RESTRI&Ccedil;&Atilde;O ALIMENTAR</td>
							</tr>
							<tr>
								<td>5</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>SALA B</td>
								<td>LUCAS WENDELL DA CRUZ</td>
								<td>INFLU&Ecirc;NCIA DE NEUR&Ocirc;NIOS CONTRALATERAIS DO HIPOT&Aacute;LAMO DORSOMEDIAL SOBRE AS RESPOSTAS CARDIOVASCULARES PRODUZIDAS PELA ATIVA&Ccedil;&Atilde;O DESTA REGI&Atilde;O EM RATOS WISTAR</td>
							</tr>
							<tr>
								<td>6</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>SALA B</td>
								<td>FREDERICO PRADO ABREU</td>
								<td>AN&Aacute;LISE COMPARATIVA DOS EFEITOS OXIDANTES DOS MODOS VENTILAT&Oacute;RIOS CONTROLADOS A VOLUME E A PRESS&Atilde;O</td>
							</tr>
							<tr>
								<td>7</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>SALA B</td>
								<td>JAQUELYNE ADELYNA SARA LUANA FERREIRA DA SILVA</td>
								<td>EFEITO DO CONSUMO DE FRUTOSE SOBRE A ATIVIDADE DA ENZIMA PARAOXONASE E DANOS OXIDATIVOS EM TECIDO HEP&Aacute;TICO MURINO E POSS&Iacute;VEIS EFEITOS PROTETORES DO A&Ccedil;A&Iacute;.</td>
							</tr>
							<tr>
								<td>8</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>10:30 - 12:30</td>
								<td>SALA B</td>
								<td>JULIA ROSSI E SILVA</td>
								<td>AVALIA&Ccedil;&Atilde;O DO POTENCIAL HIPOCOLESTEROL&Ecirc;MICO DO P&Oacute; DA FOLHA DE AMORA PRETA (M. NIGRA)EM RATAS HIPERCOLESTEROL&Ecirc;MICAS.</td>
							</tr>
							<tr>
								<td>1</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>LUCAS ROCHA DELATORRE</td>
								<td>CONDICIONALIDADES DO PROGRAMA BOLSA FAM&Iacute;LIA NA SA&Uacute;DE E EDUCA&Ccedil;&Atilde;O E IMPACTO NO ESTADO NUTRICIONAL EM OURO PRETO, MG, NO PER&Iacute;ODO DE 2008 ANO 2013</td>
							</tr>
							<tr>
								<td>2</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>AMANDA FREIRE VIEIRA</td>
								<td>PREVAL&Ecirc;NCIA DA LEISHMANIOSE VISCERAL CANINA (LVC) NO MUNIC&Iacute;PIO DE OURO PRETO, MINAS GERAIS, POR M&Eacute;TODOS COMBINADOS DE DIAGN&Oacute;STICO.</td>
							</tr>
							<tr>
								<td>3</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>HELOA TEIXEIRA DE QUEIROS</td>
								<td>PAPEL DO C&Aacute;LCIO NA RESPOSTA AO ESTRESSE &Aacute;CIDO EM SACCHAROMYCES</td>
							</tr>
							<tr>
								<td>4</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>RAFAEL PEREIRA DE ANDRADE</td>
								<td>AVALIA&Ccedil;&Atilde;O DA TOXICIDADE CARDIOVASCULAR DO ARTEM&Eacute;TER LIVRE E VEICULADO EM NANOCAPSULAS POR VIA ORAL</td>
							</tr>
							<tr>
								<td>5</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>DARIO ELIAS PEREIRA</td>
								<td>AVALIA&Ccedil;&Atilde;O DO EFEITO TERAP&Ecirc;UTICO DE C&Eacute;LULAS MESANQUIMAIS DA MEDULA &Ograve;SSEA, AUT&Oacute;LOGAS E ALOG&Ecirc;NEICAS, NO MODELO DE CTADIOPATIA CHAG&Aacute;SICA EM C&Atilde;ES</td>
							</tr>
							<tr>
								<td>6</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>IALIS PAIVA ANDRADE RODRIGUES DUTRA</td>
								<td>AVALIA&Ccedil;&Atilde;O IN VITRO DA ATIVIDADE ANTIOXIDANTE E IN VIVO DA ATIVIDADE ANTIARTRITE GOTOSA DOS EXTRATOS ETAN&Oacute;LICO E AQUOSO DAS FOLHAS DE TABEBUIA ROSEO-ALBA</td>
							</tr>
							<tr>
								<td>7</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>HELIA MARIA MARQUES DE MOURA</td>
								<td>AVALIA&Ccedil;&Atilde;O IN VITRO DA ATIVIDADE ANTIDENGUE DE NAFTOQUINONAS DERIVADAS DO LAPACHOL</td>
							</tr>
							<tr>
								<td>8</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>LORENA ULHOA ARAUJO</td>
								<td>ESTUDO BIOFARMAC&Ecirc;UTICO DA AMILORIDA E DIGOXINA, F&Aacute;RMACOS ASSOCIADOS A COMORBIDADES DA HIPERTENS&Atilde;O ARTERIAL SIST&Ecirc;MICA</td>
							</tr>
							<tr>
								<td>9</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>13:30 - 15:30</td>
								<td>SALA B</td>
								<td>ELISA DUARTE GUERRA COELHO</td>
								<td>ISOLAMENTO E IDENTIFICA&Ccedil;&Atilde;O DE BACT&Eacute;RIAS PRODUTORAS DE HIDROG&Ecirc;NIO A PARTIR DE PALHA DE CANA-DE-A&Ccedil;&Uacute;CAR HIDROLISADA.</td>
							</tr>
							<tr>
								<td>1</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>CAROLINE DE OLIVEIRA FARIA</td>
								<td>DESENVOLVIMENTO E CARACTERIZA&Ccedil;&Atilde;O DE NANOEMULS&Otilde;ES CONTENDO RAVUCONAZOL.</td>
							</tr>
							<tr>
								<td>2</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>BRUNA GABRIELE PEREIRA CALIXTO</td>
								<td>MONITORAMENTO INTERNO DE QUALIDADE VISANDO A REDU&Ccedil;&Atilde;O DOS RESULTADOS FALSOS-NEGATIVOS NOS DIAGN&Oacute;STICOS CITOL&Oacute;GICOS DO COLO DO &Uacute;TERO</td>
							</tr>
							<tr>
								<td>3</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>DALINE DE ASSIS PINHEIRO</td>
								<td>ESTUDO DE NANOC&Aacute;PSULES DE CIRCULA&Ccedil;&Atilde;O SANGU&Iacute;NEA PROLONGADA NA TERAPIA FOTODIN&Acirc;MICA EXPERIMENTAL DE TUMORES S&Oacute;LIDOS</td>
							</tr>
							<tr>
								<td>4</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>Clara Araujo Bittencourt Alves</td>
								<td>CARACTERIZA&Ccedil;&Atilde;O BIOL&Oacute;GICA E RESPOSTA AO TRATAMENTO DE CEPAS DE TRYPANOSOMA CRUZI ISOLADAS DE PACIENTES CHAG&Aacute;SICOS CR&Ocirc;NICOS REPRESENTANTES DE TR&Ecirc;S DTU(S) E APRESENTANDO FORMAS CL&Iacute;NICAS DISTINTAS DA DOEN&Ccedil;A DE CHAGAS.</td>
							</tr>
							<tr>
								<td>5</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>THAIENE ALIANE DE VASCONCELOS</td>
								<td>CONSTRU&Ccedil;&Atilde;O E VALIDA&Ccedil;&Atilde;O DA VERS&Atilde;O CURTA DO TESTE DE COORDENA&Ccedil;&Atilde;O COM BOLA - TECOBOL</td>
							</tr>
							<tr>
								<td>6</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>WASHINGTON MARTINS PONTES</td>
								<td>AVALIA&Ccedil;&Atilde;O DE MARCADORES INFLAMAT&Oacute;RIOS EM INDIV&Iacute;DUOS ADULTOS COM SOBREPESO E OBESIDADE</td>
							</tr>
							<tr>
								<td>7</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>NAYARA RESENDE GOMES</td>
								<td>AVALIA&Ccedil;&Atilde;O DA EFIC&Aacute;CIA DA EXTRA&Ccedil;&Atilde;O DE DNA DE T. CRUZI EM TECIDO PARAFINADO DE ANIMAIS INFECTADOS UTILIZANDO A T&Eacute;CNICA DE EXTRA&Ccedil;&Atilde;O ORG&Acirc;NICA COM CTAB/CLOROF&Oacute;RMIO/&Aacute;LCOOL</td>
							</tr>
							<tr>
								<td>8</td>
								<td>QUINTA-FEIRA 19/11/2015</td>
								<td>16:00 - 18:00</td>
								<td>SALA B</td>
								<td>BRUNA EUGENIA FERREIRA MOTA</td>
								<td>AVALIA&Ccedil;&Atilde;O DA SUDORESE DA PELE: O IMPACTO DE CENAS DE INTERA&Ccedil;&Atilde;O SOCIAL E DOS TRA&Ccedil;OS INDIVIDUAIS</td>
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
