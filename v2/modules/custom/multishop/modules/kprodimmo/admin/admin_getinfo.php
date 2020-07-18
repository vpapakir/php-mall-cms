<?php
try
{
    #ADMIN COMMERCIAL DETAILS
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_comdetails_admin"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_comdetailsadmin[$i] = $data['id_cdreditor'];
        $kprodimmo_code_comdetailsadmin = $data['code_cdreditor'];
        $kprodimmo_status_comdetailsadmin = $data['status_cdreditor'];
        $kprodimmo_statusobject_comdetailsadmin[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_comdetailsadmin = $data['type_cdreditor'];
        $kprodimmo_nameS_comdetailsadmin[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_comdetailsadmin[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
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
