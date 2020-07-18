<?php
if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] != 'select')
{
    $name_element_category = preg_replace('#[0-9]$#', '', $_SESSION['structure_template_cboTemplateContent']);
}
else
{
    $name_element_category = null;
}
?>


<td><table width="100%">
        
    <td class="font_subtitle" width="40%"><?php if(!empty($name_element_category)){ echo(upper_firstchar($name_element_category)); } ?></td>
    <td width="60%">
        <select name="cboTemplateContent" onchange="OnChange('bt_cboTemplateContent');">
            <option value="select"
                    <?php if(empty($_SESSION['structure_template_cboTemplateContent']) || $_SESSION['structure_template_cboTemplateContent'] == 'select'){ echo('selected'); }else{ echo(null); } ?>
                    ><?php give_translation('edit_structure.main_dd_choiceelement', '', $config_showtranslationcode); ?></option>
<?php
            try
            {
                include('modules/structure/template/template_content/template_content_logo.php');
                include('modules/structure/template/template_content/template_content_body.php');
                include('modules/structure/template/template_content/template_content_skin.php');
                include('modules/structure/template/template_content/template_content_section.php');
                include('modules/structure/template/template_content/template_content_layout.php');
                include('modules/structure/template/template_content/template_content_frame.php');
                include('modules/structure/template/template_content/template_content_box.php');
                include('modules/structure/template/template_style/template_style_font.php');
                include('modules/structure/template/template_style/template_style_button.php');
                include('modules/structure/template/template_style/template_style_block.php');
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
        </select>
        <input id="bt_cboTemplateContent" hidden="true" style="display: none;" type="submit" name="bt_cboTemplateContent" value="Choix élément"></input>
    </td>
</table></td>

<tr></tr>
