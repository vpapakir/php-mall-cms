<?php
$prepared_query = 'SELECT * FROM style_button AS button
                   ORDER BY name_button';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();

?>
<option style="background-color: lightgray; color: black;" disabled="true">Button</option>
<?php            

while($data = $query->fetch())
{
?>
    <option style="margin-left: 12px;" value="button<?php echo($data['id_button']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'button'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_button']); ?></option>
<?php                    
}
$query->closeCursor();
?>
