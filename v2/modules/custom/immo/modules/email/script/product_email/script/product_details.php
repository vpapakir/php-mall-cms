<?php
try
{
    $custom_1column_width = '40%';
    
    #price, currency
    include('modules/custom/immo/modules/email/script/product_email/script/product_details/price.php');
    
    $message .= '<tr>
                    <td align="left"><table width="100%" border="0" style="border: 1px solid;
                                    border-color: #CCCCCC;
                                    border-radius: 8px 8px 8px 8px;
                                    -moz-border-radius: 8px 8px 8px 8px;
                                    -webkit-border-radius: 8px 8px 8px 8px;
                                    background-color: #FFFFFF;
                                    width: 100%;
                                    height: 100%;
                                    font-size: 12px;
                                    font-weight: normal;
                                    color: #000000;
                                    text-decoration: none;
                                    text-align: left; margin-bottom: 4px;">
                    <tr>
                    <td align="left">
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-radius: 8px 8px 0px 0px;
                        -moz-border-radius: 8px 8px 0px 0px;
                        -webkit-border-radius: 8px 8px 0px 0px;
                        background-color: #687C66;
                        width: 100%;
                        height: 100%;
                        padding: 4px;
                        font-size: 14px;
                        font-weight: normal;
                        color: #FFFFFF;
                        text-decoration: none;
                        text-align: center;">
                            <td align="left">';
    
    $message .= '</td>
                <td width="100%" align="center">
                    <span>
                        Informations détaillées
                    </span>
                </td>
                <td align="left"></td>
            </table>
            </td>
        </tr>
        <tr>
        <td><table width="100%" style="margin: 0px 0px 4px 0px;">
            <tr>    
            <td><table width="100%" cellspacing="1" cellpadding="0" style="margin: 0px 0px 4px 0px;">'; 

            include('modules/custom/immo/modules/email/script/product_email/script/product_details/offer.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/reference.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/city.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/district.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/location.php'); 
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/condition.php'); 
    $message .= '<tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>'; 

            include('modules/custom/immo/modules/email/script/product_email/script/product_details/type.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/surfacehab.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/surfaceground.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/furnished.php');
   
    $message .= '<tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>'; 
   
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/repartition.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/rooms.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/outhouses.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/outhousesother.php');
            
            if((($count_totalouthouses > 0 || $customgetinfo_numouthouses > 0) && $customgetinfo_displayvalue[18] == 1) 
                    || (!empty($customgetinfo_other_exterior) && $customgetinfo_displayvalue[49] == 1)
                    || ($customgetinfo_numsleeps > 0 && $customgetinfo_displayvalue[16] == 1)
                    || ($customgetinfo_numbath > 0 && $customgetinfo_displayvalue[17] == 1)
                    || ($customgetinfo_numwc > 0 && $customgetinfo_displayvalue[18] == 1))
            {
                $message .= '<tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>    
                            <tr>
                                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                            </tr>'; 
            }
            
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/heating.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/heatingother.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/insulation.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/windows.php');
            
            if((!empty($customgetinfo_heating_energy) && $customgetinfo_displayvalue[22] == 1) 
                    || (!empty($customgetinfo_heatingother_energy) && $customgetinfo_displayvalue[23] == 1)
                    || ($customgetinfo_isolation_energy != 'select' && $customgetinfo_displayvalue[24] == 1) 
                    || ($customgetinfo_window_energy != 'select' && $customgetinfo_displayvalue[25] == 1))
            {
                $message .= '<tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>    
                            <tr>
                                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                            </tr>';     
            }
            
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/water.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/power.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/phone.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/tv.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/internet.php');
            include('modules/custom/immo/modules/email/script/product_email/script/product_details/facilities.php');

    $message .= '</table></td>
                 </tr>
            </table></td>
            </tr>
        </table></td>
    </tr>'; 
?>
        
<?php
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

unset($customgetinfo_offer,
    $customgetinfo_reference,
    $customgetinfo_type,
    $customgetinfo_price,
    $customgetinfo_currency,
    $customgetinfo_fee,
    $customgetinfo_feetype,
    $customgetinfo_feeincex,
    $customgetinfo_surfacehab,
    $customgetinfo_surfaceground,
    $customgetinfo_surfacegroundmeasure,
    $customgetinfo_surfacecellar,
    $customgetinfo_surfaceloft,
    $customgetinfo_numfloor,
    $customgetinfo_numrooms,
    $customgetinfo_numsleeps,
    $customgetinfo_numbath,
    $customgetinfo_numwc,
    $customgetinfo_numouthouses,
    $customgetinfo_condition,
    $customgetinfo_heating_energy,
    $customgetinfo_heatingother_energy,
    $customgetinfo_isolation_energy,
    $customgetinfo_window_energy,
    $customgetinfo_water_other,
    $customgetinfo_power_other,
    $customgetinfo_phone_other,
    $customgetinfo_tv_other,
    $customgetinfo_internet_other,
    $customgetinfo_furnished_other,
    $customgetinfo_comdetails_admin,
    $customgetinfo_note_admin,
    $customgetinfo_city_situation,
    $customgetinfo_zip_situation,
    $customgetinfo_district_situation,
    $customgetinfo_department_situation,
    $customgetinfo_region_situation,
    $customgetinfo_country_situation,
    $customgetinfo_longitude_situation,
    $customgetinfo_latitude_situation,
    $customgetinfo_location_situation,
    $customgetinfo_locdetails_situation,
    $customgetinfo_facilities_situation,
    $customgetinfo_facilitiesdistance_situation,
    $customgetinfo_piecesin_interior,
    $customgetinfo_piecesout_exterior,
    $customgetinfo_other_exterior);
?>
