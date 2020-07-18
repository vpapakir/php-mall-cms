<tr>
    <td colspan="2" align="left">
        <table id="collapseNbSleepMinQuicksearch" width="100%" cellpadding="0" cellspacing="0"
<?php
            if(empty($_SESSION['expand_collapseNbSleepMinQuicksearch']) || $_SESSION['expand_collapseNbSleepMinQuicksearch'] == 'false')
            {
                echo('class="block_collapsetitle2"');
            }
            else
            {
                echo('class="block_expandtitle2"');
            }
?>
             width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseNbSleepMinQuicksearch', 'img_expand_collapseNbSleepMinQuicksearch', 'expand_collapseNbSleepMinQuicksearch', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle2','block_expandtitle2', 'collapseNbSleepMinQuicksearch');" style="cursor: pointer;">
            <td align="left" style="vertical-align: top;">                    
<?php
                    if(empty($_SESSION['expand_collapseNbSleepMinQuicksearch']) || $_SESSION['expand_collapseNbSleepMinQuicksearch'] == 'false')
                    {
?>
                        <img id="img_expand_collapseNbSleepMinQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                    }
                    else
                    {
?>
                        <img id="img_expand_collapseNbSleepMinQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                    }
?>   
            </td>
            <td width="100%">
                &nbsp;<LABEL for="txtNbSleepMinQuicksearch" style="cursor: pointer;"><?php give_translation('immo.quicksearch_title_nrofbedrooms', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left"></td>
        </table>
        <input id="expand_collapseNbSleepMinQuicksearch" style="display: none;" type="hidden" name="expand_collapseNbSleepMinQuicksearch" value="<?php if(empty($_SESSION['expand_collapseNbSleepMinQuicksearch']) || $_SESSION['expand_collapseNbSleepMinQuicksearch'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
    </td>
</tr>
<tr id="block_expand_collapseNbSleepMinQuicksearch"
<?php
    if(empty($_SESSION['expand_collapseNbSleepMinQuicksearch']) || $_SESSION['expand_collapseNbSleepMinQuicksearch'] == 'false')
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
                <LABEL style="cursor: pointer; font-size: 10px;" for="txtNbSleepMinQuicksearch"><?php give_translation('immo.quicksearch_subtitle_minimum', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left" class="font_main">
                <LABEL style="cursor: pointer; font-size: 10px;" for="txtNbSleepMaxQuicksearch"><?php give_translation('immo.quicksearch_subtitle_maximum', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
        </tr>
        <tr>
            <td align="left">
                <input style="width: 60px;" id="txtNbSleepMinQuicksearch" type="text" name="txtNbSleepMinQuicksearch" value="<?php if(!empty($_SESSION['quicksearch_txtNbSleepMinQuicksearch'])){ echo($_SESSION['quicksearch_txtNbSleepMinQuicksearch']); } ?>"/>
            </td>
            <td align="left" class="font_main">
                <input style="width: 60px;" id="txtNbSleepMaxQuicksearch" type="text" name="txtNbSleepMaxQuicksearch" value="<?php if(!empty($_SESSION['quicksearch_txtNbSleepMaxQuicksearch'])){ echo($_SESSION['quicksearch_txtNbSleepMaxQuicksearch']); } ?>"/>
            </td>
        </tr>
    </table></td>
</tr>
