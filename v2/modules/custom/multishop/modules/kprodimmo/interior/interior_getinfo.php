<?php
try
{
    #INTERIOR PIECES IN
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_piecesin_interior"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_piecesininterior[$i] = $data['id_cdreditor'];
        $kprodimmo_code_piecesininterior = $data['code_cdreditor'];
        $kprodimmo_status_piecesininterior = $data['status_cdreditor'];
        $kprodimmo_statusobject_piecesininterior[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_piecesininterior = $data['type_cdreditor'];
        $kprodimmo_nameS_piecesininterior[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_piecesininterior[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #INTERIOR PIECES IN DETAILS
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_piecesindetails_interior"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_piecesindetailsinterior[$i] = $data['id_cdreditor'];
        $kprodimmo_code_piecesindetailsinterior = $data['code_cdreditor'];
        $kprodimmo_status_piecesindetailsinterior = $data['status_cdreditor'];
        $kprodimmo_statusobject_piecesindetailsinterior[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_piecesindetailsinterior = $data['type_cdreditor'];
        $kprodimmo_nameS_piecesindetailsinterior[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_piecesindetailsinterior[$i] = $data['L'.$main_id_language.'P'];
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
