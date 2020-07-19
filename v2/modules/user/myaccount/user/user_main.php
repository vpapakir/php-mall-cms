<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseMyaccountUser"
<?php
                if(empty($_SESSION['expand_myaccount_user']) || $_SESSION['expand_myaccount_user'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseMyaccountUser', 'img_expand_collapseMyaccountUser', 'expand_myaccount_user', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseMyaccountUser');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_myaccount_user']) || $_SESSION['expand_myaccount_user'] == 'false')
                        {
?>
                            <img id="img_expand_collapseMyaccountUser" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseMyaccountUser" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 10px;">
                        <?php give_translation('myaccount.block_title_user', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_myaccount_user" style="display: none;" type="hidden" name="expand_myaccount_user" value="<?php if(empty($_SESSION['expand_myaccount_user']) || $_SESSION['expand_myaccount_user'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseMyaccountUser"
<?php
        if(empty($_SESSION['expand_myaccount_user']) || $_SESSION['expand_myaccount_user'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
        <td>
            <table width="100%" cellpadding="0" cellspacing="1">
<?php
            include('modules/user/myaccount/user/user_info.php');
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td colspan="2"><table width="100%" style="">
                        <tr>        
                            <td align="center">
                                <input type="submit" name="bt_modify_myaccount_main" value="<?php give_translation('main.bt_modify_userdata_main', '', $config_showtranslationcode); ?>"/>
                                <input type="submit" name="bt_modify_myaccount_email" value="<?php give_translation('main.bt_modify_userdata_email', '', $config_showtranslationcode); ?>"/>
                                <input type="submit" name="bt_modify_myaccount_password" value="<?php give_translation('main.bt_modify_userdata_password', '', $config_showtranslationcode); ?>"/>
                            </td>
                        </tr> 
                    </table></td>
                </tr>
            </table>
        </td>
    </tr>
    </table></td>
</tr>
