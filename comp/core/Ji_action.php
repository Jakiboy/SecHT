<?php
/**
 * @author JIHAD SINNAOUR
 * @copyright 2015 (c)Viaprestige Web Agency
 */

//Get Vars
$name= $_POST['nameput'];
$pass= $_POST['passput'];
$path= $_POST['pathput'];
$auth= $_POST['authput'];
if (empty($auth)) {
  $auth="Admin";
}
if (empty($path)) {
  $path=$path;
}
if (empty($name)|| empty($pass)) {
	echo 'Error! nothing to generate, please try agin';
	exit();
}
// Encrypt password, MD5 algorithm
$password = crypt($pass, base64_encode($pass)); // Base64 coding
$password = $name.':'.$password;
// Writing Mode
$directory = "../../export"; // Exportation_folder's name
	if (!is_dir($directory)) { // Creating folder if not exists, to avoid bugs
		mkdir($directory);
	}
?>
<!--Writing htpasswd file-->
<?php
$htfiles = fopen($directory.'/.htpasswd', 'w');
// data
fwrite($htfiles, $password);
?>
<!--Writing htaccess file-->
<?php
$htfiles = fopen($directory.'/.htaccess', 'w');
// data
fwrite($htfiles, 'AuthType Basic'."\r\n");
fwrite($htfiles, 'AuthName "'.$auth.'"'."\r\n");
fwrite($htfiles, 'AuthUserFile "'.$path.'"'."\r\n");
fwrite($htfiles, 'Require valid-user');
?>
<!--Zipping files-->
<?php
$files = array('../../export/.htaccess', '../../export/.htpasswd');
$zip = new ZipArchive;
$zip->open('../../export/htfiles.zip', ZipArchive::CREATE);
foreach ($files as $file) {
  $zip->addFile($file);
}
$zip->close();
?>
<!--Fishing results-->
<?php
include('./Ji_download.jiphp');
?>