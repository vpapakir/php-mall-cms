<?php
//Section entity WebService public methods
function manageStyle()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['OwnerID'];
	
	//get Style file
	$clientType = $input['LayoutType'];
	if(empty($clientType)) {$clientType='front'; }
	
	$result['Vars']['LayoutType'] = $clientType;
	
	if($clientType=='admin')
	{
		$layout = 'admin';
	}
	else
	{
		$layout = 'default';
	}
	$stylePath = $config['RootPath'].'templates/'.$clientType.'/layouts/'.$layout.'/css/main.css';
	
	//$section = new SectionClass();
	if($input['actionMode']=='save' && !empty($input['StyleContent']))
	{
		$fp = fopen($stylePath,'w+');
		fwrite($fp,stripslashes($input['StyleContent']));
		fclose($fp);
	}	
	
	if(is_file($stylePath))
	{
		$result['Vars']['StyleFile'] = join(file($stylePath),"");
	}
	return $result;
}


?>