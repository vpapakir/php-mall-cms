<?php
#toilet
if($customgetinfo_displayvalue[18] == 1 && $customgetinfo_numwc > 0)
{
    
?>
    <tr>    
        <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.numwc_product_immo', $echo, $config_showtranslationcode);
?>
        </td>
        <td align="left" class="font_main">
<?php
        echo($customgetinfo_numwc);
?>
        </td>
    </tr>
<?php            
}
?>
