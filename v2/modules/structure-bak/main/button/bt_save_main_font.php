<?php
if(isset($_POST['bt_save_main_font']))
{  
    unset($_SESSION['msg_structure_edit_main_font_txtNameFont']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_font = trim(htmlspecialchars($_POST['txtNameFont'], ENT_QUOTES));
    
    $main_family_font = $_POST['cboMainFamilyFont'];
    $main_size_font = trim(htmlspecialchars($_POST['txtMainSizeFont'], ENT_QUOTES));    
    $main_weight_font = trim(htmlspecialchars($_POST['cboMainWeightFont'], ENT_QUOTES));   
    $main_color_font = trim(htmlspecialchars($_POST['cboMainColorFont'], ENT_QUOTES));   
    $main_decoration_font = trim(htmlspecialchars($_POST['cboMainDecorationFont'], ENT_QUOTES));
    $main_align_font = trim(htmlspecialchars($_POST['cboMainAlignFont'], ENT_QUOTES));
    
    $title_family_font = $_POST['cboTitleFamilyFont'];
    $title_size_font = trim(htmlspecialchars($_POST['txtTitleSizeFont'], ENT_QUOTES));    
    $title_weight_font = trim(htmlspecialchars($_POST['cboTitleWeightFont'], ENT_QUOTES));   
    $title_color_font = trim(htmlspecialchars($_POST['cboTitleColorFont'], ENT_QUOTES));   
    $title_decoration_font = trim(htmlspecialchars($_POST['cboTitleDecorationFont'], ENT_QUOTES)); 
    $title_align_font = trim(htmlspecialchars($_POST['cboTitleAlignFont'], ENT_QUOTES));
    
    $intro_family_font = $_POST['cboIntroFamilyFont'];
    $intro_size_font = trim(htmlspecialchars($_POST['txtIntroSizeFont'], ENT_QUOTES));    
    $intro_weight_font = trim(htmlspecialchars($_POST['cboIntroWeightFont'], ENT_QUOTES));   
    $intro_color_font = trim(htmlspecialchars($_POST['cboIntroColorFont'], ENT_QUOTES));   
    $intro_decoration_font = trim(htmlspecialchars($_POST['cboIntroDecorationFont'], ENT_QUOTES)); 
    $intro_align_font = trim(htmlspecialchars($_POST['cboIntroAlignFont'], ENT_QUOTES));
    
    $desc_family_font = $_POST['cboDescFamilyFont'];
    $desc_size_font = trim(htmlspecialchars($_POST['txtDescSizeFont'], ENT_QUOTES));    
    $desc_weight_font = trim(htmlspecialchars($_POST['cboDescWeightFont'], ENT_QUOTES));   
    $desc_color_font = trim(htmlspecialchars($_POST['cboDescColorFont'], ENT_QUOTES));   
    $desc_decoration_font = trim(htmlspecialchars($_POST['cboDescDecorationFont'], ENT_QUOTES)); 
    $desc_align_font = trim(htmlspecialchars($_POST['cboDescAlignFont'], ENT_QUOTES));
    
    $subtitle_family_font = $_POST['cboSubtitleFamilyFont'];
    $subtitle_size_font = trim(htmlspecialchars($_POST['txtSubtitleSizeFont'], ENT_QUOTES));    
    $subtitle_weight_font = trim(htmlspecialchars($_POST['cboSubtitleWeightFont'], ENT_QUOTES));   
    $subtitle_color_font = trim(htmlspecialchars($_POST['cboSubtitleColorFont'], ENT_QUOTES));   
    $subtitle_decoration_font = trim(htmlspecialchars($_POST['cboSubtitleDecorationFont'], ENT_QUOTES));
    $subtitle_align_font = trim(htmlspecialchars($_POST['cboSubtitleAlignFont'], ENT_QUOTES));  
    
    $com_family_font = $_POST['cboComFamilyFont'];
    $com_size_font = trim(htmlspecialchars($_POST['txtComSizeFont'], ENT_QUOTES));    
    $com_weight_font = trim(htmlspecialchars($_POST['cboComWeightFont'], ENT_QUOTES));   
    $com_color_font = trim(htmlspecialchars($_POST['cboComColorFont'], ENT_QUOTES));   
    $com_decoration_font = trim(htmlspecialchars($_POST['cboComDecorationFont'], ENT_QUOTES));
    $com_align_font = trim(htmlspecialchars($_POST['cboComAlignFont'], ENT_QUOTES));  
    
    $box1_family_font = $_POST['cboBox1FamilyFont'];
    $box1_size_font = trim(htmlspecialchars($_POST['txtBox1SizeFont'], ENT_QUOTES));    
    $box1_weight_font = trim(htmlspecialchars($_POST['cboBox1WeightFont'], ENT_QUOTES));   
    $box1_color_font = trim(htmlspecialchars($_POST['cboBox1ColorFont'], ENT_QUOTES));   
    $box1_decoration_font = trim(htmlspecialchars($_POST['cboBox1DecorationFont'], ENT_QUOTES));
    $box1_align_font = trim(htmlspecialchars($_POST['cboBox1AlignFont'], ENT_QUOTES)); 
    
    $box2_family_font = $_POST['cboBox2FamilyFont'];
    $box2_size_font = trim(htmlspecialchars($_POST['txtBox2SizeFont'], ENT_QUOTES));    
    $box2_weight_font = trim(htmlspecialchars($_POST['cboBox2WeightFont'], ENT_QUOTES));   
    $box2_color_font = trim(htmlspecialchars($_POST['cboBox2ColorFont'], ENT_QUOTES));   
    $box2_decoration_font = trim(htmlspecialchars($_POST['cboBox2DecorationFont'], ENT_QUOTES));
    $box2_align_font = trim(htmlspecialchars($_POST['cboBox2AlignFont'], ENT_QUOTES));  
    
    $box3_family_font = $_POST['cboBox3FamilyFont'];
    $box3_size_font = trim(htmlspecialchars($_POST['txtBox3SizeFont'], ENT_QUOTES));    
    $box3_weight_font = trim(htmlspecialchars($_POST['cboBox3WeightFont'], ENT_QUOTES));   
    $box3_color_font = trim(htmlspecialchars($_POST['cboBox3ColorFont'], ENT_QUOTES));   
    $box3_decoration_font = trim(htmlspecialchars($_POST['cboBox3DecorationFont'], ENT_QUOTES));
    $box3_align_font = trim(htmlspecialchars($_POST['cboBox3AlignFont'], ENT_QUOTES)); 
    
    #wrong/error font
    $error1_family_font = $_POST['cboError1FamilyFont'];
    $error1_size_font = trim(htmlspecialchars($_POST['txtError1SizeFont'], ENT_QUOTES));    
    $error1_weight_font = trim(htmlspecialchars($_POST['cboError1WeightFont'], ENT_QUOTES));   
    $error1_color_font = trim(htmlspecialchars($_POST['cboError1ColorFont'], ENT_QUOTES));   
    $error1_decoration_font = trim(htmlspecialchars($_POST['cboError1DecorationFont'], ENT_QUOTES));
    $error1_align_font = trim(htmlspecialchars($_POST['cboError1AlignFont'], ENT_QUOTES));
    
    $error2_family_font = $_POST['cboError2FamilyFont'];
    $error2_size_font = trim(htmlspecialchars($_POST['txtError2SizeFont'], ENT_QUOTES));    
    $error2_weight_font = trim(htmlspecialchars($_POST['cboError2WeightFont'], ENT_QUOTES));   
    $error2_color_font = trim(htmlspecialchars($_POST['cboError2ColorFont'], ENT_QUOTES));   
    $error2_decoration_font = trim(htmlspecialchars($_POST['cboError2DecorationFont'], ENT_QUOTES));
    $error2_align_font = trim(htmlspecialchars($_POST['cboError2AlignFont'], ENT_QUOTES));
    
    $error3_family_font = $_POST['cboError3FamilyFont'];
    $error3_size_font = trim(htmlspecialchars($_POST['txtError3SizeFont'], ENT_QUOTES));    
    $error3_weight_font = trim(htmlspecialchars($_POST['cboError3WeightFont'], ENT_QUOTES));   
    $error3_color_font = trim(htmlspecialchars($_POST['cboError3ColorFont'], ENT_QUOTES));   
    $error3_decoration_font = trim(htmlspecialchars($_POST['cboError3DecorationFont'], ENT_QUOTES));
    $error3_align_font = trim(htmlspecialchars($_POST['cboError3AlignFont'], ENT_QUOTES));
    
    #right/info font
    $info1_family_font = $_POST['cboInfo1FamilyFont'];
    $info1_size_font = trim(htmlspecialchars($_POST['txtInfo1SizeFont'], ENT_QUOTES));    
    $info1_weight_font = trim(htmlspecialchars($_POST['cboInfo1WeightFont'], ENT_QUOTES));   
    $info1_color_font = trim(htmlspecialchars($_POST['cboInfo1ColorFont'], ENT_QUOTES));   
    $info1_decoration_font = trim(htmlspecialchars($_POST['cboInfo1DecorationFont'], ENT_QUOTES));
    $info1_align_font = trim(htmlspecialchars($_POST['cboInfo1AlignFont'], ENT_QUOTES));

    $info2_family_font = $_POST['cboInfo2FamilyFont'];
    $info2_size_font = trim(htmlspecialchars($_POST['txtInfo2SizeFont'], ENT_QUOTES));    
    $info2_weight_font = trim(htmlspecialchars($_POST['cboInfo2WeightFont'], ENT_QUOTES));   
    $info2_color_font = trim(htmlspecialchars($_POST['cboInfo2ColorFont'], ENT_QUOTES));   
    $info2_decoration_font = trim(htmlspecialchars($_POST['cboInfo2DecorationFont'], ENT_QUOTES));
    $info2_align_font = trim(htmlspecialchars($_POST['cboInfo2AlignFont'], ENT_QUOTES));

    $info3_family_font = $_POST['cboInfo3FamilyFont'];
    $info3_size_font = trim(htmlspecialchars($_POST['txtInfo3SizeFont'], ENT_QUOTES));    
    $info3_weight_font = trim(htmlspecialchars($_POST['cboInfo3WeightFont'], ENT_QUOTES));   
    $info3_color_font = trim(htmlspecialchars($_POST['cboInfo3ColorFont'], ENT_QUOTES));   
    $info3_decoration_font = trim(htmlspecialchars($_POST['cboInfo3DecorationFont'], ENT_QUOTES));
    $info3_align_font = trim(htmlspecialchars($_POST['cboInfo3AlignFont'], ENT_QUOTES));
    
    $info4_family_font = $_POST['cboInfo4FamilyFont'];
    $info4_size_font = trim(htmlspecialchars($_POST['txtInfo4SizeFont'], ENT_QUOTES));    
    $info4_weight_font = trim(htmlspecialchars($_POST['cboInfo4WeightFont'], ENT_QUOTES));   
    $info4_color_font = trim(htmlspecialchars($_POST['cboInfo4ColorFont'], ENT_QUOTES));   
    $info4_decoration_font = trim(htmlspecialchars($_POST['cboInfo4DecorationFont'], ENT_QUOTES));
    $info4_align_font = trim(htmlspecialchars($_POST['cboInfo4AlignFont'], ENT_QUOTES));
    
    $info5_family_font = $_POST['cboInfo5FamilyFont'];
    $info5_size_font = trim(htmlspecialchars($_POST['txtInfo5SizeFont'], ENT_QUOTES));    
    $info5_weight_font = trim(htmlspecialchars($_POST['cboInfo5WeightFont'], ENT_QUOTES));   
    $info5_color_font = trim(htmlspecialchars($_POST['cboInfo5ColorFont'], ENT_QUOTES));   
    $info5_decoration_font = trim(htmlspecialchars($_POST['cboInfo5DecorationFont'], ENT_QUOTES));
    $info5_align_font = trim(htmlspecialchars($_POST['cboInfo5AlignFont'], ENT_QUOTES));
  
    $main_font = $main_size_font.'$'.$main_weight_font.'$'.$main_color_font.'$'.$main_decoration_font.'$'.$main_align_font.'$'.$main_family_font;
    $title_font = $title_size_font.'$'.$title_weight_font.'$'.$title_color_font.'$'.$title_decoration_font.'$'.$title_align_font.'$'.$title_family_font;
    $intro_font = $intro_size_font.'$'.$intro_weight_font.'$'.$intro_color_font.'$'.$intro_decoration_font.'$'.$intro_align_font.'$'.$intro_family_font;
    $desc_font = $desc_size_font.'$'.$desc_weight_font.'$'.$desc_color_font.'$'.$desc_decoration_font.'$'.$desc_align_font.'$'.$desc_family_font;
    $subtitle_font = $subtitle_size_font.'$'.$subtitle_weight_font.'$'.$subtitle_color_font.'$'.$subtitle_decoration_font.'$'.$subtitle_align_font.'$'.$subtitle_family_font;
    $com_font = $com_size_font.'$'.$com_weight_font.'$'.$com_color_font.'$'.$com_decoration_font.'$'.$com_align_font.'$'.$com_family_font;
    $box1_font = $box1_size_font.'$'.$box1_weight_font.'$'.$box1_color_font.'$'.$box1_decoration_font.'$'.$box1_align_font.'$'.$box1_family_font;
    $box2_font = $box2_size_font.'$'.$box2_weight_font.'$'.$box2_color_font.'$'.$box2_decoration_font.'$'.$box2_align_font.'$'.$box2_family_font;
    $box3_font = $box3_size_font.'$'.$box3_weight_font.'$'.$box3_color_font.'$'.$box3_decoration_font.'$'.$box3_align_font.'$'.$box3_family_font;
    $error1_font = $error1_size_font.'$'.$error1_weight_font.'$'.$error1_color_font.'$'.$error1_decoration_font.'$'.$error1_align_font.'$'.$error1_family_font;
    $error2_font = $error2_size_font.'$'.$error2_weight_font.'$'.$error2_color_font.'$'.$error2_decoration_font.'$'.$error2_align_font.'$'.$error2_family_font;
    $error3_font = $error3_size_font.'$'.$error3_weight_font.'$'.$error3_color_font.'$'.$error3_decoration_font.'$'.$error3_align_font.'$'.$error3_family_font;
    $info1_font = $info1_size_font.'$'.$info1_weight_font.'$'.$info1_color_font.'$'.$info1_decoration_font.'$'.$info1_align_font.'$'.$info1_family_font;
    $info2_font = $info2_size_font.'$'.$info2_weight_font.'$'.$info2_color_font.'$'.$info2_decoration_font.'$'.$info2_align_font.'$'.$info2_family_font;
    $info3_font = $info3_size_font.'$'.$info3_weight_font.'$'.$info3_color_font.'$'.$info3_decoration_font.'$'.$info3_align_font.'$'.$info3_family_font;
    $info4_font = $info4_size_font.'$'.$info4_weight_font.'$'.$info4_color_font.'$'.$info4_decoration_font.'$'.$info4_align_font.'$'.$info4_family_font;
    $info5_font = $info5_size_font.'$'.$info5_weight_font.'$'.$info5_color_font.'$'.$info5_decoration_font.'$'.$info5_align_font.'$'.$info5_family_font;

    $BoK_name_font = true;  
    
    if(empty($name_font))
    {
       $_SESSION['msg_structure_edit_main_font_txtNameFont'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_font = false; 
    }
    
    if($BoK_name_font === true)
    {        
        try
        {
            $prepared_query = 'UPDATE style_font
                               SET name_font = :name,
                                   main_font = :main,
                                   title_font = :title,
                                   intro_font = :intro,
                                   desc_font = :desc,
                                   subtitle_font = :subtitle,
                                   comment_font = :comment,
                                   boxstyle1_font = :box1,
                                   boxstyle2_font = :box2,
                                   boxstyle3_font = :box3,
                                   error1_font = :error1,
                                   error2_font = :error2,
                                   error3_font = :error3,
                                   info1_font = :info1,
                                   info2_font = :info2,
                                   info3_font = :info3,
                                   info4_font = :info4,
                                   info5_font = :info5
                               WHERE id_font = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_font,
                                  'main' => $main_font,
                                  'title' => $title_font,
                                  'intro' => $intro_font,
                                  'desc' => $desc_font,
                                  'subtitle' => $subtitle_font,
                                  'comment' => $com_font,
                                  'box1' => $box1_font,
                                  'box2' => $box2_font,
                                  'box3' => $box3_font,
                                  'error1' => $error1_font,
                                  'error2' => $error2_font,
                                  'error3' => $error3_font,
                                  'info1' => $info1_font,
                                  'info2' => $info2_font,
                                  'info3' => $info3_font,
                                  'info4' => $info4_font,
                                  'info5' => $info5_font,
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
                die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
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
