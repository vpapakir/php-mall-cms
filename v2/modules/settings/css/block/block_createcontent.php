<?php
$content_blockcss = null;

for($i = 0, $count = count($block_createcontent_classname); $i < $count; $i++)
{
    $content_blockcss .= '.'.$block_createcontent_classname[$i]."\n";
    $content_blockcss .= '{'."\n";
    if($block_createcontent_id[$i] != 'select')
    {
        if(!empty($block_createcontent_border[$i]))
        {
            $content_blockcss .= 'border: '.$block_createcontent_border[$i].'px solid;'."\n";
            $content_blockcss .= 'border-color: '.$block_createcontent_bordercolor[$i].';'."\n";
        }
       
        if(empty($block_createcontent_bradiuslt[$i]) ? $block_createcontent_bradiuslt[$i] = 0 : $block_createcontent_bradiuslt[$i] = $block_createcontent_bradiuslt[$i]);
        if(empty($block_createcontent_bradiusrt[$i]) ? $block_createcontent_bradiusrt[$i] = 0 : $block_createcontent_bradiusrt[$i] = $block_createcontent_bradiusrt[$i]);
        if(empty($block_createcontent_bradiusrb[$i]) ? $block_createcontent_bradiusrb[$i] = 0 : $block_createcontent_bradiusrb[$i] = $block_createcontent_bradiusrb[$i]);
        if(empty($block_createcontent_bradiuslb[$i]) ? $block_createcontent_bradiuslb[$i] = 0 : $block_createcontent_bradiuslb[$i] = $block_createcontent_bradiuslb[$i]);
        
        if($block_createcontent_bradiuslt[$i] > 0 || $block_createcontent_bradiusrt[$i] > 0 || $block_createcontent_bradiusrb[$i] > 0 || $block_createcontent_bradiuslb[$i] > 0)
        {
            $content_blockcss .= 'border-radius: '.$block_createcontent_bradiuslt[$i].'px '.$block_createcontent_bradiusrt[$i].'px '.$block_createcontent_bradiusrb[$i].'px '.$block_createcontent_bradiuslb[$i].'px;'."\n";
            //$content_blockcss .= '-moz-border-radius: '.$block_createcontent_bradiuslt[$i].'px '.$block_createcontent_bradiusrt[$i].'px '.$block_createcontent_bradiusrb[$i].'px '.$block_createcontent_bradiuslb[$i].'px;'."\n";
            $content_blockcss .= '-webkit-border-radius: '.$block_createcontent_bradiuslt[$i].'px '.$block_createcontent_bradiusrt[$i].'px '.$block_createcontent_bradiusrb[$i].'px '.$block_createcontent_bradiuslb[$i].'px;'."\n";
        }
        
        if(!empty($block_createcontent_bgcolor[$i]))
        {
            $content_blockcss .= 'background-color: '.$block_createcontent_bgcolor[$i].';'."\n";
        }
        
        
        if(empty($block_createcontent_width[$i]) || $block_createcontent_width[$i] == 0 ? $block_createcontent_width[$i] = '100%' : $block_createcontent_width[$i] = $block_createcontent_width[$i].'px');
        $content_blockcss .= 'width: '.$block_createcontent_width[$i].';'."\n";
        if(empty($block_createcontent_height[$i]) || $block_createcontent_height[$i] == 0 ? $block_createcontent_height[$i] = '100%' : $block_createcontent_height[$i] = $block_createcontent_height[$i].'px');
        $content_blockcss .= 'height: '.$block_createcontent_height[$i].';'."\n";
        
        if(!empty($block_createcontent_padding[$i]))
        {
            $content_blockcss .= 'padding: '.$block_createcontent_padding[$i].'px;'."\n";
        }
        
        if(!empty($block_createcontent_image[$i]))
        {
            $content_blockcss .= 'background-image: url("'.$block_createcontent_image[$i].'");'."\n";
        }
        
        if($block_createcontent_fontvalue[$i] != 'select')
        {
            $block_createcontent_fontvalue[$i] = split_string($block_createcontent_fontvalue[$i], '$');

            $content_blockcss .= 'font-size: '.$block_createcontent_fontvalue[$i][0].'px;'."\n";
            $content_blockcss .= 'font-weight: '.$block_createcontent_fontvalue[$i][1].';'."\n";
            $content_blockcss .= 'color: '.$block_createcontent_fontvalue[$i][2].';'."\n";
            $content_blockcss .= 'text-decoration: '.$block_createcontent_fontvalue[$i][3].';'."\n";
            $content_blockcss .= 'text-align: '.$block_createcontent_fontvalue[$i][4].';'."\n";
            $content_blockcss .= 'font-family: '.$block_createcontent_fontvalue[$i][5].';'."\n";
        }
    }
    $content_blockcss .= '}'."\n\n";
}

for($i = 0, $count = count($block_createcontent_classname); $i < $count; $i++)
{
    $content_blockcss .= '.'.$block_createcontent_classname[$i].':hover'."\n";
    $content_blockcss .= '{'."\n";
    if($block_createcontent_id[$i] != 'select')
    { 
        $content_blockcss .= 'background-color: '.$block_createcontent_bgcolorhover[$i].';'."\n";
    }
    $content_blockcss .= '}'."\n\n";
}
?>
