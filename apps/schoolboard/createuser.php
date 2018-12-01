<?php
session_start();



if (isset($_SESSION["user"])){

$hoogle = new mysqli("localhost","hoogle_admin","hooglepass","hoogle");

$hoogle_data = mysqli_fetch_all(mysqli_query($hoogle,"SELECT * FROM users WHERE username='" . $_SESSION["user"] . "';"),MYSQLI_ASSOC);
	



$ip = "localhost";
$conn = new mysqli($ip,"schoolboard_admin","admin_password","schoolboard");

function uniqueUname($u){
    $users = mysqli_fetch_all(mysqli_query($conn,"SELECT username FROM users;"),MYSQLI_ASSOC);
    foreach ($users as $usr ){
        if ($u == $usr["username"]){
            return false;
        }
    }
    return true;
}


    $first = $hoogle_data[0]["first"];
    $last = $hoogle_data[0]["last"];
    $email = $hoogle_data[0]["email"];
    $user = $hoogle_data[0]["username"];
    $pass = $hoogle_data[0]["password"];
    $parent = "none";
    $folder = $hoogle_data[0]["folder"];
	$image = "http://localhost/hoogle/user-data/profile-empty.jpg";
	
	if (isset($_SESSION["user"]) && isset($_SESSION["pass"])){
		
		if ($parent!=="none"){
		
		$duser = new User();
		$user_folder = $duser->getFolder();
		$folder = "$user_folder/" . $first . "/";
		}
		echo $folder;
	}
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION["error"] = "Please enter a valid email";
		echo "Ha";
    }
	
	
    
    else {
		echo "hi";
        $query = $conn->prepare("INSERT INTO users(first, last, email, username, password, folder, parent,image) VALUES(?,?,?,?,?,?,?,?);");
        $query->bind_param("ssssssss",$first,$last,$email,$user,$pass,$folder,$parent,$image);
        $query->execute();
        
        mkdir("/var/www/html/hoogle/user-data/" . $folder);
        $htaccess = fopen("/var/www/html/hoogle/user-data/" . $folder . "/.htaccess","w");
        $c = "order deny,allow\ndeny from all\nallow from $ip";
        fwrite($htaccess,$c);
		
		mkdir("/var/www/html/hoogle/user-data/" . $folder . "/.schedule/");
		$sched = fopen("/var/www/html/hoogle/user-data/" . $folder . "/.schedule/master.sched","w");
		fwrite($sched, "<?xml version='1.0' encoding='utf-8'?>\n<SCHEDULE>\n<TABLE>\n\n</TABLE>\n</SCHEDULE>");
        
        #Log in the User if it is not a child account
        if ($parent == "none"){
            $_SESSION["user"] = $user;
        }
               
    }
     header("Location: http://$ip/template/dashboard");


}
else {
	header("Location: http://localhost/hoogle/auth/login?redirect=apps/schoolboard/plugin.html");
}

?>