<?
$dir = "./";
if ($dh = opendir($dir)) {
	while (($file = readdir($dh)) !== false) {
		if (($file != ".") && ($file != "..")) {
			if (strpos($file, ".thumb_") > 0) {
				unlink($dir . $file);
				echo "<b>Arquivo excluído: " . $dir . $file . "</b><br>";
			} else {
				echo "Arquivo não excluído: " . $dir . $file . "<br>";
			}
		}
	}
}
?>