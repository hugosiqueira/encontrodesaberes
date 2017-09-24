<?php
session_start();
include ("header.php");
?>
 <div id="highlighted">

    <div class="container">

      <div class="header">

        <h2 class="page-title">

          <span>Área Restrita</span> 
          <small>Faça seu login para acessar o sistema</small>

        </h2>

      </div>

    </div>

  </div>
<div id="content">

    <div class="container">
      <div class="row">
        <div class="col-md-6 text-center" style="float: none;margin:0 auto;">
          <?php include "form_login.php"; ?>
        </div>
      </div>
    </div>

</div>
</div>

</div>
  <?php include "bibliotecas.php"; 
  		include "footer.php";
  ?>
