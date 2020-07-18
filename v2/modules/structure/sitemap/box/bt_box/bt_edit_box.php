<?php
if(isset($_POST['bt_edit_box']))
{
    unset($_SESSION['msg_sitemap_box_cboBoxType'],
          $_SESSION['msg_sitemap_box_txtBoxPosition'],
          $_SESSION['msg_sitemap_box_txtBoxTitle']);
    
    $selected_box = trim(htmlspecialchars($_POST['cboBox'], ENT_QUOTES));
    
    $msg_position_box = 'Veuillez utiliser uniquement des chiffres';
    $msg_positionlength_box = 'Veuillez saisir au maximum 3 chiffres';
    $msg_title_box = 'Veuillez saisir un titre';
    $msg_type_box = 'Veuillez choisir un type';
    
    if($selected_box != 'new')
    {
        $Bok_edit_box = true;
        
        $type_box = trim(htmlspecialchars($_POST['cboBoxType'], ENT_QUOTES));
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $title_box[$i] = trim(htmlspecialchars($_POST['txtBoxTitle'.$main_activatedidlang[$i]], ENT_QUOTES));
        }
        $typelink_box = trim(htmlspecialchars($_POST['cboBoxTypeLink'], ENT_QUOTES));
        
        switch($typelink_box)
        {
           case 'page':
             $link_box = trim(htmlspecialchars($_POST['cboBoxPage'], ENT_QUOTES));
               break;
           case 'script':
             $link_box = trim(htmlspecialchars($_POST['txtBoxScriptPath'], ENT_QUOTES));
               break;
           case 'url':
             $link_box = trim(htmlspecialchars($_POST['txtBoxURL'], ENT_QUOTES));
               break;
        }
        
        $target_box = trim(htmlspecialchars($_POST['cboBoxTarget'], ENT_QUOTES));
        $position_box = trim(htmlspecialchars($_POST['txtBoxPosition'], ENT_QUOTES));
        $status_box = trim(htmlspecialchars($_POST['cboBoxStatus'], ENT_QUOTES));
        
        $titlealign_box = trim(htmlspecialchars($_POST['cboBoxTitleAlign'], ENT_QUOTES));
        $id_frame_box = trim(htmlspecialchars($_POST['cboBoxFrame'], ENT_QUOTES));
        
        $margin_boxT = trim(htmlspecialchars($_POST['txtBoxMarginT'], ENT_QUOTES));
        $margin_boxR = trim(htmlspecialchars($_POST['txtBoxMarginR'], ENT_QUOTES));
        $margin_boxB = trim(htmlspecialchars($_POST['txtBoxMarginB'], ENT_QUOTES));
        $margin_boxL = trim(htmlspecialchars($_POST['txtBoxMarginL'], ENT_QUOTES));
        
        if(empty($margin_boxT) ? $margin_boxT = 0 : $margin_boxT = $margin_boxT);
        if(empty($margin_boxR) ? $margin_boxR = 0 : $margin_boxR = $margin_boxR);
        if(empty($margin_boxB) ? $margin_boxB = 0 : $margin_boxB = $margin_boxB);
        if(empty($margin_boxL) ? $margin_boxL = 0 : $margin_boxL = $margin_boxL);
        
        $margin_box = $margin_boxT.'$'.$margin_boxR.'$'.$margin_boxB.'$'.$margin_boxL;
        
        $rights_box = $_POST['cboBoxRights'];

        $userrights_box = null;

        if($rights_box[0] == 'all')
        {
            $userrights_box = 'all';
        }
        else
        {
            for($i = 0, $count = count($rights_box); $i < $count; $i++)
            {
                if($i == 0)
                {
                   $userrights_box = $rights_box[$i];
                }
                else
                {
                   $userrights_box .= ','.$rights_box[$i]; 
                }
            } 
            $userrights_box .= ',9';
        }
        
        if(preg_match('#9,9$#', $userrights_levelx))
        {
            $userrights_levelx = '9,9';
        }
        
        if(!is_numeric($position_box))
        {
            $Bok_edit_box = false;             
            $_SESSION['msg_sitemap_box_txtBoxPosition'] = $msg_position_box;
        }
        else
        {
            if(strlen($position_box) > 3)
            {
                $Bok_edit_box = false;             
                $_SESSION['msg_sitemap_box_txtBoxPosition'] = $msg_positionlength_box;
            }
        }
        
        if(empty($title_box[0]))
        {
            $Bok_edit_box = false;
            $_SESSION['msg_sitemap_box_txtBoxTitle'] = $msg_title_box;
        }
        
        if($type_box == 'select')
        {
            $Bok_edit_box = false;
            $_SESSION['msg_sitemap_box_cboBoxType'] = $msg_type_box;
        } 
        
        if($Bok_edit_box === true)
        {
            try
            {
                $prepared_query = 'UPDATE hierarchy_box
                                   SET status_hierarchy_box = :status,
                                       id_frame = :frame,
                                       id_box = :box,
                                       menutitle_hierarchy_box = :title,
                                       position_hierarchy_box = :position,
                                       typelink_hierarchy_box = :typelink,
                                       link_hierarchy_box = :link,
                                       target_hierarchy_box = :target,
                                       titlemargin_hierarchy_box = :margin,
                                       titlealign_hierarchy_box = :align, 
                                       userrights_hierarchy_box = :rights, ';
                
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    if($i == ($count - 1))
                    {
                        $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$title_box[$i].'" ';
                    }
                    else
                    {
                        $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$title_box[$i].'", ';
                    }
                }
                
                $prepared_query .= 'WHERE id_hierarchy_box = :id';
                
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'status' => $status_box,
                                      'frame' => $id_frame_box,
                                      'box' => $type_box,
                                      'title' => null,
                                      'position' => $position_box,
                                      'typelink' => $typelink_box,
                                      'link' => $link_box,
                                      'target' => $target_box,
                                      'margin' => $margin_box,
                                      'align' => $titlealign_box,
                                      'rights' => $userrights_box,
                                      'id' => $selected_box
                                      ));
                $query->closeCursor();

                $_SESSION['sitemap_box_cboBoxType'] = $type_box;
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['sitemap_box_txtBoxTitle'.$main_activatedidlang[$i]] = $title_box[$i];
                }
                $_SESSION['sitemap_box_cboBoxTypeLink'] = $typelink_box;
                $_SESSION['sitemap_box_txtBoxLink'] = $link_box;
                $_SESSION['sitemap_box_txtBoxPosition'] = $position_box;
                $_SESSION['sitemap_box_cboBoxRights'] = $userrights_box;
                $_SESSION['sitemap_box_cboBoxStatus'] = $status_box;
                $_SESSION['sitemap_box_cboBoxTarget'] = $target_box;
                
                $_SESSION['sitemap_box_txtBoxMargin'] = $margin_box;
                $_SESSION['sitemap_box_cboBoxTitleAlign'] = $titlealign_box;
                $_SESSION['sitemap_box_cboBoxFrame'] = $id_frame_box;
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
