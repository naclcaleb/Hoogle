<?php
session_start();
if (isset($_SESSION["user"])){
	$app = htmlspecialchars(stripslashes(trim($_GET["app"])));
	$app_file = fopen("../$app/plugin.json","r");
	$json = json_decode(fread($app_file,"20000"),true);
	
	$app_name = $json["name"];
	$app_permissions = explode(",",$json["permissions"]);
	$app_action = $json["action"];
}else {
	header("Location: http://localhost/hoogle/auth/login?redirect=" . urlencode($_SERVER["REQUEST_URI"]));
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="http://localhost/hoogle/templates/hoogle_styles_main.css">
		<title>Hoogle - New App</title>
		<meta charset='utf-8'>
	</head>
	<body>
		<div class="form">
			<h1><?php echo $app_name;?> would like to:</h1>
			<ul>
				<?php
				foreach ($app_permissions as $p){
					
				?>
					<li><?php if ($p==="r"){echo "View your Hoogle Drive";}else if ($p==="w"){ echo "Edit your Hoogle Drive Files";}?></li><br>
				<?php }?>
			</ul><br>
			<button onClick="action()">Agree</button>
		</div>
		
		<script>
			function action(){
				window.location = "<?php echo $app_action;?>";
			}
		</script>
	</body>
</html>