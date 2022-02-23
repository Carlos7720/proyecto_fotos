<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    header("HTTP/1.1 200 OK");
    date_default_timezone_set('America/La_Paz');


    if(!empty($_GET['hora']))
    {

        include_once 'dgestor_bd.php';
        echo '1111'.$_GET['dispositivo'].'-'.$_GET['accion'].'-'.$_GET['dia'].'-'.$_GET['hora'].'<hr>'    ;

        if(     (!empty($_GET['dispositivo'])) &&
                (!empty($_GET['acccion'])) &&
                (!empty($_GET['dia'])) &&
                (!empty($_GET['hora']))
            )
        {
            echo '2222';

            $valor='';$newHora='';$newMin='';
            convertir($_GET["hora"], $valor, $newHora, $newMin);
            completarHora($valor[0], $newHora);
            completarMin($valor[1], $newMin);
            
            
            $bd=new bd_class();$mensaje='';

            $bd->conectarbd($mensaje);

            echo $newHora;

            if($mensaje=='ok')
            {
                    $datos=array();$tuplas=array();

                    $bd->selectSql("select * from accion_user au ", $datos, $tuplas, $mensaje);
                    if($mensaje=='ok')
                    print_r($tuplas);
                
            }
            else echo mensaje;
            
          
        }   
        else echo 'zzz';
        
    }
    else echo 'XXX';

    
    
    function convertir($hora, &$valor, &$newHora, &$newMin)
    {
        $dato= explode(':', $hora);
        $valor=("$dato[0]"."$dato[1]");
        $newHora="$dato[0]";$newMin="$dato[1]";
    }
    function completarHora($hora, $newHora)
    {
        $num= $hora *1;
        if($num == 0)
            $newHora='00';
        if($num>0  && $num <10)    
            $newHora="$num".'0';
    }
    function completarMin($min, $newMin)
    {
        $num= $min *1;
        if($num == 0)
            $newHora='00';
        if($num>0  && $num <10)    
            $newHora='0'."$num"; 
        if($num >=10)    
            $newHora="$num";
    }

?>