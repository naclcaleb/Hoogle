<?php
include 'auth/validate.php';

if (validate()){
	
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hoogle</title>
        <meta charset='utf-8'>
		<link rel="stylesheet" type="text/css" href="templates/hoogle_styles_main.css">
		<style>
			object {
				width:100%;
			}
			
			:root {
				--primary-color:rgb(100,100,200);
				--header-color:rgb(50,50,200);
			}
		</style>
    </head>
    <body>
        <object data="templates/header.html"></object>
		<header><a>Hi</a><a class="active">There</a><a class="dark">Okay</a></header>
		<button>Press Me!</button>
		<input>
		<p>This is a block of text that is supposed to be very long in order to sufficiently test it because that's what we need to do with it.<a class="dark inline">Random Link</a>. This is a block of text that is supposed to be very long in order to sufficiently test it because that's what we need to do with it.This is a block of text that is supposed to be very long in order to sufficiently test it because that's what we need to do with it.This is a block of text that is supposed to be very long in order to sufficiently test it because that's what we need to do with it.
		
		</p>
		
    </body>
</html>