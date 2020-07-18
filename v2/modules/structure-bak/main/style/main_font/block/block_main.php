<tr>
<td align="left" colspan="2"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseFontsetBlock"
<?php
                if(empty($_SESSION['expand_editstructure_fontset_block']) || $_SESSION['expand_editstructure_fontset_block'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseFontsetBlock', 'img_expand_collapseFontsetBlock', 'expand_editstructure_fontset_block', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseFontsetBlock');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_editstructure_fontset_block']) || $_SESSION['expand_editstructure_fontset_block'] == 'false')
                        {
?>
                            <img id="img_expand_collapseFontsetBlock" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseFontsetBlock" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('edit_structure.blocktitle_block_font', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_editstructure_fontset_block" style="display: none;" type="hidden" name="expand_editstructure_fontset_block" value="<?php if(empty($_SESSION['expand_editstructure_fontset_block']) || $_SESSION['expand_editstructure_fontset_block'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseFontsetBlock"
<?php
        if(empty($_SESSION['expand_editstructure_fontset_block']) || $_SESSION['expand_editstructure_fontset_block'] == 'false')
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
                    include('modules/structure/main/style/main_font/block/boxstyle1.php');
                    include('modules/structure/main/style/main_font/block/boxstyle2.php');
                    include('modules/structure/main/style/main_font/block/boxstyle3.php');
?>
                </table></td>
            </tr>
        </table>
    </td>
</tr>
