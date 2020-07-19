<?php


$prepared_query = 'SELECT * FROM structure_frame AS frame
                   WHERE id_layout = :layout';
//if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('layout', $id_layout);
$query->execute();

?>
<optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Frame">
<?php            

while($data = $query->fetch())
{
?>
    <option style="background-color: white;" value="frame<?php echo($data['id_frame']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'frame'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_frame']); ?></option>
<?php                    
}
$query->closeCursor();
?>
</optgroup>
