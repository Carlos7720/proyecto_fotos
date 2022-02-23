<?php
  $page_title = 'Lista de Eventos';
  require_once('includes/load.php');
  
  $user = current_user(); 
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(2);
 $eventos=array();
//pull out all user form database
 $id_cliente=$user['id'];
 $all_users = find_all_eventos_cliente($id_cliente, $eventos);
 //print_r($eventos); exit(0);
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
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Eventos</span>
       </strong>
          
      </div>
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
        <tbody>
        <?php foreach($eventos as $a_user): ?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_user['nombre']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['direccion']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['fecha']))?></td>


           <td class="text-center">
             <div class="btn-group">
                 <a href="eventos_cli_com.php?id_cliente=<?php echo $id_cliente;?>&id_evento=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                  <i class="glyphicon glyphicon-pencil"></i>
               </a>
                </div>
           </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
