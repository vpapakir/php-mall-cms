<?php
if(isset($_GET['addpf']) && $_GET['addpf'] > 0)
{
    if(!empty($main_iduser_log))
    {
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_page);
        }

        unset($_SESSION['msg_portfolioadd'],
                $_SESSION['msg_portfolioadd_needlogin']);

        $msg_error_portfolioadd_alreadyexist = give_translation('messages.msg_error_portfolioadd_alreadyexist', 'false', $config_showtranslationcode);
        $msg_done_portfolioadd = give_translation('messages.msg_done_portfolioadd', 'false', $config_showtranslationcode);
        $msg_error_portfolioadd_needlogin = give_translation('messages.msg_error_portfolioadd_needlogin', 'false', $config_showtranslationcode);

        $myportfolio_add_idportfolio = trim(htmlspecialchars($_GET['addpf'], ENT_QUOTES));
        $myportfolio_add_bok_insert = true;

        try
        {
            $prepared_query = 'SELECT id_portfolio FROM immo_portfolio
                               WHERE id_page = :idpage
                               AND id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'idpage' => $myportfolio_add_idportfolio,
                                  'iduser' => $main_iduser_log
                                  ));
            if(($data = $query->fetch()) != false)
            {
                $myportfolio_add_bok_insert = false;
                $_SESSION['msg_portfolioadd'] = $msg_error_portfolioadd_alreadyexist;
            }
            $query->closeCursor();

            if($myportfolio_add_bok_insert === true)
            {
                $prepared_query = 'INSERT INTO immo_portfolio
                                   (id_user, id_page, priority_portfolio, 
                                    remarks_portfolio, dateadd_portfolio)
                                   VALUES
                                   (:iduser, :idpage, :priority, :remarks, NOW())';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'iduser' => $main_iduser_log,
                                      'idpage' => $myportfolio_add_idportfolio,
                                      'priority' => null,
                                      'remarks' => null
                                      ));
                $query->closeCursor();

                $prepared_query = 'SELECT ref_product_immo FROM page
                                   INNER JOIN immo_product
                                   ON immo_product.id_page = page.id_page
                                   WHERE page.id_page = :idpage';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $myportfolio_add_idportfolio);
                $query->execute();
                if(($data = $query->fetch()) != false)
                {
                    $_SESSION['msg_portfolioadd'] = str_replace('[#ref_product]', '"'.$data[0].'"', $msg_done_portfolioadd);
                }
                $query->closeCursor();
            }
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
    }
    else
    {
        try
        {
            $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                               INNER JOIN page_translation
                               ON page_translation.id_page = page.id_page
                               WHERE url_page = "login_subscribe"
                               AND family_page_translation = "rewritingF"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $rewritingF_page = $data[0];
            }
            $query->closeCursor();
            $_SESSION['msg_portfolioadd_needlogin'] = $msg_error_portfolioadd_needlogin;
            header('Location: '.$config_customheader.$rewritingF_page);
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
    }
}
?>
