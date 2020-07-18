<?php
$prepared_query = 'UPDATE `email_mailtext` 
                   SET status_mailtext = :status,
                       family_mailtext = :family,
                       sendername_mailtext = :sendername,
                       senderemail_mailtext = :senderemail, 
                       bcc_mailtext = :bcc, 
                       scriptpath_mailtext = :scriptpath, 
                       idsignature_mailtext = :signature, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i == ($count - 1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'S = "'.$mailtext_contentsubject[$i].'", L'.$main_activatedidlang[$i].'T = "'.$mailtext_contentname[$i].'",
                            L'.$main_activatedidlang[$i].'P1 = "'.$mailtext_contenttop[$i].'", L'.$main_activatedidlang[$i].'P2 = "'.$mailtext_contentbottom[$i].'" '; 
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'S = "'.$mailtext_contentsubject[$i].'", L'.$main_activatedidlang[$i].'T = "'.$mailtext_contentname[$i].'",
                            L'.$main_activatedidlang[$i].'P1 = "'.$mailtext_contenttop[$i].'", L'.$main_activatedidlang[$i].'P2 = "'.$mailtext_contentbottom[$i].'", '; 
    }
}

$prepared_query .= 'WHERE id_mailtext = :id';

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'status' => $mailtext_status,
                      'family' => $mailtext_family,
                      'sendername' => $mailtext_sendername,
                      'senderemail' => $mailtext_senderemail,
                      'bcc' => $mailtext_bcc,
                      'scriptpath' => $mailtext_scriptpath,
                      'signature' => $mailtext_selected_signature,
                      'id' => $mailtext_selected    
                      ));
$query->closeCursor();

$_SESSION['mailtext_cboFamilyMailtext'] = $mailtext_family;
$_SESSION['mailtext_txtSendernameMailtext'] = $mailtext_sendername;
$_SESSION['mailtext_txtSenderemailMailtext'] = $mailtext_senderemail;
$_SESSION['mailtext_txtBccMailtext'] = $mailtext_bcc;
$_SESSION['mailtext_txtScriptpathMailtext'] = $mailtext_scriptpath;
$_SESSION['mailtext_cboSignatureMailtext'] = $mailtext_selected_signature;
$_SESSION['mailtext_cboStatusMailtext'] = $mailtext_status;

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $_SESSION['mailtext_txtNameMailtext'.$main_activatedidlang[$i]] = $mailtext_contentname[$i];
    $_SESSION['mailtext_txtSubjectMailtext'.$main_activatedidlang[$i]] = $mailtext_contentsubject[$i];
    $_SESSION['mailtext_areaTopMailtext'.$main_activatedidlang[$i]] = stripslashes($mailtext_contenttop[$i]);
    $_SESSION['mailtext_areaBottomMailtext'.$main_activatedidlang[$i]] = stripslashes($mailtext_contentbottom[$i]);
}

$_SESSION['msg_mailtext_done'] = str_replace('[#]', '"'.$mailtext_contentname[$mailtext_name_selectedlang].'"', $msg_done_mailtext_edit);
?>
