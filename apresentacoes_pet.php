<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Orais Mostra PET</span> 
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
								<td>23/11/2016</td>
								<td width="145">10:30- 12:00</td>
								<td width="179">SALA TIRADENTES SALA F</td>
								<td width="342">CONTRIBUI&Ccedil;&Otilde;ES DOPET PEDAGOGIA&nbsp; DA UFOP: UM ESTUDO EXPLORAT&Oacute;RIO A PARTIR DAS VOZES DE EGRESSOS</td>
								<td width="422">MICHELLE FELIX DA SILVA, CRISLAINE GESSICA PAULINO DE OLIVEIRA, JUSSARA FERREIRA DE JESUS, JULIANE FERREIRA TIMOTEO, SCARLET LORENA SOUZA DOS SANTOS, DAIENE APARECIDA CAMPIDELE, THAISLENE FERRAZ, FERNANDA CRISTINA GONCALVES, ANA PAULA GONCALVES, LUANA MARIA XAVIER ROSA, ELAINE GONCALO BENTO, CLAUDIOMARA EVA DOS ANJOS, CLARICE AGATA DA SILVA, TAMIRIS AFONSO DE OLIVEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">PROGRAMA DE EDUCA&Ccedil;&Atilde;O TUTORIAL - PET FARM&Aacute;CIA: EDUCA&Ccedil;&Atilde;O CONTINUADA UMA TEM&Aacute;TICA DENTRE OS PROJETOS DESENVOLVIDOS EM 2016</td>
								<td width="422">MARILIA PINHEIRO BRAGA, MARIANA BRAZ DE MATOS, MARIA ALICE DE OLIVEIRA, SAMARA STEFANI DE CASTRO E SILVA, ANA PAULA AMARIZ SILVEIRA, RENATA RODRIGUES LIMA, REJANE EVANGELISTA DA CONCEICAO, JESSICA EMILIANA SANTOS SILVA, LUCIENE GONCALVES DA PAIXAO, LUCAS ANTUNES ARAUJO, SAMIRA FAGUNDES DE ANDRADE, RAFAEL PEREIRA DE ANDRADE, PATRICIA YOSHIE WATAI</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES SALA E</td>
								<td width="342">PROJETO JEQUITINHAN&Ccedil;A - PET NUTRI&Ccedil;&Atilde;O</td>
								<td width="422">ANA CELIA FERNANDES CAMPOS, HILLARY NASCIMENTO COLETRO, JULIA VELLOSO LIMA, LARA DO ROSARIO FAGUNDES, MAYARA MELO MOREIRA, LILIAN KAROLINE CUNHA LOPES, TAINA CRISTINA DAMASCENO SILVA, ISADORA RIBEIRO VIEIRA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">13:30 &ndash; 15:30</td>
								<td width="179">SALA TIRADENTES F</td>
								<td width="342">PROGRAMA DE EDUCA&Ccedil;&Atilde;O TUTORIAL - PET CONEX&Otilde;ES ECONOMIA</td>
								<td width="422">ESTHER ARREGUY CORREA MOREIRA, SILMARA CANDINHO ALVES FILGUEIRAS, AMANDA DOS SANTOS FRANCISCO, GABRIELA BRAGA FREITAS, CHINARA MENDES SCHINAIDER, VINICIUS DE CASTRO VALADARES, MARINA OLIVEIRA DE SOUZA, AMANDA ALVES CAMPOS, ANDREZZA APARECIDA DE JESUS, CLARA FERREIRA NASCIMENTO, LARISSA COGO FIGUEIREDO, CAMILA STEFANI DE SOUSA SILVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES E</td>
								<td width="342">ATIVIDADES DE FORMA&Ccedil;&Atilde;O COMPLEMENTAR PARA MEMBROS DO PETF&Iacute;SICA E DEMAIS DISCENTES</td>
								<td width="422">GUILHERME DAVID GONCALVES SOUZA, RAFAELA ALVES CAIXETA, RONIELA GONCALVES LOPES, RAFAEL RODRIGUES MATEUS, THAIS MIRANDA DE ALMEIDA, LUCIANA CAROLINE SARAIVA BISPO, WESLLEY DA SILVA FERNANDES MATHIAS, FLAVIA ELVIRA DE SOUZA OLIVEIRA, JOAO VICTOR FERNANDES DE OLIVEIRA, MARIANA PIMENTA ADAIXO DE DEUS, SERGIO FERNANDO CURCIO</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES E</td>
								<td width="342">ATIVIDADES DO GRUPO PET MATEM&Aacute;TICA 2016</td>
								<td width="422">BARBARA CRISTINA TOLEDO LIMA, ELDER CESAR DE ALMEIDA, IVO MEIRA COSTA, HAMILTON TONIDANDEL JUNIOR, PHILIPE DIAS DE ALMEIDA, MARLON MARTINS CUNHA, MONICA MADEIRA DOS SANTOS</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES F</td>
								<td width="342">PROGRAMA DE EDUCA&Ccedil;&Atilde;O TUTORIAL - PET ENGENHARIA CIVIL</td>
								<td width="422">BRENDA MARA MARQUES, MARCUS VINICIUS LIMA DIAS, CRISTIANO ROGER LARA MELO, HENRIQUE TEIXEIRA GODOI DE BARROS, PAULO HENRIQUE PEREIRA DA SILVA, EDUARDO MENDES LINO, HUGO MOURO LEAO, JEFFERSON DE OLIVEIRA BARBOSA, LORENA BOSSER NEPOMUCENO, LIVIA DE ANDRADE RIBEIRO, VANESSA PEREIRA SANTANA, THAINA SUZANNE ALVES SOUZA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES F</td>
								<td width="342">CADERNETA, B&Uacute;SSOLA E GPS: MINI-CURSOS PR&Aacute;TICOS PARA ALUNOS DA UFOP</td>
								<td width="422">ROSANA GONCALVES OLIVEIRA, AUGUSTO DO CARMO SOUSA DAVIN, GABRIEL OLIVEIRA SEPULVEDA, RENATA DELICIO ANDRADE DE FREITAS, EDUARDO SILVA MUNIZ, JOAO PAULO DE LIMA, NATALIA DIAS LEAL, JULIA COTTA MACIEL DANTAS, BEATRIZ COURA NARDY, AULO ROSMANINHO BORGES BOECHAT MACHADO, DRIELE ANTUNES DE ASSIS, PEDRO HENRIQUE DA SILVA ASSUNCAO, LAURA FROTA CAMPOS HORTA, THIAGO LUIS DA SILVA COSTA, PAULA LUIZA FRAGA FERREIRA, CAROLINA GONTIJO BERNARDES SILVA</td>
							</tr>
							<tr>
								<td>23/11/2016</td>
								<td width="145">16:00- 18:00</td>
								<td width="179">SALA TIRADENTES F</td>
								<td width="342">INTEGRAPET UFOP: PREPARAT&Oacute;RIO ENEM NA ESCOLA ESTADUAL DOM SILV&Eacute;RIO, MARIANA MG</td>
								<td width="422">JULIA TEIXEIRA PIMENTA, LETICIA GUIMARAES PEREIRA, KESIA YULI DA SILVA PEREIRA, JULIANE CAPUTO COSTA, DEBORAH DE LA CRUZ NEUMANN, TAMIRES DA SILVA ESTEVAM, MARINA DOS SANTOS OLIVEIRA, CAMILLA ADRIANE DE PAIVA, WENDERSON LUIS PEREIRA, ROSANA NOGUEIRA SILVERIO, IANY CUNHA ALBERGARIA, VICTOR LEONE DE OLIVEIRA</td>
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
