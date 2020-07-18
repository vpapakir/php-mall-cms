<?php
if(isset($_POST['bt_backto_myaccount']))
{
    #email_edit 
    unset($_SESSION['myaccount_editemail_txtOldemailUserdataEditEmail'],
            $_SESSION['myaccount_editemail_txtNewemailUserdataEditEmail']);
    unset($_SESSION['msg_error_editemail_txtOldemailUserdataEditEmail'],
            $_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail'],
            $_SESSION['msg_error_editemail_txtConfirmnewemailUserdataEditEmail'],
            $_SESSION['msg_done_editemail']);
    
    #pwd_edit
    unset($_SESSION['myaccount_editpwd_txtOldpwdUserdataEditPwd'],
            $_SESSION['myaccount_editpwd_txtNewpwdUserdataEditPwd']);
    unset($_SESSION['msg_error_editpwd_txtOldpwdUserdataEditPwd'],
            $_SESSION['msg_error_editpwd_txtNewpwdUserdataEditPwd'],
            $_SESSION['msg_error_editpwd_txtConfirmnewpwdUserdataEditPwd'],
            $_SESSION['msg_done_editpwd']);
    
    #userdata_edit
        #-main
    unset($_SESSION['myaccount_useredition_cdreditor_title_UserEdition'],
            $_SESSION['myaccount_useredition_txtUserEditionFirstname'],
            $_SESSION['myaccount_useredition_txtUserEditionLastname'],
            $_SESSION['myaccount_useredition_txtUserEditionNamecompany'],
            $_SESSION['myaccount_useredition_cdreditor_typecompany_UserEdition'],
            $_SESSION['myaccount_useredition_cdreditor_activitycompany_UserEdition'],
            $_SESSION['myaccount_useredition_cdreditor_functioncompany_UserEdition'],
            $_SESSION['myaccount_useredition_txtUserEditionSiretcompany'],
            $_SESSION['myaccount_useredition_txtUserEditionVatintracompany']);
        #-address
    unset($_SESSION['myaccount_useredition_txtUserEditionAddress1'],
            $_SESSION['myaccount_useredition_txtUserEditionAddress2'],
            $_SESSION['myaccount_useredition_txtUserEditionZip'],
            $_SESSION['myaccount_useredition_txtUserEditionCity'],
            $_SESSION['myaccount_useredition_cdrgeo_country_situation']);
        #-phone & web info
    unset($_SESSION['myaccount_useredition_cboUserEditionBirthDay'],
            $_SESSION['myaccount_useredition_cboUserEditionBirthMonth'],
            $_SESSION['myaccount_useredition_cboUserEditionBirthYear'],
            $_SESSION['myaccount_useredition_txtUserEditionWebsite'],
            $_SESSION['myaccount_useredition_txtUserEditionLandline'],
            $_SESSION['myaccount_useredition_txtUserEditionMobile'],
            $_SESSION['myaccount_useredition_txtUserEditionFax']);  
    
    unset($_SESSION['msg_myaccount_useredition_cdreditor_title_UserEdition'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionNamecompany'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionSiretcompany'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionFirstname'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionLastname'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionAddress1'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionZip'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionCity'],
            $_SESSION['msg_myaccount_useredition_cdrgeo_country_situation'],
            $_SESSION['msg_myaccount_useredition_phone'],
            $_SESSION['msg_myaccount_useredition_birthday'],
            $_SESSION['msg_myaccount_useredition_done']);
    
    try
    {
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "myaccount"
                           AND family_page_translation = "rewritingF"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $rewritingF_page = $data[0];
        }
        $query->closeCursor();
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$config_customheader.'Error/400'));
        }
        else
        {
            die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
        }
    }
    
    header('Location: '.$config_customheader.$rewritingF_page);
}
?>
