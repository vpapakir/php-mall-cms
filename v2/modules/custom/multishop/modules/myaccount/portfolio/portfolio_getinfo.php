<?php
try
{
    #USER PORTFOLIO
    $prepared_query = 'SELECT * FROM immo_portfolio
                       WHERE id_user = :iduser
                       ORDER BY priority_portfolio, dateadd_portfolio DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    $i = 0;
    if(($data = $query->fetch()) != false)
    {
        $query->execute();
        while($data = $query->fetch())
        {
            $myportfolio_idportfolio[$i] = $data[0];
            $i++;
        }
        $query->closeCursor();
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
