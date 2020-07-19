<?php
#numbath
if($customgetinfo_displayvalue[17] == 1 && $customgetinfo_numbath > 0)
{
    
?>
    <tr>    
        <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.numbath_product_immo', $echo, $config_showtranslationcode);
?>
        </td>
        <td align="left" class="font_main">
<?php
        echo($customgetinfo_numbath);
?>
        </td>
    </tr>
<?php            
}
?>
