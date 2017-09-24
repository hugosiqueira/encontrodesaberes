<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../config.php");
require_once 'includes/functions.php';
sec_session_start();

if(login_check($db)){

?>
<!DOCTYPE HTML>

<html>
<head>
    <title>Encontro de Saberes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- <x-compile> -->
        <!-- <x-bootstrap> -->
            <link rel="stylesheet" href="bootstrap.css">
            <script src="ext/ext-all-dev.js"></script>
            <script src="ext/locale/ext-lang-pt_BR.js"></script>
            <script src="includes/sha512.js"></script>
            <script src="bootstrap.js"></script>

			<!-- arquivos para o multupload -->
 			<script type="text/javascript" src="ext/src/ux/upload/plupload/js/plupload.js"></script>
 			<script type="text/javascript" src="ext/src/ux/upload/plupload/js/plupload.html4.js"></script>
			<script type="text/javascript" src="ext/src/ux/upload/plupload/js/plupload.html5.js"></script>
 			<script type="text/javascript" src="ext/src/ux/upload/plupload/js/plupload.flash.js"></script>
 			<script type="text/javascript" src="ext/src/ux/upload/plupload/js/plupload.silverlight.js"></script>

 			<!-- jQuery -->
 			<script type="text/javascript" src="../js/jquery.js"></script>
 			<script type="text/javascript" src="../js/jquery.PrintArea.js"></script>
 			<script type="text/javascript"> var $jq = $.noConflict(); </script>

 			<!-- jQuery Barcode-->
 			<script type="text/javascript" src="../js/jquery-barcode.min.js"></script>

 			<!-- HTML2canvas-->
 			<script type="text/javascript" src="../js/html2canvas.js"></script>

			<!-- arquivo de criptografia -->
			<script type="text/javascript" src="includes/des_encryption.js"></script>

        <!-- </x-bootstrap> -->
        <script type="text/javascript" src="app.js"></script>
    <!-- </x-compile> -->
    <link rel="stylesheet" href="resources/css/desktop.css">
    <link rel="stylesheet" href="resources/css/app.css">

</head>
<body>
	<div id="over">
		<span class="Centerer"></span>
		<img class="Centered" src="resources/css/icons/loadingSis.gif" />
	</div>

	<div id="bemvindo">
		<b>
		Bem vindo: <font size="3"><?php echo $_SESSION['nome']; ?></font> </br>
		Último login:
		<?php
			if( $_SESSION['ultimo_acesso'] == "" ||  $_SESSION['ultimo_acesso'] == NULL){
				echo "Nunca efetuou login.";
			}
			else{
				echo date('d/m/Y H:i', $_SESSION['ultimo_acesso']);
			}
		?>
		</b>

	</div>
</body>
</html>
<?php
}
else {
   header('Location: index.php');
	// echo $_SESSION['teste_dbpass']."<br>";
	// echo $_SESSION['teste_pass']."<br><br>";
	// echo $_SESSION['login_string']."<br>";
	// echo $_SESSION['teste_lscheck']."<br><br>";
}
?>