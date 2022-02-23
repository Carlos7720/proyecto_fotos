<?php
  $page_title = 'Home';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
 <div class="col-md-12">
    <div class="panel">
      <div class="jumbotron text-center">
       
          
        <?php 
        /*
            if($_SESSION['id_pizarra'] != '' )
            {    
        ?>  
          <iframe src="<?php echo $_SESSION['id_pizarra'];?>" height="800" width="1400">
          </iframe>

        <?php 
            }
            else
            {
        ?>  
          <iframe src="https://app.excalidraw.com/l/GpZeNs4Zfd/9xqGfqACaWN" height="800" width="1400">
          </iframe>

        <?php 
            }
         * 
         * 
         */
        ?>  
          
          
          
     
      </div>
    </div>
 </div>
</div>
<?php include_once('layouts/footer.php'); ?>
