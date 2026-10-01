<?
session_start();
$_SESSION["yasoft_cd_usuario"] = 0;
$_SESSION["yasoft_nome"] = "";
$_SESSION["yasoft_nivel"] = -1;
header("location:login.php?mensagem=success");
?>