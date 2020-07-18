<?php
function manageGSM()
{ 
	global $CORE;
	global $_SERVER;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$manageMode = $input['manageMode'];
	$clientType = $config['ClientType'];
	$entityID = $input['ResourceLinkID'];
	
	$input['SectionType']='front';
	$sections=getSectionsTree($input);
	$gsg = new GsgXml('http://'.$_SERVER['SERVER_NAME']);
	foreach($sections['DB']['Sections'] as $id=>$value)
	{
//		$lastmod='2006-03-04T04:13:33-06:00';
		$lastmod=str_replace(' ','T',$value['TimeSaved']);
		$changefreq='weekly';
		$priority='1.0';
		if ($gsg->addUrl('http://'.$_SERVER['SERVER_NAME'].setting('url').$value['SectionAlias'].'/', FALSE, $lastmod, FALSE, $changefreq, $priority) === FALSE)
		{
			$result['error']=$gsg->errorMsg.' - Error adding file: '.'http://'.$_SERVER['SERVER_NAME'].setting('url').$value['SectionAlias'].'/<br>';
//				echo 'Error adding file: '.'http://'.$_SERVER['SERVER_NAME'].setting('url').$value['SectionAlias'].'/<br>';
//				echo $gsg->errorMsg;
		}
	}
	$filehandle = @fopen(setting('RootPath').'content/root/en/files/sitemap.xml.gz', 'w+');
	if ($filehandle === FALSE) {
		//echo 'Could not write sitemap';
		$result['errorCritical']='Could not write sitemap';
		return FALSE;
	}else{
		$result['createdFile']='/content/root/en/files/sitemap.xml.gz';
	}
	$xml = $gsg->output(TRUE, 'compress_sitemap', FALSE);

	fputs ($filehandle, $xml);
	fclose ($filehandle);
	
//	$result=$xml;
	return $result;
}
?>