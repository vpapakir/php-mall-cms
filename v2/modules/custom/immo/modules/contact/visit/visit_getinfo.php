<?php
try
{
    if(isset($_GET['property']))
    {
        if($_GET['property'] > 0)
        {
            $kformvisit_selected_property = trim(htmlspecialchars($_GET['property'], ENT_QUOTES));
            $_SESSION['kform_visit_selected_property'] = $kformvisit_selected_property;
        }
    }
    
    $kformvisit_selectedid_property = array(0 => 1);
    
    #Product title
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE page.id_page = :idpage
                       AND family_page_translation = "title"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_visit_selected_property']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformvisit_product_title[0] = $data[0];
        $kformvisit_product_title[0] = give_prioritylangcontent($kformvisit_product_title[0], $_SESSION['kform_visit_selected_property'], 'title');
    }
    $query->closeCursor();
    
    #Product rewritingF
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE page.id_page = :idpage
                       AND family_page_translation = "rewritingF"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_visit_selected_property']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformvisit_product_rewritingF[0] = $data[0];
    }
    $query->closeCursor();
    
    #Product intro
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE page.id_page = :idpage
                       AND family_page_translation = "intro"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_visit_selected_property']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformvisit_product_intro[0] = $data[0];
        $kformvisit_product_intro[0] = give_prioritylangcontent($kformvisit_product_intro[0], $_SESSION['kform_visit_selected_property'], 'intro');
    }
    $query->closeCursor();
    
    #Product info
    $prepared_query = 'SELECT * FROM page
                       INNER JOIN immo_product
                       ON immo_product.id_page = page.id_page
                       WHERE page.id_page = :idpage';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_visit_selected_property']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformvisit_product_url[0] = $data['url_page'];
        $kformvisit_product_reference[0] = $data['ref_product_immo'];
        $kformvisit_product_price[0] = $data['price_product_immo'];
        $kformvisit_product_idoffer[0] = $data['offer_product_immo'];
        $kformvisit_product_idcomdetails[0] = $data['comdetails_product_immo'];
        $kformvisit_product_idtype[0] = $data['type_product_immo'];
        $kformvisit_product_idcondition[0] = $data['condition_product_immo'];
        $kformvisit_product_idlocation[0] = $data['location_product_immo'];
        $kformvisit_product_idlocdetails[0] = $data['locdetails_product_immo'];
        $kformvisit_product_surfhab[0] = $data['surfhab_product_immo'];
    }
    $query->closeCursor();
    
    $kformvisit_product_offer[0] = giveCDRvalue($kformvisit_product_idoffer[0], 'cdreditor', $main_id_language);
    $kformvisit_product_comdetails[0] = giveCDRvalue($kformvisit_product_idcomdetails[0], 'cdreditor', $main_id_language);
    $kformvisit_product_type[0] = giveCDRvalue($kformvisit_product_idtype[0], 'cdreditor', $main_id_language);
    $kformvisit_product_condition[0] = giveCDRvalue($kformvisit_product_idcondition[0], 'cdreditor', $main_id_language);
    $kformvisit_product_location[0] = giveCDRvalue($kformvisit_product_idlocation[0], 'cdreditor', $main_id_language);
    $kformvisit_product_locdetails[0] = giveCDRvalue($kformvisit_product_idlocdetails[0], 'cdreditor', $main_id_language);
    
    #Product image
    $prepared_query = 'SELECT pathsearch_image, alt_image FROM page_image
                       WHERE id_page = :idpage
                       AND position_image = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_visit_selected_property']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformvisit_product_pathimage[0] = $data[0];
        $kformvisit_product_altimage[0] = $data[0];
    }
    $query->closeCursor();
    
    if(empty($kformvisit_product_pathimage[0]))
    {
        $kformvisit_product_pathimage[0] = $config_noimage_search;
        $kformvisit_product_altimage[0] = 'noimage.gif';
    }
    
    #USER INFO
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
