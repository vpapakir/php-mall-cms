<?php
try
{   
    $status_template = 1;
    
    $prepared_query = 'SELECT * FROM structure_template AS temp
                            INNER JOIN structure_body AS body
                            ON temp.id_body = body.id_body
                            INNER JOIN structure_logo AS logo 
                            ON temp.id_template = logo.id_template
                            WHERE status_template = :status_template';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('status_template', $status_template);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $name_body = $data['name_body'];
        $bgcolor_body = $data['bgcolor_body'];
        $id_body = $data['id_body'];
        $id_logo = $data['id_logo'];
    }
    $query->closeCursor();
    
    #get ID image body
    $prepared_query = 'SELECT * FROM structure_template AS temp
                        INNER JOIN structure_body AS body
                        ON temp.id_body = body.id_body
                        WHERE status_template = :status_template';
    
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('status_template', $status_template);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_image_body = $data['id_image'];
    }
    $query->closeCursor();
    
    if($bgcolor_body == null)
    {
       $bgcolor_body = 'white'; 
    }
    
    #get image body Info
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_image = :id_image';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_image', $id_image_body);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
       $path_body = $data['path_image'];
       $alt_body = $data['alt_image'];
       $title_body = $data['title_image'];
       $repeat_body = $data['repeat_image'];
       $attachment_body = $data['attachment_image'];
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
        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
    }
}

?>
<body style="background-color: <?php echo($bgcolor_body); ?>;
      background-image: url('<?php echo($config_customheader.$path_body) ?>'); 
      <?php if(!empty($repeat_body)){ ?>background-repeat: <?php echo($repeat_body) ?>;<?php } ?>
      <?php if(!empty($attachment_body)){ ?>background-attachment: <?php echo($attachment_body) ?>; <?php } ?> margin: 0px;
      text-align: <?php echo('center'); ?>;">
    
<?php
    include('structure/skin/skin1.php');
?>

</body>
