<?php
if(isset($_POST['bt_edit_levelx']))
{
    unset($_SESSION['msg_sitemap_levelx_cboLevelxType'],
          $_SESSION['msg_sitemap_levelx_txtLevelxPosition'],
          $_SESSION['msg_sitemap_levelx_txtLevelxTitle'],
          $_SESSION['msg_sitemap_levelx_txtLevelxReference']);
    
    $selected_levelx = trim(htmlspecialchars($_POST['cboLevelx'], ENT_QUOTES));
    
    $msg_position_levelx = 'Veuillez utiliser uniquement des chiffres';
    $msg_positionlength_levelx = 'Veuillez saisir 4 chiffres';
    $msg_title_levelx = 'Veuillez saisir un titre';
    $msg_type_levelx = 'Veuillez choisir un type';
    
    if($selected_levelx != 'new')
    {
        $Bok_edit_levelx = true;
        
        $type_levelx = trim(htmlspecialchars($_POST['cboLevelxType'], ENT_QUOTES));
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $title_levelx[$i] = trim(htmlspecialchars($_POST['txtLevelxTitle'.$main_activatedidlang[$i]], ENT_QUOTES));
        }
        $typelink_levelx = trim(htmlspecialchars($_POST['cboLevelxTypeLink'], ENT_QUOTES));
        
        switch($typelink_levelx)
        {
           case 'page':
             $link_levelx = trim(htmlspecialchars($_POST['cboLevelxPage'], ENT_QUOTES));
               break;
           case 'script':
             $link_levelx = trim(htmlspecialchars($_POST['txtLevelxScriptPath'], ENT_QUOTES));
               break;
           case 'url':
             $link_levelx = trim(htmlspecialchars($_POST['txtLevelxURL'], ENT_QUOTES));
               break;
        }
        
        $target_levelx = trim(htmlspecialchars($_POST['cboLevelxTarget'], ENT_QUOTES));
        $reference_levelx = trim(htmlspecialchars($_POST['txtLevelxReference'], ENT_QUOTES));
        $position_levelx = trim(htmlspecialchars($_POST['txtLevelxPosition'], ENT_QUOTES));
        $status_levelx = trim(htmlspecialchars($_POST['cboLevelxStatus'], ENT_QUOTES));
        
        $titlealign_levelx = trim(htmlspecialchars($_POST['cboLevelxTitleAlign'], ENT_QUOTES));
        
        $margin_levelxT = trim(htmlspecialchars($_POST['txtLevelxMarginT'], ENT_QUOTES));
        $margin_levelxR = trim(htmlspecialchars($_POST['txtLevelxMarginR'], ENT_QUOTES));
        $margin_levelxB = trim(htmlspecialchars($_POST['txtLevelxMarginB'], ENT_QUOTES));
        $margin_levelxL = trim(htmlspecialchars($_POST['txtLevelxMarginL'], ENT_QUOTES));
        
        if(empty($margin_levelxT) ? $margin_levelxT = 0 : $margin_levelxT = $margin_levelxT);
        if(empty($margin_levelxR) ? $margin_levelxR = 0 : $margin_levelxR = $margin_levelxR);
        if(empty($margin_levelxB) ? $margin_levelxB = 0 : $margin_levelxB = $margin_levelxB);
        if(empty($margin_levelxL) ? $margin_levelxL = 0 : $margin_levelxL = $margin_levelxL);
        
        $margin_levelx = $margin_levelxT.'$'.$margin_levelxR.'$'.$margin_levelxB.'$'.$margin_levelxL;
        
        $rights_levelx = $_POST['cboLevelxRights'];

        $userrights_levelx = null;

        if($rights_levelx[0] == 'all')
        {
            $userrights_levelx = 'all';
        }
        else
        {
            for($i = 0, $count = count($rights_levelx); $i < $count; $i++)
            {
                if($i == 0)
                {
                   $userrights_levelx = $rights_levelx[$i];
                }
                else
                {
                   $userrights_levelx .= ','.$rights_levelx[$i]; 
                }
            } 
            $userrights_levelx .= ',9';
        }
        
        if(preg_match('#9,9$#', $userrights_levelx))
        {
            $userrights_levelx = '9,9';
        }
        
        if(!is_numeric($position_levelx))
        {
            $Bok_edit_levelx = false;             
            $_SESSION['msg_sitemap_levelx_txtLevelxPosition'] = $msg_position_levelx;
        }
        else
        {
            if(strlen($position_levelx) != 4)
            {
                $Bok_edit_levelx = false;             
                $_SESSION['msg_sitemap_levelx_txtLevelxPosition'] = $msg_positionlength_levelx;
            }
        }
        
        if(!is_numeric($reference_levelx))
        {
            $Bok_edit_levelx = false;             
            $_SESSION['msg_sitemap_levelx_txtLevelxReference'] = $msg_position_levelx;
        }
        else
        {
            if(strlen($reference_levelx) != 4)
            {
                $Bok_edit_levelx = false;             
                $_SESSION['msg_sitemap_levelx_txtLevelxReference'] = $msg_positionlength_levelx;
            }
        }
        
        if(empty($title_levelx[0]))
        {
            $Bok_edit_levelx = false;
            $_SESSION['msg_sitemap_levelx_txtLevelxTitle'] = $msg_title_levelx;
        }
        
        if($type_levelx == 'select')
        {
            $Bok_edit_levelx = false;
            $_SESSION['msg_sitemap_levelx_cboLevelxType'] = $msg_type_levelx;
        }
        
        
        if($Bok_edit_levelx === true)
        {
            try
            {
                $code_levelx = $reference_levelx.'$'.$position_levelx;
                
                $prepared_query = 'UPDATE hierarchy_box_content
                                   SET reference_hierarchy_box_content = :reference,
                                       code_hierarchy_box_content = :code,
                                       status_hierarchy_box_content = :status,
                                       type_hierarchy_box_content = :type,
                                       menutitle_hierarchy_box_content = :title,
                                       position_hierarchy_box_content = :position,
                                       typelink_hierarchy_box_content = :typelink,
                                       link_hierarchy_box_content = :link,
                                       target_hierarchy_box_content = :target,
                                       margin_hierarchy_box_content = :margin,
                                       align_hierarchy_box_content = :align,
                                       userrights_hierarchy_box_content = :rights, ';
                
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    if($i == ($count - 1))
                    {
                        $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$title_levelx[$i].'" ';
                    }
                    else
                    {
                        $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$title_levelx[$i].'", ';
                    }
                }
                
                $prepared_query .= 'WHERE id_hierarchy_box_content = :id';
                
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'reference' => $reference_levelx,
                                      'code' => $code_levelx,
                                      'status' => $status_levelx,
                                      'type' => $type_levelx,
                                      'title' => null,
                                      'position' => $position_levelx,
                                      'typelink' => $typelink_levelx,
                                      'link' => $link_levelx,
                                      'target' => $target_levelx,
                                      'margin' => $margin_levelx,
                                      'align' => $titlealign_levelx,
                                      'rights' => $userrights_levelx,
                                      'id' => $selected_levelx
                                      ));
                $query->closeCursor();

                $_SESSION['sitemap_levelx_cboLevelxType'] = $type_levelx;
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]] = $title_levelx[$i];
                }
                $_SESSION['sitemap_levelx_cboLevelxTypeLink'] = $typelink_levelx;
                $_SESSION['sitemap_levelx_txtLevelxLink'] = $link_levelx;
                $_SESSION['sitemap_levelx_txtLevelxPosition'] = $position_levelx;
                $_SESSION['sitemap_levelx_txtLevelxReference'] = $reference_levelx;
                $_SESSION['sitemap_levelx_cboLevelxRights'] = $userrights_levelx;
                $_SESSION['sitemap_levelx_cboLevelxStatus'] = $status_levelx;
                $_SESSION['sitemap_levelx_cboLevelxTarget'] = $target_levelx;
                
                $_SESSION['sitemap_levelx_txtLevelxMargin'] = $margin_levelx;
                $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] = $titlealign_levelx;
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
            
            if($_SESSION['index'] == 'index.php')
            {
                header('Location: '.$config_customheader.$rewritingF_page);
            }
            else
            {
                header('Location: '.$config_customheader.$rewritingB_page);
            }
        }
    }
}
?>
