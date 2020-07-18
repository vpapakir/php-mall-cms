<?php
if(isset($_POST['bt_new_CDRgeoCity']))
{
    #city
    unset($_SESSION['cdrgeo_edit_button_city'],
            $_SESSION['cdrgeo_hiddenidCDRgeoCity'],
            $_SESSION['cdrgeo_txtSearchCDRgeoCity'],
            $_SESSION['cdrgeo_txtZipCDRgeoCity'],
            $_SESSION['msg_cdrgeo_upload_city']);

    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
       unset($_SESSION['cdrgeo_txtNameCDRgeoCity'.$main_activatedidlang[$i]]); 
    }

    unset($_SESSION['cdrgeo_IDImageCDRgeoCity'],
            $_SESSION['cdrgeo_cboDistrictCDRgeoCity'],
            $_SESSION['cdrgeo_txtLatitudeCDRgeoCity'],
            $_SESSION['cdrgeo_txtLongitudeCDRgeoCity'],
            $_SESSION['cdrgeo_txtINSEECDRgeoCity'],
            $_SESSION['cdrgeo_txtPopulationCDRgeoCity'],
            $_SESSION['cdrgeo_txtTaxhabCDRgeoCity'],
            $_SESSION['cdrgeo_cdreditor_typecity_cdrgeo'],
            $_SESSION['cdrgeo_areaRemarkCDRgeoCity'],
            $_SESSION['cdrgeo_cboStatusCDRgeoCity']);
}
?>
