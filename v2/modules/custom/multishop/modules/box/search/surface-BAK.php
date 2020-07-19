<tr>
    <td colspan="2" align="left">
        <table id="collapseSurfacehabQuicksearch" width="100%" cellpadding="0" cellspacing="0"
<?php
            if(empty($_SESSION['expand_collapseSurfacehabQuicksearch']) || $_SESSION['expand_collapseSurfacehabQuicksearch'] == 'false')
            {
                echo('class="block_collapsetitle2"');
            }
            else
            {
                echo('class="block_expandtitle2"');
            }
?>
             width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseSurfacehabQuicksearch', 'img_expand_collapseSurfacehabQuicksearch', 'expand_collapseSurfacehabQuicksearch', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle2','block_expandtitle2', 'collapseSurfacehabQuicksearch');" style="cursor: pointer;">
            <td align="left" style="vertical-align: top;">                    
<?php
                    if(empty($_SESSION['expand_collapseSurfacehabQuicksearch']) || $_SESSION['expand_collapseSurfacehabQuicksearch'] == 'false')
                    {
?>
                        <img id="img_expand_collapseSurfacehabQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                    }
                    else
                    {
?>
                        <img id="img_expand_collapseSurfacehabQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                    }
?>                        
            </td>
            <td width="100%">
                &nbsp;<LABEL for="txtSurfacehabQuicksearch" style="cursor: pointer;"><?php give_translation('immo.quicksearch_title_surface', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left"></td>
        </table>
        <input id="expand_collapseSurfacehabQuicksearch" style="display: none;" type="hidden" name="expand_collapseSurfacehabQuicksearch" value="<?php if(empty($_SESSION['expand_collapseSurfacehabQuicksearch']) || $_SESSION['expand_collapseSurfacehabQuicksearch'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
    </td>
</tr>
<tr id="block_expand_collapseSurfacehabQuicksearch"
<?php
    if(empty($_SESSION['expand_collapseSurfacehabQuicksearch']) || $_SESSION['expand_collapseSurfacehabQuicksearch'] == 'false')
    {
        echo('style="display: none;"');
    }
    else
    {
        echo(null);
    }
?>
    ><td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" class="font_main" width="100%">
                <LABEL style="cursor: pointer; font-size: 10px;" for="txtSurfacehabQuicksearch"><?php give_translation('immo.quicksearch_subtitle_surfacelivingspace', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left" class="font_main">
                <LABEL style="cursor: pointer; font-size: 10px;" for="txtSurfacegroundQuicksearch"><?php give_translation('immo.quicksearch_subtitle_surfaceground', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
        </tr>
        <tr>
            <td align="left">
                <input style="width: 60px;" id="txtSurfacehabQuicksearch" type="text" name="txtSurfacehabQuicksearch" value="<?php if(!empty($_SESSION['quicksearch_txtSurfacehabQuicksearch'])){ echo($_SESSION['quicksearch_txtSurfacehabQuicksearch']); } ?>"/>
            </td>
            <td align="left" class="font_main">
                <input style="width: 60px;" id="txtSurfacegroundQuicksearch" type="text" name="txtSurfacegroundQuicksearch" value="<?php if(!empty($_SESSION['quicksearch_txtSurfacegroundQuicksearch'])){ echo($_SESSION['quicksearch_txtSurfacegroundQuicksearch']); } ?>"/>
            </td>
        </tr>
    </table></td>
</tr>

