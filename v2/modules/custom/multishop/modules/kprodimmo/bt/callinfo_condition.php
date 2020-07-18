<?php

#general
$Bok_kprodimmo_general = true;

$kprodimmo_surfaceground_general = str_replace(',', '.', $kprodimmo_surfaceground_general);

if(empty($kprodimmo_price_general))
{
    $kprodimmo_price_general = 0;
}

switch($kprodimmo_surfacetype_general)
{
    case '76':
        $kprodimmo_surfacegroundm2_general = $kprodimmo_surfaceground_general;
        break;
    case '77':
        $kprodimmo_surfacegroundm2_general = $kprodimmo_surfaceground_general * 100;
        break;
    case '78':
        $kprodimmo_surfacegroundm2_general = $kprodimmo_surfaceground_general * 10000;
        break;
}

$kprodimmo_surfacegroundm2_general = number_format($kprodimmo_surfacegroundm2_general, 0, '', '');

if(empty($kprodimmo_reference_general) || $kprodimmo_type_general == 'select' 
        || $kprodimmo_currency_general == 'select' || $kprodimmo_offer_general == 'select')
{
    $Bok_kprodimmo_general = false;
    
    if($kprodimmo_offer_general == 'select')
    {
        $_SESSION['msg_Kprodimmo_general_cdreditor.offer_object'] = $msg_empty_general;
    }
    
    if(empty($kprodimmo_reference_general))
    {
        $_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral'] = $msg_empty_general;
    }
    
    if($kprodimmo_type_general == 'select')
    {
        $_SESSION['msg_Kprodimmo_general_cdreditor.type_object'] = $msg_empty_general;
    }    
    
    if($kprodimmo_currency_general == 'select')
    {
        $_SESSION['msg_Kprodimmo_general_cdreditor.currency_object'] = $msg_empty_general;
    }
    
//    if(empty($kprodimmo_numrooms_general))
//    {
//        $_SESSION['msg_Kprodimmo_general_txtKprodimmoNumRoomsGeneral'] = $msg_empty_general;
//    }
}

if(!empty($kprodimmo_price_general) && !is_numeric($kprodimmo_price_general))
{
    $Bok_kprodimmo_general = false;
    $_SESSION['msg_Kprodimmo_general_txtKprodimmoPriceGeneral'] = $msg_numericdouble_general;
}

if(!empty($kprodimmo_numrooms_general) && !is_numeric($kprodimmo_numrooms_general))
{
    $Bok_kprodimmo_general = false;
    $_SESSION['msg_Kprodimmo_general_txtKprodimmoPriceGeneral'] = $msg_numericint_general;
}
//else
//{
//    $kprodimmo_numrooms_general = 0;
//}
?>
