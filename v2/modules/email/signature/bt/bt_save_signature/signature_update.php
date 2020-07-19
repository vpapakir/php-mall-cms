<?php
$prepared_query = 'UPDATE `email_signature` 
                   SET scriptpath_signature = :scriptpath, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i == ($count - 1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'T = "'.$signature_name[$i].'", L'.$main_activatedidlang[$i].'S = "'.$signature_content[$i].'" '; 
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'T = "'.$signature_name[$i].'", L'.$main_activatedidlang[$i].'S = "'.$signature_content[$i].'", '; 
    }
}

$prepared_query .= 'WHERE id_signature = :id';

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'scriptpath' => $signature_scriptpath,
                      'id' => $signature_selected    
                      ));
$query->closeCursor();

$_SESSION['signature_txtScriptpathSignature'] = $signature_scriptpath;
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $_SESSION['signature_txtNameSignature'.$main_activatedidlang[$i]] = $signature_name[$i];
    $_SESSION['signature_areaContentSignature'.$main_activatedidlang[$i]] = stripslashes($signature_content[$i]);
}

$_SESSION['msg_signature_done'] = str_replace('[#]', '"'.$signature_name[$signature_name_selectedlang].'"', $msg_done_signature_edit);
?>
