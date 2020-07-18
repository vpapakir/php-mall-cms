<?php
$prepared_query = 'INSERT INTO `email_mailtext` 
                   (status_mailtext, family_mailtext, sendername_mailtext, 
                    senderemail_mailtext, bcc_mailtext, scriptpath_mailtext, 
                    idsignature_mailtext, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i == ($count - 1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'S, L'.$main_activatedidlang[$i].'T, L'.$main_activatedidlang[$i].'P1, L'.$main_activatedidlang[$i].'P2)'; 
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'S, L'.$main_activatedidlang[$i].'T, L'.$main_activatedidlang[$i].'P1, L'.$main_activatedidlang[$i].'P2, '; 
    }
}

$prepared_query .= 'VALUES 
                   (:status, :family, :sendername, :senderemail, :bcc, :scriptpath, :signature, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i == ($count - 1))
    {
        $prepared_query .= '"'.$mailtext_contentsubject[$i].'", "'.$mailtext_contentname[$i].'", "'.$mailtext_contenttop[$i].'", "'.$mailtext_contentbottom[$i].'")'; 
    }
    else
    {
        $prepared_query .= '"'.$mailtext_contentsubject[$i].'", "'.$mailtext_contentname[$i].'", "'.$mailtext_contenttop[$i].'", "'.$mailtext_contentbottom[$i].'", '; 
    }
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'status' => $mailtext_status,
                      'family' => $mailtext_family,
                      'sendername' => $mailtext_sendername,
                      'senderemail' => $mailtext_senderemail,
                      'bcc' => $mailtext_bcc,
                      'scriptpath' => $mailtext_scriptpath,
                      'signature' => $mailtext_selected_signature
                      ));
$query->closeCursor();

$_SESSION['msg_mailtext_done'] = str_replace('[#]', '"'.$mailtext_contentname[$mailtext_name_selectedlang].'"', $msg_done_mailtext_add);
?>
