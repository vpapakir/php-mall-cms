<?php
#city
if(($customgetinfo_displayvalue[41] == 1 || $customgetinfo_displayvalue[42] == 1) && !empty($customgetinfo_city_situation))
{
    $prepared_query = 'SELECT L'.$main_id_language.' FROM cdrgeo
                       WHERE id_cdrgeo = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_city_situation);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_city_situation = $data[0];
    }
?>
    <tr>    
        <td class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        if($customgetinfo_displayvalue[41] == 1)
        {
            give_translation('displayvalueimmo.city_product_immo');
        }
        else
        {
            give_translation('displayvalueimmo.zip_product_immo');
        }       
?>
        </td>
        <td class="font_main">
<?php 
            if($customgetinfo_displayvalue[41] == 1 && $customgetinfo_displayvalue[42] == 1)
            {
                $white_space = ' ';
            }
            else
            {
                $white_space = null;
            }
            if($customgetinfo_displayvalue[42] == 1)
            {
                echo($customgetinfo_zip_situation);
            }

            echo($white_space);

            if($customgetinfo_displayvalue[41] == 1)
            {
                echo($customgetinfo_city_situation);
            }
?>
        </td>
    </tr>
<?php            
}
?>
