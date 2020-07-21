<?php
if(isset($_POST['bt_save_main_box']))
{  
    unset($_SESSION['msg_structure_edit_main_box_txtNameBox']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_box = trim(htmlspecialchars($_POST['txtNameBox'], ENT_QUOTES));
    //$oldname_box = trim(htmlspecialchars($_POST['txtOldNameBox'], ENT_QUOTES));
    
    $width_box = trim(htmlspecialchars($_POST['txtWidthBox'], ENT_QUOTES));
    $height_box = trim(htmlspecialchars($_POST['txtHeightBox'], ENT_QUOTES));
    $position_box = trim(htmlspecialchars($_POST['txtPositionBox'], ENT_QUOTES));
    $margin_box = trim(htmlspecialchars($_POST['txtMarginBox'], ENT_QUOTES));
    $border_box = trim(htmlspecialchars($_POST['txtBorderBox'], ENT_QUOTES));
    $bordercolor_box = trim(htmlspecialchars($_POST['cboBordercolorBox'], ENT_QUOTES));
    $tablebg_box = trim(htmlspecialchars($_POST['cboTablebgBox'], ENT_QUOTES));
    $cs_box = trim(htmlspecialchars($_POST['txtCsBox'], ENT_QUOTES));
    $cp_box  = trim(htmlspecialchars($_POST['txtCpBox'], ENT_QUOTES));
    
    $bgcolor_box = trim(htmlspecialchars($_POST['cboBgcolorBox'], ENT_QUOTES));
    $bgimage_box = trim(htmlspecialchars($_POST['txtBgimageBox'], ENT_QUOTES));
    $xrepeat_box = trim(htmlspecialchars($_POST['txtXrepeatBox'], ENT_QUOTES));
    $yrepeat_box = trim(htmlspecialchars($_POST['txtYrepeatBox'], ENT_QUOTES));    
    
    $scriptpath_box = trim(htmlspecialchars($_POST['txtScriptPathBox'], ENT_QUOTES));
    $scriptcode_box = trim($_POST['areaScriptCodeBox']); 
    $defaultfont_box = $_POST['cboStyleBox'];
    $blocktitle_box = $_POST['cboBlockTitleBox'];
    $blockcontent_box = $_POST['cboBlockContentBox']; 

    $BoK_name_box = true;  
    
    if(empty($name_box))
    {
       $_SESSION['msg_structure_edit_main_box_txtNameBox'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_box = false; 
    }
    
    if($BoK_name_box === true)
    {  
//        shell_exec('cd /home/gandic2root/www-dev/netfacts/htdocs/structure/box');
//        shell_exec('mv '.$oldname_box.'.php '.$name_box.'.php');
//        shell_exec('cd --');
        
        try
        {
            $prepared_query = 'UPDATE structure_box
                               SET name_box = :name,
                                   width_box = :width,
                                   height_box = :height,
                                   position_box = :position,
                                   margin_box = :margin,
                                   border_box = :border,
                                   bordercolor_box = :bordercolor,
                                   tablebg_box = :tablebg,
                                   cs_box = :cs,
                                   cp_box = :cp,
                                   bgcolor_box = :bgcolor,
                                   bgimg_box = :bgimage,
                                   xrepeat_box = :xrepeat,
                                   yrepeat_box = :yrepeat,
                                   scriptpath_box = :path,
                                   scriptcode_box = :code,
                                   defaultfont_box = :font,
                                   blocktitle_box = :blocktitle,
                                   blockcontent_box = :blockcontent
                               WHERE id_box = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_box,
                                  'width' => $width_box,
                                  'height' => $height_box,
                                  'position' => $position_box,
                                  'margin' => $margin_box,
                                  'border' => $border_box,
                                  'bordercolor' => $bordercolor_box,
                                  'tablebg' => $tablebg_box,
                                  'cs' => $cs_box,
                                  'cp' => $cp_box,
                                  'bgcolor' => $bgcolor_box,
                                  'bgimage' => $bgimage_box,
                                  'xrepeat' => $xrepeat_box,
                                  'yrepeat' => $yrepeat_box,
                                  'path' => $scriptpath_box,
                                  'code' => $scriptcode_box,
                                  'font' => $defaultfont_box,
                                  'blocktitle' => $blocktitle_box,
                                  'blockcontent' => $blockcontent_box,
                                  'id' => $id_element,
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
                die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
            } 
        }
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Structure');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Structure');
    }
}
?>
