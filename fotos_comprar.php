<?php
  require_once('includes/load.php');
  $user = current_user(); 
    //print_r($_POST);
    
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
  
  
    $id_evento=$_POST['id_evento'];
    $id_cliente=$_POST['id_cliente'];
    $lista=$_POST['ids'];
    
    //$sw_compra=true;
    
    
    $amount = 0.01; 
    $concept = 'COMPRA DE FOTOS';
    $order = date('ymdHis');

    //if($sw_compra)
    //{
        foreach ($lista as $value) 
        {
            $sql="UPDATE fotos_clientes SET compro='1' WHERE  fk_id_fotos=".$value."  and   fotos_clientes.fk_id_cliente=".$id_cliente;
            if($db->query($sql)){
            } else {
              //failed
              $session->msg('d',' Error: Update fotos de clientes');
            }
        }
    //}
        
    
    
    ?>
    <?php include_once('layouts/header.php'); ?>
    <div class="loading">Un momento....</div>
    
    <form id="realizarPago" action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input name="cmd" type="hidden" value="_cart" />
        <input name="upload" type="hidden" value="1" />
        <input name="business" type="hidden" value="josely1984@hotmail.com" />
        <input name="shopping_url" type="hidden" value="http://<?php echo IP_URL;?>/negocio" />
        <input name="currency_code" type="hidden" value="USD" />
        <input name="return" type="hidden" value="http://<?php echo IP_URL;?>/negocio/eventos_cliente.php" />
        <input name="notify_url" type="hidden" value="http://<?php echo IP_URL;?>/negocio/pay_correo.php" />

        <input name="rm" type="hidden" value="2" />
        <input name="item_number_1" type="hidden" value="<?php echo $order; ?>" />
        <input name="item_name_1" type="hidden" value="<?php echo $concept; ?>" />
        <input name="amount_1" type="hidden" value="<?php echo $amount; ?>" />
        <input name="quantity_1" type="hidden" value="1" /> 

    </form>    

    <script>
    $(document).ready(function () {
        $("#realizarPago").submit();
    });
    </script>    
    
    <?php
    

?>
<?php include_once('layouts/footer.php'); ?>