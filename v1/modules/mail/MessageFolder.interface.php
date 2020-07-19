<?php
//XCMSPro: MessageFolder entity WebService public methods

/**
* Gets messageFolders. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getMessageFolders()
{
	global $SERVER;
	//get input
	$SERVER->setDebug('messageFolder.getMessageFolders.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('{module}','server');
	$MessageFolder = new MessageFolderServer(&$SERVER,&$DS);
	//get content
	$messageFoldersRS = $MessageFolder->getMessageFolders($input);
	$SERVER->setOutput($messageFoldersRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('messageFolder.getMessageFolders.End','End');
	return $returnValue;
}
/**
* Gets messageFolder. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getMessageFolder($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('messageFolder.getMessageFolder.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('{module}','server');
	$MessageFolder = new MessageFolderServer(&$SERVER,&$DS);
	//get content
	$messageFolderRS = $MessageFolder->getMessageFolder($input);
	$SERVER->setOutput($messageFolderRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('messageFolder.getMessageFolder.End','End');
	return $returnValue;
}
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageMessageFolders($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('messageFolder.manageMessageFolders.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('{module}','server');
	$MessageFolder = new MessageFolderServer(&$SERVER,&$DS);
	//get content
	if($input['actionMode']=='delete')
	{
		$MessageFolder->deleteMessageFolder($input);
	}
	elseif($input['actionMode']=='save')
	{
		$MessageFolder->setMessageFolder($input);
	}
	$messageFoldersRS = $MessageFolder->getMessageFolders($input);
	$SERVER->setOutput($messageFoldersRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('messageFolder.manageMessageFolders.End','End');
	return $returnValue;
}
/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageMessageFolder($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('messageFolder.manageMessageFolder.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('{module}','server');
	$MessageFolder = new MessageFolderServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$MessageFolder->setMessageFolder($input);
	}
	if($input['actionMode']=='delete')
	{
		$MessageFolder->deleteMessageFolder($input);
	}
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $MessageFolder->setMessageFolder($input);
	}
	else
	{
		$contentRS = $MessageFolder->getMessageFolder($input);
	}
	$SERVER->setOutput($contentRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('MessageFolderStatus',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('MessageFolderType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('PermAll',$in,'localRefs');	
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('messageFolder.manageMessageFolder.End','End');
	return $returnValue;
}

?>