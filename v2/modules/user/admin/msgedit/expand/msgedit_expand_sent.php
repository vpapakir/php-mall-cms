<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseMsgeditSent"
<?php
                if(empty($_SESSION['expand_msgedit_sent']) || $_SESSION['expand_msgedit_sent'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseMsgeditSent', 'img_expand_collapseMsgeditSent', 'expand_msgedit_sent', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseMsgeditSent');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_msgedit_sent']) || $_SESSION['expand_msgedit_sent'] == 'false')
                        {
?>
                            <img id="img_expand_collapseMsgeditSent" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseMsgeditSent" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 10px;">
                        <?php echo($msgedit_sent_blocktitle); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_msgedit_sent" style="display: none;" type="hidden" name="expand_msgedit_sent" value="<?php if(empty($_SESSION['expand_msgedit_sent']) || $_SESSION['expand_msgedit_sent'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseMsgeditSent"
<?php
        if(empty($_SESSION['expand_msgedit_sent']) || $_SESSION['expand_msgedit_sent'] == 'false')
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
        include('modules/user/admin/msgedit/content/msgedit_sent.php');
?>
        </table></td>
    </tr>
    </table></td>
</tr>
