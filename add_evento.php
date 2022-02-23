<?php
  $page_title = 'Eventos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_evento'])){

   $req_fields = array('nombre','direccion','fecha');
   validate_fields($req_fields);

   if(empty($errors)){
       $nombre   = remove_junk($db->escape($_POST['nombre']));
       $direccion= remove_junk($db->escape($_POST['direccion']));
       $f=remove_junk($db->escape($_POST['fecha'])); 
       //$f= explode('-', $f);$fech=$f[2].'-'.$fech=$f[1].'-'.$fech=$f[0];
       
       //echo $f; exit(0);
       //$fecha   = remove_junk($db->escape(fecha));
        $query ="INSERT INTO eventos(nombre,direccion,fecha) VALUES (";
        $query .=" '{$nombre}', '{$direccion}', '{$f}' ";
        $query .=")";  //echo $query; exit(0);
        if($db->query($query)){
          //sucess
          $session->msg('s'," Evento Creado, Cargue Fotos");
          redirect('eventos.php', false);
        } else {
          //failed
          $session->msg('d',' Error: No se creo Evento..');
          redirect('eventos.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('eventos.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>CREAR EVENTO</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="add_evento.php">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="nombre" required>
            </div>
            <div class="form-group">
                <label for="username">Direccion</label>
                <input type="text" class="form-control" name="direccion" placeholder="Direccion">
            </div>
              
            <div class="form-group">
                <label for="username">Fecha</label>
                <input type="date" class="form-control" name="fecha" placeholder="fecha"
                       min="2021-10-10" max="2021-12-31"  value="2021-12-25" >
            </div>
              
              
            <div class="form-group clearfix">
              <button type="submit" name="add_evento" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
