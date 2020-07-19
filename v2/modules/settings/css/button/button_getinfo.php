<?php

$prepared_query = 'SELECT * FROM style_button
                   WHERE id_template = 1';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
while($data = $query->fetch())
{
    $button_createcontent_family = split_string($data['family_button'], '$');
    $button_createcontent_size = split_string($data['size_button'], '$');
    $button_createcontent_weight = split_string($data['weight_button'], '$');
    $button_createcontent_color = split_string($data['color_button'], '$');
    $button_createcontent_align = split_string($data['align_button'], '$');
    $button_createcontent_border = split_string($data['border_button'], '$');
    $button_createcontent_bordercolor = split_string($data['bordercolor_button'], '$');
    $button_createcontent_borderradiuslt = split_string($data['borderradius_lt_button'], '$');
    $button_createcontent_borderradiusrt = split_string($data['borderradius_rt_button'], '$');
    $button_createcontent_borderradiusrb = split_string($data['borderradius_rb_button'], '$');
    $button_createcontent_borderradiuslb = split_string($data['borderradius_lb_button'], '$');
    $button_createcontent_bgcolor = split_string($data['bgcolor_button'], '$');
    $button_createcontent_width = split_string($data['width_button'], '$');
    $button_createcontent_height = split_string($data['height_button'], '$');
    $button_createcontent_padding = split_string($data['padding_button'], '$');
    $button_createcontent_image = split_string($data['image_button'], '$');
}
$query->closeCursor();

for($i = 0, $count = count($button_createcontent_width); $i < $count; $i++)
{
    if(empty($button_createcontent_borderradiuslt[$i]) ? $button_createcontent_borderradiuslt[$i] = 0 : $button_createcontent_borderradiuslt[$i] = $button_createcontent_borderradiuslt[$i])
    if(empty($button_createcontent_borderradiusrt[$i]) ? $button_createcontent_borderradiusrt[$i] = 0 : $button_createcontent_borderradiusrt[$i] = $button_createcontent_borderradiusrt[$i])
    if(empty($button_createcontent_borderradiusrb[$i]) ? $button_createcontent_borderradiusrb[$i] = 0 : $button_createcontent_borderradiusrb[$i] = $button_createcontent_borderradiusrb[$i])
    if(empty($button_createcontent_borderradiuslb[$i]) ? $button_createcontent_borderradiuslb[$i] = 0 : $button_createcontent_borderradiuslb[$i] = $button_createcontent_borderradiuslb[$i])
    if($button_createcontent_width[$i] == 0)
    {
       $button_createcontent_width[$i] = 'auto';
    }
    else
    {
       $button_createcontent_width[$i] = $width_button_css[$i].'px'; 
    }
}

for($i = 0, $count = count($button_createcontent_height); $i < $count; $i++)
{
    if($button_createcontent_height[$i] == 0)
    {
       $button_createcontent_height[$i] = 'auto';
    }
    else
    {
       $button_createcontent_height[$i] = $button_createcontent_height[$i].'px'; 
    }
}
?>
