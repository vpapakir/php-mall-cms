<?php
#region
if($customgetinfo_displayvalue[38] == 1)
{
    $prepared_query = 'SELECT L'.$main_id_language.' FROM cdrgeo
                       WHERE id_cdrgeo = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_region_situation);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_region_situation = $data[0];
    }
?>
    <tr>    
        <td class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.region_product_immo');
?>
        </td>
        <td class="font_main">
            <?php echo($customgetinfo_region_situation); ?>
        </td>
    </tr>
<?php            
}
?>
