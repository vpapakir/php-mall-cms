<?php
#numsleeps
if($customgetinfo_displayvalue[16] == 1 && $customgetinfo_numsleeps > 0)
{
    
?>
    <tr>    
        <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.numsleep_product_immo', $echo, $config_showtranslationcode);
?>
        </td>
        <td align="left" class="font_main">
<?php
        echo($customgetinfo_numsleeps);
?>
        </td>
    </tr>
<?php            
}
?>
