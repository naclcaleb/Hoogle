<?php
require_once("vendor/autoload.php");
use \Firebase\JWT\JWT;
define("SECRET_KEY","kX0EAx5TIX78GyHfrGJycS0BlrOgB_3NoSlZjsqK");
define("ALGORITHM","HS512");

$token = htmlspecialchars(stripslashes(trim($_GET["token"])));

try {
    $secretKey = base64_decode(SECRET_KEY);
    $DecodedDataArray = JWT::decode($token,$secretKey,array(ALGORITHM));
    
    echo '{"status":"success", "data":'.json_encode($DecodedDataArray)."}";die();
}catch (Exception $e){
    echo '{"status":"fail","msg":"Unauthorized"}';die();
}
?>