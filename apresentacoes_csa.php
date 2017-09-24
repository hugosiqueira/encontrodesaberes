<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais CSA</span> 
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
							<td>SALA E</td>
							<td>TICIANE KARITA GOMES ALVES</td>
			<td>RADIOMORFOSE: MODELOS DE NEG&Oacute;CIO DO R&Aacute;DIO NA INTERNET</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA E</td>
							<td>ALEXANDRO GALENO DA COSTA</td>
			<td>REVISTA ALTEROSA NAS TRAMAS DA EDITORA&Ccedil;&Atilde;O MINEIRA E BRASILEIRA EM MEADOS DO S&Eacute;CULO XX</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA E</td>
							<td>GISELLE BORGES DE CARVALHO</td>
			<td>DESENVOLVIMENTO DE PROJETOS PEDAG&Oacute;GICOS PARA A CRIA&Ccedil;&Atilde;O DE PRODUTOS JORNAL&Iacute;STICOS EM HIPERM&Iacute;DIA, MULTIM&Iacute;DIA E TRANSM&Iacute;DIA ATRAV&Eacute;S DO USO DE FERRAMENTAS E SISTEMAS DE GERENCIAMENTO DE CONTE&Uacute;DOS.</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA E</td>
							<td>INGRIDY RAYANE DA SILVA</td>
			<td>REPRESENTA&Ccedil;&Otilde;ES MIDI&Aacute;TICAS E A CONSTRU&Ccedil;&Atilde;O DO IMAGIN&Aacute;RIO DAS OLIMP&Iacute;ADAS DE INVERNO DE SOCHI E DA COPA DO MUNDO DA FIFA NO BRASIL</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA E</td>
							<td>DREISSE DRIELLE FERREIRA PAULO</td>
			<td>ESTRAT&Eacute;GIAS DISCURSIVAS DE OPACIDADE NOS PROCESSOS DE SIGNIFICA&Ccedil;&Atilde;O DA INFORMA&Ccedil;&Atilde;O P&Uacute;BLICA</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA E</td>
							<td>WALQUIRIA MARINHO DE FREITAS</td>
			<td>UM ESTRANHO NO NINHO: UM ESTUDO SOBRE A INSER&Ccedil;&Atilde;O DA TEM&Aacute;TICA &ldquo;ANTROPOLOGIA DO CONSUMO&rdquo; NAS DISCIPLINAS DE MARKETING DOS PROGRAMAS STRICTO SENSU EM ADMINISTRA&Ccedil;&Atilde;O NO BRASIL.</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA E</td>
							<td>LUIS ROBERTO ALFONSO PRADO JUNIOR</td>
			<td>CARACTERIZA&Ccedil;&Atilde;O E AN&Aacute;LISE DA PAISAGEM URBANA DE OURO PRETO E A PROTE&Ccedil;&Atilde;O OFERECIDA PELA LEGISLA&Ccedil;&Atilde;O URBAN&Iacute;STICA</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>TAIS LAIARA COSTA RODRIGUES</td>
			<td>ENTIDADE FAMILIAR HOMOAFETIVA - DA POSSIBILIDADE AO CASAMENTO E ADO&Ccedil;&Atilde;O HOMOAFETIVA</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>JANAINA SANTOS CURI</td>
			<td>A ABRANG&Ecirc;NCIA DO DIREITO: A DEFENSORIA P&Uacute;BLICA COMO INSTRUMENTO DO ESTADO PARA RECONHECIMENTO. UM ESTUDO DE CASO SOBRE A COMARCA DE BELO HORIZONTE</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>LUCAS CIPRIANI DE OLIVEIRA</td>
			<td>AS IMAGENS MERAMENTE ILUSTRATIVAS E SUA LICITUDE: UM ESTUDO A LUZ DO C&Oacute;DIGO DE DEFESA DO CONSUMIDOR</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>DANIELE CRISTINA DE BRITO MORAIS OLIVEIRA</td>
			<td>LUTAS SOCIAIS E PROCESSOS POL&Iacute;TICOS NO BRASIL: MEDIA&Ccedil;&Otilde;ES HIST&Oacute;RICAS DA CONSOLIDA&Ccedil;&Atilde;O DA &ldquo;DEMOCRACIA VULGAR&rdquo; NA CONTEMPORANEIDADE</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>THAYZA SILVA DA CRUZ</td>
			<td>AVALIA&Ccedil;&Otilde;ES E MELHORIAS DOS MODELOS DE NEG&Oacute;CIO DE IND&Uacute;STRIAS DE JO&Atilde;O MONLEVADE - MG</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>LUCAS MARDONES GAIAO</td>
			<td>FONTES DE CRESCIMENTO DOS PRINCIPAIS EXPORTADORES DE SUCO DE LARANJA CONCENTRADO E CONGELADO: UMA AN&Aacute;LISE DE CONSTANT MARKET SHARE</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>JULIANA LIMA DE DEUS</td>
			<td>OS AVAN&Ccedil;OS DA TECNOLOGIA BANC&Aacute;RIA NO BRASIL: MAPEAMENTO E AN&Aacute;LISE DO PERFIL DAS PATENTES DOS GRUPOS ITA&Uacute;SA E BRADESCO.</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA E</td>
							<td>FILIPE SOARES DOS SANTOS</td>
			<td>ELASTICIDADE RENDA E PRE&Ccedil;O DA DEMANDA DOM&Eacute;STICA DE A&Ccedil;O NO BRASIL</td>
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
