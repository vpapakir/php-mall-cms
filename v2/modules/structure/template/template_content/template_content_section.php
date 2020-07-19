<?php
$prepared_query = 'SELECT * FROM structure_template AS temp
                   INNER JOIN structure_section AS section
                   ON temp.id_section = section.id_section
                   WHERE id_template = :template';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('template', $_SESSION['structure_template_cboTemplate']);
$query->execute();

?>
<optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Section">
<?php            

while($data = $query->fetch())
{
?>
    <option style="background-color: white;" value="section<?php echo($data['id_section']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'section'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_section']); ?></option>
<?php                    
}
$query->closeCursor();
?>
</optgroup>
