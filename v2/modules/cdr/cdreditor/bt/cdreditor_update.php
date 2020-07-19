<?php
$cdreditor_selected_lang = null;

$prepared_query = 'UPDATE cdreditor
                   SET type_cdreditor = :type,
                       position_cdreditor = :position,
                       status_cdreditor = :status,
                       statusobject_cdreditor = :statusobject,';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $prepared_query .= 'L'.$main_activatedidlang[$i].'S = "'.$cdreditor_add_namelangS[$i].'", ';
    if($i == ($count - 1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'P = "'.$cdreditor_add_namelangP[$i].'"';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].'P = "'.$cdreditor_add_namelangP[$i].'", ';
    }  
    
    if($main_activatedidlang[$i] == $main_id_language)
    {
        $cdreditor_selected_lang = $i;
    }
}

$prepared_query .= 'WHERE id_cdreditor = :id';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'type' => $cdreditor_add_mode,
                      'position' => $cdreditor_add_position,  
                      'status' => 1,
                      'statusobject' => $cdreditor_add_status,
                      'id' => $selected_option_cdreditor
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE cdreditor
                   SET type_cdreditor = :type
                   WHERE code_cdreditor = :code';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'type' => $cdreditor_add_mode,
                      'code' => $cdreditor_add_family
                      ));
$query->closeCursor();

$_SESSION['cdreditor_add_cboModeCDReditor'] = $cdreditor_add_mode;
$_SESSION['cdreditor_add_txtPosCDReditor'] = $cdreditor_add_position;
$_SESSION['cdreditor_add_cboStatusCDReditor'] = $cdreditor_add_status;

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'] = $cdreditor_add_namelangS[$i];
    $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P'] = $cdreditor_add_namelangP[$i];
}

$_SESSION['msg_cdreditor_addedit_done'] = 'L\'élément "'.$cdreditor_add_namelangS[$cdreditor_selected_lang].'" a été modifié';
?>
