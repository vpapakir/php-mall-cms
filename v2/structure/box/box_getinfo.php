<?php
try
{
    $prepared_query = 'SELECT * FROM structure_box
                       WHERE id_box = :id_box
                       AND id_frame LIKE \'%'.$id_frame.'%\'';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_box', $idbox_hierarchybox[$i]);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $Bok_insert_table_left = true;

        $id_box = $data['id_box'];
        $name_box = $data['name_box'];
        $width_box = $data['width_box'].'px';
        $height_box = $data['height_box'].'px';
        $position_box = $data['position_box'];
        $margin_box = $data['margin_box'];
        $border_box = $data['border_box'].'px';
        $bordercolor_box = $data['bordercolor_box'];
        $tablebg_box = $data['tablebg_box'];
        $cs_box = $data['cs_box'];
        $cp_box = $data['cp_box'];
        $bgcolor_box = $data['bgcolor_box'];
        $bgimg_box = $data['bgimg_box'];
        $xrepeat_box = $data['xrepeat_box'];
        $yrepeat_box = $data['yrepeat_box'];
        //$id_layout = $data['id_frame'];
        //$id_box = $data['id_layout'];
    }
    else
    {
        $Bok_insert_table_left = false;
    }
    $query->closeCursor();

    if($width_box == '0px')
    {
        $width_box = '100%';
    }

    if($height_box == '0px')
    {
        $height_box = '100%';
    }

    if($bgcolor_box == null)
    {
       $bgcolor_box = 'white'; 
    }

    if($position_box == 0)
    {
       $position_box = 'relative'; 
    }

    if($margin_box == 0)
    {
        $margin_box = 'auto';
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
?>
