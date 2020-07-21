<?php
$prepared_query = 'SELECT * FROM style_font AS font
                   ORDER BY name_font';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();

?>
<option style="background-color: lightgray; color: black;" disabled="true"><?php give_translation('edit_structure.template_style_font', '', $config_showtranslationcode) ?></option>
<?php            

while($data = $query->fetch())
{
?>
    <option style="margin-left: 12px;" value="font<?php echo($data['id_font']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'font'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_font']); ?></option>
<?php                    
}
$query->closeCursor();
?>
