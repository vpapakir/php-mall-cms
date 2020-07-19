<?php
#[other image]
for($i = 1, $count = count($id_image_page); $i < $count; $i++)
{
    if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
    {
        $custom2_mainimage_width = 180;
        $custom2_mainimage_height = ($custom2_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
    }
    
    $message .= '<tr>
                    <td><table width="100%" style="margin: 0px 0px 4px 0px; 
                        background-color: transparent;
                        width: 100%;
                        height: 100%;
                        font-size: 12px;
                        font-weight: normal;
                        color: #000000;
                        text-decoration: none;
                        text-align: left;">
                        <tr>
                            <td><table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="vertical-align: top;" align="center">
                                        <img src="'.$config_customheader.$path_thumb_page[$i].'" alt="'.$alt_image_page[$i].'" style="border: none; ';                                     
    
    if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
    { 
        $message .= 'width: '.$custom2_mainimage_width.'px; height: '.$custom2_mainimage_height.'px';    
    } 
    else
    {
        $message .= 'width: 180px;';
    }
    $message .= '" />';
    
    if(!empty($legend_image_page[$i]))
    {
        $message .= '<div>
                        <span style="margin: 0px 3px 0px 3px;">'.$legend_image_page[$i].'</span>
                     </div>';
    }
    
    $message .= '</td>
                 </tr>';
    
    $message .= '</table></td>
                </tr>
            </table></td>
        </tr>';
}
unset($id_image_page, $custom2_mainimage_width, $custom2_mainimage_height,
        $legend_image_page);
#[/other image]
?>
