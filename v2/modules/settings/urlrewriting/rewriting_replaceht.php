<?php
$prepared_query = 'SELECT * FROM rewriting_url
                   WHERE id_rewriting_url = :id';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $lastid_rewritingurl);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $replaceht_rewritingurl = $data['content_rewriting_url'];
}
$query->closeCursor();

//$pathht = realpath('.htaccess');
$openht = fopen('./.htaccess', 'w');
chmod($openht, 0646);
fwrite($openht, $replaceht_rewritingurl);
$pathht = realpath('.htaccess');
chmod($openht, 0644);
fclose($openht);



?>
