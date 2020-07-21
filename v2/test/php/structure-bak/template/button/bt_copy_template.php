<?php
if(isset($_POST['bt_copy_template']))
{
    $id_template = $_SESSION['structure_template_cboTemplate'];
	
	header('Location: www.google.gr');
    
    try
    {
		$prepared_query = 'INSERT INTO structure_template (id_template,id_body,id_skin,id_section,id_layout,id_frame,id_box,id_font,id_button,id_block,name_template,status_template)  VALUES (NULL,:id_body,:id_skin,:id_section,:id_layout,:id_frame,:id_box,:id_font,:id_button,:id_block,:name_template,:status_template)';
		//echo $prepared_query;
		if((checkrights($main_rights_log, '9', $redirection)) === true){
			$_SESSION['prepared_query'] = $prepared_query;
			$query = $connectData->prepare($prepared_query);
			$query->execute(array(
								'id_body' => 1,
								'id_skin' => 1,
								'id_section' => 1,
								'id_layout' => 1,
								'id_frame' => '1',
								'id_box' => '1',
								'id_font' => '1',
								'id_button' => '1',
								'id_block' => '1',
								'name_template' => $_SESSION['current_template_name'].rand(),
								'status_template' => 0
                            ));
			$query->closeCursor();
		}
	} catch(Exception $e)
    {
		include('modules/error/catch/catch400.php');
    }
	
	if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Structure');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Structure');
    }
} else {
	// do nothing
}
?>
