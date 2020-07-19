<?php
$prepared_query = 'INSERT INTO style_color
                   (name_color, code_color, ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].') ';
    }
}

$prepared_query .= 'VALUES
                   (:name, :code, ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= '\''.$color_name[$i].'\', ';
    }
    else
    {
        $prepared_query .= '\''.$color_name[$i].'\')';
    }
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'name' => $color_name[0],
                      'code' => $color_code
                      ));
$query->closeCursor();

$msg_done_color_add = str_replace('[#name_color]', $color_name[$color_selected_lang], $msg_done_color_add);
$_SESSION['msg_color_done'] = $msg_done_color_add;   
?>
