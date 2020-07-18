<?php
try
{
    unset($cdreditor_arraycode_translate, $cdreditor_arraytype);
    
    $prepared_query = 'SELECT DISTINCT(code_cdreditor), type_cdreditor FROM cdreditor
                       WHERE status_cdreditor = 1
                       ORDER BY code_cdreditor';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $cdreditor_arraycode_translate[$i] = give_translation('cdreditor.'.$data[0], 'false', $config_showtranslationcode).'$'.$data[0].'$'.$data[1];
        $i++;
    }
    $query->closeCursor();
    
    sort($cdreditor_arraycode_translate);
    
    $cdreditor_temparraycode_translate = null;
    
    for($i = 0, $count = count($cdreditor_arraycode_translate); $i < $count; $i++)
    {
        $cdreditor_temparraycode_translate = split_string($cdreditor_arraycode_translate[$i], '$');
        $cdreditor_arraycode[$i] = $cdreditor_temparraycode_translate[1];
        $cdreditor_arraycode_translate[$i] = $cdreditor_temparraycode_translate[0];
        $cdreditor_arraytype[$i] = $cdreditor_temparraycode_translate[2];
    }
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?>
