<?php
  $page_title = 'Editar Usuario';
  require_once('includes/load.php');
  require_once 'metodos.php';
  // Checkin What level user has permission to view this page
   page_require_level(1);
        //error_reporting(E_ALL);
     //ini_set('display_errors', '1');

?>
<?php

    $url_img='eventos/';
    
  $e_user = find_by_id('eventos',(int)$_GET['id']);
  $groups  = find_all('user_groups');
  if(!$e_user){
    $session->msg("d","Missing user id.");
    redirect('eventos.php');
  }
?>

<?php

    if (isset($_FILES['imagen']))
    {
                foreach($_FILES["imagen"]['tmp_name'] as $key => $tmp_name)
                {
                    //Validamos que el archivo exista
              //      echo $key.'<hr>';
                    if($_FILES["imagen"]["name"][$key]) 
                    {
                        $filename = $_FILES["imagen"]["name"][$key];//Obtenemos el nombre original del archivo
                        $source = $_FILES["imagen"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                        //$source = 'evento_'.(int)$e_user['id'].'_'.$key;
                        $directorio = $url_img.'evento_'.(int)$e_user['id']; //Declaramos un  variable con la ruta donde guardaremos los archivos
                                        //Validamos si la ruta de destino existe, en caso de no existir la creamos
                        if(!file_exists($directorio)){
                            mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                        }
                        $dir=opendir($directorio); //Abrimos el directorio de destino
                        $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                        //Movemos y validamos que el archivo se haya cargado correctamente
                        //El primer campo es el origen y el segundo el destino
                        if(move_uploaded_file($source, $target_path)) 
                        {	
   $sql="INSERT INTO fotos_eventos(nombre,fk_id_evento) VALUES ('".$_FILES["imagen"]["name"][$key]."','".(int)$e_user['id']."')" ; 
        if($db->query($sql)){  
            
        } else {
            
        }
                        } else {	

                            }
                            closedir($dir); //Cerramos el directorio de destino
                    }    
                }
                //obtener solo clientes 
                $resp=array();
                obtenerSoloCli($resp);
                $resp_total=array();
                buscarIgualdadClientes('evento_'.(int)$e_user['id'],$resp_total, $resp);
                
           //     print_r($resp_total); echo '<hr>';
                foreach ($resp_total as $valor) 
                {
                    $user=$valor['foto_user'];
          
                        $id_user=$valor['id'];
                        if($id_user>0)
                        {
                            $lista=$valor['lista'];
                            foreach ($lista as $foto)
                            {
                                $sql="SELECT * FROM fotos_eventos WHERE nombre='".$foto."' and fk_id_evento=".(int)$e_user['id']." ";
                         //       echo '<hr>'.$sql.'<hr>';
                                $result = find_by_sql($sql);
                                if($result)
                                {
  $sql="INSERT INTO fotos_clientes(fk_id_fotos,fk_id_cliente, fk_id_evento) VALUES ('".$result[0]['id']."', '".$id_user."', '".(int)$e_user['id']."')";

                                        if($db->query($sql)){  
                                      } else {
                                      }
                                } else {
                                  //$session->msg('d',' Lo siento no se actualizó los datos.');
                                }                        
                            }                            
                        }
                    //}
                }
                
                
                     redirect('eventos.php');   

             
                
    }

//Update User basic info
    /*
  if(isset($_POST['update'])) {
    $req_fields = array('nombre','direccion','fecha');
    validate_fields($req_fields);
    
    if(empty($errors)){
             $id = (int)$e_user['id'];
           $nombre = remove_junk($db->escape($_POST['nombre']));
       $direccion= remove_junk($db->escape($_POST['direccion']));
       $fecha= remove_junk($db->escape($_POST['fecha']));
       
            $sql = "UPDATE users SET name ='{$name}', username ='{$username}',user_level='{$level}',status='{$status}' WHERE id='{$db->escape($id)}'";
         $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Acount Updated ");
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          } else {
            $session->msg('d',' Lo siento no se actualizó los datos.');
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_user.php?id='.(int)$e_user['id'],false);
    }
  }*/
?>
<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
  <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Actualizar Eventos 
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="edit_eventos.php?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Nombre</label>
                  <input type="name" class="form-control" name="nombre" value="<?php echo remove_junk(ucwords($e_user['nombre'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Direccion</label>
                  <input type="text" class="form-control" name="direccion" value="<?php echo remove_junk(ucwords($e_user['direccion'])); ?>">
            </div>

            <div class="form-group">
                  <label for="username" class="control-label">Fecha</label>
                  <input type="text" class="form-control" name="fecha" value="<?php echo remove_junk(ucwords($e_user['fecha'])); ?>">
            </div>
              
              
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info">Actualizar</button>
            </div>
        </form>
       </div>
     </div>
  </div>
  <!-- Change password form -->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Subir Fotos Evento
        </strong>
      </div>
      <div class="panel-body">
          <form action="edit_eventos.php?id=<?php echo (int)$e_user['id'];?>" method="post" 
                class="clearfix" enctype="multipart/form-data">
          <div class="form-group">
              <input type="file" name="imagen[]" value="" multiple="" style="background-color: red">   <br>
          </div>
          <div class="form-group clearfix">
                  <button type="submit" name="update-pass" class="btn btn-danger pull-right">Subir</button>
          </div>
        </form>
      </div>

  </div>

 </div>
<?php include_once('layouts/footer.php'); ?>

  
<?php 
    function obtenerSoloCli(&$resp)
    {
        $sql="SELECT * FROM users WHERE  tipo=2";
        $res=find_by_sql($sql);
        
        foreach ($res as $value) 
        {
            $dato['id']=$value['id'];
            $dato['image']=$value['image'];
            $resp[]=$dato;
        }

    }
?>  
