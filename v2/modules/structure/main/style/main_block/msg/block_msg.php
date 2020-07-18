<tr>
<td align="left" colspan="2"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseBlocksetMsg"
<?php
                if(empty($_SESSION['expand_editstructure_blockset_msg']) || $_SESSION['expand_editstructure_blockset_msg'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseBlocksetMsg', 'img_expand_collapseBlocksetMsg', 'expand_editstructure_blockset_msg', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseBlocksetMsg');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_editstructure_blockset_msg']) || $_SESSION['expand_editstructure_blockset_msg'] == 'false')
                        {
?>
                            <img id="img_expand_collapseBlocksetMsg" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseBlocksetMsg" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('edit_structure.blocktitle_msg_block', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_editstructure_blockset_msg" style="display: none;" type="hidden" name="expand_editstructure_blockset_msg" value="<?php if(empty($_SESSION['expand_editstructure_blockset_msg']) || $_SESSION['expand_editstructure_blockset_msg'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseBlocksetMsg"
<?php
        if(empty($_SESSION['expand_editstructure_blockset_msg']) || $_SESSION['expand_editstructure_blockset_msg'] == 'false')
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
                    include('modules/structure/main/style/main_block/msg/msg1.php');
                    include('modules/structure/main/style/main_block/msg/msg2.php');
                    include('modules/structure/main/style/main_block/msg/msg3.php');
                    include('modules/structure/main/style/main_block/msg/msg4.php');
                    include('modules/structure/main/style/main_block/msg/msg5.php');
?>
                    <tr>
                        <td><div style="height: 4px;"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                            <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                                <tr>
                                    <td align="center">
                                        <input type="submit" name="bt_save_main_block" value="Sauvegarder"/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>     
                        
                </table></td>
            </tr>
        </table>
    </td>
</tr>
