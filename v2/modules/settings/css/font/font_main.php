<?php
include('modules/settings/css/font/font_getinfo.php');
include('modules/settings/css/font/font_createcontent.php');
$openht = fopen('./modules/css/font.css', 'w');
chmod($openht, 0646);
fwrite($openht, $content_fontcss);
$pathht = realpath('./modules/css/font.css');
chmod($openht, 0644);
fclose($openht);
?>
