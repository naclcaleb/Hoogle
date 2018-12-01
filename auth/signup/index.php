<?php
session_start();
if (isset($_SESSION["user"])){
    header("Location: http://localhost/hoogle");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hoogle - Create Account</title>
        <meta charset='utf-8'>
        <link rel="stylesheet" type="text/css" href="../../templates/hoogle_styles_main.css">
    </head>
    <body>
        <div class="form">
            <h1>Create an Account</h1>
        <p>Please fill out the form below, and you'll have access to all our products in no time!</p>
            
            <input id="first_name" placeholder="First Name">
            
            <input id="last_name" placeholder="Last Name">
            
            <input id="email" placeholder="Email">
            
            <input id="username" placeholder="Username">
            
            <input id="password" type="password" placeholder="Password"><br>
            <button onClick="submit()">Submit</button>
            <br>
            <p id="error" class="error"></p>
            <br><br>
            <h5>By Signing up, you agree to our Privacy Policy and Terms of Service</h5>
            <h5>Already have an account? <a href="../login">Log In here</a></h5>
            
        </div>
        
        <script src="https://code.jquery.com/jquery.min.js"></script>
        <script>
            var first = document.getElementById("first_name");
            var last = document.getElementById("last_name");
            var email = document.getElementById("email");
            var user = document.getElementById("username");
            var pass = document.getElementById("password");
            var error = document.getElementById("error")
            
            function submit(){
                
                $.ajax({
                    url:"../createuser.php",
                    method:"POST",
                    data:{
                        first:first.value,
                        last:last.value,
                        email:email.value,
                        user:user.value,
                        pass:pass.value
                    },
                    success:function(res){
                       var data = res;
                        if (data.length===0){
							window.location.reload(true);
							
						}
						else {
							error.textContent = data;
						}
                    }
                });
            }
        </script>
    </body>
</html>