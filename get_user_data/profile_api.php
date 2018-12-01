<?php
session_start();
include '../auth/validate.php';

if (validate()){
	$udc = new mysqli("localhost","hoogle_admin","hooglepass","hoogle");
	
	class User {
    
    function getUsername(){
        return $_SESSION["user"];
    }
    function isParent(){
        global $udc;
        $tmp = mysqli_fetch_all(mysqli_query($udc,"SELECT parent FROM users WHERE username='" . $_SESSION["user"] . "';"),MYSQLI_ASSOC);
        
        if ($tmp[0]["parent"] == "none"){
            return true;
        }
        return false;
    }
    
    function getFolder(){
        global $udc;
		$tmp = mysqli_fetch_all(mysqli_query($udc,"SELECT folder FROM users WHERE username='" . $_SESSION["user"] . "';"),MYSQLI_ASSOC);
        return $tmp[0]["folder"];
    }
    
    function getImage(){
        global $udc;
        $tmp = mysqli_fetch_all(mysqli_query($udc,"SELECT image FROM users WHERE username='" . $_SESSION["user"] . "';"),MYSQLI_ASSOC);
        
        return $tmp[0]["image"];
    }
	
	function getEmail(){
        global $udc;
        $tmp = mysqli_fetch_all(mysqli_query($udc,"SELECT email FROM users WHERE username='" . $_SESSION["user"] . "';"),MYSQLI_ASSOC);
        
        return $tmp[0]["email"];
    }
	
	function getName(){
		global $udc;
        $tmp = mysqli_fetch_all(mysqli_query($udc,"SELECT first,last FROM users WHERE username='" . $_SESSION["user"] . "';"),MYSQLI_ASSOC);
        
        return $tmp[0]["first"] . " " . $tmp[0]["last"];
	}
	
	function setPicture($f){
		global $udc;
        $query = $udc->prepare("UPDATE users SET image=? WHERE username='" . $_SESSION["user"] . "';");
		$query->bind_param('s',$f);
		$query->execute();
        
	}
	
}
}else {
echo "Error. You are not logged in.";
}
?>