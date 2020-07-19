<?php
$cdreditor_selected_lang = null;

$prepared_query = 'INSERT INTO cdreditor
                   (type_cdreditor, code_cdreditor, position_cdreditor, status_cdreditor, statusobject_cdreditor, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $prepared_query .= 'L'.$main_activatedidlang[$i].'S, ';
    if($i == ($count - 1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'P)';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'P, ';
    }   
}

$prepared_query .= ' VALUES(:type, :code, :position, :status, :statusobject, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $prepared_query .= '"'.$cdreditor_add_namelangS[$i].'", ';
    if($i == ($count - 1))
    {
        $prepared_query .= '"'.$cdreditor_add_namelangP[$i].'")';
    }
    else
    {
        $prepared_query .= '"'.$cdreditor_add_namelangP[$i].'", ';
    } 
    
    if($main_activatedidlang[$i] == $main_id_language)
    {
        $cdreditor_selected_lang = $i;
    }
}

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'type' => $cdreditor_add_mode,
                      'code' => $cdreditor_add_family,
                      'position' => $cdreditor_add_position,  
                      'status' => 1,
                      'statusobject' => $cdreditor_add_status
                      ));

$prepared_query = 'UPDATE cdreditor
                   SET type_cdreditor = :type
                   WHERE code_cdreditor = :code';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'type' => $cdreditor_add_mode,
                      'code' => $cdreditor_add_family
                      ));

$_SESSION['msg_cdreditor_addedit_done'] = 'L\'élément "'.$cdreditor_add_namelangS[$cdreditor_selected_lang].'" a été ajouté';
?>
