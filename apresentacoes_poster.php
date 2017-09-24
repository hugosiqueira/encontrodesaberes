<?php include ("header.php");?>
<link href="plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/> 
<link href="plugins/datatables/media/css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css"/> 
<div id="highlighted">
	<div class="container">
		<div class="header">
			<h2 class="page-title">
				<span>Apresenta&ccedil;&otilde;es Pôsteres - SEXT</span> 
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
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pesquisar Pôster</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">

                             <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="apresentador">Título</label>
                                    <input class='form-control' type = "text" id = "titulo" />
                                </div>
                            </div>
                        </div>
                        <table id="apresentacoes-grid" class="table table-striped table-bordered display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Pôster</th>
                                    <th>Apresentador</th>
                                    <th>Título</th>
                                    <th>Horário</th>
                                    <th>Sessão</th>
                                    <th>Instituição</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
		</div>
		<?php include "bibliotecas.php"; ?>
		<script type="text/javascript" language="javascript" src="plugins/datatables/media/js/jquery.dataTables.min.js"></script>
		<script>
		 $(document).ready(function() {
       
        var table = $('#apresentacoes-grid').DataTable( {
            "oLanguage": {
              "sUrl": "datables_portugues.json",
              "sProcessing": "Carregando..."
            },
            "bprocessing": true,
            "serverSide": true,
            "order": [[ 0, "asc" ]],
            "aoColumns": [
                { "sClass": "text-center text-uppercase", "sWidth": "8%"  },
                { "sClass": "text-left text-uppercase", "sWidth": "22%" },
                { "sClass": "text-justify text-uppercase", "sWidth": "35%" },
                
                { "sClass": "text-center text-uppercase", "sWidth": "11%" },
                { "sClass": "text-center", "sWidth": "4%" },
                { "sClass": "text-center", "sWidth": "10%" },
                { "sClass": "text-center", "sWidth": "10%" }

            ],
            "columnDefs": [
                
                {
                    "targets": 6,
                    "data": "fgk_trabalho",
                    "render":  function ( data, type, row, meta ) {
                        return '<a href="detalhes.php?id='+row[6]+'"class="btn btn-danger">Detalhes</a>';
                    }
                }
                
               
                
            ],
            "ajax":{
                url :"apresentacoes-grid-data.php",
                type: "post",
                error: function(){
                    $(".apresentacoes-grid-error").html("");
                    $("#apresentacoes-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nenhum poster encontrado</th></tr></tbody>');
                    $("#apresentacoes-grid_processing").css("display","none");
 
                }
            }
        } );


        $('#titulo').on( 'change', function () {
            table.column(2).search( this.value ).draw();
        } );

    } );
		</script>
		<?php include ("footer.php"); ?>
		