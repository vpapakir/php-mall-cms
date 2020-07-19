<?php
$content_fontcss = null;

for($i = 0, $count = count($font_createcontent_classname); $i < $count; $i++)
{
    unset($font_createcontent_splittedvalue);
    if($font_createcontent_value[$i] != 'select')
    {
        $content_fontcss .= $font_createcontent_classnamefont[$i].', '.$font_createcontent_classnamelinkfont[$i]."\n";
        $content_fontcss .= '{'."\n";
        
        $font_createcontent_splittedvalue = split_string($font_createcontent_value[$i], '$');
        
        if(!empty($font_createcontent_splittedvalue[0]))
        {
            $content_fontcss .= 'font-size: '.$font_createcontent_splittedvalue[0].'px;'."\n";
        }
        
        if(!empty($font_createcontent_splittedvalue[1]))
        {
            $content_fontcss .= 'font-weight: '.$font_createcontent_splittedvalue[1].';'."\n";
        }
        
        if(!empty($font_createcontent_splittedvalue[2]))
        {
            $content_fontcss .= 'color: '.$font_createcontent_splittedvalue[2].';'."\n";
        }
        
        if(!empty($font_createcontent_splittedvalue[3]))
        {
            $content_fontcss .= 'text-decoration: '.$font_createcontent_splittedvalue[3].';'."\n";
        }
        
        if(!empty($font_createcontent_splittedvalue[4]))
        {
            $content_fontcss .= 'text-align: '.$font_createcontent_splittedvalue[4].';'."\n";
        }
        
        if(!empty($font_createcontent_splittedvalue[5]))
        {
            $content_fontcss .= 'font-family: '.$font_createcontent_splittedvalue[5].';'."\n";
        }

        $content_fontcss .= '}'."\n\n";
    }
}

for($i = 0, $count = count($font_createcontent_classname); $i < $count; $i++)
{
    if($i == 0)
    {
       $content_fontcss .= $font_createcontent_classnamelinkfont[$i];    
    }
    else
    {
       $content_fontcss .= ', '.$font_createcontent_classnamelinkfont[$i];    
    }   
}

$content_fontcss .= '{'."\n";
if($font_createcontent_id[$i] != 'select')
{ 
    $content_fontcss .= 'border-bottom: 1px dotted black; ';
}
$content_fontcss .= '}'."\n\n";

for($i = 0, $count = count($font_createcontent_classname); $i < $count; $i++)
{
    if($i == 0)
    {
       $content_fontcss .= $font_createcontent_classnamelinkfont[$i].':hover';    
    }
    else
    {
       $content_fontcss .= ', '.$font_createcontent_classnamelinkfont[$i].':hover';    
    }   
}

$content_fontcss .= '{'."\n";
if($font_createcontent_id[$i] != 'select')
{ 
    $content_fontcss .= 'border-bottom: 1px solid black; ';
}
$content_fontcss .= '}';
?>
