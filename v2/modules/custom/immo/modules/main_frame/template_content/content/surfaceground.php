<?php
#surface ground
if($customgetinfo_displayvalue[9] == 1)
{
    if($customgetinfo_displayvalue[10] == 1)
    {
        $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                           WHERE id_cdreditor = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $customgetinfo_surfacegroundmeasure);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $customgetinfo_surfacegroundmeasure = $data[0];
        }
        $query->closeCursor();
        
        if($customgetinfo_surfacegroundmeasure == 'm²')
        {
            $customgetinfo_surfaceground = number_format($customgetinfo_surfaceground, 0);
        }
    }
    else
    {
        $customgetinfo_surfacegroundmeasure = null;
    } 
    
    if($customgetinfo_surfaceground > 0)
    {
?>
        <tr>    
            <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
            give_translation('displayvalueimmo.surfaceground_product_immo');
?>
            </td>
            <td align="left" class="font_main">
<?php            
                echo($customgetinfo_surfaceground.'&nbsp;'.$customgetinfo_surfacegroundmeasure);
?>
            </td>
        </tr>
<?php        
    }
}
?>
