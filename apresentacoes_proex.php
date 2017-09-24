<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais PROEX</span> 
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
							<td width="77">22/11/2016</td>
							<td width="128">8:00 &ndash; 10:00</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REI - A</td>
							<td width="467">HOSPITAL DAS M&Aacute;QUINAS</td>
							<td width="468">CRISTIANO LU&Iacute;S TURBINO DE FRAN&Ccedil;A E SILVA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">8:00 &ndash; 10:00</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REI - A</td>
							<td width="467">PROGRAMA ENGENHARIA PARA A SUSTENTABILIDADE</td>
							<td width="468">M&Aacute;XIMO ELEOT&Eacute;RIO MARTINS</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">8:00 &ndash; 10:00</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REI - A</td>
							<td width="467">LUZ, C&Acirc;MERA E... CI&Ecirc;NCIA</td>
							<td width="468">GUILHERME DA SILVA LIMA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">8:00 &ndash; 10:00</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REI - B</td>
							<td width="467">ABORDAGENS EDUCATIVAS EM SEXUALIDADE E TERAP&Ecirc;UTICA DA SA&Uacute;DE DA MULHER</td>
							<td width="468">ELZA CONCEI&Ccedil;&Atilde;O DE OLIVEIRA SEBASTI&Atilde;O</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">8:00 &ndash; 10:00</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REI - B</td>
							<td width="467">APRENDIZADO DA SEXUALIDADE: APOIO INTERSETORIAL ENTRE ESCOLA E UNIDADE DE SA&Uacute;DE PARA O PROCESSO COEDUCATIVO INTERGERACIONAL NA COMUNIDADE DE ANTONIO PEREIRA, OURO PRETO, MG</td>
							<td width="468">ALINE SOUZA DE OLIVEIRA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">8:00 &ndash; 10:00</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REI - B</td>
							<td width="467">PREVEN&Ccedil;&Atilde;O DE GRAVIDEZ NA ADOLESC&Ecirc;NCIAE DST:&nbsp;&nbsp; INTERVEN&Ccedil;&Atilde;O NAS ESCOLAS P&Uacute;BLICAS DE OURO PRETO</td>
							<td width="468">MARILIA ALFENAS DE OLIVEIRA SIRIO</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">10:00</td>
							<td width="186">AUDIT&Oacute;RIO S&Atilde;O JO&Atilde;O DEL REY - A</td>
							<td width="467">TEATRO TUMULTO &ndash; CINEMA AO VIVO</td>
							<td width="468">PEDRO GABAN PETIND&Aacute; MOREIRA, NATHANE ALVES CRUZ, JOAO PAULO OLIVEIRA, PAOLA GIOVANA ALMEIDA SOARES SOUSA CARMO</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="467">AVALIA&Ccedil;&Atilde;O DAS FUN&Ccedil;&Otilde;ES CARDIORRESPIRAT&Oacute;RIAS E COMPOSI&Ccedil;&Atilde;O CORPORAL DOS ASSISTIDOS NO N&Uacute;CLEO PREVENTT</td>
							<td width="468">LUIZ EDUARDO DE SOUSA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="467">MATRICIAMENTO COMO UM DISPOSITIVO NOS CUIDADOS EM SA&Uacute;DE MENTAL DO MUNIC&Iacute;PIO DETR&Ecirc;S MARIAS/MG: DIAGN&Oacute;STICO DE REDE E CAPACITA&Ccedil;&Atilde;O DA ATEN&Ccedil;&Atilde;O PRIM&Aacute;RIA</td>
							<td width="468">FERNANDO MACHADO VILHENA DIAS</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="467">A&Ccedil;&Otilde;ES EDUCATIVAS DO PROJETO DE RASTREAMENTO E PREVEN&Ccedil;&Atilde;O DA DOEN&Ccedil;A RENAL CR&Ocirc;NICA EM POPULA&Ccedil;&Atilde;O DE RISCO NA UNIDADE DE SA&Uacute;DE DE PASSAGEM DE MARIANA EM MARIANA - MG</td>
							<td width="468">THAISLENE FERRAZ , CLARISSE &Aacute;GATA DA SILVA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="467">PROGRAMA PREVEN&Ccedil;&Atilde;O E TRATAMENTO DE TENDINOPATIAS PREVENTT</td>
							<td width="468">GUSTAVO PEREIRA BENEVIDES</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="467">CENTRO CULTURAL DO BAIRRO PIEDADE</td>
							<td width="468">GEM&Iacute;RSON DE PAULA DOS REIS</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="467">CENTRO CULTURAL SARAMENHA DE CIMA</td>
							<td width="468">ADRIANO HENRIQUE BORGES RAIMUNDO</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="467">PROGRAMA DE EXTENS&Atilde;O EM HANDEBOL/ CURSO DE EXTENS&Atilde;O EM BIOMEC&Acirc;NICA APLICADA</td>
							<td width="468">LEANDRO VINHAS DE PAULA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="467">PROJETO DAN&Ccedil;A DO VENTRE NA UFOP</td>
							<td width="468">NAYARA CRISTINA DE OLIVEIRA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="467">ENSINO DE L&Iacute;NGUA ESTRANGEIRA</td>
							<td width="468">ANELISE FONSECA DUTRA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="467">EDUCA&Ccedil;&Atilde;O MATEM&Aacute;TICA INCLUSIVA E DESENVOLVIMENTO PROFISSIONAL: A&Ccedil;&Otilde;ES VOLTADAS PARA A INCLUS&Atilde;O DE ALUNOS SURDOS E CEGOS NAS AULAS DE MATEM&Aacute;TICA</td>
							<td width="468">ANA CRISTINA FERREIRA</td>
						</tr>
						<tr>
							<td width="77">22/11/2016</td>
							<td width="128">13:30 &ndash; 15:30</td>
							<td width="186">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="467">O CIRCUITO DO TREM EM OURO PRETO/MARIANA-MG: CONTRIBUI&Ccedil;&Otilde;ES PARA ALFABETIZA&Ccedil;&Atilde;O CARTOGR&Aacute;FICA NOS ANOS INICIAIS DA EDUCA&Ccedil;&Atilde;O B&Aacute;SICA</td>
							<td width="468">JACKS RICHARD DE PAULO</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">8:00 &ndash; 10:00</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">ATEN&Ccedil;&Atilde;O FARMAC&Ecirc;UTICA PARA TERCEIRA IDADE EM OURO PRETO</td>
							<td width="422">ELZA CONCEI&Ccedil;&Atilde;O DE OLIVEIRA SEBASTI&Atilde;O</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">8:00 &ndash; 10:00</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">ATEN&Ccedil;&Atilde;O FARMAC&Ecirc;UTICA NA ATEN&Ccedil;&Atilde;O PRIM&Aacute;RIA &Atilde;&nbsp; SA&Uacute;DE</td>
							<td width="422">LISIANE DA SILVEIRA EV</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">8:00 &ndash; 10:00</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">SABERES E SABORES EM OFICINAS DE CULIN&Aacute;RIA</td>
							<td width="422">S&Ocirc;NIA MARIA DE FIGUEIREDO</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">8:00 &ndash; 10:00</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">AMBULAT&Oacute;RIO DE DOEN&Ccedil;AS INF. E PARASI</td>
							<td width="422">S&Ocirc;NIA MARIA DE FIGUEIREDO</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">8:00 &ndash; 10:00</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">COM POSTURA - PROJETO DE AN&Aacute;LISE E GEST&Atilde;O DOS RISCOS LABORAIS</td>
							<td width="422">M&Aacute;XIMO ELEOT&Eacute;RIO MARTINS</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">8:00 &ndash; 10:00</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">PROJETO FIQUE BEM - GEST&Atilde;O EMOCIONAL NO TRABALHO</td>
							<td width="422">PATR&Iacute;CIA RIBEIRO REZENDE NETTO</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">8:00 &ndash; 10:00</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">CAPACITA&Ccedil;&Atilde;O E AVALIA&Ccedil;&Atilde;O EM HOSPEDAGEM E HOSPITALIDADE: SERVI&Ccedil;OS DE RECEP&Ccedil;&Atilde;O E CAMARIA&Acirc;&euro;</td>
							<td width="422">KERLEY DOS SANTOS ALVES</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">10:30 &ndash; 12:00</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY - B</td>
							<td rowspan="2" width="342">PROJETO OBSERVAT&Oacute;RIO INTERINSTITUCIONAL MARIANA RIO DOCE</td>
							<td width="422">EQUIPE UFOP/UFMG/UFES</td>
						</tr>
						
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">MINERA&Ccedil;&Atilde;O EM FOCO:O IMPACTO DA MINERA&Ccedil;&Atilde;O NO USO DA &Aacute;GUA, DO SOLO E O PAPEL DA ESCOLA</td>
							<td width="422">CLARISSA RODRIGUES</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">DISCUTINDO A CI&Ecirc;NCIA E A MINERA&Ccedil;&Atilde;O COM A SOCIEDADE</td>
							<td width="422">GUILHERME DA SILVA LIMA</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">&nbsp;S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">OBSERVAT&Oacute;RIO DO REASSENTAMENTO: REDE DE A&Ccedil;&Otilde;ES E APOIO AOS ATINGIDOS NOS MUNIC&Iacute;PIOS DE MARIANA E BARRA LONGA</td>
							<td width="422">KARINE GON&Ccedil;ALVES CARNEIRO</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 - 15:30</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">NARRATIVAS ATINGIDAS</td>
							<td width="422">WELLINGTON PHILLIPE ALCANTARA SPINOLA, SARA CORTES GAMA FERREIRA DE OLIVEIRA</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 - 15:30</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY &ndash; A</td>
							<td width="342">ADMINISTRA&Ccedil;&Atilde;O EM A&Ccedil;&Atilde;O: APOIO &Agrave;S INICIATIVAS DE GERA&Ccedil;&Atilde;O DE RENDA E EMPREGOS &Agrave;S V&Iacute;TIMAS DA QUEDA DAS BARRAGENS DE REJEITO DA SAMARCO - VALORIZA&Ccedil;&Atilde;O DE PESSOAS E CAPACITA&Ccedil;&Atilde;O T&Eacute;CNICA EM TURISMO HOSPITALIDADE NOS MUNIC&Iacute;PIOS DE&nbsp; OURO PRETO E MARIANA</td>
							<td width="422">&nbsp;IONA ARAUJO SANTOS FAUSTINO</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">PEPASS - PROJETO DE ESTRUTURA&Ccedil;&Atilde;O PROATIVO PARA ALIAN&Ccedil;AS SOCIAIS E SUSTENT&Aacute;VEIS</td>
							<td width="422">M&Aacute;XIMO ELEOT&Eacute;RIO MARTINS</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">N&Uacute;CLEO DE DIREITOS HUMANOS</td>
							<td width="422">ALEXANDRE GUSTAVO MELO FRANCO DE MORAES BAHIA</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">OBSERVAT&Oacute;RIO DA LIBERDADE DE EXPRESS&Atilde;O</td>
							<td width="422">CLAUDIO HENRIQUE RIBEIRO DA SILVA</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">PROGRAMA DIREITO E SOCIEDADE E PROJETOS CORRELATOS.</td>
							<td width="422">ROBERTO HENRIQUE P&Ocirc;RTO NOGUEIRA</td>
						</tr>
						<tr>
							<td>23/11/2016</td>
							<td width="145">13:30 &ndash; 15:30</td>
							<td width="179">S&Atilde;O JO&Atilde;O DEL REY &ndash; B</td>
							<td width="342">PARLAMENTO JOVEM E EDUCA&Ccedil;&Atilde;O CIDAD&Atilde;</td>
							<td width="422">ALEXANDRE G. MELO FRANCO DE MORAES BAHIA</td>
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
		"order": [[ 0, "asc" ]],
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
