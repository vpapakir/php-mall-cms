<?php
$prepared_query = 'SELECT * FROM structure_box AS box
                   ORDER BY name_box';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();

?>
<optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Box">
<?php            

while($data = $query->fetch())
{
?>
    <option style="background-color: white;" value="box<?php echo($data['id_box']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'box'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_box']); ?></option>
<?php                    
}
$query->closeCursor();
?>
</optgroup>
