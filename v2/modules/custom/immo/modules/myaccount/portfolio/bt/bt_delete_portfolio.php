<?php
for($i = 0, $count = count($myportfolio_idportfolio); $i < $count; $i++)
{
    if(isset($_POST['bt_delete_portfolio'.$myportfolio_idportfolio[$i]]))
    {
        $_SESSION['expand_myaccount_portfolio'] = trim(htmlspecialchars($_POST['expand_myaccount_portfolio'], ENT_QUOTES));
        
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_page);
        }
        
        try
        {
            #USER PORTFOLIO
            $prepared_query = 'DELETE FROM immo_portfolio
                               WHERE id_portfolio = :idportfolio';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idportfolio', $myportfolio_idportfolio[$i]);
            $query->execute();
            $query->closeCursor();
            
            reallocate_table_id('id_portfolio', 'immo_portfolio');
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
        
        $i = $count;
    }
}
?>
