<?php
try
{
    #USER PORTFOLIO
    $prepared_query = 'SELECT id_portfolio FROM immo_portfolio
                       WHERE id_user = :iduser
                       ORDER BY priority_portfolio, dateadd_portfolio DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $kformvisit_id_property[$i] = $data[0];
        $i++;
    }
    $query->closeCursor();
    
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
        $rewritingF_myaccount_page = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM user
                       WHERE id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $kformvisit_user_firstname = $data['firstname_user'];
        $kformvisit_user_lastname = $data['name_user'];
        $kformvisit_user_companyname = $data['namecompany_user'];
        $kformvisit_user_address1 = $data['address1_user'];
        $kformvisit_user_address2 = $data['address2_user'];
        $kformvisit_user_zip = $data['zip_user'];
        $kformvisit_user_city = $data['city_user'];
        $kformvisit_user_country = $data['country_user'];
        $kformvisit_user_landline = $data['landline_user'];
        $kformvisit_user_mobile = $data['mobile_user'];
        $kformvisit_user_fax = $data['fax_user'];
        $kformvisit_user_email = $data['email_user'];
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
?>
