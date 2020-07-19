<?php
#district (department), Region, Pays
if($customgetinfo_displayvalue[40] == 1 || $customgetinfo_displayvalue[39] == 1 || $customgetinfo_displayvalue[38] == 1 || $customgetinfo_displayvalue[37] == 1)
{
    $prepared_query = 'SELECT L'.$main_id_language.' FROM cdrgeo
                       WHERE id_cdrgeo = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_district_situation);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_district_situation = $data[0];
    }

    $prepared_query = 'SELECT L'.$main_id_language.' FROM cdrgeo
                       WHERE id_cdrgeo = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_department_situation);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_department_situation = $data[0];
    }

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

    $prepared_query = 'SELECT L'.$main_id_language.' FROM cdrgeo
                       WHERE id_cdrgeo = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_country_situation);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_country_situation = $data[0];
    }
    
    if(!empty($customgetinfo_district_situation) && !empty($customgetinfo_department_situation)
            && !empty($customgetinfo_region_situation) && !empty($customgetinfo_country_situation))
    {
?>
    <tr>    
        <td class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        if($customgetinfo_displayvalue[40] == 1)
        {
            give_translation('displayvalueimmo.district_product_immo');
        }
        else
        {
            if($customgetinfo_displayvalue[39] == 1)
            {
                give_translation('displayvalueimmo.department_product_immo');
            }
            else
            {
                if($customgetinfo_displayvalue[38] == 1)
                {
                    give_translation('displayvalueimmo.region_product_immo');
                }
                else
                {
                    give_translation('displayvalueimmo.country_product_immo');
                }
            }
        }

?>
        </td>
        <td class="font_main">
<?php 
                           
            $white_bracketopen = ' (';
            $white_bracketclose = ')';
            $white_space = ', ';
            
            if($customgetinfo_displayvalue[40] == 1)
            {
                echo($customgetinfo_district_situation);
                echo(' ');
            }

            if(($customgetinfo_displayvalue[39] == 1 || $customgetinfo_displayvalue[38] == 1 || $customgetinfo_displayvalue[37] == 1) && $customgetinfo_displayvalue[40] == 1)
            {
                echo($white_bracketopen);
            }

            if($customgetinfo_displayvalue[39] == 1)
            {
                echo($customgetinfo_department_situation);
                if($customgetinfo_displayvalue[38] == 1 || $customgetinfo_displayvalue[37] == 1)
                {                
                    echo($white_space);
                }
            }
            
            if($customgetinfo_displayvalue[38] == 1)
            {
                echo($customgetinfo_region_situation);
                if($customgetinfo_displayvalue[37] == 1)
                {
                    echo($white_space); 
                }
            }
            
            if($customgetinfo_displayvalue[37] == 1)
            {
                echo($customgetinfo_country_situation);
            }
            
            if(($customgetinfo_displayvalue[39] == 1 || $customgetinfo_displayvalue[38] == 1 || $customgetinfo_displayvalue[37] == 1) && $customgetinfo_displayvalue[40] == 1)
            {
                echo($white_bracketclose);
            }

?>
        </td>
    </tr>
<?php 
    }
}
?>
