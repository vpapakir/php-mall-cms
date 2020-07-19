<?php
$prepared_query = 'SHOW COLUMNS FROM style_block_set';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$i = 0;
$y = 0;
while($data = $query->fetch())
{
    if($i > 2)
    {
        $block_createcontent_classname[$y] = $data[0];
        $y++;
    }

    $i++;
}
$query->closeCursor();

for($i = 0, $count = count($block_createcontent_classname); $i < $count; $i++)
{
    $selected_template = 1;            
    $prepared_query = 'SELECT '.$block_createcontent_classname[$i].' 
                       FROM style_block_set
                       WHERE id_template = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $selected_template);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $array_block_id[$i] = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM style_block
                       WHERE id_block = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $array_block_id[$i]);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $block_createcontent_id[$i] = $data[0];
        $block_createcontent_border[$i] = $data['border_block'];
        $block_createcontent_bordercolor[$i] = $data['bordercolor_block'];
        $block_createcontent_bradiuslt[$i] = $data['borderradius_lt_block'];
        $block_createcontent_bradiusrt[$i] = $data['borderradius_rt_block'];
        $block_createcontent_bradiusrb[$i] = $data['borderradius_rb_block'];
        $block_createcontent_bradiuslb[$i] = $data['borderradius_lb_block'];
        $block_createcontent_bgcolor[$i] = $data['bgcolor_block'];
        $block_createcontent_width[$i] = $data['width_block'];
        $block_createcontent_height[$i] = $data['height_block'];
        $block_createcontent_padding[$i] = $data['padding_block'];
        $block_createcontent_image[$i] = $data['image_block'];
        $block_createcontent_bgcolorhover[$i] = $data['bgcolorhover_block'];
        $block_createcontent_font[$i] = $data['font_block'];
    }
    else
    {
        $block_createcontent_id[$i] = 'select';
    }
    $query->closeCursor();
    
    if($block_createcontent_id[$i] != 'select')
    {
        $block_createcontent_font[$i] = str_replace('font_', '', $block_createcontent_font[$i]);
        
        if(preg_match('#block#', $block_createcontent_font[$i]))
        {
            $block_createcontent_font[$i] = str_replace('block', 'boxstyle', $block_createcontent_font[$i]);
        }
        
        $block_createcontent_font[$i] .= '_font';
        
        $prepared_query = 'SELECT * FROM style_font
                           WHERE id_template = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $selected_template);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $block_createcontent_fontvalue[$i] = $data[$block_createcontent_font[$i]];
        }
        $query->closeCursor();
    }
    else
    {
        $block_createcontent_fontvalue[$i] = 'select';
    }
}
?>
