<?php
  $page_title = 'Compra Fotos';
  require_once('includes/load.php');
  
  $user = current_user(); 
  
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

  
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(2);
 $eventos=array();
//pull out all user form database
 $id_cliente=$_GET['id_cliente'];
 $id_evento=$_GET['id_evento'];
 $resp=array();
 $all_users = find_eventos_cliente_fotos($id_cliente, $id_evento,$resp);
// print_r($resp); 
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
          <span>Fotos</span>
       </strong>
          
      </div>
        
        
        <form id="realizarPago" action="fotos_comprar.php" method="post">
            <input name="id_evento" type="hidden" value="<?php echo $id_evento?>" />
            <input name="id_cliente" type="hidden" value="<?php echo $id_cliente?>" />
     <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Nombre Foto</th>
            <th>Foto</th>
            <th class="text-center" style="width: 100px;">Comprar</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        
        foreach($resp as $a_user): ?>
          <tr>
              <td>.</td>   
           <td><?php echo remove_junk(ucwords($a_user[15]))?></td>
           <td>
<img src="<?php echo 'eventos/evento_'.$id_evento.'/'.$a_user[15]; ?>"  
     style="width: 100px; height: 75px" >
           </td>
           <td class="text-center">
                <div class="btn-group">
                    <input type= 'checkbox' name='ids[]' value ='<?php echo $a_user[14];?>'> 
                </div>
           </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
        
            <input class="btn btn-lg btn-primary btn-block" name="submitPayment" type="submit" value="Pagar">
            
        </form>    
        
    </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
