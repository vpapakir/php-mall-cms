<?php
try
{
    $advertedit_preview_type = null;
    $prepared_query = 'SELECT * FROM advertising
                       WHERE id_advertising = :idadvert';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idadvert', $_SESSION['advertedit_cboSelectAdvert']);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        if(!empty($data['path_advertising_L'.$main_activatedidlang[$i]]))
        {
            $advertedit_preview_type = 'upload';
            $adveredit_preview_path = $data['path_advertising_L'.$main_activatedidlang[$i]];
        }
        else
        {
            if(!empty($data['scriptpath_advertising_L'.$main_activatedidlang[$i]]))
            {
                $advertedit_preview_type = 'scriptpath';
                $adveredit_preview_path = $data['scriptpath_advertising_L'.$main_activatedidlang[$i]];
            }
            else
            {
                if(!empty($data['scriptcode_advertising_L'.$main_activatedidlang[$i]]))
                {
                    $advertedit_preview_type = 'scriptcode';
                    $adveredit_preview_path = $data['scriptcode_advertising_L'.$main_activatedidlang[$i]];
                }
            }
        }
        
        $adveredit_preview_alt = $data['alt_advertising_L'.$main_activatedidlang[$i]];
        $adveredit_preview_legend = $data['legend_advertising_L'.$main_activatedidlang[$i]];
        $adveredit_preview_width = $data['widthlimit_advertising_L'.$main_activatedidlang[$i]];
        $adveredit_preview_height = $data['heightlimit_advertising_L'.$main_activatedidlang[$i]];
        $adveredit_preview_link = $data['link_advertising_L'.$main_activatedidlang[$i]];
        $adveredit_preview_target = $data['target_advertising_L'.$main_activatedidlang[$i]];
        
        if(empty($adveredit_preview_width))
        {
            $adveredit_preview_width = 0;
        }
        
        if(empty($adveredit_preview_height))
        {
            $adveredit_preview_height = 0;
        }
        
    }
    $query->closeCursor();
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
?>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>    
<tr>
    <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
</tr>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>
<tr>
    <td align="center" colspan="2">
<?php
        switch ($advertedit_preview_type)
        {
            case 'upload':
                if(!empty($adveredit_preview_link))
                {
?>
                    <a href="<?php echo($adveredit_preview_link); ?>" style="text-decoration: none;" target="<?php echo($adveredit_preview_target) ?>">
<?php
                }
?>
                <img src="<?php echo($config_customheader.$adveredit_preview_path); ?>" 
                     alt="<?php echo($adveredit_preview_alt); ?>" 
                     title="<?php echo($adveredit_preview_legend); ?>"
                     style="max-width: <?php echo($adveredit_preview_width); ?>px; max-height: <?php echo($adveredit_preview_height); ?>px; border: none;"/> 
<?php
                if(!empty($adveredit_preview_link))
                {
?>
                    </a>
<?php
                }
                break;
                
            case 'scriptpath':
                if(!empty($adveredit_preview_link))
                {
?>
                    <a href="<?php echo($adveredit_preview_link); ?>" style="text-decoration: none;" target="<?php echo($adveredit_preview_target) ?>">
<?php
                }
                    
                include($adveredit_preview_path);
                
                if(!empty($adveredit_preview_link))
                {
?>
                    </a>
<?php
                }
                break;
                
            case 'scriptcode':
                if(!empty($adveredit_preview_link))
                {
?>
                    <a href="<?php echo($adveredit_preview_link); ?>" style="text-decoration: none;" target="<?php echo($adveredit_preview_target) ?>">
<?php
                }
                    
                echo($adveredit_preview_path);
                
                if(!empty($adveredit_preview_link))
                {
?>
                    </a>
<?php
                }
                break;
        }
?>
    </td>
</tr>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>    
<tr>
    <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
</tr>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>
