<?php
try
{
    #EXTERIOR PIECES OUT
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_piecesout_exterior"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_piecesoutexterior[$i] = $data['id_cdreditor'];
        $kprodimmo_code_piecesoutexterior = $data['code_cdreditor'];
        $kprodimmo_status_piecesoutexterior = $data['status_cdreditor'];
        $kprodimmo_statusobject_piecesoutexterior[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_piecesoutexterior = $data['type_cdreditor'];
        $kprodimmo_nameS_piecesoutexterior[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_piecesoutexterior[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #EXTERIOR PIECES OUT DETAILS
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_piecesoutdetails_exterior"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_piecesoutdetailsexterior[$i] = $data['id_cdreditor'];
        $kprodimmo_code_piecesoutdetailsexterior = $data['code_cdreditor'];
        $kprodimmo_status_piecesoutdetailsexterior = $data['status_cdreditor'];
        $kprodimmo_statusobject_piecesoutdetailsexterior[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_piecesoutdetailsexterior = $data['type_cdreditor'];
        $kprodimmo_nameS_piecesoutdetailsexterior[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_piecesoutdetailsexterior[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();

    #EXTERIOR OTHERS
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_others_exterior"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_othersexterior[$i] = $data['id_cdreditor'];
        $kprodimmo_code_othersexterior = $data['code_cdreditor'];
        $kprodimmo_status_othersexterior = $data['status_cdreditor'];
        $kprodimmo_statusobject_othersexterior[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_othersexterior = $data['type_cdreditor'];
        $kprodimmo_nameS_othersexterior[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_othersexterior[$i] = $data['L'.$main_id_language.'P'];
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
