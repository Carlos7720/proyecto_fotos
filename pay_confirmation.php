<?php
  $page_title = 'Home';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo "PAGO EXITOSO, YA PUEDE DESCARGAR SUS FOTOS AQUI...."; ?>
  </div>
 <div class="col-md-12">
    <div class="panel">
      <div class="jumbotron text-center">
          
          
     
      </div>
    </div>
 </div>
</div>
<?php include_once('layouts/footer.php'); ?>
