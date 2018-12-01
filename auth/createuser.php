<?php
$conn = new mysqli("localhost","hoogle_admin","hooglepass","hoogle");

function check($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $user = check($_POST["user"]);
    $pass = check($_POST["pass"]);
    $first = check($_POST["first"]);
    $last = check($_POST["last"]);
    $email = check($_POST["email"]);
	$folder = uniqid();
	$parent = "none";
	$image = "http://localhost/hoogle/user-data/profile-empty.jpg";
    
    $username_duplicates = mysqli_fetch_all(mysqli_query($conn,"SELECT username FROM users WHERE username='$user';"),MYSQLI_ASSOC);
    
    $email_duplicates = mysqli_fetch_all(mysqli_query($conn,"SELECT email FROM users WHERE email='$email';"),MYSQLI_ASSOC);
    
    if (count($email_duplicates)==0&&count($username_duplicates)==0&&filter_var($email,FILTER_VALIDATE_EMAIL)){
        
        $query = $conn->prepare("INSERT INTO users(username,password,email,first,last,folder, parent, image) VALUES(?,?,?,?,?,?,?,?);");
        
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        
        $query->bind_param("ssssssss",$user, $hashed_password, $email, $first, $last,$folder,$parent,$image);
        
        $query->execute();
		
		mkdir("/var/www/html/hoogle/user-data/" . $folder);
		
		mkdir("/var/www/html/hoogle/user-data/" . $folder . "/.schedule/");
		$sched = fopen("/var/www/html/hoogle/user-data/" . $folder . "/.schedule/master.sched","w");
		fwrite($sched, "<?xml version='1.0' encoding='utf-8'?>\n<SCHEDULE>\n<TABLE>\n\n</TABLE>\n</SCHEDULE>");
    
        session_start();
        $_SESSION["user"] = $user;
        
    } else {
        $error = "";
        
        if (count($username_duplicates)>0){ $error = "Sorry, that username is taken";}
        if (count($email_duplicates)>0){ $error = "Sorry, that email is taken";}
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ $error = "Please enter a valid email";}
        if($error == ""){ $error = "Please fill in all the fields";}
        echo $error;
    }
}
?>