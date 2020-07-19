<?php
$prepared_query = 'SELECT * FROM structure_template AS temp
                   INNER JOIN structure_body AS body
                   ON temp.id_body = body.id_body
                   WHERE id_template = :template';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('template', $_SESSION['structure_template_cboTemplate']);
$query->execute();

?>
<optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Body">
<?php            

while($data = $query->fetch())
{
?>
    <option style="background-color: white;" value="body<?php echo($data['id_body']); ?>"
            <?php if(!empty($_SESSION['structure_template_cboTemplateContent']) && $_SESSION['structure_template_cboTemplateContent'] == 'body'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
            ><?php echo($data['name_body']); ?></option>
<?php                    
}
$query->closeCursor();
?>

</optgroup>
