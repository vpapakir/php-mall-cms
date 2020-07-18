<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigImage"
<?php
                if(empty($_SESSION['expand_adminconfig_image']) || $_SESSION['expand_adminconfig_image'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigImage', 'img_expand_collapseAdminconfigImage', 'expand_adminconfig_image', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseAdminconfigImage');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_image']) || $_SESSION['expand_adminconfig_image'] == 'false')
                        {
?>
                            <img id="img_expand_collapseAdminconfigImage" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseAdminconfigImage" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 10px;">
                        <?php give_translation('adminconfig_edit.block_title_image', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_image" style="display: none;" type="hidden" name="expand_adminconfig_image" value="<?php if(empty($_SESSION['expand_adminconfig_image']) || $_SESSION['expand_adminconfig_image'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigImage"
<?php
        if(empty($_SESSION['expand_adminconfig_image']) || $_SESSION['expand_adminconfig_image'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
        <td><table width="100%">
<?php
        include('modules/settings/adminconfig/expand/adminconfig_expand_image/expand_admin_ratio.php');
        include('modules/settings/adminconfig/expand/adminconfig_expand_image/expand_admin_status.php');
?>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        <tr>
            <td colspan="2"><table width="100%">
                <tr>        
                    <td align="center">
<?php
                    if(empty($_SESSION['adminconfig_cboSelectSiteAdminconfig_new']))
                    {
?>
                        <input type="submit" name="bt_save_adminconfig" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
<?php
                        if(!empty($_SESSION['adminconfig_cboSelectSiteAdminconfig']) && $_SESSION['adminconfig_cboSelectSiteAdminconfig'] != 'select')
                        {
?>
                            <input type="submit" name="bt_use_adminconfig" value="<?php give_translation('main.bt_use', '', $config_showtranslationcode); ?>"/>
<?php
                        }
                    }
                    else
                    {
?>
                        <input type="submit" name="bt_add_adminconfig" value="<?php give_translation('main.bt_add', '', $config_showtranslationcode); ?>"/>
<?php
                    }
?>
                    </td>
                </tr> 
            </table></td>
        </tr>
        </table></td>
    </tr>
    </table></td>
</tr>
