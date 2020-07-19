<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseMsgeditUnread"
<?php
                if(!empty($_SESSION['expand_msgedit_unread']) && $_SESSION['expand_msgedit_unread'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseMsgeditUnread', 'img_expand_collapseMsgeditUnread', 'expand_msgedit_unread', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseMsgeditUnread');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(!empty($_SESSION['expand_msgedit_unread']) && $_SESSION['expand_msgedit_unread'] == 'false')
                        {
?>
                            <img id="img_expand_collapseMsgeditUnread" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseMsgeditUnread" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 10px;">
                        <?php echo($msgedit_unread_blocktitle); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_msgedit_unread" style="display: none;" type="hidden" name="expand_msgedit_unread" value="<?php if(empty($_SESSION['expand_msgedit_unread']) || $_SESSION['expand_msgedit_unread'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseMsgeditUnread"
<?php
        if(!empty($_SESSION['expand_msgedit_unread']) && $_SESSION['expand_msgedit_unread'] == 'false')
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
        include('modules/user/admin/msgedit/content/msgedit_unread.php');
?>
        </table></td>
    </tr>
    </table></td>
</tr>
