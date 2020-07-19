<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseMyaccountMsg"
<?php
                if((!empty($_SESSION['expand_myaccount_msg']) && $_SESSION['expand_myaccount_msg'] == 'false') || $myaccount_msg_unread_count == 0)
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseMyaccountMsg', 'img_expand_collapseMyaccountMsg', 'expand_myaccount_msg', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseMyaccountMsg');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if((!empty($_SESSION['expand_myaccount_msg']) && $_SESSION['expand_myaccount_msg'] == 'false') || $myaccount_msg_unread_count == 0)
                        {
?>
                            <img id="img_expand_collapseMyaccountMsg" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseMyaccountMsg" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 10px;">
                        <?php echo($myaccount_msg_blocktitle); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_myaccount_msg" style="display: none;" type="hidden" name="expand_myaccount_msg" value="<?php if(empty($_SESSION['expand_myaccount_msg']) || $_SESSION['expand_myaccount_msg'] == 'false' || $myaccount_msg_unread_count == 0){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseMyaccountMsg"
<?php
        if((!empty($_SESSION['expand_myaccount_msg']) && $_SESSION['expand_myaccount_msg'] == 'false') || $myaccount_msg_unread_count == 0)
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
        include('modules/user/myaccount/message/myaccountmsg_listing.php');
?>
        </table></td>
    </tr>
    </table></td>
</tr>
