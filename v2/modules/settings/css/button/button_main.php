<?php
include('modules/settings/css/button/button_getinfo.php');
include('modules/settings/css/button/button_createcontent.php');
if (is_writable('./modules/css/button.css')) {
    echo 'The file is writable: ';
	echo substr(sprintf('%o', fileperms('../../../css/button.css')), -4);
} else {
    echo 'The file is not writable: ';
	echo substr(sprintf('%o', fileperms('../../../css/button.css')), -4);
}
$openht = fopen('./modules/css/button.css', 'w');
chmod($openht, 0646);
fwrite($openht, $content_buttoncss);
$pathht = realpath('./modules/css/button.css');
chmod($openht, 0644);
fclose($openht);
?>
