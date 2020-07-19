<?php
if(isset($_POST['bt_cboColor']))
{
    unset($_SESSION['msg_color_done'], 
            $_SESSION['color_cboColor'],
            $_SESSION['color_txtCodeColor']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['color_txtNameColor'.$main_activatedidlang[$i]]);
    }
    
    $color_id = trim(htmlspecialchars($_POST['cboColor'], ENT_QUOTES));
    
    if($color_id != 'new')
    {
        try
        {
            $prepared_query = 'SELECT * FROM style_color
                               WHERE id_color = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $color_id);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['color_txtNameColor'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
                $_SESSION['color_txtCodeColor'] = $data[2];
            }
            $query->closeCursor();
            
            $_SESSION['color_cboColor'] = $color_id;
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
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
