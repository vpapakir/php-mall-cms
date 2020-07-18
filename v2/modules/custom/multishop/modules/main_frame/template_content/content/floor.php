<?php
#floor, cellar, loft
if(($customgetinfo_displayvalue[13] == 1 && $customgetinfo_numfloor > 0) 
        || ($customgetinfo_displayvalue[11] == 1 && $customgetinfo_surfacecellar > 0)
        || ($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0))
{
    
?>
    <tr>    
        <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.repartition_product_immo');
?>
        </td>
    </tr>
    <tr>
        <td align="left" class="font_main">
<?php
        if($customgetinfo_displayvalue[13] == 1 && $customgetinfo_numfloor > 0)
        {
            echo($customgetinfo_numfloor.' '); 
            
            if($customgetinfo_numfloor > 1)
            {
                give_translation('displayvalueimmo.levelnb_product_immo');
            }
            else
            {
                give_translation('displayvalueimmo.Slevelnb_product_immo');
            } 
            
            if(($customgetinfo_displayvalue[11] == 1 && $customgetinfo_surfacecellar > 0)
                    || ($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0))
            {
                echo(', ');
            }
            
        }
        
        if($customgetinfo_displayvalue[11] == 1 && $customgetinfo_surfacecellar > 0)
        {
            give_translation('displayvalueimmo.cellar_product_immo');
            echo('&nbsp;('.$customgetinfo_surfacecellar.'m²)');
            
            if($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0)
            {
                echo(', ');
            }
        }
        
        if($customgetinfo_displayvalue[12] == 1 && $customgetinfo_surfaceloft > 0)
        {
            give_translation('displayvalueimmo.loft_product_immo');
            echo('&nbsp;('.$customgetinfo_surfaceloft.'m²)'); 
        }
?>
        </td>
    </tr>
<?php            
}
?>
