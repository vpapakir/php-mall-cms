<?php
try
{
    $prepared_query = 'SELECT * FROM style_font
                       WHERE id_font = :font';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('font', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_font = $data['id_font'];
        
        $name_font = $data['name_font'];
        $title_font = $data['title_font'];
        $intro_font = $data['intro_font'];
        $desc_font = $data['desc_font'];
        $subtitle_font = $data['subtitle_font'];
        $main_font = $data['main_font'];
        $com_font = $data['comment_font'];
        $box1_font = $data['boxstyle1_font'];
        $box2_font = $data['boxstyle2_font'];
        $box3_font = $data['boxstyle3_font'];
        $error1_font = $data['error1_font'];
        $error2_font = $data['error2_font'];
        $error3_font = $data['error3_font'];
        $info1_font = $data['info1_font'];
        $info2_font = $data['info2_font'];
        $info3_font = $data['info3_font'];
        $info4_font = $data['info4_font'];
        $info5_font = $data['info5_font'];
    }
    $query->closeCursor();
   
    $title_font = split_string($title_font, '$');
    $intro_font = split_string($intro_font, '$');
    $desc_font = split_string($desc_font, '$');
    $subtitle_font = split_string($subtitle_font, '$');
    $main_font = split_string($main_font, '$');
    $com_font = split_string($com_font, '$');
    $box1_font = split_string($box1_font, '$');
    $box2_font = split_string($box2_font, '$');
    $box3_font = split_string($box3_font, '$');
    $error1_font = split_string($error1_font, '$');
    $error2_font = split_string($error2_font, '$');
    $error3_font = split_string($error3_font, '$');
    $info1_font = split_string($info1_font, '$');
    $info2_font = split_string($info2_font, '$');
    $info3_font = split_string($info3_font, '$');
    $info4_font = split_string($info4_font, '$');
    $info5_font = split_string($info5_font, '$');
    
    
    $_SESSION['structure_edit_id_element'] = $id_font;
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
?>

<td><table width="100%">
        
        <td class="font_subtitle" width="40%">
            <?php give_translation('edit_structure.subtitle_name_element', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="60%">
            <input type="text" name="txtNameFont" value="<?php echo($name_font); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_font_txtNameFont']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_font_txtNameFont'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td></td>
        <td>
            <input type="submit" name="bt_save_main_font" value="<?php give_translation('edit_structure.main_bt_save', '', $config_showtranslationcode); ?>"></input>
        </td>
        
<?php
        include('modules/structure/main/style/main_font/main/font_main.php');
        include('modules/structure/main/style/main_font/block/block_main.php');
        include('modules/structure/main/style/main_font/error/error_main.php');
        include('modules/structure/main/style/main_font/info/info_main.php');
?>
        
        <td></td>
        <td>
            <input type="submit" name="bt_save_main_font" value="<?php give_translation('edit_structure.main_bt_save', '', $config_showtranslationcode); ?>"></input>
        </td>
        
</table></td>




