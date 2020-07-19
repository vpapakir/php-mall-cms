<?php
$content_buttoncss = null;

for($i = 0, $count = count($button_createcontent_family); $i < $count; $i++)
{   
    switch($i)
    {
        case 0:
            $content_buttoncss .= 'input[type=submit], .link_input, .navtab'."\n";
            break;
        case 1:
            $content_buttoncss .= 'input[type=submit]:hover, .link_input:hover, .navtab:hover'."\n";
            break;
        case 2:
            $content_buttoncss .= 'input[type=submit]:active, .link_input:active, .navtab:active'."\n";
            break;
    }
    $content_buttoncss .= '{'."\n";
    if(!empty($button_createcontent_family[$i]))
    {
        $content_buttoncss .= 'font-family: '.$button_createcontent_family[$i].';'."\n";
    }

    if(!empty($button_createcontent_size[$i]))
    {
        $content_buttoncss .= 'font-size: '.$button_createcontent_size[$i].'px;'."\n";
    }

    if(!empty($button_createcontent_weight[$i]))
    {
        $content_buttoncss .= 'font-weight: '.$button_createcontent_weight[$i].';'."\n";
    }

    if(!empty($button_createcontent_color[$i]))
    {
        $content_buttoncss .= 'color: '.$button_createcontent_color[$i].';'."\n";
    }

    if(!empty($button_createcontent_align[$i]))
    {
        $content_buttoncss .= 'text-align: '.$button_createcontent_align[$i].';'."\n";
    }

    if(!empty($button_createcontent_border[$i]))
    {
        $content_buttoncss .= 'border: '.$button_createcontent_border[$i].'px solid;'."\n";
    }
    
    if(!empty($button_createcontent_bordercolor[$i]))
    {
        $content_buttoncss .= 'border-color: '.$button_createcontent_bordercolor[$i].';'."\n";
    }
    
    if(!empty($button_createcontent_borderradiuslt[$i])
            || !empty($button_createcontent_borderradiusrt[$i])
            || !empty($button_createcontent_borderradiusrb[$i])
            || !empty($button_createcontent_borderradiuslb[$i]))
    {
        $content_buttoncss .= 'border-radius: '.$button_createcontent_borderradiuslt[$i].'px '.$button_createcontent_borderradiusrt[$i].'px '.$button_createcontent_borderradiusrb[$i].'px '.$button_createcontent_borderradiuslb[$i].'px;'."\n";
        //$content_buttoncss .= '-moz-border-radius: '.$button_createcontent_borderradiuslt[$i].'px '.$button_createcontent_borderradiusrt[$i].'px '.$button_createcontent_borderradiusrb[$i].'px '.$button_createcontent_borderradiuslb[$i].'px;'."\n";
        $content_buttoncss .= '-webkit-border-radius: '.$button_createcontent_borderradiuslt[$i].'px '.$button_createcontent_borderradiusrt[$i].'px '.$button_createcontent_borderradiusrb[$i].'px '.$button_createcontent_borderradiuslb[$i].'px;'."\n";
    }
    
    if(!empty($button_createcontent_bgcolor[$i]))
    {
        $content_buttoncss .= 'background-color: '.$button_createcontent_bgcolor[$i].';'."\n";
    }
    
    if(!empty($button_createcontent_width[$i]))
    {
        $content_buttoncss .= 'width: '.$button_createcontent_width[$i].';'."\n";
    }
    
    if(!empty($button_createcontent_height[$i]))
    {
        $content_buttoncss .= 'height: '.$button_createcontent_height[$i].';'."\n";
    }
    
    if(!empty($button_createcontent_padding[$i]))
    {
        $content_buttoncss .= 'padding: '.$button_createcontent_padding[$i].'px;'."\n";
    }
    
    if(!empty($button_createcontent_image[$i]))
    {
        $content_buttoncss .= 'background-image: url(\''.$button_createcontent_image[$i].'\');'."\n";
    }
    
    $content_buttoncss .= 'cursor: pointer;'."\n";
    $content_buttoncss .= '}'."\n\n";
    
    if($i == 2)
    {
        $content_buttoncss .= '.navtab, .navtab:hover, .navtab:active, .navtab_selected'."\n";
        $content_buttoncss .= '{'."\n";
        if(!empty($button_createcontent_borderradiuslt[$i])
            || !empty($button_createcontent_borderradiusrt[$i])
            || !empty($button_createcontent_borderradiusrb[$i])
            || !empty($button_createcontent_borderradiuslb[$i]))
        {
            $content_buttoncss .= 'border-radius: '.$button_createcontent_borderradiuslt[$i].'px '.$button_createcontent_borderradiusrt[$i].'px 0px 0px;'."\n";
            //$content_buttoncss .= '-moz-border-radius: '.$button_createcontent_borderradiuslt[$i].'px '.$button_createcontent_borderradiusrt[$i].'px 0px 0px;'."\n";
            $content_buttoncss .= '-webkit-border-radius: '.$button_createcontent_borderradiuslt[$i].'px '.$button_createcontent_borderradiusrt[$i].'px 0px 0px;'."\n";
        }
        $content_buttoncss .= '}';
    }
}
?>
