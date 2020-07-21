<?php
$prepared_query = 'SELECT * FROM structure_template AS temp
                   INNER JOIN structure_logo AS logo
                   ON temp.id_template = logo.id_template
                   WHERE temp.id_template = :template';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('template', $_SESSION['structure_template_cboTemplate']);
$query->execute();

?>
<optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Logo">
<?php            

while($data = $query->fetch())
{
?>
    <option style="background-color: white;" value="logo<?php echo($data['id_logo']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'logo'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_logo']); ?></option>
<?php                    
}
$query->closeCursor();
?>

</optgroup>
