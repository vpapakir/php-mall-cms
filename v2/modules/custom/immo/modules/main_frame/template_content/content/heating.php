<?php
#heating
if($customgetinfo_displayvalue[22] == 1)
{
    if(!empty($customgetinfo_heating_energy))
    {
        $customgetinfo_heating_energy = split_string($customgetinfo_heating_energy, '$');
    }
    
    if(!empty($customgetinfo_heating_energy))
    {
?>
        <tr>    
            <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
            give_translation('displayvalueimmo.heating_product_immo');
?>
            </td>
            <td align="left" class="font_main">
<?php  
                for($i = 0, $count = count($customgetinfo_heating_energy); $i < $count; $i++)
                {
                    $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                                       WHERE id_cdreditor = :id';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $customgetinfo_heating_energy[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        echo($data[0]);
                    }
                    $query->closeCursor();

                    if($i < ($count - 1))
                    {
                        echo(', ');
                    }
                }
?>
            </td>
        </tr>
<?php
    }
}
?>
