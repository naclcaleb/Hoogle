<?php
$conn = new mysqli("localhost","hoogle_admin","hooglepass","hoogle");

function check($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $user = check($_POST["user"]);
    $pass = check($_POST["pass"]);
    
    $verifier = mysqli_fetch_all(mysqli_query($conn, "SELECT password FROM users WHERE username='$user'"),MYSQLI_ASSOC);
    
    
    if (count($verifier)>0&&password_verify($pass, $verifier[0]["password"])){
        session_start();
        $_SESSION["user"] = $user;
    }
    
    else {
        $error = "";
		$error = "Invalid Username or Password";
		
		echo $error;
    }
}
?>