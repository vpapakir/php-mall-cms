<?php

$prepared_query = 'SHOW COLUMNS FROM style_font';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$i = 0;
$y = 0;
while($data = $query->fetch())
{
    if($i > 2)
    {
        $font_createcontent_classname[$y] = $data[0];
        $y++;
    }

    $i++;
}
$query->closeCursor();

for($i = 0, $count = count($font_createcontent_classname); $i < $count; $i++)
{    
    $prepared_query = 'SELECT '.$font_createcontent_classname[$i].' FROM style_font
                       WHERE id_font = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('id', 1);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $font_createcontent_value[$i] = $data[0];
    }
    else
    {
        $font_createcontent_value[$i] = 'select';
    }
    $query->closeCursor();
    
    if($font_createcontent_value[$i] != 'select')
    {
        $font_createcontent_classnamefont[$i] = str_replace('_font', '', $font_createcontent_classname[$i]);
                
        if(preg_match('#boxstyle#', $font_createcontent_classnamefont[$i]))
        {
            $font_createcontent_classnamefont[$i] = str_replace('boxstyle', 'block', $font_createcontent_classnamefont[$i]);
        }
        
        $font_createcontent_classnamelinkfont[$i] = '.link_'.$font_createcontent_classnamefont[$i];
        $font_createcontent_classnamefont[$i] = '.font_'.$font_createcontent_classnamefont[$i];
    }
}
?>
