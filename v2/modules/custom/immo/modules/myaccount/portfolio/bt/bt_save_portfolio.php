<?php
if(isset($_POST['bt_save_portfolio']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    $_SESSION['expand_myaccount_portfolio'] = trim(htmlspecialchars($_POST['expand_myaccount_portfolio'], ENT_QUOTES));
    
    
    for($i = 0, $count = count($myportfolio_idportfolio); $i < $count; $i++)
    {
        $myportfolio_remarks = null;
        $myportfolio_remarks = trim(htmlspecialchars($_POST['areaMyaccountPortfolioRemarks'.$myportfolio_idportfolio[$i]], ENT_QUOTES));
        
        try
        {
            $prepared_query = 'UPDATE immo_portfolio
                               SET remarks_portfolio = :remarks
                               WHERE id_portfolio = :idportfolio';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'remarks' => $myportfolio_remarks, 
                                  'idportfolio' => $myportfolio_idportfolio[$i]
                                  ));            
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
    }
    
    
}
?>
