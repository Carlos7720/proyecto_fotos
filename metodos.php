<?php 
    //    error_reporting(E_ALL);
      //  ini_set('display_errors', '1');
?>
<?php
  $page_title = 'Eventos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
//  page_require_level(1);
  $groups = find_all('user_groups');
?>


<?php 
	require 'vendor/autoload.php';
	use Aws\Rekognition\RekognitionClient;
	//buscarIgualdadClientes('evento_1');

    function buscarIgualdadClientes($evento,&$resp_total, $clientes)
    {
		$credentials = new Aws\Credentials\Credentials('AKIARRUCF2L34P5QVSXP', 'fGQOwG02PnR9lgapw5Y8WnbNrOK4qVs3K2bfBsL7');
		$rekognitionClient = RekognitionClient::factory(array(
		    		'region'	=> "us-east-1",
		    		'version'	=> 'latest',
		        'credentials' => $credentials
		));
//...............LISTAR FOTOS DE USUARIOS		
		//$v_clientes=array();
		$carpeta_origen=dirname( __DIR__ ).'/negocio/uploads/users';
		//echo $carpeta_origen.'<hr>';
		//listarArchivosFotosClientes($carpeta_origen, $v_clientes );
		//print_r($v_clientes);
		$sw_nombre=true;
//...............busqueda de fotos del evento   
                $carpeta_origen=dirname( __DIR__ ).'/negocio/eventos/'.$evento;
              //  echo '<hr>'.$carpeta_origen.'<hr>';
		    $v_fotos=array();
		    listarArchivosFotos($carpeta_origen, $v_fotos );
		//    print_r($v_fotos);
		foreach ($clientes as $cliente) 
		{
                    
		    $dato=array('foto_user'=>'','evento'=>'', 'id'=>0);  $fotos=array();
		    $cont=1;
		    foreach ($v_fotos as $foto)
		    {
		        $resp=false;
                        $foto_cliente=dirname( __DIR__ ).'/negocio/uploads/users/'.$cliente['image'];
		        buscar($foto_cliente,$carpeta_origen.'/'.$foto , $resp,$rekognitionClient);
		        if($resp)
                        {
		            if($sw_nombre)
                            {$dato['foto_user']=$cliente['image'];  
                                $dato['id']=$cliente['id'];  $dato['evento']=$evento;
                                $sw_nombre=false;  
                            }
		            $fotos[]=$foto;
		        }
		        $cont++;
		    }
		    if(count($fotos) >0){$dato['lista']=$fotos;   $resp_total[]=$dato;  }
		    $fotos=null; $dato=null;
		    $sw_nombre=true;        
                }
    }
                
     
    function insertarEveFotosCli($informacion, $resp)
    {
        
        foreach ($informacion as $valor) 
        {
            
        }
    }
    
    
    function buscarIgual()
    {
        
		$credentials = new Aws\Credentials\Credentials('AKIARRUCF2L34P5QVSXP', 'fGQOwG02PnR9lgapw5Y8WnbNrOK4qVs3K2bfBsL7');
		$rekognitionClient = RekognitionClient::factory(array(
		    		'region'	=> "us-east-1",
		    		'version'	=> 'latest',
		        'credentials' => $credentials
		));
		
		
		$foto_cliente='img/c2.jpg';
		$v_eventos=array();
		

		
		
		$carpeta_origen=dirname( __DIR__ ).'/reconocimiento/img/eventos';
		
		listarArchivos($carpeta_origen, $v_eventos );
		

		$resp_total=array();
		$sw_nombre=true;
		
		foreach ($v_eventos as $event) 
		{
		    $carpeta_origen_fotos=dirname( __DIR__ ).'/reconocimiento/img/eventos/'.$event;
		    $v_fotos=array();
		    listarArchivosFotos($carpeta_origen_fotos, $v_fotos );

		    $dato=array('evento_id'=>'');  $fotos=array();
		    $cont=1;

		    foreach ($v_fotos as $foto)
		    {
		    	echo $cont.'<br>';
		        $resp=false;

		        buscar($foto_cliente,$carpeta_origen_fotos.'/'.$foto , $resp,$rekognitionClient);

		        if($resp){
		            if($sw_nombre){$dato['evento_id']=$event;$sw_nombre=false;  }
		            $fotos[]=$foto;
		            
		        }
		        $cont++;
		    }
		    if(count($fotos) >0){$dato[]=$fotos;   $resp_total[]=$dato;  }
		    $fotos=null; $dato=null;
		    $sw_nombre=true;
    
		}

		
    }	

                    /**
                 * 
                 * @param type $origen FOTO SOLO DE LA PERSONA
                 * @param type $entorno FOTO DONDE SE BUSCARA
                 * @param type $resp TRUE=ESTA , FALSE= NO ESTA
                 * @param type $rekognitionClient
                 */
		function buscar($origen, $entorno, &$resp=false,$rekognitionClient)
		{
		    //Calling Compare Face function
			//echo 'ENTRO';
		    $compareFaceResults= $rekognitionClient->compareFaces([
		        'SimilarityThreshold' => 80,
		        'SourceImage' => [
		            'Bytes' => file_get_contents($origen)
		        ],
		        'TargetImage' => [
		            'Bytes' => file_get_contents($entorno)
		        ],
		    ]);
		    foreach ($compareFaceResults  as $key => $value)
		    {
		        if($key ==='FaceMatches')
		        {
		            if(count($value) > 0)
		            {
		                $resp=true; return;
		            }else  $resp=false;
		        }
		    }
		    
		    
		}

		function listarArchivos($carpeta_origen, &$v_files )
		{


			    $listado = scandir($carpeta_origen);
			    unset($listado[array_search('.', $listado, true)]);
			    unset($listado[array_search('..', $listado, true)]);
			    if (count($listado) < 1) {
			        return;
			    }
			    foreach($listado as $elemento){
			        if(is_dir($carpeta_origen.'/'.$elemento)) {
			        	$v_files[]=$elemento;
			        }
			    }			
		    
		    
		}
/**
 * 
 * @param type $carpeta_origen
 * @param type $v_files
 */
		function listarArchivosFotosClientes($carpeta_origen, &$v_files )
		{
		    $handler;
		    if ($handler = opendir($carpeta_origen))
		    {
		    	$file; $extension;
		        while (false !== ($file = readdir($handler)))
		        {
		   
		            $extension = end(explode('.',$file));
		            if($extension == 'png'
		                || $extension == 'gif'
		                || $extension == 'jpg')
		            {
		                $v_files[]=$file;
		            }
		        }
		        closedir($handler);
		    }
		    else echo 'ERROR: NO FILES';
		}
                
                
		function listarArchivosFotos($carpeta_origen, &$v_files )
		{
		    $handler;
		    if ($handler = opendir($carpeta_origen))
		    {
		    	$file; $extension;
		        while (false !== ($file = readdir($handler)))
		        {
		   
		            $extension = end(explode('.',$file));
		            if($extension == 'png'
		                || $extension == 'gif'
		                || $extension == 'jpg')
		            {
		                $v_files[]=$file;
		            }
		        }
		        closedir($handler);
		    }
		    else echo 'ERROR: NO FILES';
		}
		
		
		//Response to JSON Data
		/*
		$FaceMatchesResult = $compareFaceResults['FaceMatches'];
		$SimilarityResult =  $FaceMatchesResult['Similarity']; //Here You will get similarity
		$sourceImageFace = $compareFaceResults['SourceImageFace'];
		$sourceConfidence = $sourceImageFace['Confidence']; //Here You will get confidence of the picture
		  */  

?>
