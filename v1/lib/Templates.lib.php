<?
//global functins used in templates

//show language field
function lang($code,$mode='')
{
	global $languageFieldCache,$CORE;
	$DS = new DataSource('main');
	$session = $CORE->getSession();
	//print_r($session);
	$rs[0] = $languageFieldCache[$code];
	if(empty($rs[0]['Value']))
	{
		$rs = $DS->query("SELECT Value, FileValue FROM LangField WHERE Code='".addslashes(stripslashes($code))."'");
		$languageFieldCache[$code] = $rs[0];
		if(empty($rs[0]['Value']))
		{
			$languageFieldCache[$code]['Value'] = $code;
		}
	}
	if($mode=='html')
	{
		$result = nl2br(getValue($rs[0]['Value']));
	}
	elseif($mode=='nospace')
	{
		$result = str_replace(" ","&nbsp;",getValue($rs[0]['Value']));
	}	
	else
	{
		$fileResult = trim(getValue($rs[0]['FileValue']));
		if(!empty($fileResult))
		{
			if(eregi(".swf",$fileResult)){
				$result = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
						codebase="http://download.macromedia.com/pub/shockwave/
						cabs/flash/swflash.cab#version=6,0,0,0" width="400" height="300">
						<param name="movie" value="'.setting('urlfiles').$fileResult.'">
						<param name="quality" value="high">
						<param name="scale" value="exactfit">
						<param name="bgcolor" value="#ffffff">
						<embed src="'.setting('urlfiles').$fileResult.'"
						type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
						</embed>
						</object>';
			}else{
				$result = '<img src="'.setting('urlfiles').$fileResult.'" border="0" alt="'.getValue($rs[0]['Value']).'"/>';
			}
			
		}
		elseif(stristr($code,".helptip"))
		{
			$text = getValue($rs[0]['Value']);
			if(empty($text)) {$text = $code;};
			
			$result = '<img src="'.setting('layout').'images/icons/info.png" border="0" id="'.$code.'" onmouseover="showDiv(\''.$code.'\',\''.$code.'.content\',\'right\')" onmouseout="hideDiv(\''.$code.'.content\'); return false;" />';
			$result .= '<div id="'.$code.'.content" class="popup" style="width:150px">'.$text.'</div>';
		}
		else
		{
			//echo $session['User']['SessionVars']['setCodeLang'];
			if($session['User']['SessionVars']['setCodeLang']=='Y'){
				if(stristr($code,".title")){
					$result = getValue($rs[0]['Value']);
					$result .= ' #<a href="#" onClick="javascript:popup(\''.setting('adminurl').'manageLanguageFields/selectedLangFieldCode/'.$code.'\')">'.$code.'</a>#';
				}
				elseif(stristr($code,".link") || stristr($code,".tip") || !stristr($code,".")){
					$result = getValue($rs[0]['Value']);
					$result .= " #".$code."#";
				}
			}else{
				$result = getValue($rs[0]['Value']);
			}
		}
	}
	if(empty($result))
	{
		$result = $code;
	}
	return $result;
}

//show settings field or variable
function setting($code,$mode='')
{
	global $CORE;
	$setting = $CORE->getConfig();
	return $setting[$code];
}

function setSetting($variable,$value)
{
	global $CORE;
	$CORE->setConfigVar($variable,$value);
}

function input($code,$mode='')
{
	global $CORE;
	$input = $CORE->getInput();
	return $input[$code];
}

function session($code,$mode='')
{
	global $CORE;
	$session = $CORE->getSessionData();
	return $session[$code];
}

function setInput($variable,$value)
{
	global $CORE;
	$CORE->setInputVar($variable,$value);
}

function getInputForm()
{
	global $CORE;
	$input = $CORE->getInput();
	foreach($input as $fieldName=>$fieldValue)
	{
		if($fieldName!='SID')
		{
			if(is_array(is_array($fieldValue)))
			{
				foreach($fieldValue as $fieldName2=>$fieldValue2)
				{
					if(is_array(is_array($fieldValue2)))
					{
						foreach($fieldValue2 as $fieldName3=>$fieldValue3)
						{
							$result .= '<input type="hidden" name="'.$fieldName3.'" value="'.$fieldValue3.'" />'."\n";
						}
					}
					else
					{
						$result .= '<input type="hidden" name="'.$fieldName2.'" value="'.$fieldValue2.'" />'."\n";
					}
				}
			}
			else
			{
				$result .= '<input type="hidden" name="'.$fieldName.'" value="'.$fieldValue.'" />'."\n";
			}
		}
	}
	return $result;
}

function getInputLink($mode='')
{
	global $CORE, $HTTP_GET_VARS,$HTTP_POST_VARS;
	
	$input = $CORE->getInput();
	$pagesMethod = $input['pagesMethod'];
	
	if($pagesMethod == 'post')
	{
		if(!empty($HTTP_POST_VARS))
		{
			$input = $HTTP_POST_VARS;
		}
		else
		{
			$input = $HTTP_GET_VARS;
		}
	}
	elseif($pagesMethod == 'get')
	{
		$input = $HTTP_GET_VARS;
	}
	elseif($pagesMethod == 'getpost')
	{
		$input = arrayMerge($HTTP_GET_VARS,$HTTP_POST_VARS);
	}
	elseif($pagesMethod == 'postget')
	{
		$input = arrayMerge($HTTP_POST_VARS,$HTTP_GET_VARS);
	}
	elseif(!empty($input['actionMode']))
	{
		$input = $HTTP_GET_VARS;
	}
	else
	{
		$input = arrayMerge($HTTP_GET_VARS,$HTTP_POST_VARS);
	}
	
	if(empty($mode)) {$mode='/';}
	foreach($input as $fieldName=>$fieldValue)
	{
		if($fieldName!='SID' && $fieldName!='page' && $fieldName!='next' && $fieldName!='page.html')
		{
			if(is_array(is_array($fieldValue)))
			{
				foreach($fieldValue as $fieldName2=>$fieldValue2)
				{
					if(is_array(is_array($fieldValue2)))
					{
						foreach($fieldValue2 as $fieldName3=>$fieldValue3)
						{
							if(!empty($fieldName3) && !empty($fieldValue3))
							{
								$result .= $mode.$fieldName3.$mode.$fieldValue3;
							}
						}
					}
					else
					{
						if(!empty($fieldName2) && !empty($fieldValue2))
						{
							$result .= $mode.$fieldName2.$mode.$fieldValue2;
						}
					}
				}
			}
			elseif(!empty($fieldName) && !empty($fieldValue))
			{
				$result .= $mode.$fieldName.$mode.$fieldValue;
			}
		}
	}
	return $result;
}

function user($code,$mode='')
{
	global $CORE;
	$user = $CORE->getUser();
	return $user[$code];
}

function getValue($keycode,$lang='')
{
	global $CORE;
	if(empty($lang))
	{
		$lang = setting('lang');
	}
	return $CORE->getValue($keycode,$lang);
	//return str_replace('&quot;','"',);
}

function getListValue($values,$value,$mode='',$lang='')
{
	global $CORE;
	if(empty($lang))
	{
		$lang = setting('lang');
	}	
	$type = $mode['type'];
	
	$id = $mode['id'];
	if(empty($id)) $id='id';
	$name = $mode['value'];
	if(empty($name)) $name='value';
	$delimiter = $mode['delimiter'];
	if(empty($delimiter)) $delimiter=',&nbsp; ';
	$i=1;
	foreach($values as $row)
	{
		if($type=='multiple' || $type=='checkboxes' || $type=='multipledropdown')
		{
			if(eregi("\|".$row[$id]."\|",$value))
			{
				if($i==1) {$result = $CORE->getValue($row[$name],$lang); $i++;}
				else {$result .= $delimiter.$CORE->getValue($row[$name],$lang);}
			}
		}
		else
		{
			if($row[$id]==$value) {	 $result =  $CORE->getValue($row[$name],$lang);}
		}
	}
	
	return $result;
}

function getFormated($value,$format,$mode='',$options='')
{
	global $CORE;
	
	if(empty($mode))
	{
		$mode = 'get';
	}
	if($format=='lang')
	{
		return getValue($value);
	}
	if($format=='serialized')
	{
		return unserialize($value);
	}	
	if(!empty($format))
	{
		eval('$DataType = new '.$format.'DataType(&$CORE);');
		if($mode=='set')
		{
			$value=$DataType->setDataType($value,$options);
		}
		elseif($mode=='form')
		{
			$value=$DataType->formDataType($value,$options);
		}
		elseif($mode=='separate')
		{
			$value=$DataType->separateDataType($value,$options);
		}
		elseif($mode=='fromdateto')
		{
			$value=$DataType->fromdatetoDataType($value,$options);
		}
		else
		{
			$value=$DataType->getDataType($value,$options);
		}	
	}
	//use datatypes classes here
	return $value;
}

function getLists($input,$currentValue,$mode,$lang='')
{
	global $CORE;
	if(empty($lang))
	{
		$config = $CORE->getConfig();
		$lang = $config['lang'];
	}
	
	$result = $CORE->getLists($input,$currentValue,$mode,$lang);
	$editlink = $mode['editlink'];
	if(hasRights('admin') && !empty($editlink) && $mode['noEdit']!='Y')
	{
		if(setting('ClientType') == 'admin' )
		{
			$result .='<a href="'.setting('url').$editlink.'">'.lang('-editbox').'</a>'; 
		}
		else
		{
			$result .='<a href="'.setting('adminurl').$editlink.'/frontBackLinkAction/save">'.lang('-editbox').'</a>'; 
		}
	}	
	return $result;
}

function getReference($typeName,$fieldName,$currentValue='',$mode='',$reflection='',$lang='')
{
	global $CORE;
	if(empty($lang))
	{
		$config = $CORE->getConfig();
		$lang = $config['lang'];
	}
	$type = $mode['type'];
	$result = $CORE->getType($typeName,$fieldName,$currentValue,$lang,$mode,$reflection);
	if($type == 'array')
	{
		return $result;
	}
	if(hasRights('admin') && $mode['suppressEdit']!='Y' && $mode['noEdit']!='Y' )
	{
		if(setting('ClientType') == 'admin')
		{
			$result .='<a href="'.setting('url').'manageReferences/ReferenceCode/'.$typeName.'">'.lang('-editbox').'</a>'; 
		}
		else
		{
			$result .='<a href="'.setting('adminurl').'manageReferences/ReferenceCode/'.$typeName.'/frontBackLinkAction/save">'.lang('-editbox').'</a>'; 
		}
	}
	return $result;
}

function getSettingsList($typeName,$fieldName,$currentValue='',$mode='',$lang='')
{
	global $CORE;
	if(empty($lang))
	{
		$config = $CORE->getConfig();
		$lang = $config['lang'];
	}
	$type = $mode['type'];
	$result = $CORE->getSettingsType($typeName,$fieldName,$currentValue,$lang,$mode);
	if($type == 'array')
	{
		return $result;
	}
	if(hasRights('admin') )
	{
		if(setting('ClientType') == 'admin')
		{
			$result .='<a href="'.setting('url').'manageSettings/Level2GroupID/11365480442006051812025318f111">'.lang('-editbox').'</a>'; 
		}
		else
		{
			$result .='<a href="'.setting('adminurl').'manageSettings/Level2GroupID/11365480442006051812025318f111/frontBackLinkAction/save">'.lang('-editbox').'</a>'; 
		}
	}
	return $result;
}

//jb 21.11.05. Get value of current refs option from refference by refference code and option code 
function getReferenceValue($typeName,$currentValue,$lang='',$mode='')
{
	global $CORE;
	if(empty($lang))
	{
		$config = $CORE->getConfig();
		$lang = $config['lang'];
	}

	return $CORE->getReferenceValue($typeName,$currentValue,$lang,$mode='');
}

//show box by id or by alias
function getBox($boxID,$mode='')
{
//echo $boxID.'///'.$mode;
//timeTracking('boxbegins-'.$boxID);
	global $CORE, $SERVER_SOAP;
	$boxes = $CORE->getBoxesDefinition();
	//print_r($boxes);
	$box = $boxes[$boxID];
	$arguments = $box['arguments'];
	$params = $mode['params'];
	$config = $CORE->getConfig();
//	$config['OwnerStyle'] = 'style1';
	if($mode['style']=='' && !empty($mode['side'])) 
		$mode['style'] = $config['OwnerStyle'].'.styles.box.default'.$mode['side'];
	
	$CORE->setConfigVar('boxstyle',$mode['style']);
	//
	if(!empty($arguments))
	{
		$CORE->getArguments($arguments,'torestore');
	}
	$input = $CORE->getInput();
	$config = $CORE->getConfig();
	$setting = $config;
	$user = $CORE->getUser();
	$clientType = $config['ClientType'];
	
	
	$moduleFile = $config['RootPath'].'modules/'.$box['module'].'/index.php';
	//echo $boxID.' - '.$moduleFile.'<br>';
	if(is_file($moduleFile))
	{
		include_once($moduleFile);
		$method = $box['method'];
		//$methodString = "\$moduleObject = new \$class(); if(function_exists(\$moduleObject->\$method())) {\$moduleObject->\$method();}";
		if(!empty($method))
		{
			//$methodString = "if(function_exists($method)) {\$out = $method(); }";
			//eval($methodString);
			if(function_exists($method)) {$out = $method();}//new jb 4.12.05
		}
		$input = $CORE->getInput();
		
		$templateLibFile = $config['RootPath'].'templates/'.$clientType.'/'.$box['module'].'/lib.tpl.php';
		if(is_file($templateLibFile))
		{
			include_once($templateLibFile);
		}		
		if(!empty($input['ResourceTemplate']))
		{
			//get from resource tmelplate and layout
			$templateFile = $config['RootPath'].'templates/'.$clientType.'/'.$box['module'].'/'.$input['ResourceTemplate'].'/layouts/'.$config['Layout'].'/'.$box['template'].'.tpl.php';
			if(!is_file($templateFile))
			{
				//try from root and layout
				$templateFile = $config['RootPath'].'templates/'.$clientType.'/'.$box['module'].'/layouts/'.$config['Layout'].'/'.$box['template'].'.tpl.php';
			}
			if(!is_file($templateFile))
			{
				//try from template wihtout layout
				$templateFile = $config['RootPath'].'templates/'.$clientType.'/'.$box['module'].'/'.$input['ResourceTemplate'].'/'.$box['template'].'.tpl.php';
			}
			if(!is_file($templateFile))
			{
				//try from root without layout
				$templateFile = $config['RootPath'].'templates/'.$clientType.'/'.$box['module'].'/'.$box['template'].'.tpl.php';
			}
			//echo $templateFile;
		}
		else
		{
			$templateFile = $config['RootPath'].'templates/'.$clientType.'/'.$box['module'].'/layouts/'.$config['Layout'].'/'.$box['template'].'.tpl.php';
			if(!is_file($templateFile))
			{			
				$templateFile = $config['RootPath'].'templates/'.$clientType.'/'.$box['module'].'/'.$box['template'].'.tpl.php';
			}
		}
		//echo $boxID.' - '.$templateFile.'<br>';
		//echo $boxID.'<br>';
		if(is_file($templateFile))
		{
			//echo "1111".$config['boxstyle'];
			include($templateFile);
		}
	}
	if(!empty($arguments))
	{
		$CORE->restoreArguments();
	}
//timeTracking('boxbeends-'.$boxID);	
	return $out;	
}

//show boxe by sides
function getBoxes($boxesSide,$mode='')
{
	global $CORE, $SERVER_SOAP;
	$website = $CORE->getWebsiteDefinition();
	$input = $CORE->getInput();
	$sectionID = $input['SID'];
	$boxes = $website[$sectionID][$boxesSide];
	//echo $boxesSide;
	//print_r($website);
	//print_r($boxes);
	
	if(is_array($boxes))
	{
		foreach($boxes as $boxID=>$box)
		{
			getBox($boxID,array('style'=>$box['boxstyle'],'side'=>$boxesSide));
		}
	}
}

function boxHeader($data='',$mode='')
{
	global $CORE;
	$boxes = $CORE->getBoxesDefinition();
	$input = $CORE->getInput();
	$config = $CORE->getConfig();
	$setting = $config;
	$user = $CORE->getUser();
	$clientType = $config['ClientType'];
	$windowMode = $input['windowMode'];
	if(!empty($input['windowMode']))
	{
		$templateFile = $config['RootPath'].'templates/'.$clientType.'/layouts/'.$config['Layout']."/$windowMode/boxHeader.tpl.php";
	}
	else
	{
		$templateFile = $config['RootPath'].'templates/'.$clientType.'/layouts/'.$config['Layout'].'/boxHeader.tpl.php';
	}	
	$out=$data;
	$tabs = $data['tabs'];
	if(!empty($tabs) && !is_array($tabs))
	{
		$tabLink=$input['tabLink'];
		$DS = new DataSource('main');
		$tabsRS = $DS->query("SELECT * FROM TabLink WHERE TabLinkAlias='$tabs' ORDER BY TabLinkPosition");
		$out['DB']['tabs'] = $tabsRS;
		$out['tabs'] = $tabsRS;
		//print_r($out['DB']['tabs']);
		if($tabLink==1)
		{
			$CORE->setSessionVar('tabLink',$tabsRS[0]['TabLinkID']);
			$tabLink = $tabsRS[0]['TabLinkID'];
		}
		elseif(!empty($tabLink))
		{
			$CORE->setSessionVar('tabLink',$tabLink);
		}
	}
	if(is_file($templateFile))
	{
		include($templateFile);
	}
}

function boxFooter($data='',$mode='')
{
	global $CORE;
	$boxes = $CORE->getBoxesDefinition();
	$input = $CORE->getInput();
	$config = $CORE->getConfig();
	$setting = $config;
	$user = $CORE->getUser();
	$clientType = $config['ClientType'];
	$windowMode = $input['windowMode'];
	if(!empty($input['windowMode']))
	{
		$templateFile = $config['RootPath'].'templates/'.$clientType.'/layouts/'.$config['Layout']."/$windowMode/boxFooter.tpl.php";
	}
	else
	{
		$templateFile = $config['RootPath'].'templates/'.$clientType.'/layouts/'.$config['Layout'].'/boxFooter.tpl.php';
	}		
	$out=$data;
	if(is_file($templateFile))
	{
		include($templateFile);
	}	
	
}

function hasRights($rights)
{
	global $CORE;
	//return false;
	return $CORE->hasRights($rights);
}

function getPages($pages)
{
	//print_r($pages);
	$currentPage = $pages['currentPage'];
	$result = ''.$pages['total'].' '.lang('-totalfound').'';
	if($pages['total']==1) $result = ''.$pages['total'].' '.lang('-total').'';
	if(is_array($pages['pagesList']))
	{
		if(!empty($pages['prev']))
		{
			//$result .= ' <a href="'.setting('url').input('SID').'--page--'.$pages['prevLinkPage'].'--next--'.$pages['prevLinkBlock'].''.getInputLink('--').'--page.html" class="subtitle">[<<'.$pages['prev'].'<<]</a> ';
			$result .= ' <a href="'.setting('url').input('SID').'--page--'.$pages['prevLinkPage'].'--next--'.$pages['prevLinkBlock'].''.getInputLink('--').'--page.html" class="text">['.lang('-prevpages').']</a> ';
		}
		foreach($pages['pagesList'] as $page)
		{
			if($currentPage==$page['pageNumber'])
			{
				$result .= ' | '.$page['pageFirstItem'].'-'.$page['pageLastItem'].'';
			}
			else
			{
				$result .= ' | <a href="'.setting('url').input('SID').'--page--'.$page['pageLinkPage'].'--next--'.$page['pageLinkNext'].''.getInputLink('--').'--page.html"  class="text">'.$page['pageFirstItem'].'-'.$page['pageLastItem'].'</a>';
			}
		}
		$result .= ' | ';
		if(!empty($pages['next']))
		{
			//$result .= ' <a href="'.setting('url').input('SID').'--page--'.$pages['nextLinkPage'].'--next--'.$pages['nextLinkBlock'].''.getInputLink('--').'--page.html" class="subtitle">[>>'.$pages['next'].'>>]</a> ';
			$result .= ' <a href="'.setting('url').input('SID').'--page--'.$pages['nextLinkPage'].'--next--'.$pages['nextLinkBlock'].''.getInputLink('--').'--page.html" class="text">['.lang('-nextpages').']</a> ';
		}		
	}
	
	return $result;
}


function goLink($url,$mode='')
{
	die(header('Location: '.$url));
}
?>