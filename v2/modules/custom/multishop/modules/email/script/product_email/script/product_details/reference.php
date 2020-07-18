<?php
#reference
if($customgetinfo_displayvalue[1] == 1)
{
    $message .= '<tr>    
                    <td class="font_subtitle" width="'.$custom_1column_width.'" style="vertical-align: top;">

                    '.give_translation('displayvalueimmo.ref_product_immo', 'false', $config_showtranslationcode).'

                    </td>
                    <td class="font_main">
                        '.$customgetinfo_reference.'
                    </td>
                </tr>';          
}
?>
