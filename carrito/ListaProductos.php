<div id="product-grid">
    <div class="txt-heading">
        <div class="txt-heading-label">Productos</div>
    </div>
    <?php
    $query = "SELECT * FROM users 
INNER JOIN fotos_clientes on fotos_clientes.fk_id_cliente= users.id
INNER JOIN fotos_eventos on fotos_eventos.id= fotos_clientes.fk_id_fotos
INNER JOIN eventos on eventos.id= fotos_eventos.fk_id_evento
WHERE users.id=".$_GET['user_id']." and eventos.id=".$_GET['event_id'];
    
  
    
    //$product_array = $shoppingCart->getAllProduct($query);
    $product_array=find_by_sql($sql);
    
    print_r($product_array); exit(0);
    
    if (! empty($product_array)) {
        foreach ($product_array as $key => $value) {
            print_r($value); exit(0);
            ?>
        <div class="product-item">
        <form method="post"
            action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
            <div class="product-image">
                <img src="<?php echo  dirname( __DIR__ ).'/negocio/eventos/evento_'.$event_id.'/'.$value['nombre']; ?>">
                <div class="product-title">
                    <?php echo 'foto'; ?>
                </div>
            </div>
            <div class="product-footer">
                <div class="float-right">
                    <input type="text" name="quantity" value="1"
                        size="2" class="input-cart-quantity" /><input type="image"
                        src="image/add-to-cart.png" class="btnAddAction" />
                </div>
                <div class="product-price float-left"><?php echo '5'; ?></div>
                
            </div>
        </form>
    </div>
    <?php
        }
    }
    ?>
</div>