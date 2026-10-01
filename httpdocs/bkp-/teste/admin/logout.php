<?
session_start();
$_SESSION["pppp_cd_usuario"] = 0;
$_SESSION["pppp_nome"] = "";
$_SESSION["pppp_nivel"] = -1;
header("location:login.php?mensagem=success");
?>