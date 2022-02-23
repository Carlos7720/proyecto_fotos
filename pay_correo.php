<?php
//Leer POST del sistema de PayPal y añadir ‘cmd’

$req = 'cmd=_notify-validate';

 

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

 

//header para el sistema de paypal
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
//header para el correo
$headers = 'From: '. CORREO_PAYPAL. "\r\n" .
'Reply-To: '.CORREO_PAYPAL . "\r\n" .
'X-Mailer: PHP/' . phpversion();
//Si estamos usando el testeo de paypal:
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
//En caso de querer usar PayPal oficialmente:
//$fp = fsockopen (‘ssl://www.paypal.com’, 443, $errno, $errstr, 30);
if (!$fp) {
// ERROR DE HTTP
echo "no se ha aiberto el socket<br/>";
}else{ echo "si se ha abierto el socket<br/>";
fputs ($fp, $header . $req);
    while (!feof($fp)) 
    {
            $res = fgets ($fp, 1024);
            if (strcmp ($res, "VERIFIED") == 0) 
            {
            foreach($_POST as $key => $value){
            $recibido.= $key." = ". $value."\r\n";
            }
               mail("correo", "NOTIFICACION DE PAGO", $recibido , $headers);

            } else if (strcmp ($res, "INVALID") == 0) {
            mail("correo", "NOTIFICACION DE PAGO INVALIDA", "invalido",$headers);}
    }fclose ($fp);

}

 

?>