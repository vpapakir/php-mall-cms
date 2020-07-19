<?php
#surface hab
if($customgetinfo_displayvalue[8] == 1)
{
    if($customgetinfo_surfacehab > 0)
    {
?>
        <tr>    
            <td class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
            give_translation('displayvalueimmo.surfacehab_product_immo');
?>
            </td>
            <td class="font_main">
<?php            
                echo($customgetinfo_surfacehab.'&nbsp;m²'); 
?>
            </td>
        </tr>
<?php  
    }
}
?>
