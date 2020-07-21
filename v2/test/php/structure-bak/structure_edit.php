<?php
include('modules/structure/template/button/bt_use_template.php');
include('modules/structure/template/button/bt_copy_template.php');
include('modules/structure/template/button/bt_delete_template.php');
include('modules/structure/template/button/bt_cboTemplate.php');
include('modules/structure/template/button/bt_cboTemplateContent.php');
include('modules/structure/main/button/bt_save_main_logo.php');
include('modules/structure/main/button/bt_save_main_body.php');
include('modules/structure/main/button/bt_save_main_skin.php');
include('modules/structure/main/button/bt_save_main_section.php');
include('modules/structure/main/button/bt_save_main_layout.php');
include('modules/structure/main/button/bt_save_main_frame.php');
include('modules/structure/main/button/bt_save_main_box.php');
include('modules/structure/main/button/bt_save_main_font.php');
include('modules/structure/main/button/bt_save_main_button.php');
include('modules/structure/main/button/bt_save_main_block.php');
include('modules/structure/main/button/bt_general.php');

#upload
include('modules/structure/main/button/upload/logo/bt_send_image_logo.php');
include('modules/structure/main/button/upload/logo/bt_delete_image_logo.php');
include('modules/structure/main/button/upload/body/bt_send_image_body.php');
include('modules/structure/main/button/upload/body/bt_delete_image_body.php');
include('modules/structure/main/button/upload/skin/bt_send_image_skin.php');
include('modules/structure/main/button/upload/skin/bt_delete_image_skin.php');
    #layout
    include('modules/structure/main/button/upload/layout/bt_send_image_layout_top.php');
    include('modules/structure/main/button/upload/layout/bt_send_image_layout_middle.php');
    include('modules/structure/main/button/upload/layout/bt_send_image_layout_bottom.php');
    include('modules/structure/main/button/upload/layout/bt_delete_image_layout_top.php');
    include('modules/structure/main/button/upload/layout/bt_delete_image_layout_middle.php');
    include('modules/structure/main/button/upload/layout/bt_delete_image_layout_bottom.php');

?>

<td><form method="post" enctype="multipart/form-data"><table width="100%">
               
<?php
    include('modules/structure/template/structure_template.php');
    
if(!empty($_SESSION['structure_template_cboTemplate']) && $_SESSION['structure_template_cboTemplate'] != 'select')
{
?> 
        <td><table width="100%">
                
                <td class="font_subtitle" width="40%">
                    <?php give_translation('edit_structure.subtitle_name_template', '', $config_showtranslationcode); ?>
                </td>
                <td width="60%">
                    <input style="<?php echo($style_main_font); ?>" type="text" name="txtNameTemplate" value="<?php echo($name_template); ?>"></input>
                    <br clear="left">
                    <div class="font_main">
<?php 
                        if(!empty($_SESSION['msg_structure_edit_main_body_txtNameTemplate']))
                        { 
                            echo(check_session_input($_SESSION['msg_structure_edit_main_body_txtNameTemplate'])); 
                        } 
?>
                    </div>
                </td>

        </table></td>

        <tr></tr>
            
<?php 
    
    include('modules/structure/template/structure_template_content.php');         

    if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] != 'select')
    {
        $name_element = preg_replace('#[0-9]{1,2}$#', '', $_SESSION['structure_template_cboTemplateContent']);
        $id_element = preg_replace('#[A-Za-z]#', '', $_SESSION['structure_template_cboTemplateContent']);
        $id_template = $_SESSION['structure_template_cboTemplate'];
    
        switch ($name_element)
        {
            case 'logo':
                include('modules/structure/main/content/main_logo.php');
                break;
            
            case 'body':
                include('modules/structure/main/content/main_body.php');
                break;
            
             case 'skin':
                include('modules/structure/main/content/main_skin.php');
                break;
            
            case 'section':
                include('modules/structure/main/content/main_section.php');
                break;
            
            case 'layout':
                include('modules/structure/main/content/main_layout.php');
                break;
            
            case 'frame':
                include('modules/structure/main/content/main_frame.php');
                break;
            
            case 'box':
                include('modules/structure/main/content/main_box.php');
                break;
            
            case 'font':
                include('modules/structure/main/style/main_font.php');
                break;
            
            case 'button':
                include('modules/structure/main/style/main_button.php');
                break;
            
            case 'block':
                include('modules/structure/main/style/main_block.php');
                break;
        }
        
        
    }
}
?>       
        
               
</table></form></td>
