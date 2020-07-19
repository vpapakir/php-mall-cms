<?php
if($adveredit_selected_idadvert == 'new')
{
    $prepared_query = 'SELECT MAX(id_advertising) FROM advertising';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $adveredit_selected_idadvert = $data[0];
    }
    $query->closeCursor();
}

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if(!empty($adveredit_upload[$i]))
    {
        $_SESSION['msg_advertedit_upload'.$main_activatedidlang[$i]] = 
            upload_advert
            ('upload_advert'.$main_activatedidlang[$i], 
              $adveredit_name[$i], 
              5242880, 
              $adveredit_width[$i], 
              $adveredit_height[$i], 
              'publicity/', 
              $adveredit_selected_idadvert, 
              $main_activatedidlang[$i]);
    }
}
?>
