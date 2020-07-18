<?php
try
{
    $prepared_query = 'SELECT COUNT(id_user) FROM user';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $usermailing_totalregistereduser = $data[0];
    }
    $query->closeCursor();
    
    $usermailing_totalreceiver = 0;
    unset($usermailing_listing_iduser);
    $y = 0;
    for($i = 1, $count = $usermailing_totalregistereduser; $i <= $count; $i++)
    {
        if($_SESSION['useredit_chk'.$i] == 1)
        {
            $usermailing_totalreceiver++; 
            
            $prepared_query = 'SELECT * FROM user
                               INNER JOIN user_rights
                               ON user_rights.level_rights = user.rights_user
                               WHERE id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('iduser', $i);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                if(!empty($data['namecompany_user']))
                {
                    $usermailing_listing_iduser[$y] = '1$'.$data['namecompany_user'].'$1$'.$data[0];
                }
                else
                {
                    $usermailing_listing_iduser[$y] = '1$'.$data['name_user'].'$'.$data['firstname_user'].'$'.$data[0];
                }
            }
            $query->closeCursor();
            $y++;
        }
    }
    sort($usermailing_listing_iduser);
    $usermailing_blocktitle_listing = give_translation('user_mailing.block_title_listing', 'false', $config_showtranslationcode);
    $usermailing_blocktitle_listing = str_replace('[#count_receiver]', $usermailing_totalreceiver, $usermailing_blocktitle_listing);
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
