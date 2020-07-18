<?php
$prepared_query = 'SELECT * FROM style_block_set AS block
                   ORDER BY name_block';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();

?>
<option style="background-color: lightgray; color: black;" disabled="true">Block</option>
<?php            

while($data = $query->fetch())
{
?>
    <option style="margin-left: 12px;" value="block<?php echo($data['id_block']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'block'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_block']); ?></option>
<?php                    
}
$query->closeCursor();
?>
