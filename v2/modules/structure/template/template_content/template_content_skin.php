<?php
$prepared_query = 'SELECT * FROM structure_template AS temp
                   INNER JOIN structure_skin AS skin
                   ON temp.id_skin = skin.id_skin
                   WHERE id_template = :template';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('template', $_SESSION['structure_template_cboTemplate']);
$query->execute();

?>
<optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Skin">
<?php            

while($data = $query->fetch())
{
?>
    <option style="background-color: white;" value="skin<?php echo($data['id_skin']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'skin'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_skin']); ?></option>
<?php                    
}
$query->closeCursor();
?>
</optgroup>
