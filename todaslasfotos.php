<?php
  $page_title = 'Fotos de los Eventos';
  require_once('includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all user form database
 $all_users = find_all_eventos();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
      <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Evento</th>
            <th>Direccion</th>
            <th>Fecha</th>
            <th class="text-center" style="width: 100px;">Acciones</th>
          </tr>
        </thead>
        
    
     </div>
    </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
