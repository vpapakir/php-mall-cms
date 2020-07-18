<?php
$prepared_query = 'SELECT * FROM structure_template AS temp
                   INNER JOIN structure_layout AS layout
                   ON temp.id_layout = layout.id_layout
                   WHERE id_template = :template';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('template', $_SESSION['structure_template_cboTemplate']);
$query->execute();

?>
<optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Layout">
<?php            

while($data = $query->fetch())
{
    $id_layout = $data['id_layout'];
?>
    <option style="background-color: white;" value="layout<?php echo($data['id_layout']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'layout'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_layout']); ?></option>
<?php                    
}
$query->closeCursor();
?>
</optgroup>
