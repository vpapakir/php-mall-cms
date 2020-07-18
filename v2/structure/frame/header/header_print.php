<?php
try
{     
    $prepared_query = 'SELECT * FROM structure_frame
                               WHERE id_frame = :id_frame
                               AND id_layout = :id_layout';
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'id_frame' => $array_id_frame[1],
                          'id_layout' => $id_layout
                          ));
    
    if(($data = $query->fetch()) != false)
    {
        $name_frame = $data['name_frame'];
        $width_frame = $data['width_frame'].'px';
        $height_frame = $data['height_frame'].'px';
        $position_frame = $data['position_frame'];
        $margin_frame = $data['margin_frame'];
        $border_frame = $data['border_frame'].'px';
        $bordercolor_frame = $data['bordercolor_frame'];
        $tablebg_frame = $data['tablebg_frame'];
        $cs_frame = $data['cs_frame'];
        $cp_frame = $data['cp_frame'];
        $bgcolor_frame = $data['bgcolor_frame'];
        $bgimg_frame = $data['bgimg_frame'];
        $xrepeat_frame = $data['xrepeat_frame'];
        $yrepeat_frame = $data['yrepeat_frame'];
        $id_layout = $data['id_layout'];
        $id_box = $data['id_box'];
    }
    $query->closeCursor();
    
    if($width_frame == '0px')
    {
        $width_frame = '100%';
    }
    
    if($height_frame == '0px')
    {
        $height_frame = '100%';
    }
    
    if($bgcolor_frame == null)
    {
       $bgcolor_frame = 'white'; 
    }
    
    if($position_frame == 0)
    {
       $position_frame = 'relative'; 
    }
    
    if($margin_frame == 0)
    {
        $margin_frame = 'auto';
    }
    
    $array_box = split_number($id_box);
    
    
    
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


<table style="width: <?php echo($width_frame); ?>; height: <?php echo($height_frame); ?>; 
       border: <?php echo($border_frame.' solid '.$bordercolor_frame); ?>;
       position: <?php echo($position_skin); ?>; margin: <?php echo($margin_skin); ?>;" 
       cellpadding="<?php echo($cp_frame); ?>" cellspacing="<?php echo($cs_frame); ?>">
  
    <tr>
        <td style="background-color: <?php echo($tablebg_frame); ?>;" align="center">
            <table width="100%" cellpadding="0" cellspacing="0">
<?php
            try
            {
                #title
                $prepared_query = 'SELECT * FROM page
                                   INNER JOIN page_translation
                                   ON page.id_page = page_translation.id_page
                                   WHERE url_page = "print_header"
                                   AND family_page_translation = "title"';
                //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $structure_header_title = $data['L'.$main_id_language];
                }
                $query->closeCursor();
                #intro
                $prepared_query = 'SELECT * FROM page
                                   INNER JOIN page_translation
                                   ON page.id_page = page_translation.id_page
                                   WHERE url_page = "print_header"
                                   AND family_page_translation = "intro"';
                //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $structure_header_intro = $data['L'.$main_id_language];
                }
                $query->closeCursor();
                #desc
                $prepared_query = 'SELECT * FROM page
                                   INNER JOIN page_translation
                                   ON page.id_page = page_translation.id_page
                                   WHERE url_page = "print_header"
                                   AND family_page_translation = "desc"';
                //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);

                if(($data = $query->fetch()) != false)
                {
                    $structure_header_desc = $data['L'.$main_id_language];
                }
                $query->closeCursor();
                $query->execute();
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
            
            if(!empty($structure_header_title))
            {
?>
                <tr>
                    <td>
                        <h4 class="font_main"><?php echo($structure_header_title); ?></h4>
                    </td>
                </tr>
<?php
            }
                
            if(!empty($structure_header_intro))
            {
?>
                <tr>
                    <td>
                        <h4 class="font_main"><?php echo($structure_header_intro); ?></h4>
                    </td>
                </tr>
<?php
            }
            
            if(!empty($structure_header_desc))
            {
?>
                <tr>
                    <td>
                        <h4 class="font_main"><?php echo($structure_header_desc); ?></h4>
                    </td>
                </tr>
<?php
            }
?>              
            </table>
        </td>
    </tr>
    
</table>

