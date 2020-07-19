<?
	$mainConfig['db']['main']['type']    ='mysql';
	$mainConfig['db']['main']['host']    ='XXX';
	$mainConfig['db']['main']['name']    ='YYY';
	$mainConfig['db']['main']['user']    ='ZZZ';
	$mainConfig['db']['main']['password']='TTTT';
	
	$mainConfig['Settings']['WebFolder'] = str_replace($_SERVER['DOCUMENT_ROOT'],"",realpath('./')).'/';

	//loader configuration
	$mainConfig['LoaderConfig']['loaderend']='/';
	$mainConfig['LoaderConfig']['delimiter']='.';
	$mainConfig['LoaderConfig']['DefaultVariable']='lang';
	$mainConfig['LoaderConfig']['Variables'][0]='OwnerID';
	$mainConfig['LoaderConfig']['Variables'][1]='lang';

	//main config
	$mainConfig['Settings']['CookieName']='cmssystem';
	$mainConfig['Settings']['CookieTimeout']=172800;
	$mainConfig['Settings']['OwnerID']='root';
	$mainConfig['Settings']['DefaultOwner']='root';
	$mainConfig['Settings']['ClientType']='front';
	$mainConfig['Settings']['Layout']='default';
	$mainConfig['Settings']['DTR']='_11_';
	$mainConfig['Settings']['lang']='en';
	$mainConfig['Settings']['GMT']='+2';
	
	//paths and urls
	$configurationFilePath = dirname(ereg_replace("\\\\","/",__FILE__));
	$mainConfig['Settings']['RootPath']=$configurationFilePath.'/';	

	$requestURL = $_SERVER['HTTP_HOST'];
	$requestURL  = str_replace("http://","",$requestURL);
	$requestURL = 'http://'.$requestURL;
	$mainConfig['Settings']['rooturl']=$requestURL.$mainConfig['Settings']['WebFolder'];
	if(empty($loaderName)) {$loaderName='go';}
	$mainConfig['Settings']['LoaderName']=$loaderName;
	if($mainConfig['Settings']['LoaderName']=='rss') {$mainConfig['Settings']['LoaderName']='go';}
	
	if(!empty($loaderName))
	{
		$mainConfig['Settings']['url']=$mainConfig['Settings']['rooturl'].$loaderName.'/'.$mainConfig['Settings']['lang'].'/';
		$mainConfig['Settings']['adminurl'] = $mainConfig['Settings']['rooturl'].'adm/'.$mainConfig['Settings']['lang'].'/';
	}
	else
	{
		$mainConfig['Settings']['url']=$mainConfig['Settings']['rooturl'].'?SID=';
	}
	
	$mainConfig['Settings']['CacheStatus']='N';
	
	$mainConfig['Settings']['MaxFileSize']=1000000;
	$mainConfig['Settings']['HDDSpace']=52428800;
	$mainConfig['Settings']['ExtensionsOFF']='php,cgi,php4,php3,pl';
	$mainConfig['Settings']['EditExtensions']='htm,html,txt,php,css,xml,xsl,thtml,js,css';
	
	$mainConfig['Settings']['UseImageResize']='Y';
	$mainConfig['Settings']['UseImagePreview']='Y';
	$mainConfig['Settings']['UseImageIcon']='Y';
	$mainConfig['Settings']['ImageWidthLimit']=500;
	$mainConfig['Settings']['ImageHeightLimit']=1000;
	$mainConfig['Settings']['ImageIconWidthLimit']=60;
	$mainConfig['Settings']['ImageIconHeightLimit']=300;	
	$mainConfig['Settings']['ImagePreviwWidthLimit']=240;
	$mainConfig['Settings']['ImagePreviewHeightLimit']=400;
	
	$mainConfig['Settings']['MailEncoding']='iso-8859-2';
	$mainConfig['Settings']['MailMode']='';
	$mainConfig['Settings']['MailSMTP']='localhost';
	$mainConfig['Settings']['SiteMail']='test@com.com';
	
	$mainConfig['ftp']['main']['host'] = 'ftp://localhost';
	$mainConfig['ftp']['main']['user'] = 'annonimous';
	$mainConfig['ftp']['main']['password'] = '***';
	$mainConfig['ftp']['main']['path'] = '/*';	

	//Cache control
	$cacheConfig['CacheStatus'] = 'N';	
	$cacheConfig['CachePath'] = 'cache/';	
	$cacheConfig['CacheCotrolType'] = 'event';// values: time or event
	$cacheConfig['CacheTime'] = 24;// for time caching .. period of cahce validity in hours
	$cacheConfig['folders']['category'] = 'category';	
	
?>
