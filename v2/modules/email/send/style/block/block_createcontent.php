<?php
for($i = 0, $count = count($block_createcontent_classname); $i < $count; $i++)
{
    $message .= '.'.$block_createcontent_classname[$i]."\n";
    $message .= '{'."\n";
    if($array_block_id[$i] != 'select')
    {
        if(!empty($block_createcontent_border[$i]))
        {
            $message .= 'border: '.$block_createcontent_border[$i].'px solid;'."\n";
            $message .= 'border-color: '.$block_createcontent_bordercolor[$i].';'."\n";
        }
       
        if(empty($block_createcontent_bradiuslt[$i]) ? $block_createcontent_bradiuslt[$i] = 0 : $block_createcontent_bradiuslt[$i] = $block_createcontent_bradiuslt[$i]);
        if(empty($block_createcontent_bradiusrt[$i]) ? $block_createcontent_bradiusrt[$i] = 0 : $block_createcontent_bradiusrt[$i] = $block_createcontent_bradiusrt[$i]);
        if(empty($block_createcontent_bradiusrb[$i]) ? $block_createcontent_bradiusrb[$i] = 0 : $block_createcontent_bradiusrb[$i] = $block_createcontent_bradiusrb[$i]);
        if(empty($block_createcontent_bradiuslb[$i]) ? $block_createcontent_bradiuslb[$i] = 0 : $block_createcontent_bradiuslb[$i] = $block_createcontent_bradiuslb[$i]);
        
        if($block_createcontent_bradiuslt[$i] > 0 || $block_createcontent_bradiusrt[$i] > 0 || $block_createcontent_bradiusrb[$i] > 0 || $block_createcontent_bradiuslb[$i] > 0)
        {
            $message .= 'border-radius: '.$block_createcontent_bradiuslt[$i].'px '.$block_createcontent_bradiusrt[$i].'px '.$block_createcontent_bradiusrb[$i].'px '.$block_createcontent_bradiuslb[$i].'px;'."\n";
            $message .= '-moz-border-radius: '.$block_createcontent_bradiuslt[$i].'px '.$block_createcontent_bradiusrt[$i].'px '.$block_createcontent_bradiusrb[$i].'px '.$block_createcontent_bradiuslb[$i].'px;'."\n";
            $message .= '-webkit-border-radius: '.$block_createcontent_bradiuslt[$i].'px '.$block_createcontent_bradiusrt[$i].'px '.$block_createcontent_bradiusrb[$i].'px '.$block_createcontent_bradiuslb[$i].'px;'."\n";
        }
        
        if(!empty($block_createcontent_bgcolor[$i]))
        {
            $message .= 'background-color: '.$block_createcontent_bgcolor[$i].';'."\n";
        }
        
        
        if(empty($block_createcontent_width[$i]) || $block_createcontent_width[$i] == 0 ? $block_createcontent_width[$i] = '100%' : $block_createcontent_width[$i] = $block_createcontent_width[$i].'px');
        $message .= 'width: '.$block_createcontent_width[$i].';'."\n";
        if(empty($block_createcontent_height[$i]) || $block_createcontent_height[$i] == 0 ? $block_createcontent_height[$i] = '100%' : $block_createcontent_height[$i] = $block_createcontent_height[$i].'px');
        $message .= 'height: '.$block_createcontent_height[$i].';'."\n";
        
        if(!empty($block_createcontent_padding[$i]))
        {
            $message .= 'padding: '.$block_createcontent_padding[$i].'px;'."\n";
        }
        
        if(!empty($block_createcontent_image[$i]))
        {
            $message .= 'background-image: url("'.$block_createcontent_image[$i].'");'."\n";
        }
        
        if($block_createcontent_fontvalue[$i] != 'select')
        {
            $block_createcontent_fontvalue[$i] = split_string($block_createcontent_fontvalue[$i], '$');

            $message .= 'font-size: '.$block_createcontent_fontvalue[$i][0].'px;'."\n";
            $message .= 'font-weight: '.$block_createcontent_fontvalue[$i][1].';'."\n";
            $message .= 'color: '.$block_createcontent_fontvalue[$i][2].';'."\n";
            $message .= 'text-decoration: '.$block_createcontent_fontvalue[$i][3].';'."\n";
            $message .= 'text-align: '.$block_createcontent_fontvalue[$i][4].';'."\n";
            $message .= 'font-family: '.$block_createcontent_fontvalue[$i][5].';'."\n";
        }
    }
    $message .= '}'."\n\n";
}

for($i = 0, $count = count($block_createcontent_classname); $i < $count; $i++)
{
    $message .= '.'.$block_createcontent_classname[$i].':hover'."\n";
    $message .= '{'."\n";
    if($block_createcontent_id[$i] != 'select')
    { 
        $message .= 'background-color: '.$block_createcontent_bgcolorhover[$i].';'."\n";
    }
    $message .= '}'."\n\n";
}
?>
