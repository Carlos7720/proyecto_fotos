<?php 

        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        
    function buscarIgual()
    {
        
		require 'vendor/autoload.php';
		use Aws\Rekognition\RekognitionClient;
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
//		echo '....<br>'; print_r($resp_total); exit(0);
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
		               // echo $value[0]['Similarity'].'<hr>';
		                $resp=true;
		            }else  $resp=false;
		        }
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
		$FaceMatchesResult = $compareFaceResults['FaceMatches'];
		$SimilarityResult =  $FaceMatchesResult['Similarity']; //Here You will get similarity
		$sourceImageFace = $compareFaceResults['SourceImageFace'];
		$sourceConfidence = $sourceImageFace['Confidence']; //Here You will get confidence of the picture
		    

?>
