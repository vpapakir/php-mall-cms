<tr>
    <td align="left"><table class="block_main2" width="100%">  
<?php
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
?>
    <tr>
        <td align="left">
            <span class="font_subtitle">
                <?php give_translation($main_activatedcodelang[$i], $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <input type="text" name="txtNameColor<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['color_txtNameColor'.$main_activatedidlang[$i]] )){ echo($_SESSION['color_txtNameColor'.$main_activatedidlang[$i]] ); } ?>"></input>
        </td>
    </tr>
<?php
    }
?>
    <tr>
        <td align="left">
            <span class="font_subtitle">
                <?php give_translation('edit_color.subtitle_code_color', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left">
            <input class="color" type="text" name="txtCodeColor" style="text-align: center; padding: 4px; width: 65px; border: 1px solid lightgrey; border-radius: 6px 6px 6px 6px;" value="<?php if($_SESSION['color_txtCodeColor'] == 'transparent'){ echo('000001'); }else{ if(!empty($_SESSION['color_txtCodeColor'])){echo($_SESSION['color_txtCodeColor']); } } ?>"></input>
            <input hidden="hidden" type="text" name="txtOldCodeColor" value="<?php if($_SESSION['color_txtCodeColor'] == 'transparent'){ echo('000001'); }else{ if(!empty($_SESSION['color_txtCodeColor'])){ echo($_SESSION['color_txtCodeColor']); } } ?>"></input>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
    </tr>
    <tr>
        <td colspan="2"><table width="100%" style="">
            <tr>        
                <td align="center" width="<?php echo($right_column_width); ?>">
<?php
                if(empty($_SESSION['color_cboColor']))
                {
?>
                    <input type="submit" name="bt_add_color" value="<?php give_translation('main.bt_add', '', $config_showtranslationcode); ?>"/>
<?php
                }
                else
                {
?>
                    <input type="submit" name="bt_edit_color" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"></input>
                    <input type="submit" name="bt_delete_color" value="<?php give_translation('main.bt_delete', '', $config_showtranslationcode); ?>"></input>
<?php
                }
?>
                </td>
            </tr> 
        </table></td>
    </tr>
</table></td>
