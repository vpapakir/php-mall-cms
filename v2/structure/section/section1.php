<?php
try
{ 
    $prepared_query = 'SELECT * FROM structure_logo
                       WHERE id_logo = :id_logo';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_logo', $id_logo);   
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $align_logo = $data['align_logo'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM structure_section
                       WHERE id_section = :id_section';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_section', $id_section);   
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $name_section = $data['name_section'];
        $width_section = $data['width_section'].'px';
        $height_section = $data['height_section'].'px';
        $position_section = $data['position_section'];
        $margin_section = $data['margin_section'];
        $border_section = $data['border_section'].'px';
        $bordercolor_section = $data['bordercolor_section'];
        $tablebg_section = $data['tablebg_section'];
        $cs_section = $data['cs_section'];
        $cp_section = $data['cp_section'];
        $bgcolor_section = $data['bgcolor_section'];
        $bgimg_section = $data['bgimg_section'];
        $xrepeat_section = $data['xrepeat_section'];
        $yrepeat_section = $data['yrepeat_section'];
        $radius_section = $data['radius_section'];
        $id_layout = $data['id_layout'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM structure_frame
                       WHERE id_layout = :layout';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('layout', $id_layout);   
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {    
        $section_id_frame[$i] = $data['id_frame'];
        $status_frame[$i] = $data['status_frame'];
        $i++;
    }
    $query->closeCursor();    
    
    if($width_section == '0px')
    {
        $width_section = '100%';
    }
    
    if($height_section == '0px')
    {
        $height_section = '100%';
    }
    
    if($bgcolor_section == null)
    {
       $bgcolor_section = 'white'; 
    }
    
    if($position_section == 0)
    {
       $position_section = 'relative'; 
    }
    
    if($margin_section == 0)
    {
        $margin_section = 'auto';
    }
    
    $radius_section = split_string($radius_section, '$');
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    echo $_SESSION['error400_message'];
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
<table style="width: <?php echo($width_section); ?>; height: <?php echo($height_section); ?>; 
       border: <?php echo($border_section.' solid '.$bordercolor_section); ?>;
       position: <?php echo($position_section); ?>; margin: <?php echo($margin_section); ?>;
       border-radius: <?php echo($radius_section[0].'px '.$radius_section[1].'px '.$radius_section[2].'px '.$radius_section[3].'px'); ?>;
/*       -moz-border-radius: <?php //echo($radius_section[0].'px '.$radius_section[1].'px '.$radius_section[2].'px '.$radius_section[3].'px'); ?>;*/
       -webkit-border-radius: <?php echo($radius_section[0].'px '.$radius_section[1].'px '.$radius_section[2].'px '.$radius_section[3].'px'); ?>;
       <?php if(!empty($bgcolor_section)){ ?>background-color: <?php echo($bgcolor_section); ?>;"<?php } ?> 
       cellpadding="<?php echo($cp_section); ?>" cellspacing="<?php echo($cs_section); ?>" border="0">
  
    
    <tr>
        <td <?php if(!empty($tablebg_section)){ ?>style="background-color: <?php echo($tablebg_section); ?>;"<?php } ?>>
            <div style="height: 4px;"></div>
        </td>
    </tr>
    
    <tr>
        <td <?php if(!empty($tablebg_section)){ ?>style="background-color: <?php echo($tablebg_section); ?>;"<?php } ?>><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="<?php echo($align_logo); ?>" width="100%">
                    <?php
                        include('structure/logo/logo1.php');
                    ?>
                </td>
                <td align="<?php echo($align_logo); ?>">
                    <?php
                        include('structure/currency/currency_box.php');
                    ?>
                </td>
                <td>
                    <?php
                        include('structure/box/11.php');
                    ?>
                </td>
                <td><div style="width: 10px;"></div></td>
                <td align="right">
                    <?php
                        include('structure/language/language_box.php');
                    ?>
                </td>
            </tr>
        </table></td>
    </tr>
    <?php
    if($status_frame[6] == 1 || $status_frame[7] == 1)
    {
?>
    
        <tr>
            <td style="background-color: <?php echo($tablebg_section); ?>;"><table style="margin-top: 10px;" width="100%" border="0" cellpadding="0" cellspacing="0">
       
                <tr> 
                    <td align="left">    
<?php   
                        if($status_frame[6] == 1)
                        {
                            #include('structure/frame/tabbar/tabbarL1.php');
                        }   
?>
                    </td>
                    <td></td>
                    <td align="right">
<?php                
                        if($status_frame[7] == 1)
                        {
                            #include('structure/frame/tabbar/tabbarR1.php');
                        }
?>
                    </td>
                </tr>
            
            </table></td>       
        </tr>       
<?php
    }
?>
    <tr>
        <td align="center" style="background-color: <?php echo($tablebg_section); ?>;">
            <?php
                include('structure/layout/layout1.php');
            ?>
        </td>
    </tr>
<?php    
    if(isset($status_frame_layout) && $status_frame_layout[5] == 1)
    {
?>    
        <tr>
        <td colspan="3" style="vertical-align: top;">
<?php
            include('structure/frame/footer/footer1.php');
?>
        </td>
        </tr>
    
<?php
    }
?>
    <tr style="height: 100%;">
        <td style="background-color: <?php echo($tablebg_section); ?>;">
            <div></div>
        </td>
    </tr>
    
</table>
