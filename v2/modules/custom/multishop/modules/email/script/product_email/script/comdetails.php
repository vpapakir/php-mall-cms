<?php
#[comdetails]
if($customgetinfo_displayvalue[33] == 1)
{
    $positiondefault_comdetails_admin = null;

    $prepared_query = 'SELECT datecreate_product_immo 
                       FROM immo_product
                       WHERE id_page = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $id_page);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $datecreate_kprod = $data[0];
    }
    $query->closeCursor();

    $maxelapsedtime = $timestamp_day * $day_maxday;

    $datenow_kprod = time();
    $datecreate_kprod = converto_timestamp($datecreate_kprod);
    $dateelapsed_kprod = $datenow_kprod - $datecreate_kprod;

    $check_comdetails_admin = $customgetinfo_comdetails_admin;

    if($customgetinfo_comdetails_admin == 'select')
    {
        $positiondefault_comdetails_admin = ' OR position_cdreditor = 1000';
    }

    $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                       WHERE id_cdreditor = :id'.$positiondefault_comdetails_admin;
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_comdetails_admin);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_comdetails_admin = $data[0];
    }
    $query->closeCursor();

    if(($check_comdetails_admin != 'select' && !empty($customgetinfo_comdetails_admin)) || ($dateelapsed_kprod < $maxelapsedtime))
    {
        $message .= '<tr>
                        <td><table width="100%" cellpadding="0" cellspacing="0" style="margin: 0px 0px 4px 0px;">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/product/bgoption.gif\'); height: 60px; background-repeat: no-repeat;" background="'.$config_customheader.'modules/custom/immo/graphic/product/bgoption.gif">
                                    <tr>
                                        <td><div style="width: 20px;"></div></td>
                                        <td style="font-size: 18px;
                                            font-weight: bold;
                                            color: #FFFFFF;
                                            text-decoration: none;
                                            text-align: center;">
                                            <span>
                                                '.$customgetinfo_comdetails_admin.'
                                            </span>
                                        </td>
                                        <td><div style="width: 20px;"></div></td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                        </table></td>
                    </tr>';  
    }
}
unset($maxelapsedtime,$datenow_kprod,$datecreate_kprod,$dateelapsed_kprod,$check_comdetails_admin,
        $positiondefault_comdetails_admin,$customgetinfo_comdetails_admin);
#[/comdetails]
?>
