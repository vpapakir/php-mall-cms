<?php
include('modules/settings/css/block/block_getinfo.php');
include('modules/settings/css/block/block_createcontent.php');
$openht = fopen('./modules/css/block.css', 'w');
chmod($openht, 0646);
fwrite($openht, $content_blockcss);
$pathht = realpath('./modules/css/block.css');
chmod($openht, 0644);
fclose($openht);
?>
