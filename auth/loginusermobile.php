<?php
require_once("vendor/autoload.php");
use \Firebase\JWT\JWT;
define('SECRET_KEY','<SECRET_ENCRYPTION_KEY>');
define('ALGORITHM','HS512');

$conn = new mysqli("localhost","hoogle_admin","hooglepass","hoogle");

function check($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $user = check($_POST["user"]);
    $pass = check($_POST["pass"]);
    
    $verifier = mysqli_fetch_all(mysqli_query($conn, "SELECT password FROM users WHERE username='$user'"),MYSQLI_ASSOC);
    
    
    if (count($verifier)>0&&password_verify($pass, $verifier[0]["password"])){
        $tokenId = base64_encode(random_bytes(32));
        $issuedAt = time();
        $notBefore = $issuedAt + 10;
        $expire = $notBefore + 7200;
        $serverName = "http://localhost/hoogle/auth/";
        
        $data = [
            'iat' => $issuedAt,
            'jti' => $tokenId,
            'iss' => $serverName,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => [
                'user' => $user
            ]
        ];
        
        $secretKey = base64_decode(SECRET_KEY);
        $jwt = JWT::encode(
            $data,
            $secretKey,
            ALGORITHM
        );
        
         $unencodedArray = ['jwt' => $jwt];
        echo '{"status":"success","resp":' . json_encode($unencodedArray).'}';
        
    }
    
    else {
        echo '{"jwt":"'. $pass . '"}';
    }
}
?>
