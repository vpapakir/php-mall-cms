<?php
try
{   
    if(isset($_GET['product']))
    {
        $kform_prodemail_idpage = trim(htmlspecialchars($_GET['product'], ENT_QUOTES));

        $_SESSION['kform_prodemail_idpage'] = $kform_prodemail_idpage;   
    }
    
    #Product title
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE page.id_page = :idpage
                       AND family_page_translation = "title"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_prodemail_idpage']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformprodemail_product_title = $data[0];
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
    $query->bindParam('idpage', $_SESSION['kform_prodemail_idpage']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformprodemail_product_rewritingF = $data[0];
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
    $query->bindParam('idpage', $_SESSION['kform_prodemail_idpage']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformprodemail_product_intro = $data[0];
    }
    $query->closeCursor();
    
    #Product desc
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE page.id_page = :idpage
                       AND family_page_translation = "desc"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_prodemail_idpage']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformprodemail_product_desc = $data[0];
    }
    $query->closeCursor();
    
    #Product info
    $prepared_query = 'SELECT * FROM page
                       INNER JOIN immo_product
                       ON immo_product.id_page = page.id_page
                       WHERE page.id_page = :idpage';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_prodemail_idpage']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformprodemail_product_url = $data['url_page'];
        $kformprodemail_product_reference = $data['ref_product_immo'];
        $kformprodemail_product_price = $data['price_product_immo'];
        $kformprodemail_product_idoffer = $data['offer_product_immo'];
        $kformprodemail_product_idcomdetails = $data['comdetails_product_immo'];
        $kformprodemail_product_idtype = $data['type_product_immo'];
        $kformprodemail_product_idcondition = $data['condition_product_immo'];
        $kformprodemail_product_idlocation = $data['location_product_immo'];
        $kformprodemail_product_idlocdetails = $data['locdetails_product_immo'];
        $kformprodemail_product_surfhab = $data['surfhab_product_immo'];
    }
    $query->closeCursor();
    
    $kformprodemail_product_offer = giveCDRvalue($kformprodemail_product_idoffer, 'cdreditor', $main_id_language);
    $kformprodemail_product_comdetails = giveCDRvalue($kformprodemail_product_idcomdetails, 'cdreditor', $main_id_language);
    $kformprodemail_product_type = giveCDRvalue($kformprodemail_product_idtype, 'cdreditor', $main_id_language);
    $kformprodemail_product_condition = giveCDRvalue($kformprodemail_product_idcondition, 'cdreditor', $main_id_language);
    $kformprodemail_product_location = giveCDRvalue($kformprodemail_product_idlocation, 'cdreditor', $main_id_language);
    $kformprodemail_product_locdetails = giveCDRvalue($kformprodemail_product_idlocdetails, 'cdreditor', $main_id_language);
    
    #Product image
    $prepared_query = 'SELECT pathsearch_image, alt_image, path_image, L'.$main_id_language.' FROM page_image
                       WHERE id_page = :idpage
                       AND position_image = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $_SESSION['kform_prodemail_idpage']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $kformprodemail_product_pathimage = $data[0];
        $kformprodemail_product_altimage = $data[1];
        $kformprodemail_product_pathoriginimage = $data[2];
        $kformprodemail_product_legendoriginimage = $data[3];
    }
    $query->closeCursor();
    
    if(empty($kformprodemail_product_pathimage))
    {
        $kformprodemail_product_pathimage = $config_noimage_search;
        $kformprodemail_product_altimage = 'noimage.gif';
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
        $kformprodemail_user_firstname = $data['firstname_user'];
        $kformprodemail_user_lastname = $data['name_user'];
        $kformprodemail_user_companyname = $data['namecompany_user'];
        $kformprodemail_user_address1 = $data['address1_user'];
        $kformprodemail_user_address2 = $data['address2_user'];
        $kformprodemail_user_zip = $data['zip_user'];
        $kformprodemail_user_city = $data['city_user'];
        $kformprodemail_user_country = $data['country_user'];
        $kformprodemail_user_landline = $data['landline_user'];
        $kformprodemail_user_mobile = $data['mobile_user'];
        $kformprodemail_user_fax = $data['fax_user'];
        $kformprodemail_user_email = $data['email_user'];
    }
    $query->closeCursor();
    
    $kformprodemail_bt_value_show = give_translation('kform_prodemail.link_addemail', 'false', $config_showtranslationcode);
    $kformprodemail_bt_value_hide = give_translation('kform_prodemail.link_deleteemail', 'false', $config_showtranslationcode);
    
    $prepared_query = 'SELECT *
                       FROM page_image
                       WHERE id_page = :id
                       ORDER BY position_image';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $_SESSION['kform_prodemail_idpage']);
    $query->execute();

    unset($id_image_page,$legend_image_page,$path_image_page,$path_thumb_page,$alt_image_page[$i]);

    $i = 0;
    while($data = $query->fetch())
    {
        $id_image_page[$i] = $data[0];
        $legend_image_page[$i] = $data['L'.$main_id_language];
        $path_origin_page[$i] = $data['path_image'];
        $path_thumb_page[$i] = $data['paththumb_image'];
        $alt_image_page[$i] = $data['alt_image'];
        $i++;
    } 
    
    $query->closeCursor();
    
    $dpe_part1 = 50;
    $dpe_part2a = 51;
    $dpe_part2b = 90;
    $dpe_part3a = 91;
    $dpe_part3b = 150;
    $dpe_part4a = 151;
    $dpe_part4b = 230;
    $dpe_part5a = 231;
    $dpe_part5b = 330;
    $dpe_part6a = 331;
    $dpe_part6b = 450;
    $dpe_part7 = 451;
    
    $ges_part1 = 5;
    $ges_part2a = 6;
    $ges_part2b = 10;
    $ges_part3a = 11;
    $ges_part3b = 20;
    $ges_part4a = 21;
    $ges_part4b = 35;
    $ges_part5a = 36;
    $ges_part5b = 55;
    $ges_part6a = 56;
    $ges_part6b = 80;
    $ges_part7 = 81;
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
