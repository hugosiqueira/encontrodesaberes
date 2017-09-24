<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais CHLA</span> 
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
							<td>SALA A</td>
							<td>ARIANE APARECIDA ALBERGARIA</td>
							<td>DO APARELHO FORMAL DA ENUNCIA&Ccedil;&Atilde;O &Agrave; CONSTRU&Ccedil;&Atilde;O DO ETHOS: UMA ABORDAGEM RET&Oacute;RICO-DISCURSIVA DOS &Iacute;NDICES DE MODALIZA&Ccedil;&Atilde;O</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA A</td>
							<td>KARINE GONCALVES MARTINS</td>
							<td>AQUISI&Ccedil;&Atilde;O DA ESCRITA E PADR&Otilde;ES FONOL&Oacute;GICOS: INTERFER&Ecirc;NCIAS, INTERCESS&Otilde;ES</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA A</td>
							<td>PRISCILA LOBO COSTA</td>
							<td>G&Ecirc;NEROS TEXTUAIS: SEUS LIMITES E FORMAS DE AVALIA&Ccedil;&Atilde;O</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA A</td>
							<td>EVANDRO LUIS MOREIRA DE SOUZA</td>
							<td>MULTILETRAMENTO LITER&Aacute;RIO: LITERATURA E FILME NO ENSINO DE L&Iacute;NGUA INGLESA NA EDUCA&Ccedil;&Atilde;O B&Aacute;SICA</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA A</td>
							<td>Fernanda Miranda Dias</td>
							<td>O ENSINO DA L&Iacute;NGUA FRANCESA NO COL&Eacute;GIO DA PROVID&Ecirc;NCIA EM MARIANA/MINAS GERAIS NO S&Eacute;CULO XIX</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA A</td>
							<td>MARIA EMILIA ELIAS JUNQUEIRA</td>
							<td>MODELAGEM DO AC&Uacute;MULO DE INFORMA&Ccedil;&Atilde;O E PRODU&Ccedil;&Atilde;O TEXTUAL: O SISTEMA DE MENSAGEM</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA A</td>
							<td>MARCUS VINICIUS PEREIRA DAS DORES</td>
							<td>O ESTUDO DA CONCORD&Acirc;NCIA VARI&Aacute;VEL (NOMINAL E VERBAL) EM MANUSCRITOS SETECENTISTAS E OITOCENTISTAS DE MINAS COLONIAL.</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>13:30 - 15:30</td>
							<td>SALA A</td>
							<td>VICTOR VIANNA GUEDES</td>
							<td>MEM&Oacute;RIA E RESIST&Ecirc;NCIA NEGRA EM GRUPOS TRADICIONAIS DE MATRIZ AFRICANA NA AM&Eacute;RICA LATINA</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>ANA CAROLINA DA SILVA</td>
							<td>LOUCO, G&Ecirc;NIO, POETA: REFLEX&Otilde;ES EM TORNO DOS ESCRITOS DE FERNANDO PESSOA SOBRE G&Ecirc;NIO E LOUCURA</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>NAAMAN MENDES LATALIZA</td>
							<td>O PAPEL DA PROS&Oacute;DIA NA EXPRESS&Atilde;O DA CERTEZA E DA INCERTEZA EM PORTUGU&Ecirc;S BRASILEIRO: RESPOSTAS AO QUESTION&Aacute;RIO ALIB NAS CAPITAIS DO SUDESTE</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>GIOVANI SILVEIRA DUARTE</td>
							<td>OS AMORES DE OV&Iacute;DIO NA TRADU&Ccedil;&Atilde;O &quot;PARAFR&Aacute;STICA&quot; DE ANT&Oacute;NIO FELICIANO DE CASTILHO (1858)</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>ALINE NOGUEIRA GUERRIERI</td>
							<td>ESCOLA NORMAL DE PONTE NOVA, MINAS GERAIS: INSTITUI&Ccedil;&Atilde;O, CURR&Iacute;CULO E FORMA&Ccedil;&Atilde;O DOCENTE NO PER&Iacute;ODO DE 1896 &ndash; 1940</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>FLAVIA ALESSANDRA SANTANA CARNEIRO</td>
							<td>DESVELANDO PONTOS: A EVAS&Atilde;O NO CURSO DE PEDAGOGIA DA UFOP</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>DANIEL PHILIPE DOS SANTOS ROCHA</td>
							<td>PERFIL DOS/AS PROFESSORES/AS DA REGI&Atilde;O DOS INCONFIDENTES</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>DAISY RIBEIRO HUBNER</td>
							<td>DESIGUALDADES E PROJETOS DE MOBILIDADE DOS ESTUDANTES DO ENSINO M&Eacute;DIO</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUARTA-FEIRA 18/11/2015</td>
							<td>16:00 - 18:00</td>
							<td>SALA A</td>
							<td>Andre de Cesari Martins Estanislau</td>
							<td>BRASIL: USO MORAL DA HIST&Oacute;RIA NAS OBRAS DO C&Ocirc;NEGO FERNANDES PINHEIRO 1850-1876</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>MARIANNA ANDRADE MELO</td>
							<td>HIST&Oacute;RIA E TEMPORALIDADE NO DEBATE POL&Iacute;TICO BRASILEIRO EM TORNO DO PROBLEMA DA REPRESENTA&Ccedil;&Atilde;O POL&Iacute;TICA (1837-1843)</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>MARIELEN GOMES</td>
							<td>MULHERES FORRAS: RELA&Ccedil;&Otilde;ES SOCIAIS E ECON&Ocirc;MICAS NA VILA DE PITANGUI (1750-1800)</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>ANA TERESA BARROSO DE SOUSA</td>
							<td>CULTURA HIST&Oacute;RICA EM REVISTA: VENDO O PASSADO NA ILUSTRA&Ccedil;&Atilde;O BRASILEIRA (1935-1945)</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>VICTOR SILVEIRA DO CARMO</td>
							<td>DESDOBRAMENTOS DO CONCEITO DE DESEJO NA FILOSOFIA DE GILLES DELEUZE</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>THAIS APARECIDA DE OLIVEIRA MUNIZ</td>
							<td>DA &#39;METAF&Iacute;SICA DE ARTISTAS&#39; &Agrave; FISIOLOGIA DA ARTE: ELEMENTOS PARA UMA EST&Eacute;TICA NIETZSCHIANA</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>ISAAC RAMOS JUNIOR</td>
							<td>TE&Iacute;SMO C&Eacute;TICO</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>VICTORINE LIGUICANO</td>
							<td>CI&Ecirc;NCIA E LITERATURA NA CONSTRU&Ccedil;&Atilde;O DA METAPSICOLOGIA FREUDIANA</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>08:00 - 10:00</td>
							<td>SALA A</td>
							<td>Frederico Goncalves</td>
							<td>CINEMA E FILOSOFIA EM A OBRA DE ARTE NA ERA DA SUA REPRODUTIBILIDADE T&Eacute;CNICA, DE WALTER BENJAMIN</td>
						</tr>
						<tr>
							<td>1</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>CAROLINE MORATO MARTINS</td>
							<td>IMAGENS DA MORTE NO SATYRICON.</td>
						</tr>
						<tr>
							<td>2</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>Luis Filipe Maiolini</td>
							<td>A JUSTI&Ccedil;A E A PR&Aacute;TICA DO PERD&Atilde;O NAS MINAS SETECENTISTAS (1711-1832)</td>
						</tr>
						<tr>
							<td>3</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>LUA CAMARGO DOS REIS</td>
							<td>HIST&Oacute;RIA E MEM&Oacute;RIA DE COMUNIDADES E MOVIMENTOS POPULARES NA INTERNET.</td>
						</tr>
						<tr>
							<td>4</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>KAIAN LUCA PERCE EUGENIO</td>
							<td>M&Iacute;DIA E CONSCI&Ecirc;NCIA ECOL&Oacute;GICA: A REVISTA VEJA DIANTE DOS IMPACTOS AMBIENTAIS NO BRASIL CONTEMPOR&Acirc;NEO (1960-1990)</td>
						</tr>
						<tr>
							<td>5</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>JULIO CESAR SANTOS</td>
							<td>DIOCESE DE ITABIRA-CORONEL FABRICIANO: CATOLICISMO E IDENTIDADES POL&Iacute;TICO-CULTURAIS REGIONAIS NO S&Eacute;CULO XX</td>
						</tr>
						<tr>
							<td>6</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>RAQUEL DE JESUS EVANGELISTA</td>
							<td>MULHERES EDUCADORAS EM MINAS GERAIS: TRAJET&Oacute;RIAS CONTEMPOR&Acirc;NEAS</td>
						</tr>
						<tr>
							<td>7</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>FERNANDA BACHA FERREIRA</td>
							<td>LES BALLETS C DE LA B: PO&Eacute;TICAS TRANSVIADAS NO TEATRO-DAN&Ccedil;A</td>
						</tr>
						<tr>
							<td>8</td>
							<td>QUINTA-FEIRA 19/11/2015</td>
							<td>10:30 - 12:30</td>
							<td>SALA A</td>
							<td>TACIANA SENE LUCIO</td>
							<td>JUVENTUDE, LA&Ccedil;OS SOCIAIS E PROCESSOS DE SUBJETIVA&Ccedil;&Atilde;O: UM ESTUDO SOBRE AS REPUBLICAS ESTUDANTIS</td>
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
