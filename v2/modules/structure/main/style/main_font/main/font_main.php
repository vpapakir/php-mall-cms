<tr>
<td align="left" colspan="2"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseFontsetMain"
<?php
                if(empty($_SESSION['expand_editstructure_fontset_main']) || $_SESSION['expand_editstructure_fontset_main'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseFontsetMain', 'img_expand_collapseFontsetMain', 'expand_editstructure_fontset_main', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseFontsetMain');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_editstructure_fontset_main']) || $_SESSION['expand_editstructure_fontset_main'] == 'false')
                        {
?>
                            <img id="img_expand_collapseFontsetMain" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseFontsetMain" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('edit_structure.blocktitle_main_font', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_editstructure_fontset_main" style="display: none;" type="hidden" name="expand_editstructure_fontset_main" value="<?php if(empty($_SESSION['expand_editstructure_fontset_main']) || $_SESSION['expand_editstructure_fontset_main'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseFontsetMain"
<?php
        if(empty($_SESSION['expand_editstructure_fontset_main']) || $_SESSION['expand_editstructure_fontset_main'] == 'false')
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
                    include('modules/structure/main/style/main_font/main/main.php');
                    include('modules/structure/main/style/main_font/main/subtitle.php');
                    include('modules/structure/main/style/main_font/main/title.php');
                    include('modules/structure/main/style/main_font/main/intro.php');
                    include('modules/structure/main/style/main_font/main/desc.php');
                    include('modules/structure/main/style/main_font/main/comment.php');
?>
                </table></td>
            </tr>
        </table>
    </td>
</tr>
