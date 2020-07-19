<?php
#reference
if($customgetinfo_displayvalue[1] == 1)
{
?>
    <tr>    
        <td class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.ref_product_immo');
?>
        </td>
        <td class="font_main">
            <?php echo($customgetinfo_reference); ?>
        </td>
    </tr>
<?php            
}
?>
