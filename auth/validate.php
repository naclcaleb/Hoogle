<?php
session_start();

function validate(){
	if (isset($_SESSION["user"])){ return true; }
	return false;
}
?>