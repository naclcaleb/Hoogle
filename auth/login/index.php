<?php
session_start();

$redirect = htmlspecialchars(stripslashes(trim($_GET["redirect"])));

if (strlen($redirect)==0){
     $redirect = "hoogle";
}

if (isset($_SESSION["user"])){
    header("Location: http://localhost/" . $redirect);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hoogle - Login</title>
        <meta charset='utf-8'>
        <link rel="stylesheet" type="text/css" href="../../templates/hoogle_styles_main.css">
    </head>
    <body>
        <div class="form">
            <h1>Log In</h1>
        <p>to your Hoogle account</p>
            
            <input id="username" placeholder="Username">
            
            <input id="password" type="password" placeholder="Password"><br>
            <button onClick="submit()">Submit</button>
            <br>
            <p id="error" class="error"></p>
            <br><br>
            <h5>By Signing up, you agree to our Privacy Policy and Terms of Service</h5>
            <h5>Don't have an account? <a href="../signup">Create one</a></h5>
            
        </div>
        
        <script src="https://code.jquery.com/jquery.min.js"></script>
        <script>
            var user = document.getElementById("username");
            var pass = document.getElementById("password");
            var error = document.getElementById("error")
            
            function submit(){
                
                $.ajax({
                    url:"../loginuser.php",
                    method:"POST",
                    data:{
                        user:user.value,
                        pass:pass.value
                    },
                    success:function(res){
                       var data = res;
                        if (data.length===0) {
                            window.location = "http://localhost/<?php echo $redirect;?>";
                        }else {
                            error.textContent = data;
                        }
                    }
                });
            }
        </script>
    </body>
</html>