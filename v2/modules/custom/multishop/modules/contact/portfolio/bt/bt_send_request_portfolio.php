<?php
if(isset($_POST['bt_send_request_portfolio']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    #session
    unset($_SESSION['msg_form_visit_done'],
            $_SESSION['msg_form_visit_chkrequestpf']);
    unset($_SESSION['form_visit_areaRequestPortfolioMsg']);
    #special
    $kformvisit_bok_sendemail = true;
    $kformvisit_bok_allselected = false;
    #msg
    $msg_done_kformvisit = give_translation('messages.msg_done_kformvisit', 'false', $config_showtranslationcode);
    $msg_error_kformvisit_listing = give_translation('messages.msg_error_kformvisit_listing', 'false', $config_showtranslationcode);
    #callinfo
    $kformvisit_msg = trim(htmlspecialchars($_POST['areaRequestPortfolioMsg'], ENT_QUOTES));
    $y = 0;
    for($i = 0, $count = count($kformvisit_id_property); $i < $count; $i++)
    {
        if($_POST['chk_requestpf'.$kformvisit_id_property[$i]] == 1)
        {
            $kformvisit_selected_property[$y] = trim(htmlspecialchars($_POST['chk_requestpf'.$kformvisit_id_property[$i]], ENT_QUOTES));  
            $kformvisit_selectedid_property[$y] = $kformvisit_id_property[$i];
            $kformvisit_bok_allselected = true;
            $y++;
        }
        else
        {
            $kformvisit_selected_property[$i] = 0;  
        }
        
    }
    #condition
    if($kformvisit_bok_allselected === false)
    {
        $_SESSION['msg_form_visit_chkrequestpf'] = $msg_error_kformvisit_listing;
    }
    #operation
    if($kformvisit_bok_sendemail === true && $kformvisit_bok_allselected === true)
    {
        for($i = 0, $count = count($kformvisit_selectedid_property); $i < $count; $i++)
        {    
            #ID page
            $prepared_query = 'SELECT id_page FROM immo_portfolio
                               WHERE id_portfolio = :idportfolio';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idportfolio', $kformvisit_selectedid_property[$i]);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $kformvisit_product_idpage = $data[0];
            }
            $query->closeCursor();
            
            #Product title
            $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                               INNER JOIN page_translation
                               ON page_translation.id_page = page.id_page
                               WHERE page.id_page = :idpage
                               AND family_page_translation = "title"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idpage', $kformvisit_product_idpage);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $kformvisit_product_title[$i] = $data[0];
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
            $query->bindParam('idpage', $kformvisit_product_idpage);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $kformvisit_product_rewritingF[$i] = $data[0];
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
            $query->bindParam('idpage', $kformvisit_product_idpage);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $kformvisit_product_intro[$i] = $data[0];
            }
            $query->closeCursor();

            #Product info
            $prepared_query = 'SELECT * FROM page
                               INNER JOIN immo_product
                               ON immo_product.id_page = page.id_page
                               WHERE page.id_page = :idpage';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idpage', $kformvisit_product_idpage);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $kformvisit_product_url[$i] = $data['url_page'];
                $kformvisit_product_reference[$i] = $data['ref_product_immo'];
                $kformvisit_product_price[$i] = $data['price_product_immo'];
                $kformvisit_product_idoffer[$i] = $data['offer_product_immo'];
                $kformvisit_product_idcomdetails[$i] = $data['comdetails_product_immo'];
                $kformvisit_product_idtype[$i] = $data['type_product_immo'];
                $kformvisit_product_idcondition[$i] = $data['condition_product_immo'];
                $kformvisit_product_idlocation[$i] = $data['location_product_immo'];
                $kformvisit_product_idlocdetails[$i] = $data['locdetails_product_immo'];
                $kformvisit_product_surfhab[$i] = $data['surfhab_product_immo'];
            }
            $query->closeCursor();

            $kformvisit_product_offer[$i] = giveCDRvalue($kformvisit_product_idoffer[$i], 'cdreditor', $main_id_language);
            $kformvisit_product_comdetails[$i] = giveCDRvalue($kformvisit_product_idcomdetails[$i], 'cdreditor', $main_id_language);
            $kformvisit_product_type[$i] = giveCDRvalue($kformvisit_product_idtype[$i], 'cdreditor', $main_id_language);
            $kformvisit_product_condition[$i] = giveCDRvalue($kformvisit_product_idcondition[$i], 'cdreditor', $main_id_language);
            $kformvisit_product_location[$i] = giveCDRvalue($kformvisit_product_idlocation[$i], 'cdreditor', $main_id_language);
            $kformvisit_product_locdetails[$i] = giveCDRvalue($kformvisit_product_idlocdetails[$i], 'cdreditor', $main_id_language);

            #Product image
            $prepared_query = 'SELECT pathsearch_image, alt_image FROM page_image
                               WHERE id_page = :idpage
                               AND position_image = 1';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idpage', $kformvisit_product_idpage);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $kformvisit_product_pathimage[$i] = $data[0];
                $kformvisit_product_altimage[$i] = $data[0];
            }
            $query->closeCursor();

            if(empty($kformvisit_product_pathimage[$i]))
            {
                $kformvisit_product_pathimage[$i] = $config_noimage_search;
                $kformvisit_product_altimage[$i] = 'noimage.gif';
            }
        }
        $kformvisit_msg = '<p style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">'.$kformvisit_msg.'</p>';
        $kformvisit_msg = nl2br($kformvisit_msg);
        
        $kformvisit_emailuser = null;
        $prepared_query = 'SELECT email_user FROM user
                           WHERE id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $main_iduser_log);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $kformvisit_emailuser = $data[0];
        }
        $query->closeCursor();
        
        include('modules/custom/immo/modules/email/send/user/visit/email_main.php');
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'user';
        $messages_insert_iduser = $main_iduser_log;
        $messages_insert_sender = $config_email_senderemail;
        $messages_insert_receiver = $kformvisit_emailuser;
        $messages_insert_bcc = $kformvisit_bcc;
        $messages_insert_type = 'kform_visit';
        $messages_insert_subject = $kformvisit_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        
        include('modules/custom/immo/modules/email/send/admin/visit/email_main.php');
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'admin';
        $messages_insert_iduser = $main_iduser_log;
        $messages_insert_sender = $kformvisit_senderemail;
        $messages_insert_receiver = $config_email_senderemail;
        $messages_insert_bcc = $kformvisit_bcc;
        $messages_insert_type = 'kform_visit';
        $messages_insert_subject = $kformvisit_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        $_SESSION['msg_form_visit_done'] = $msg_done_kformvisit;
    }
    else
    {
        $_SESSION['form_visit_areaRequestPortfolioMsg'] = $kformvisit_msg;
    }
}
?>
