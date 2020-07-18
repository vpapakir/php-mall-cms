<?php
$prepared_query = 'INSERT INTO `email_signature` 
                   (scriptpath_signature, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i == ($count - 1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'T, L'.$main_activatedidlang[$i].'S)'; 
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'T, L'.$main_activatedidlang[$i].'S, '; 
    }
}

$prepared_query .= 'VALUES 
                   (:scriptpath, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i == ($count - 1))
    {
        $prepared_query .= '"'.$signature_name[$i].'", "'.$signature_content[$i].'")'; 
    }
    else
    {
        $prepared_query .= '"'.$signature_name[$i].'", "'.$signature_content[$i].'", '; 
    }
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('scriptpath', $signature_scriptpath);
$query->execute();
$query->closeCursor();

$_SESSION['msg_signature_done'] = str_replace('[#]', '"'.$signature_name[$signature_name_selectedlang].'"', $msg_done_signature_add);
?>
