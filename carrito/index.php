<?php
        error_reporting(E_ALL);
     ini_set('display_errors', '1');


     
     require_once('sql.php');
     
require_once "CarritoCompras.php";

$member_id = 2; // you can your integerate authentication module here to get logged in member

$shoppingCart = new ShoppingCart();

$_GET["user_id"]=11; $_GET["event_id"]=2;


$user_id=0; $event_id=0;

    if (! empty($_GET["user_id"])) 
    {
        $user_id=$_GET["user_id"]; $event_id=$_GET["event_id"];
    }


if (! empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (! empty($_POST["quantity"])) {
                
                $productResult = $shoppingCart->getProductByCode($_GET["code"]);
                
                $cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $member_id);
                
                if (! empty($cartResult)) {
                    // Update cart item quantity in database
                    $newQuantity = $cartResult[0]["quantity"] + $_POST["quantity"];
                    $shoppingCart->updateCartQuantity($newQuantity, $cartResult[0]["id"]);
                } else {
                    // Add to cart table
                    $shoppingCart->addToCart($productResult[0]["id"], $_POST["quantity"], $member_id);
                }
            }
            break;
        case "remove":
            // Delete single entry from the cart
            $shoppingCart->deleteCartItem($_GET["id"]);
            break;
        case "empty":
            // Empty cart
            $shoppingCart->emptyCart($member_id);
            break;
    }
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">
<title>CUENTA</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">

</head>

<body>


<!-- Begin page content -->

<div class="container">
  <h3 class="mt-5">Fotos</h3>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
      

<?php
$cartItem = $shoppingCart->getMemberCartItem($member_id);
$item_quantity = 0;
$item_price = 0;
if (! empty($cartItem)) {
    if (! empty($cartItem)) {
        foreach ($cartItem as $item) {
            $item_quantity = $item_quantity + $item["quantity"];
            $item_price = $item_price + ($item["price"] * $item["quantity"]);
        }
    }
}
?>
<div id="shopping-cart">
        <div class="txt-heading">
            <div class="txt-heading-label">Carrito de Compras</div>

            <a id="btnEmpty" href="index.php?action=empty"><img
                src="image/empty-cart.png" alt="empty-cart"
                title="Carta vacia" class="float-right" /></a>
            <div class="cart-status">
                <div>Total Cantidad: <?php echo $item_quantity; ?></div>
                <div>Total Pricio: $ <?php echo $item_price; ?></div>
            </div>
        </div>
        <?php
        if (! empty($cartItem)) {
            ?>
<?php
            require_once ("ListaCarrito.php");
            ?>  
            <div class="align-right">
            <a href="ProcesoPago.php"><button class="btn-action" name="check_out">Ir a Pagos</button></a>
            </div>
<?php
        } // End if !empty $cartItem
        ?>

</div>
<?php
    require_once  'ListaProductos.php';
?>
    

      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 

  
</div>
<!-- Fin container -->
<footer class="footer">
  <div class="container"> <span class="text-muted">
    <p>Gesti&oacute;n 2021</p>
    </span> </div>
</footer>
<script src="assets/jquery-1.12.4-jquery.min.js"></script> 

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>