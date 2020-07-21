<?php
if(isset($_POST['bt_copy_template']))
{
    $id_template = $_SESSION['structure_template_cboTemplate'];
    
    /*try
    {
		$prepared_query = "INSERT INTO structure_template (id_template,id_body,id_skin,id_section,id_layout,id_frame,id_box,id_font,id_button,id_block,name_template,status_template) 
						VALUES (NULL,0,0,0,0,'1,2,3,4,5,6,7,8','1,4,5','1','1','1',$_SESSION['current_template_name'],0)";
		
		if((checkrights($main_rights_log, '9', $redirection)) === true){
			$_SESSION['prepared_query'] = $prepared_query;
			$query = $connectData->prepare($prepared_query);
			$query->execute();
			$query->closeCursor();
		}
	} catch(Exception $e)
    {
        //include('modules/error/catch/catch400.php');
    }*/
	
	/*if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Structure');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Structure');
    }*/
} else {
	// do nothing
}
?>
