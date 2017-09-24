<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais ENG</span> 
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
							<td>SALA D</td>
							<td>DIEGO DE ARAUJO SANTANA</td>
							<td>PROPOSI&Ccedil;&Atilde;O E AVALIA&Ccedil;&Atilde;O ESTAT&Iacute;STICA DE UMA METODOLOGIA PARA MEDI&Ccedil;&Atilde;O DE TAMANHO DE GR&Atilde;OS EM MATERIAIS MET&Aacute;LICOS</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA D</td>
							<td>MARCUS VINICIUS SILVA E SOUZA</td>
							<td>SEGURAN&Ccedil;A ESTRUTURAL: APLICA&Ccedil;&Atilde;O EM ESTRUTURAS DE PERFIS FORMADOS A FRIO</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA D</td>
							<td>PAOLA SUZANE MOREIRA GONCALVES</td>
							<td>FLOTA&Ccedil;&Atilde;O ANI&Ocirc;NICA INVERSA DE MIN&Eacute;RIO DE FERRO</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA D</td>
							<td>MARCOS PAULO SALOMAO PARACAMPOS</td>
							<td>EMPACOTAMENTO APOLONIANO E POROSIDADE EM GRANEIS</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA D</td>
							<td>SANDRA DE FREITAS ABREU</td>
							<td>EFICI&Ecirc;NCIA ENERG&Eacute;TICA DE ALTERNATIVAS DE PROJETO DE HABITA&Ccedil;&Otilde;ES VISANDO O CONFORTO T&Eacute;RMICO DO USU&Aacute;RIO</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA D</td>
							<td>TATIANE MAGA PEREIRA MENDES</td>
							<td>AN&Aacute;LISE SISTEMAS ESTRUTURAIS (PLANOS) DE EDIF&Iacute;CIOS EM CONCRETO ARMADO</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA D</td>
							<td>RENATA DE CASTRO PIRES</td>
							<td>DESENVOLVIMENTO DE M&Eacute;TODOS ANAL&Iacute;TICOS NA VISANDO INOVA&Ccedil;&Atilde;O NA &Aacute;REA DE HIDROMETALURGIA DOS METAIS BASE E NOBRES</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA D</td>
							<td>DANIEL JOS&Eacute; ROCHA PEREIRA</td>
							<td>AN&Aacute;LISE DE LIGAÇÕES ENTRE PERFIS DE AÇO DE SE&Ccedil;&Atilde;O TUBULAR RETANGULAR DE PAREDES COMPACTAS E ESBELTAS</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA D</td>
							<td>NICOLAS YURI BRAGA</td>
							<td>CLASSIFICA&Ccedil;&Atilde;O GEOMEC&Acirc;NICA E AN&Aacute;LISE DE ESTABILIDADE DE TALUDES URBANOS EM OURO PRETO &ndash; MINAS GERAIS</td>
						</tr>

						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA D</td>
							<td>LAIS MILAGRES FURTADO</td>
							<td>DETERMINA&Ccedil;&Atilde;O DO POTENCIAL DE PRODU&Ccedil;&Atilde;O DE BIOG&Aacute;S (CH4 E H2) A PARTIR DOS HIDROLISADOS OBTIDOS POR DIFERENTES T&Eacute;CNICAS DE PR&Eacute;-TRATAMENTO DO BAGA&Ccedil;O DE CANA-DE-A&Ccedil;UCAR.</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA D</td>
							<td>DIEGO DA SILVA CHAVES</td>
							<td>MUNICIPALIZA&Ccedil;&Atilde;O DO LICENCIAMENTO E DA AVALIA&Ccedil;&Atilde;O DE IMPACTO AMBIENTAL DE ABRANG&Ecirc;NCIA LOCAL EM BETIM E BELO HORIZONTE, MG</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA D</td>
							<td>MARINA FERREIRA CUNHA</td>
							<td>HEUR&Iacute;STICAS PARA O PROBLEMA DE ROTEAMENTO E ALOCA&Ccedil;&Atilde;O DE COMPRIMENTOS DE ONDA EM REDES &Oacute;TICAS</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA D</td>
							<td>ARTHUR REIS LARA MIRANDA</td>
							<td>UMA METAHEUR&Iacute;STICA H&Iacute;BRIDA BASEADA NOS CONCEITOS DE L&Oacute;GICA FUZZY APLICADA AO PROBLEMA DE PREVIS&Atilde;O DE GERA&Ccedil;&Atilde;O DE ENERGIA EL&Eacute;TRICA EM PARQUES E&Oacute;LICOS</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA D</td>
							<td>BARBARA OLIVEIRA MENDES</td>
							<td>DESENVOLVIMENTO DE METODOLOGIA PARA MEDI&Ccedil;&Atilde;O DE IMPED&Acirc;NCIA DE RESSONADORES VISANDO APLICA&Ccedil;&Atilde;O EM PROJETO DE CAVIDADES DE ALTO DESEMPENHO AC&Uacute;STICO</td>
						</tr>
						
						<tr>
							<td>1</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA D</td>
							<td>TAINAN FERREIRA MUNIZ</td>
							<td>EFEITO DE ALGUNS TRATAMENTOS T&Eacute;RMICOS SOBRE A MICROESTRUTURA E PROPRIEDADES MEC&Acirc;NICAS DE UM A&Ccedil;O API LINEPIPE BAIXO CARBONO</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA D</td>
							<td>RODRIGO DE OLIVEIRA SEVERINO</td>
							<td>REOLOGIA DO MANUSEIO DE POLPAS</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA D</td>
							<td>GUSTAVO DE AZEVEDO PRADO MARTINS</td>
							<td>MONITORAMENTO DE PAR&Acirc;METROS AC&Uacute;STICOS E T&Eacute;RMICOS EM AMBIENTES CONSTRU&Iacute;DOS</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA D</td>
							<td>TAIS KUSTER MORO</td>
							<td>ADER&Ecirc;NCIA DE BARRAS DE A&Ccedil;O EM CONCRETO SUSTENT&Aacute;VEL</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA D</td>
							<td>LUCAS ALVES ESCANIO</td>
							<td>DESENVOLVIMENTO DE LIGA&Ccedil;&Atilde;O EM PERFIS TUBULARES TIPO LUVA COM PARAFUSOS CRUZADOS A 90&ordm;</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA D</td>
							<td>Joao Otavio Belizario Tonhao</td>
							<td>MICROSISTEMA H&Iacute;BRIDO FOTOVOLTAICO-HIDREL&Eacute;TRICO PARA GERA&Ccedil;&Atilde;O AUT&Ocirc;NOMA DE ENERGIA EL&Eacute;TRICA OU BOMBEAMENTO FOTOVOLTAICO</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA D</td>
							<td>STEPHANIA DA CONSOLACAO SILVA NOGUEIRA</td>
							<td>MOAGEM DOS MINERAIS PORTADORES DE ZINCO, CHUMBO E PRATA SULFETADOS</td>
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
