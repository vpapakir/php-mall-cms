<tr>
<td align="left" colspan="2"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseBlocksetPriority"
<?php
                if(empty($_SESSION['expand_editstructure_blockset_priority']) || $_SESSION['expand_editstructure_blockset_priority'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseBlocksetPriority', 'img_expand_collapseBlocksetPriority', 'expand_editstructure_blockset_priority', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseBlocksetPriority');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_editstructure_blockset_priority']) || $_SESSION['expand_editstructure_blockset_priority'] == 'false')
                        {
?>
                            <img id="img_expand_collapseBlocksetPriority" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseBlocksetPriority" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('edit_structure.blocktitle_priority_block', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_editstructure_blockset_priority" style="display: none;" type="hidden" name="expand_editstructure_blockset_priority" value="<?php if(empty($_SESSION['expand_editstructure_blockset_priority']) || $_SESSION['expand_editstructure_blockset_priority'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseBlocksetPriority"
<?php
        if(empty($_SESSION['expand_editstructure_blockset_priority']) || $_SESSION['expand_editstructure_blockset_priority'] == 'false')
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
                    include('modules/structure/main/style/main_block/priority/priority1.php');
                    include('modules/structure/main/style/main_block/priority/priority2.php');
                    include('modules/structure/main/style/main_block/priority/priority3.php');
                    include('modules/structure/main/style/main_block/priority/priority4.php');
                    include('modules/structure/main/style/main_block/priority/priority5.php');
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
