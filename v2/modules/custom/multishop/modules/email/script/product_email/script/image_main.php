<?php
if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
{
    $custom2_mainimage_width = 600 - 32;
    $custom2_mainimage_height = ($custom2_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
}

$message .= '<tr>
                <td><table width="100%" border="0" style="background-color: transparent;
                    width: 100%;
                    height: 100%;
                    font-size: 12px;
                    font-weight: normal;
                    color: #000000;
                    text-decoration: none;
                    text-align: left;">
                    <tr>
                        <td><table width="100%" cellpadding="0" cellspacing="0" style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">                           
                            <tr>
                            <td style="vertical-align: top;" align="center">';
#first image
$message .= '                   <img src="'.$config_customheader.$kformprodemail_product_pathoriginimage.'" alt="'.$kformprodemail_product_altimage.'" style="border: none;'; 

if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
{ 
    $message .= 'width: '.$custom2_mainimage_width.'px; height: '.$custom2_mainimage_height.'px';    
} 
else
{
    $message .= 'width: 568px;';
}
$message .= '" /> 
                            </td>
                            </tr>';
#lengend first image
if(!empty($kformprodemail_product_legendoriginimage))
{
    $message .= '<tr>
                    <td align="center">
                        <span style="margin: 0px 3px 0px 3px;">'.$kformprodemail_product_legendoriginimage.'</span>
                    </td>
                </tr>';
}

$message .= '</table></td>
            </tr>
        </table></td>
    </tr>';
?>
