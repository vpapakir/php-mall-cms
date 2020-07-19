<?php
#surface hab
if($customgetinfo_displayvalue[8] == 1)
{
    if($customgetinfo_surfacehab > 0)
    {
        $message .= '<tr>    
                         <td  class="font_subtitle" align="left" width="'.$custom_1column_width.'" style="vertical-align: top;">
                            '.give_translation('displayvalueimmo.surfacehab_product_immo', 'false', $config_showtranslationcode).'
                         </td>
                         <td align="left" class="font_main">';
            
        $message .= $customgetinfo_surfacehab.'&nbsp;m²'; 
        
        $message .=  '</td>
                  </tr>'; 
    }
}
?>
