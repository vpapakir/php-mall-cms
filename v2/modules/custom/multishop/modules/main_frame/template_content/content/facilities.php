<?php
#facilities
if($customgetinfo_displayvalue[45] == 1)
{
    $count_totalfacilities = null;
    $customgetinfo_facilitiesorder_situation = split_string($customgetinfo_facilitiesorder_situation, '#');
    sort($customgetinfo_facilitiesorder_situation, SORT_NUMERIC);
    for($i = 0, $count = count($customgetinfo_facilitiesorder_situation); $i < $count; $i++)
    {    
        $temp_customgetinfo_facilitiesorder_situation = split_string($customgetinfo_facilitiesorder_situation[$i], '$');
        if($temp_customgetinfo_facilitiesorder_situation[2] > 0)
        {
            $count_totalfacilities += 1;
        }        
    }
    
    unset($temp_customgetinfo_facilitiesorder_situation);
    if($count_totalfacilities > 0)
    {
?>   

        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>    
            <td class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;" colspan="2">
<?php
            give_translation('displayvalueimmo.facilities_product_immo');
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_main" colspan="2">
                <table width="100%" cellpadding="0" cellspacing="0">
<?php
                $details_totalfacilities = null;
                $customgetinfo_currentkmkey_bok_displaydashedline = true;

                    for($i = 0, $count = count($customgetinfo_facilitiesorder_situation); $i < $count; $i++) 
                    {
                    
                        $customgetinfo_detailsfacilitiesorder_situation = split_string($customgetinfo_facilitiesorder_situation[$i], '$');

                        if(!empty($customgetinfo_detailsfacilitiesorder_situation[0]))
                        {

                            $customgetinfo_newkmkey = $customgetinfo_detailsfacilitiesorder_situation[0];
                            if($i == 0)
                            {
                                $customgetinfo_currentkmkey = 'unknown';
                            }
                            if($customgetinfo_newkmkey != $customgetinfo_currentkmkey)
                            {
                                $customgetinfo_currentkmkey = $customgetinfo_newkmkey;
                                
                                if($customgetinfo_currentkmkey == '0.0')
                                {
?>
                                    <tr>
                                        <td align="left" colspan="2">
                                            <span class="font_main">
                                    
<?php                                    
                                }
                                else
                                {
?>
                                    <tr>
                                        <td align="left" style="vertical-align: top;">
                                            <span class="font_subtitle" style="margin-right: 10px;"><?php echo($customgetinfo_currentkmkey.'&nbsp;km'); ?></span>
                                        </td>
                                        <td align="left">
                                            <span class="font_main">
<?php                                   
                                }
                            }
                        }

                        if($customgetinfo_detailsfacilitiesorder_situation[2] != 0)
                        {
                            $details_facilities = null;

                            if($customgetinfo_detailsfacilitiesorder_situation[2] != 'select')
                            {

                                $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                                                   WHERE id_cdreditor = :id';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('id', $customgetinfo_detailsfacilitiesorder_situation[2]);
                                $query->execute();

                                if(($data = $query->fetch()) != false)
                                {
                                    $details_facilities .= $data[0]; 
                                }
                                $query->closeCursor();
                            }
                            
                            $p = $i + 1;
                            $temp_customgetinfo_facilitiesorder_situation = split_string($customgetinfo_facilitiesorder_situation[$p], '$');
                            if($temp_customgetinfo_facilitiesorder_situation[0] != $customgetinfo_currentkmkey)
                            {
                                $customgetinfo_comma = null;
                            }
                            else
                            {
                                $customgetinfo_comma = ', ';
                            }
                            
                            if(!empty($customgetinfo_detailsfacilitiesorder_situation[1]))
                            {
                                echo($details_facilities.'&nbsp;('.$customgetinfo_detailsfacilitiesorder_situation[1].')'.$customgetinfo_comma);
                            }
                            else
                            {
                                echo($details_facilities.$customgetinfo_comma);
                            }
                        }
                        
                        
                        if($temp_customgetinfo_facilitiesorder_situation[0] != $customgetinfo_currentkmkey && $customgetinfo_currentkmkey_bok_displaydashedline === true && $customgetinfo_currentkmkey == '0.0')
                        {
                            $customgetinfo_currentkmkey_bok_displaydashedline = false;
?>
                                     </span>
                                </td>
                            </tr>            
                            <tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>    
                            <tr>
                                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                            </tr>                         
<?php
                        }
                        else
                        {
                            if($temp_customgetinfo_facilitiesorder_situation[0] != $customgetinfo_currentkmkey)
                            {
?>
                                       </span>
                                    </td>
                                </tr>     
<?php
                            }
                        }
                    }
?>
            
                </table>                
            </td>
        </tr>
<?php
    }
}
?>
