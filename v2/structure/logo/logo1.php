<?php
$Bok_include_both = false;
$Bok_include_path = false;

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
        $name_logo = $data['name_logo'];
        $text_logo = $data['text_logo'];
        $font_logo = $data['font_logo'];
        $size_logo = $data['size_logo'];
        $weight_logo = $data['weight_logo'];
        $color_logo = $data['color_logo'];
        $align_logo = $data['align_logo'];
        $scriptpath_logo = $data['scriptpath_logo'];
        $scriptcode_logo = $data['scriptcode_logo'];
        $marginl_logo = $data['marginl_logo'];
        $marginr_logo = $data['marginr_logo'];
        $id_image_logo = $data['id_image'];
        $id_language_logo = $data['id_language'];
    }
    $query->closeCursor();
    
    if(preg_match('#\${1,}#', $scriptpath_logo))
    {
        unset($scriptpath_logo);
    }
    else
    {
        $scriptpath_logo = split_string($scriptpath_logo, '$');
    }
    
    if(preg_match('#\${1,}#', $scriptcode_logo))
    {
        unset($scriptcode_logo);
    }
    else
    {
        $scriptcode_logo = split_string($scriptcode_logo, '$');
    }
    
    $id_image_logo = split_string($id_image_logo, '$');
    $id_language_logo = split_string($id_language_logo, '$');
    
    for($i = 0, $count = count($id_language_logo); $i < $count; $i++)
    {
        if($id_language_logo[$i] == $main_id_language)
        {
            $y = $i;
        }
    }
    
    $prepared_query = 'SELECT * FROM structure_image
                            WHERE id_image = :id_image';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_image', $id_image_logo[$y]);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
       $path_logo = $data['path_image'];
       $alt_logo = $data['alt_image'];
       $title_logo = $data['title_image'];
       $repeat_logo = $data['repeat_image'];
    }
    $query->closeCursor();
    
    #URL rewriting Home link frontend
    $prepared_query = 'SELECT L'.$main_id_language.'
                       FROM page_translation
                       INNER JOIN page
                       ON page.id_page = page_translation.id_page
                       WHERE url_page = "home_frontend"
                       AND family_page_translation = "rewritingF"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('page', htmlspecialchars($id_page, ENT_QUOTES));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $link_logo = $data[0];
    }
    $query->closeCursor();
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    echo $_SESSION['error400_message'];
    /*if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
    }*/
}


if(empty($scriptcode_logo[$y]))
{
    $include_script = $scriptpath_logo[$y];
    $Bok_include_path = true;
}
else
{
    $include_script = $scriptcode_logo[$y];
}

if(!empty($scriptcode_logo[$y]) && !empty($scriptpath_logo[$y]))
{
    $Bok_include_both = true;

    $include_path = $scriptpath_logo[$y];
    $include_code = $scriptcode_logo[$y];
}

?>
<table width="100%" style="background-image: url(''); 
                  <?php if(!empty($repeat_logo)){ ?>background-repeat: <?php echo($repeat_logo); ?>;<?php } ?>" border="0" cellpadding="0" cellspacing="0">
<?php

    if(!empty($id_image_logo[$y]))
    {
?>
        <tr>
            <td align="left">              
                <div style="margin-left: <?php echo($marginl_logo); ?>px;">
                    <a href="<?php echo($config_customheader.$link_logo); ?>" style="text-decoration: none;">
                        <img style="border: none;" src="<?php echo($config_customheader.$path_logo); ?>" alt="<?php echo($text_logo); ?>"/> 
                    </a>
                </div>               
            </td>
        </tr>
<?php 
    }
    else
    {
?>
        <tr>
            <td align="left"> 
                <div style="margin-left: <?php echo($marginl_logo); ?>px;">
                    <a href="<?php echo($config_customheader.$link_logo); ?>" style="text-decoration: none; font-family: <?php echo($font_logo); ?>; 
                              color: <?php echo($color_logo); ?>;
                              font-weight: <?php echo($weight_logo); ?>; 
                              font-size: <?php echo($size_logo.'px'); ?>;">
                     <?php echo($text_logo); ?>
                    </a>
                </div>
            </td>
        </tr>
<?php
    }
    
    if($Bok_include_both === true)
    {
?>
        <tr>
            <td align="left"> 
<?php
        include($include_path);
        
?>
            </td>
        </tr>    
        <tr>
        <td align="left"> 
<?php 

        echo($include_code);
?>
        
        </td>
        </tr>
<?php            
    }
    else
    {
        if($Bok_include_path === false)
        {
?>
            <tr>
            <td align="left"> 
<?php
            echo($include_script);
?>
            </td>
            </tr>
               
<?php                
        }
        else
        {
?>
            <tr>
            <td align="left"> 
<?php
            include($include_script);
?>
            </td>
            </tr>
               
<?php
        }
    }
?>

</table>

