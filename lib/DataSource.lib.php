<?
class DataSource
{
    // PRIVATE PROPERTIES
	var $_connection;
	var $_host;
	var $_user;
	var $_pass;
	var $_name;
	var $_dsDef;
	var $_controller;	
	// PRIVATE METHODS
	function _getConfig ()
	{
		return $GLOBALS['mainConfig'];		
	}
	function _setDebug ($code,$description='')
	{
		$this->_controller->setDebug($code,$description);		
	}
	function _setMessage ($code,$descritpion='',$number='')
	{
		$this->_controller->setMessage($code,$descritpion,$number);
	}
				
	function _connect()
	{
		$name=$this->_name;
		global $mysqlConnection;
		if(empty($mysqlConnection[$name]))
		{
			// Connect to MySQL server
			//echo 'user='.$this->_user.'<br>';
			$conn = @mysql_connect($this->_host,$this->_user,$this->_pass) or die('Can not connect to MySQL database: '.$name);//$this->_setMessage('MySQLSource._connect.err.mysql_connect','Cannnot connect to DB server');
			// Set the database
            mysql_query("SET NAMES 'utf8'");
			if (!$conn) 
			{
				//$this->_setMessage('MySQLSource._connect.connection','Error in _connect');
			}
			// return connection object
			$mysqlConnection[$name] = $conn;
		}
		$this->_connection = $mysqlConnection[$name];
		return $conn;
	}
	
	function _query($sql)
	{
		$db = $this->_connection;
		$name=$this->_name;
		// Run query
		//echo '<hr>sql'.$sql.'';
		/*
		if(eregi("update",$sql))
		{
			$controller = &$this->_controller;
			$config = $controller->getConfig();		
			$fp = fopen($config['Settings']['RootPath'].'content/root/sqllog.txt','a+');
			$log = $_SERVER['PHP_SELF']."\n".$sql;
			fwrite($fp,$log."\n");
			fclose($fp);
			unlink($config['Settings']['RootPath'].'content/root/sqllog.txt');
		}
		*/
		@mysql_select_db($name,$db) or die('Can not select MySQL database: '.$name);//$this->_setMessage('MySQLSource._connect.err.mysql_select_db','error selecting database: '.$name);
		$result = mysql_query($sql,$db);
		
		// If OK, return otherwise echo error
		if (mysql_errno() == 0 && !empty($result)) 
		{
			return $result;

		} else {
			// callee may want to supress printing of errors
			$this->_setMessage('MySQLDatabase._query.err.mysql_query','Error in mysql query: '.mysql_errno().' : '.mysql_error().' sql:'.$sql);				
			return false;
		}
	}
	
	function _parseSQLQuery($sql)
	{
		$dsDef = $this->_dsDef;
		$dbprefix = $dsDef['con']['SourcePrefix'];	
		preg_match ("/FROM(.*)WHERE/i", $sql, $selectRS);
		$retval['from'] = $selectRS[1];
		if(empty($retval['from']))
		{
			preg_match ("/FROM(.*)/i", $sql, $selectRS);
			$retval['from'] = $selectRS[1];		
		}
		$retval['from'] = eregi_replace(" ", "", $retval['from']);
	
		preg_match ("/SELECT(.*)FROM/i", $sql, $selectRS);
		$retval['select'] = $selectRS[1];
		if(eregi("\*", $retval['select']))
		{
			$tables = explode(",", $retval['from']);
			foreach($tables as $table)
			{
				$table = eregi_replace($dbprefix, "", $table);
				$select .= $this->_makeSelect(trim($table));
			}
			$select = substr($select,0,strlen($select)-2);// delete the last coma
			$retval['select'] = $select;
		}
		preg_match ("/WHERE(.*)/i", $sql, $whereRS);
		$retval['where'] = $whereRS[1];
		
		if($retval['where'])
		{
			$retval['query'] = 'SELECT '.$retval['select'].' FROM '.$retval['from'].' WHERE '.$retval['where'];
		}
		else
		{
			$retval['query'] = 'SELECT '.$retval['select'].' FROM '.$retval['from'];			
		}
		
		return $retval;
	}	
	
	function getPages($tables,$where,$mode='')
	{
		$maxpages = $mode['ItemsPerPage'];
		$total = $this->dbCount($tables,$where);
		return $this->_getPages($total,$maxpages);
	}
	
	function _getPages ($totalfound,$maxpages='') {
	
		global $refvarsurl;
		$controller = &$this->_controller;
		$config = $controller->getConfig();
		$in = $controller->getInput();

		//$pref = $refvarsurl;
		if(empty($config["ItemsPerPage"])) {$config["ItemsPerPage"]=50;}
		if(empty($config["PagesPerBar"])) {$config["PagesPerBar"]=10;}
		//$xml = '<'.'Pages'.'>' . LB;
		//$xml .= '<'.'Total>'.$totalfound.'</Total>' . LB;
		$result['pages']['total'] = $totalfound;
		$page= $in['page'];
		//echo 'page='.$page;
		$next= $in['next'];
		if ($maxpages)
		{
			$item_per_page = $maxpages;
		}
		else
		{
			$item_per_page=$config["ItemsPerPage"];
		}
		$pages_per_bar = $config['PagesPerBar'];
		if (empty($next)){$next=1;} if(empty($page)) {$page=1;}
		if ($item_per_page) {$num = $totalfound/$item_per_page;}
		$test = $num - round($num);
		if ($test > 0) { $pages = round($num)+1; } else { $pages = round($num); }
	
		$end=$page*$item_per_page;
		//echo 'end='.$end.' $item_per_page='.$item_per_page.' page='.$page.'<hr>';
		$begin=$end-$item_per_page;
	
		$firstpage = $pages_per_bar*$next-$pages_per_bar+1;
		$nextlink = $item_per_page*$pages_per_bar;
		if ($nextlink > $totalfound-$item_per_page*$pages_per_bar*$next) { $nextlink = $totalfound-$item_per_page*$pages_per_bar*$next; }
		if ($totalfound > ($item_per_page*$pages_per_bar*$next)) 
		{
			$result['pages']['next'] = $nextlink;
			$result['pages']['nextLinkPage'] = $firstpage+$pages_per_bar;
			$result['pages']['nextLinkBlock'] = $next+1;
			//$xml .= '<'.'Next'.'>'.'<![CDATA['.$nextlink.']]>'.'</'.'Next'.'>' . LB;
			//$xml .= '<'.'NextLinkPage'.'>'.'<![CDATA['.($firstpage+$pages_per_bar).']]>'.'</'.'NextLinkPage'.'>' . LB;			
			//$xml .= '<'.'NextLinkNext'.'>'.'<![CDATA['.($next+1).']]>'.'</'.'NextLinkNext'.'>' . LB;			
//			$xml .= '<'.'Nextlink'.'>'.'<![CDATA['."?page=".($firstpage+$pages_per_bar).$pref."&next=".($next+1).']]></nextlink>' . LB;
			
			//$NEXTANCHOR = '<a href="'.$REQUEST_URI."&page=".($firstpage+$pages_per_bar).$pref."&next=".($next+1).'">&nbsp;&nbsp;[>>&nbsp;'.$nextlink.'&nbsp;>>]</a>';
		} 
		else 
		{
			//$NEXTANCHOR = '';
		}
		
		if ($firstpage != "1") 
		{
			$result['pages']['prev'] = $item_per_page*$pages_per_bar;
			$result['pages']['prevLinkPage'] = $firstpage-$pages_per_bar;
			$result['pages']['prevLinkBlock'] = $next-1;
			
			//$xml .= '<'.'Prev'.'>'.'<![CDATA['.$item_per_page*$pages_per_bar.']]>'.'</'.'Prev'.'>' . LB;
			//$xml .= '<'.'PrevLinkPage'.'>'.'<![CDATA['.($firstpage-$pages_per_bar).']]>'.'</'.'PrevLinkPage'.'>' . LB;
			//$xml .= '<'.'PrevLinkNext'.'>'.'<![CDATA['.($next-1).']]>'.'</'.'PrevLinkNext'.'>' . LB;
			//$xml .= '<prevlink><![CDATA['."?page=".($firstpage-$pages_per_bar).$pref."&next=".($next-1).']]></prevlink>' . LB;		
			
			//$PREVANCHOR='<a href="'.$REQUEST_URI."&page=".($firstpage-$pages_per_bar).$pref."&next=".($next-1).'">[<<&nbsp;'.$item_per_page*$pages_per_bar.'&nbsp;<<]&nbsp;&nbsp;</a>';
		}
		else 
		{
			//$PREVANCHOR='';
		}
	
		if ($totalfound > $item_per_page) 
		{
			$limit = $firstpage+$pages_per_bar-1;
			if ($limit > $pages) { $limit = $pages; }
			//echo '$limit='.$limit.' $firstpage ='.$firstpage .' pages='.$pages;
			//if ($firstpage == $limit) 
			{ 
				//$PAGES=''; 
			}
			//else 
			{
				for ($j=$firstpage;$j<=$limit;$j++) 
				{
					if ($j*$item_per_page >= $totalfound) 
					{ 
						$page_n = $totalfound; 
						$pageFrom = $pageTo+1;
						$pageTo =  $totalfound;
					} 
					else 
					{ 
						$pageFrom = ($j*$item_per_page-$item_per_page+1);
						$pageTo = $j*$item_per_page;
						//$page_n = ($j*$item_per_page-$item_per_page+1)."-".$j*$item_per_page; 
					}
					if ($j==$page) 
					{    
						//$xml .= '<'.'CurrentPage'.'>'.$j.'</'.'CurrentPage'.'>' . LB;
						$result['pages']['currentPage'] = $j;
					} 
					else 
					{    
												
					}
					$result['pages']['pagesList'][$j]['pageNumber'] = $j;
					$result['pages']['pagesList'][$j]['pageFirstItem'] = $pageFrom;
					$result['pages']['pagesList'][$j]['pageLastItem'] = $pageTo;
					$result['pages']['pagesList'][$j]['pageLinkPage'] = $j;
					$result['pages']['pagesList'][$j]['pageLinkNext'] = $next;
					
						//$xml .='<'.'Page'.'>' . LB;
							//$xml .='<'.'PageNumber'.'>'.$j.'<'.'/PageNumber'.'>' . LB;
							//$xml .='<'.'PageFirstItem'.'>'.$pageFrom.'</'.'PageFirstItem'.'>' . LB;
							//$xml .='<'.'PageLastItem'.'>'.$pageTo.'</'.'PageLastItem'.'>' . LB;
							//$xml .='<'.'PageLinkPage'.'>'.$j.'</'.'PageLinkPage'.'>' . LB;
							//$xml .='<'.'PageLinkNext'.'>'.$next.'</'.'PageLinkNext'.'>' . LB;
							//$xml .='<plink><![CDATA['.'?page='.$j.$pref."&next=".$next.']]></plink>' . LB;
						//$xml .='</'.'Page'.'>' . LB;				
					
				}
			}
		} 
		else 
		{  // $totalfound < $item_per_page
			$PAGES='';
		}
		//$xml .= '</'.'Pages'.'>' . LB;

		$step = $end-$begin;	
		$result['begin']  = $begin;
		$result['end']  = $end;
		$result['step']  = $step;
	  
	  	//print_r($result);
	  	return $result;
	 // return array (
		//'begin' => $begin,
		//'end' => $end,
		//'step' => $step,	  
		//'xml' => $xml
	 // );
	}

	function _form2SQL($in)
	{
		$dbdef = $this->_dsDef;
		unset($search); $i=0;
		$sqlMode = $in['sqlMode'];
		$retvalxml = '';
		$retvalsearchxml = '<search>' . LB;
		$retvalrowxml = '<row>' . LB;
		$retvalsql = '';
		while (list($table_name,$fields_list)= each($dbdef['t']))
		{
			$table_name = trim($table_name);
			$fields = explode(',',$fields_list); // get all fields for this table in an array
			$retvalxml .= '<'.$table_name.'>' . LB;
			while (list($filed_number,$field_name)= each($fields))
			{
				$field_name = trim($field_name);
				if ($in[$table_name.DTR.$field_name])
				{
					$searchtype = $in[searchtype];
					if ($i>=1){$retvalsql .= ' AND ';}
					if($searchtype[$table_name.DTR.$field_name] == 1)
					{
						if($sqlMode =='full')
						{
							$retvalsql .= $table_name.'.'.$field_name." LIKE '%".$in[$table_name.DTR.$field_name]."'";
						}
						else
						{
							$retvalsql .= $field_name." LIKE '%".$in[$table_name.DTR.$field_name]."'";							
						}
					}
					elseif($searchtype[$table_name.DTR.$field_name] == 2)
					{
						if($sqlMode =='full')
						{
							$retvalsql .= $table_name.'.'.$field_name." LIKE '".$in[$table_name.DTR.$field_name]."%'";
						}
						else
						{
							$retvalsql .= $field_name." LIKE '".$in[$table_name.DTR.$field_name]."%'";							
						}
					}
					elseif($searchtype[$table_name.DTR.$field_name] == 3)
					{
						if($sqlMode =='full')
						{						
							$retvalsql .= $table_name.'.'.$field_name." LIKE '%".$in[$table_name.DTR.$field_name]."%'";
						}
						else
						{
							$retvalsql .= $field_name." LIKE '%".$in[$table_name.DTR.$field_name]."%'";							
						}
					}
					else
					{
						if($sqlMode =='full')
						{									
							$retvalsql .= $table_name.'.'.$field_name."='".$in[$table_name.DTR.$field_name]."'";
						}
						else
						{
							$retvalsql .= $field_name."='".$in[$table_name.DTR.$field_name]."'";							
						}
					}
					
					$retvalxml .= '<'.$field_name.'><![CDATA['.$in[$table_name.DTR.$field_name].']]></'.$field_name.'>' . LB;
					$i++;
				}
			}
			$retvalxml .= '</'.$table_name.'>' . LB;
	
		}
			$retvalsearchxml .= $retvalxml.'</search>' . LB;
			//$retvalrowxml .= $retvalxml.'</row>' . LB;
			//$search['xml'] = $retvalsearchxml;
			//$search['row'] = $retvalrowxml;		
			$search = $retvalsql;
			//echo 'retval='.$retval.'<br>';
			return $search;
	}
	
	function _parseSaveSQL($in,$where,$rights='',$rows='')
	{
		$dsDef = $this->_dsDef;
		$user = $this->_controller->getUser();
		//$sessionIP = $this->_controller->getCurrentSessionIP();
		$this->_rights=$rights;
		//echo 'sessionIP='.$sessionIP;
		$config = $this->_controller->getConfig();
		$dbprefix = $dsDef['con']['SourcePrefix'];
		if(!empty($rows))
		{
			$this->_updateRows = $rows;
		}
		$this->_setDebug('DataSource.parseSaveSQL.start','<font color="green">STARTED</font>');
		while (list($targetName,$targetQuery)= each($where)) 
		{
			$targetTables[] = $targetName;
		}
		$this->_setDebug('DataSource.parseSaveSQL.targetTables',$targetTables);
		if ($in['actionMode'] == 'save')
		{
			if ($in) 
			{ 
				 // 1. list tables from array
				 // 2. create array Table[colums]=value;
				//prepare the array with values for all columns of all alowed tables
				reset($in);
				$rowID =0;
				while (list($varName,$varValue)= each($in)) 
				{
					//print_r($varValue);
					//echo $varValue.'<br>';
					$tmpl=trim($varName);
					$element = explode(DTR, $varName);
					$tableName = $element[0]; $fieldName = $element[1]; 				
		
					//start to prepare saving for multiple list
					$feyNameOfCurrentTableName = $dsDef['k'][$tableName];
					if(is_array($varValue) && $dsDef['langs'][$tableName][$fieldName]=='infield' && !is_array($in[$tableName.DTR.$feyNameOfCurrentTableName]))
					{
						$languageFieldUpdatedInArray = $this->_languageFieldUpdatedInArray;
						$varValue=$this->_getValueForLanguageToSaveFromArray($tableName,$fieldName,$varValue);
						//echo 'afterpars='.$fieldName.' afterparsvalue<textarea>'.$varValue.'</textarea><br>';	
						$languageFieldUpdatedInArray[$tableName.DTR.$fieldName] = 'Y';	
						$this->_languageFieldUpdatedInArray = $languageFieldUpdatedInArray;
					}
					if ( is_array($varValue) && (!is_array($in[$tableName.DTR.$feyNameOfCurrentTableName]) || empty($in[$tableName.DTR.$feyNameOfCurrentTableName]))) 
					{ 
						foreach($varValue as $varValueElement)
						{
							$checkElement  = trim($varValueElement);
							if(!empty($checkElement))
							{
								$varValueResult .= $varValueElement.'|';
							}
						}
						//$varValue = '|'. implode("|",$varValue).'|';
						if(!empty($varValueResult))
						{
							$varValue = '|'.$varValueResult;
						}
						else
						{
							$varValue = ' ';
						}
						$varValueResult='';
					}
					//end to prepare saving for multiple list
					
					if (is_array($varValue))
					{
						while (list($rowNumber,$fieldValue)= each($varValue)) 
						{
							if (in_array($tableName,$targetTables))
							{
								//check if the field is in the definition list
								if(!empty($fieldName))
								{
									if (eregi($fieldName, $dsDef['t'][$tableName]))
									{
										$allRows[$rowNumber][$tableName][$fieldName]=$fieldValue;
									}
								}
							}
						}
					}
					else
					{
						if (in_array($tableName,$targetTables))
						{
							//check if the field is in the definition list
							if(!empty($fieldName))
							{
								if (eregi($fieldName, $dsDef['t'][$tableName]))
								{
									$allRows[0][$tableName][$fieldName]=$varValue;
									//echo 'fielld='.$fieldName.' value<textarea>'.$allRows[0][$tableName][$fieldName].'</textarea><br>';		
								}
							}
						}
						
									
					}
					$varValue='';
				}// end while (list table)

				$this->_setDebug('DataSource.parseSaveSQL.dsDefFields',$dsDef['t']);				
				$this->_setDebug('DataSource.parseSaveSQL.allRows',$allRows);
				if (is_array($targetTables) and is_array($allRows))
				{
					$targetTables=array_unique($targetTables);
					// 3. create sql-query 
					//$wherei=0;					
					while (list($rowNumber,$Alltable)= each($allRows)) 
					{ 
						$this->_setDebug('DataSource.parseSaveSQL.Alltable',$Alltable);
						reset($targetTables);
						while (list($tmp,$table_name)= each($targetTables)) 
						{ 
							if(is_array($Alltable[$table_name]))
							{						 

								$update='';
								$currentTime = date('Y-m-d H:i:s');
								// check if the key name of current table has a value to decide for INSERT or UPDATE
								//echo $table_name.'='.$in[$table_name.DTR.$dsDef['k'][$table_name]].'<hr>';
								$targetKeyName = $dsDef['k'][$table_name];
								if(is_array($in[$table_name.DTR.$targetKeyName]))
								{
									$targetKeyInputValue = $in[$table_name.DTR.$targetKeyName][$rowNumber];
								}
								else
								{
									$targetKeyInputValue = $in[$table_name.DTR.$targetKeyName];
								}
								//echo "update= $table_name - $targetKeyName = ".$targetKeyInputValue."<hr>";								
								if (!empty($targetKeyInputValue)) 
								{
									$update = 1;
									$targetKeyValue = $targetKeyInputValue;
									//save TimeSaved globaly
									if(eregi('TimeSaved', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['TimeSaved'] = $this->setFormated($currentTime,$table_name,'TimeSaved',$dsDef);
									}									
									if(eregi('IPSaved', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['IPSaved'] = $sessionIP;
									}										
									//$this->_setDebug('DataSource.parseSaveSQL.updatemode',$table_name.DTR.$dsDef['k'][$table_name].'='.$in[$table_name.DTR.$dsDef['k'][$table_name]]);							
								}
								else
								{
									if($dsDef['ktype'][$table_name]=='unique')
									{
										$targetKeyValue =  $this->_controller->getUniqueID();
									}
									$Alltable[$table_name][$targetKeyName] = $targetKeyValue; 
									if(eregi('TimeCreated', $dsDef['t'][$table_name]))
									{
										//$Alltable[$table_name]['TimeCreated'] = $this->_transformFormat($table_name,'TimeCreated',$currentTime);
										$Alltable[$table_name]['TimeCreated'] = $this->setFormated($currentTime,$table_name,'TimeCreated',$dsDef);
									}
									if(eregi('TimeSaved', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['TimeSaved'] = $this->setFormated($currentTime,$table_name,'TimeSaved',$dsDef);
									}									
									if(eregi('IPCreated', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['IPCreated'] = $sessionIP;
									}
									if(eregi('IPSaved', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['IPSaved'] = $sessionIP;
									}																
									if(eregi('TimeStart', $dsDef['t'][$table_name]))
									{
										//$Alltable[$table_name]['TimeStart'] = $this->_transformFormat($table_name,'TimeStart',$currentTime);
										if(empty($Alltable[$table_name]['TimeStart']))
										{
											$Alltable[$table_name]['TimeStart'] = $this->setFormated($currentTime,$table_name,'TimeStart',$dsDef);
										}
										else
										{
											$Alltable[$table_name]['TimeStart'] = $this->setFormated($Alltable[$table_name]['TimeStart'],$table_name,'TimeStart',$dsDef);
										}
									}																		
									if(eregi('PermUser', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['PermUser'] = '3';
									}
									if(eregi('PermOwner', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['PermOwner'] = '3';
									}
									if(eregi('PermAll', $dsDef['t'][$table_name]))
									{
										if(empty($Alltable[$table_name]['PermAll']))
										{
											$Alltable[$table_name]['PermAll'] = '4';
										}
									}
									//save OwnerID globaly
									if(eregi('OwnerID', $dsDef['t'][$table_name]))
									{
										$Alltable[$table_name]['OwnerID'] = $config['OwnerID'];//torefact0:
									}																																				

								}
								//save UserID globaly
								if(eregi('IPSaved', $dsDef['t'][$table_name]))
								{
									if(!$this->_controller->hasRights('admin'))
									{									
										$Alltable[$table_name]['IPSaved'] = $sessionIP;
									}
								}								
								if(eregi('UserID', $dsDef['t'][$table_name]))
								{
									if(empty($Alltable[$table_name]['UserID']))
									{
										if ($user['UserID'])
										{
											if(!$this->_controller->hasRights('admin'))
											{
												$Alltable[$table_name]['UserID'] = $user['UserID'];
											}
											elseif($update<>1)
											{
												$Alltable[$table_name]['UserID'] = $user['UserID'];
											}
										}
										else
										{
											if ($table_name <> 'User')
											{
												$Alltable[$table_name]['UserID'] = '1';
											}
										}
									}
								}
								if(eregi('AdminID', $dsDef['t'][$table_name]))
								{
									if ($this->_controller->hasRights('admin'))
									{
										$Alltable[$table_name]['AdminID'] = $user['UserID'];
									}
								}	
								//print_r($controller);
								if ($this->_controller->hasRights($table_name.'.update') or $rights == 'insert' or $rights == 'update')
								{
									$this->_setDebug('DataSource.parseSaveSQL.CurrentTable',$table_name);
									//#---- Insert 
									$sql_insert ="INSERT INTO ".$dbprefix."$table_name ( ";
									$sql_insert_val="";
									//#---- Update
									$sql_update ="UPDATE ".$dbprefix."$table_name set ";
									$sql_update_val="";
									$Num_count_tble= count($Alltable[$table_name]);
									$i=0;
									while (list($column,$Value)= each($Alltable[$table_name]))
									{
										if(!empty($column))
										{
										if(eregi($column, $dsDef['t'][$table_name]))
										{
											//echo 'column'.$column.'  value=<textarea>'.$Value.'</textarea><br>';
											$i++;
											//$testValueAsInt = (int) $Value;
											//if($testValueAsInt===0)
											//{
												//echo 'field: '.$column.' = '.$Value.'<hr>';
											//}
											if (!empty($Value) || $Value===0)
											{
												if(is_string($Value))
												{
													if (!trim($Value)) {$Value = '';}
												}
												if(!empty($Value) || $Value===0) 
												{
													//transform the time
													if(empty($wherei[$table_name])){$whereiii = 0;}
													else {$whereiii = $wherei[$table_name];}													
													$Value = $this->_transformFormat($table_name,$column,$Value,$whereiii);
												}
												if (function_exists('module_savetransform'))
												{
													//torefact0
													//do transformation here
													//$Value = module_savetransform($column,$Value);
												}// end of if (function_exists('tpltransform_tpl'))
														
												$sql_tmp_ins="";
												$sql_tmp_upd="=";
												if ($i<>$Num_count_tble){$sql_tmp_ins=",";}
												$sql_insert .= $column . $sql_tmp_ins;
												$sql_insert_val .="'" .$Value ."'" . $sql_tmp_ins;           
												$sql_update .=$column . $sql_tmp_upd . "'" .$Value ."'" . $sql_tmp_ins;
											}// end of if (!empty($Value))
										}//if(eregi($column, $dsDef['t'][$table_name]))
										}
									}   //end while (list($column,$Value)= each($Alltable[$table_name]))
									//echo "_#_".$update."_#_";
									if  (!$update)
									{
										if (substr($sql_insert, (strlen($sql_insert)-1)) ==','){$sql_insert = substr($sql_insert, 0, (strlen($sql_insert)-1));}
										if (substr($sql_insert_val, (strlen($sql_insert_val)-1)) ==','){$sql_insert_val = substr($sql_insert_val, 0, (strlen($sql_insert_val)-1));}
										$sql_insert .=" ) Values ( " .  $sql_insert_val ."  )";
										$result=1;
										$this->_setDebug('DataSource.parseSaveSQL.sql_insert',"<font color=green><b>" .$sql_insert ."</b></font>");																	
									} 
									else
									{
											//#--- Add where if update
										if (substr($sql_update, (strlen($sql_update)-1)) ==','){$sql_update = substr($sql_update, 0, (strlen($sql_update)-1));}
										if ($where)  
										{
											//echo $sql_update.'<br>';
											if ($where[$table_name]) 
											{
												if(is_array($where[$table_name]))
												{
													if(empty($wherei[$table_name])) {$whereii=0;}
													else {$whereii=$wherei[$table_name];}
													$sql_update  .= " WHERE " .$where[$table_name][$whereii];
													$wherei[$table_name]++;
												}
												else
												{
													$sql_update  .= " WHERE " .$where[$table_name];
												}
												$result=1;
											}
										}
										if  ((!($where) ) && $update)
										{
											$this->_setDebug('DataSource.parseSaveSQL.update_error',"<font color=red>Error in parameters:in(array),where(array),dsDef(array)</font>");								
											$result=0;
										}
										$this->_setDebug('DataSource.parseSaveSQL.sql_update',"<font color=green><b>" .$sql_update ."</b></font>");								
									}
									if ($result==1)
									{
										//if  (!$update){$sqlresult = coredb_query($sql_insert); $lastidresult = coredb_lastid(); $retval[$table_name] = $lastidresult;}
										if  (!$update)
										{
											$QueryResult['query'][]=$sql_insert;
											$actionResultType = 'insert';
										}
										else
										{
											$QueryResult['query'][]=$sql_update;
											$actionResultType = 'update';
										}
										
										$QueryResult['action'][] = $actionResultType;
										$QueryResult['table'][] = $table_name;
										$QueryResult['keyField'][] = $targetKeyName;
										$QueryResult['keyValue'][] = $targetKeyValue;
										//if  ($update){coredb_query($sql_update); $retval[$table_name] = '';}
									}
								}// if (coreses_hasrights($table_name.'.update') or $rights == 'all')
								else
								{
									$this->_controller->setMessage('DataSource.parseSaveSQL.err.NoUpdateRights');
								} 
							}// end if if(is_array($Alltable[$table_name]))                   															
						}// end of while (list($tmp,$table_name)= each($targetTables))
					} //end of while (list($rowNumber,$Alltable)= each($allRows)) 
				}// end of if ($targetTables)
			}// end if ($in)
			else
			{
				$this->_setDebug('DataSource.parseSaveSQL.err_noinput',"<font color=red><b>No input data has been found</b></font>");
				$result=0;
				return false;
			}			
		} // end if ($in[actionMode] == 'save' or $in[actionMode] == 'insert')
		elseif ($in['actionMode'] == 'delete')
		{
			$this->_setDebug('DataSource.parseSaveSQL.deleteMode','DELETE STARTS');
			while (list($targetTableNumber,$targetTableName)= each($targetTables)) 
			{
				if ($this->_controller->hasRights($targetTableName.'.delete') or $rights == 'delete')
				{
					$targetKeyName= $dsDef['k'][$targetTableName];
					$targetKeyValue = $in[$targetTableName.DTR.$targetKeyName];
					if ($targetKeyValue)
					{
						if (is_array($targetKeyValue))
						{
							while (list($targetRowNumber,$targetKeyValue2)= each($targetKeyValue)) 
							{
								$queryDelete = "DELETE FROM ".$dbprefix."$targetTableName WHERE $targetKeyName='$targetKeyValue2'";
								$QueryResult['query'][] = $queryDelete;
								$this->_setDebug('DataSource.parseSaveSQL.queryDelete',"<font color=green><b>" .$queryDelete ."</b></font>");									
								$QueryResult['table'][] = $targetTableName;
								$QueryResult['keyField'][] = $targetKeyName;
								$QueryResult['keyValue'][] = $targetKeyValue2;												
							}
						}
						else
						{
								$queryDelete = "DELETE FROM ".$dbprefix."$targetTableName WHERE $targetKeyName='$targetKeyValue'";
								$QueryResult['query'][] = $queryDelete;
								$this->_setDebug('DataSource.parseSaveSQL.queryDelete',"<font color=green><b>" .$queryDelete ."</b></font>");								
								$QueryResult['table'][] = $targetTableName;
								$QueryResult['keyField'][] = $targetKeyName;
								$QueryResult['keyValue'][] = $targetKeyValue;												
						}
					}//end of if ($in[$targetTableName.DTR.$targetKeyName])
				}
				else
				{
					//echo 'trying to delete the table:'.$targetTableName.'<br/>';
					$this->_controller->setMessage('DataSource.parseSaveSQL.err.NoDeleteRights');
				}
			}// end of while (list($targetTableNumber,$targetTableName)= each($targetTables))
		}// end of elseif ($in['actionMode'] == 'delete')
		$this->_setDebug('DataSource.parseSaveSQL.QueryResult',$QueryResult);
		$this->_setDebug('DataSource.parseSaveSQL.end','<font color="green">END</font>');		
		$this->_queriesSQL = $QueryResult;
		return $QueryResult;
	}

	function _getUpdatingRows($in,$where)
	{
		$dsDef = $this->_dsDef;
		foreach ($where as $targetTableName=>$whereString)
		{
			$keyFieldName = $dsDef['k'][$targetTableName];
			$keyFieldValue = $in[$targetTableName.DTR.$keyFieldName];
			if(!empty($keyFieldValue))
			{
				//we have updating function now .. so let's get the row
				if(is_array($whereString))
				{
					foreach ($whereString as $whereStringFromArray)
					{
						$sql = "SELECT * FROM $targetTableName WHERE $whereStringFromArray";
						$rs = $this->query($sql);
						$result[$targetTableName][] = $rs[0];
					}
				}
				else
				{
					$sql = "SELECT * FROM $targetTableName WHERE $whereString";
					$rs = $this->query($sql);
					$result[$targetTableName][0] = $rs[0];
				}					
			}
		}
		return $result;						
	}

	function _getValueForLanguageToSave($tableName,$fieldName,$fieldValue,$wherei)
	{
		$lang = $this->_language;
		//get current value of the language field in the database
		//$lang = 'en';
		//$fieldValue = nl2br($fieldValue);
		//echo 'tttt='.$fieldName;
		$languageFieldUpdatedInArray = $this->_languageFieldUpdatedInArray;		
		if($languageFieldUpdatedInArray[$tableName.DTR.$fieldName]!='Y')
		{
			if(!eregi('<'.$lang.'>',$fieldValue))
			{
				$rows = $this->_updateRows;
				$row = $rows[$tableName][$wherei];
				$currentValue = $row[$fieldName];
				//print_r($row);
				//update the field with language
				if(!empty($currentValue))
				{
					$currentValue = addslashes ($currentValue);
					$currentValue = eregi_replace('<'.$lang.'></'.$lang.'>',"",$currentValue);
					$currentValue = str_replace('<'.$lang.'> </'.$lang.'>',"",$currentValue);
					$languageValue = $this->_controller->getValue($currentValue,$lang);
					//@preg_match ("/<".$lang.">(.*)<\/".$lang.">/i", $currentValue, $resultValue);
					if(!empty($languageValue))
					{
						//update mode for an existing language
						//echo 'transforming language: '.$lang;
						//$otherLanguages = preg_replace("/<".$lang.">".$resultValue[1]."<\/".$lang.">/i", "", $currentValue);
						$otherLanguages = str_replace("<".$lang.">".$languageValue."</".$lang.">", "", $currentValue);
						//echo 'currentValue='.$currentValue.'<br>';
						//echo 'otherLanguages='.$otherLanguages.'<br>';	
						$result = $otherLanguages .'<'.$lang.'>'.$fieldValue.'</'.$lang.'>';
					}
					else
					{
						//update mode  for not existing language
						$result = $currentValue.'<'.$lang.'>'.$fieldValue.'</'.$lang.'>';
					}
				}
				else
				{
					//insert mode
					$result = '<'.$lang.'>'.$fieldValue.'</'.$lang.'>';
				}
	
				$result = str_replace('<'.$lang.'></'.$lang.'>'," ",$result);
				$result = str_replace('<'.$lang.'> </'.$lang.'>'," ",$result);	
				//echo('fieldName=<textarea>'.$fieldValue.'</textarea>');
				//echo 'resultAllNoArrayTransfrom11=<textarea>'.$result.'</textarea><hr>';
				return $result;
			}
			else
			{
				$fieldValue = str_replace('<'.$lang.'></'.$lang.'>'," ",$fieldValue);
				$fieldValue = str_replace('<'.$lang.'> </'.$lang.'>'," ",$fieldValue);	
				//echo('fieldName=<textarea>'.$fieldValue.'</textarea>');		
				return $fieldValue;
			}
		}
		else
		{
			return $fieldValue;
		}
		
	}

	function _getValueForLanguageToSaveFromArray($tableName,$fieldName,$fieldValue)
	{
		//$lang = $this->_language;
		//get current value of the language field in the database
		//$lang = 'en';
		//$fieldValue = nl2br($fieldValue);
		$rows = $this->_updateRows;
		$row = $rows[$tableName][0];
		$currentValue = $row[$fieldName];
		$fieldValueStart = $fieldValue;
		//update the field with language
		//print_r($fieldValue);
		//echo 'fieldName=<textarea>'.$currentValue.'</textarea><hr>';
		
		foreach($fieldValue as $lang=>$currentFieldValue)
		{
			//$testCurrentFieldValue = trim($currentFieldValue);
			//if(empty($testCurrentFieldValue)) {$currentFieldValue='';}
			if(!empty($lang) && strlen($lang)<3)
			{
				if(!empty($currentValue))
				{
					//$currentValue = str_replace('"','&quot;',$currentValue);
					$currentValue = addslashes (stripslashes($currentValue));
					$currentValue = str_replace('<'.$lang.'></'.$lang.'>',"",$currentValue);
					$currentValue = str_replace('<'.$lang.'> </'.$lang.'>',"",$currentValue);
					$languageValue = $this->_controller->getValue($currentValue,$lang);
					if(!empty($languageValue))
					{
						//update mode for an existing language
						//echo 'transforming language: '.$lang;
						$languageValue = addslashes (stripslashes($languageValue));
						$otherLanguages = str_replace("<".$lang.">".$languageValue."</".$lang.">", "", $currentValue);
						//echo 'currentValue['.$lang.']=<textarea>'.$currentValue.'</textarea><hr>';
						//echo 'languageValue['.$lang.']=<textarea>'."<".$lang.">".$languageValue."</".$lang.">".'</textarea><hr>';
						//echo 'otherLanguages['.$lang.']=<textarea>'.$otherLanguages.'</textarea><hr>';	
						//echo 'currentFieldValue['.$lang.']=<textarea>'.$currentFieldValue.'</textarea><hr>';	
						$result = $otherLanguages .'<'.$lang.'>'.$currentFieldValue.'</'.$lang.'>';
						//echo 'result['.$lang.']=<textarea>'.$result.'</textarea><hr>';
					}
					else
					{
						//update mode for not existing language
						$result = $currentValue.'<'.$lang.'>'.$currentFieldValue.'</'.$lang.'>';
					}
				}
				else
				{
					//insert mode
					$result = '<'.$lang.'>'.$currentFieldValue.'</'.$lang.'>';
				}
				$currentValue = $result;
			}
		}
		
		foreach($fieldValueStart as $lang=>$currentFieldValue)
		{
			$result = str_replace('<'.$lang.'></'.$lang.'>'," ",$result);
			$result = str_replace('<'.$lang.'> </'.$lang.'>'," ",$result);
		}		
		//die('fieldName=<textarea>'.$result.'</textarea>');
		//echo 'resultAll=<textarea>'.$result.'</textarea><hr>';
		return $result;
	}
	
	function _transformFormat($tableName,$fieldName,$fieldValue,$wherei='')
	{
		$dsDef = $this->_dsDef;
		$config = $this->_controller->getConfig();
		$input = $this->_controller->getInput();
		$lang = $this->_language;
		if($this->_rights=='noformat')
		{
			return $fieldValue;
		}		
		if($fieldName == 'TimeCreated' || $fieldName == 'TimeSaved' || $fieldName == 'TimeStart' || $fieldName == 'TimeEnd')
		{
			$DataType = new DateTimeDataType(&$this->_controller);
			return $DataType->setDataType($fieldValue,$tableName,$fieldName,$wherei);			
		}
		else
		{
			if($dsDef['types'][$tableName][$fieldName] == 'datetime')
			{
				$DataType = new DateTimeDataType(&$this->_controller);
				return $DataType->setDataType($fieldValue,$tableName,$fieldName,$wherei);							
			}
			elseif($dsDef['types'][$tableName][$fieldName] == 'text')
			{
				$fieldValue = $this->_getTextFieldToSave($fieldValue);
				$result = $this->_getValueForLanguageToSave($tableName,$fieldName,$fieldValue,$wherei);
				return $result;
			}
			elseif($dsDef['types'][$tableName][$fieldName] == 'char')
			{
				$result = $this->_getValueForLanguageToSave($tableName,$fieldName,$fieldValue,$wherei);
				return $result;
			}	
			elseif($dsDef['types'][$tableName][$fieldName] == 'html')
			{
				$fieldValue = $this->_getHtmlFieldToSave($fieldValue);
				$result = $this->_getValueForLanguageToSave($tableName,$fieldName,$fieldValue,$wherei);
				return $result;
			}
			elseif($dsDef['types'][$tableName][$fieldName] == 'xml')
			{
				$result = str_replace("&lt;","<",$fieldValue);
				$result = str_replace("&gt;",">",$result);
				return $result;
			}
			elseif(!empty($dsDef['types'][$tableName][$fieldName]))
			{
				eval('$DataType = new '.$dsDef['types'][$tableName][$fieldName].'DataType(&$this->_controller);');
				$fieldValue=$DataType->setDataType($fieldValue,$tableName,$fieldName,$wherei);
			}						
			if(!empty($dsDef['langs'][$tableName][$fieldName]))
			{
				if($dsDef['langs'][$tableName][$fieldName]=='infield')
				{
					$fieldValue=$this->_getValueForLanguageToSave($tableName,$fieldName,$fieldValue,$wherei);
				}
			}
			return $fieldValue;			
		}
	}	
	
	function getAccessFilter($input,$right,$mode='')
	{
		$filterMode = $mode['mode'];
		$accessField = $mode['accessField'];
		if(empty($accessField)) {$accessField='AccessGroups';}
		$statusField = $mode['statusField'];
		if(empty($statusField)) {$statusField='PermAll';}		
		if($filterMode=='groups')
		{
			$user = $this->_controller->getUser();
			if(!empty($user['GroupID']))
			{
				$filter = " AND AccessGroups NOT LIKE '%|hideforloggedin|%' ";
				$groupFilter = " OR $accessField LIKE '%|".$user['GroupID']."|%' ";
			}
			$filter .= " AND ".$statusField."=1 AND ($accessField LIKE '%|all|%' $groupFilter OR ".$accessField."='' OR $accessField IS NULL) ";
			return $filter;
		}
	}
		
	function getFormated($elementValue,$table,$fieldName,$dsDef='')
	{
		$config = $this->_controller->getConfig();
		$input = $this->_controller->getInput();
		if($this->_rights=='noformat')
		{
			return $elementValue;
		}
		//get language dependence
		if(!empty($dsDef['langs'][$table][$fieldName]))
		{
			if($dsDef['langs'][$table][$fieldName]=='infield')
			{
				$elementValue=$this->_controller->getLanguageFieldValue($elementValue);
			}
		}
		switch ($fieldName) { 

		   case 'TimeCreated': 
		   				$DataType = new DateTimeDataType(&$this->_controller);
						return $DataType->getDataType($elementValue);
			break; 
		   case 'TimeSaved': 
		   				$DataType = new DateTimeDataType(&$this->_controller);
						return $DataType->getDataType($elementValue);
			break; 
		   case 'TimeStart': 
		   				$DataType = new DateTimeDataType(&$this->_controller);
						return $DataType->getDataType($elementValue);
			break;
		   case 'TimeEnd': 
		   				$DataType = new DateTimeDataType(&$this->_controller);
						return $DataType->getDataType($elementValue);
			break;
		   case 'UserID': 
						return trim($elementValue);
			break;		
		   case 'OwnerID': 
						return trim($elementValue);
			break;	
		   case 'AdminID': 
						return trim($elementValue);
			break;						 
			default:
					if($dsDef['types'][$table][$fieldName] == 'datetime')
					{
		   				$DataType = new DateTimeDataType(&$this->_controller);
						return $DataType->getDataType($elementValue);
					}
					elseif($dsDef['types'][$table][$fieldName] == 'text')
					{
						return $this->getLanguageFieldValue($elementValue);
					}
					elseif($dsDef['types'][$table][$fieldName] == 'html')
					{
						return $this->getLanguageFieldValue($elementValue);
					}					
					elseif(!empty($dsDef['types'][$table][$fieldName]))
					{
		   				eval('$DataType = new '.$dsDef['types'][$table][$fieldName].'DataType(&$this->_controller);');
						return $DataType->getDataType($elementValue);
					}					
					else
					{
						return $elementValue;
					}
			break;									
		}
	}
	function setFormated($elementValue,$table,$fieldName,$dsDef='')
	{
		$config = $this->_controller->getConfig();
		switch ($fieldName) { 

		   case 'TimeCreated': 
	   				$DataType = new DateTimeDataType(&$this->_controller);
					return $DataType->setDataType($elementValue);
			break; 
		   case 'TimeSaved': 
	   				$DataType = new DateTimeDataType(&$this->_controller);
					return $DataType->setDataType($elementValue);
			break; 
		   case 'TimeStart': 
	   				$DataType = new DateTimeDataType(&$this->_controller);
					return $DataType->setDataType($elementValue);
			break;
		   case 'TimeEnd': 
	   				$DataType = new DateTimeDataType(&$this->_controller);
					return $DataType->setDataType($elementValue);
			break; 
			default:
					if($dsDef['types'][$table][$fieldName] == 'datetime')
					{
		   				$DataType = new DateTimeDataType(&$this->_controller);
						return $DataType->setDataType($elementValue);
					}
					elseif($dsDef['types'][$table][$fieldName] == 'text')
					{
						return $this->getLanguageFieldValue($elementValue);
					}
					elseif($dsDef['types'][$table][$fieldName] == 'html')
					{
						return $this->getLanguageFieldValue($elementValue);
					}					
					else
					{
						return $elementValue;
					}
			break;									
		}
	}
	
	function getLanguageFieldValue($elementValue)
	{
		return $this->_controller->getLanguageFieldValue($elementValue);
		//$lang = $this->_language;
	}
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function DataSource($dbID)
	{
		global $CORE, $databaseDefinition;
		$this->_controller = &$CORE;
		$config = $CORE->getDBConfig($dbID);
		$setting = $CORE->getConfig();
		$this->_host = $config['host'];
		$this->_user = $config['user'];		
		$this->_pass = $config['password'];		
		$this->_name = $config['name'];
		$this->_dsDef = $databaseDefinition;
		$this->_connect();
		$this->_language = $setting['lang'];
		//$this->DataSource($dsDef,&$this->_controller);
	}
	// PUBLIC METHODS
	function query($sql,$mode='')
	{
		//$XCMSQuery = str_replace("\n","",$XCMSQuery);
		$resultMode = $mode['resultMode'];
		$pagesMode = $mode['pagesMode'];
		$pagesCount = $mode['pagesCount'];
		
		$config = $this->_getConfig();
		$currentLanguage = $config['SiteLang'];
		$dsDef = $this->_dsDef;
		
		$query['query'] = $sql;
		//echo $sql.'<hr>';
		/*$parsedSQL = $this->_parseSQLQuery($query['query']);
		$query['tables'] = $parsedSQL['from'];
		$query['where'] = $parsedSQL['where'];
		$query['join'] = $parsedSQL['from'];
		$query['query']  = $parsedSQL['query'];

		$query['where'] = eregi_replace ("{ls}","<$currentLanguage>",$query['where']);
		$query['where'] = eregi_replace ("{le}","</$currentLanguage>",$query['where']);
		$query['query'] = eregi_replace ("{ls}","<$currentLanguage>",$query['query']);
		$query['query'] = eregi_replace ("{le}","</$currentLanguage>",$query['query']);
		*/
		//pages spliting
		if(!empty($pagesMode))
		{
				if(empty($pagesCount))
				{
					$numRows = $this->dbCount($query['join'],$query['where']);
				}
				else
				{
					$numRows=$pagesCount;
				}
				//echo 'numRows='.$numRows.'<br>';
				if(is_numeric ($pagesMode))
				{
					$maxPages = $pagesMode;
				}
				else
				{
					$maxPages = '';
				}
				$pages = $this->_getPages($numRows,$maxPages);
				$query['query'] = $query['query'] . ' LIMIT '.$pages['begin'].','.$pages['step'];
			//torefact1: calculate the limit for the query to split it in the pages
		//echo 'query='.$query['query'].'<br>';
		}
		$result = $this->_query($query['query']);
		//$intables = $query['tables'];
		//if($result) echo 'results<br>';	
		while($row=$this->dbFetch($result))
		{
			//echo 'results<br>';
			if($resultMode=='xml')
			{
				$xmlResult = $this->SQL2XML($row,$intables,$xmlResult2,$in['Transformation']);
				$xmlResult2 = $xmlResult;
			}
			$retval[] = $row;
			//print_r($row);
			//echo LB . '<br>'.'<br>'.$xmlResult['startXML'].'<br><br>' . LB . LB . LB;
			//$retval['sql'][] = $this->getValueForLanguage($elementValue);
		}
		return $retval;		
	}
	
	function save($in,$where,$rights='')
	{
		$dsDef = $this->_dsDef;
		//$queryObject = new XCMSParser($dsDef,&$this->_controller);
		//get updating rows if it is updating function now. The row is needed for optimization of the language transformation
		//print_r($in);
		$rows = $this->_getUpdatingRows($in,$where);
		
		$query = $this->_parseSaveSQL($in,$where,$rights,$rows);
		
	//	print_r($query);
		
		if ($in['actionMode']=='save')
		{ 
			if(!empty($query['query']))
			{
				$i=0;
				while (list($queryNumber,$querySQL)= each($query['query'])) 
				{
					//update or insert query
					$this->_setDebug('MySQLSource.dsSave.SaveQuerySQL',$querySQL);
//					echo $querySQL;
					$this->_query($querySQL);
		
					if($query['action'][$i]=='insert' && empty($query['keyValue'][$i]))
					{
						$query['keyValue'][$i] = $this->dbLastID();
					}
					
					//select inserted or updated rows
					$selectQuery = "SELECT * FROM ".$query['table'][$i]." WHERE ".$query['keyField'][$i]."='".$query['keyValue'][$i]."'";
					
					//$this->_setDebug('MySQLSource.dsSave.selectQuery',$selectQuery );
					$result = $this->query($selectQuery);
					//print_r($result);
					$retval[] = $result[0];
					$this->_setDebug('MySQLSource.dsSave.selectResult',$result);
					$i++;
					
				}
				$this->_setDebug('MySQLSource.dsSave.EndSave','END_SAVE');
			  return $retval;
			}
			else
			{
				$this->_setDebug('MySQLSource.dsSave.End','END_FALSE');			
				return false;
			}
		}
		elseif($in['actionMode']=='delete')
		{ 
			if(!empty($query['query']))
			{
				$i=0;
				//$query = "DELETE ";
				$this->_query($query['query'][0]);
				//while (list($queryNumber,$querySQL)= each($query['query'])) 
				//{
					//$this->_deleteSlave($query['table'][$i],$query['keyField'][$i],$query['keyValue'][$i]);
					//$i++;
				//}
				$this->_setDebug('MySQLSource.dsSave.EndDelete','END_DELETE');
				return $retval;
			}
			$this->_setDebug('MySQLSource.dsSave.EndDelete','END_FALSE_DELETE');						
			return false;
		}
  
  }
	
	function dbDelete()
	{
	}

	function dbGetItem($table,$what,$selection='') 
	{
		if (!empty($selection)) {
			$sql = "SELECT $what FROM $table WHERE $selection";
			$result = $this->_query($sql);
		} else {
			$result = $this->_query("SELECT $what FROM $table");
		}
		$ITEM = $this->dsFetch($result);
		return $ITEM[0];
	}
	function dbNumRows($recordset)
	{
		return @mysql_numrows($recordset);
	}
	function dbNumFields($recordset)
	{
			return @mysql_numfields($recordset);
	}		
	function dbFieldName($recordset,$fnumber)
	{
			return @mysql_fieldname($recordset,$fnumber);
	}
	function dbFields($tablename)
	{
		global $coredb_conf, $coredb_xconnection;
			// Connect to database server
			$db = $this->_connection;
			$fields = mysql_list_fields($this->_name, $tablename, $db);
			$columns = mysql_num_fields($fields);
			for ($i = 0; $i < $columns; $i++) {
			 $retval[$i] = mysql_field_name($fields, $i);
			}
		return $retval;
	}

	function dbFetch($recordset,$mode='')
	{
		$retval = @mysql_fetch_assoc($recordset);
		return $retval;
	}
	function dbLastID($recordset='')
	{
			if (empty($recordset)) {
				$lastid =  mysql_insert_id();
				//echo 'lastid='.$lastid;
				 return $lastid;
			} else {
				$lastid = mysql_insert_id($recordset);
				return $lastid;
			}
	}
	function dbCount($tables,$where)
	{ 
		if ($where and $tables) 
		{
			$query = "SELECT COUNT(*) FROM $tables WHERE $where";
		} 
		if(!$where and $tables) 
		{
			$query = "SELECT COUNT(*) FROM $tables ";
		} 
		if ($tables) 
		{    
			$result = $this->_query($query);
		} 
		return ($this->dbResult($result,0)); 
	} 

	
    function dbResult($recordset,$row,$field=0)
    {
		return @mysql_result($recordset,$row,$field);
    }			

	function getLimitSyntax($limit)
	{
		return' LIMIT '. $limit;
	}
	
	function getOrderSyntax($order,$mode)
	{
		if($mode=='desc')
		{
			return ' ORDER BY '. $order . ' DESC';
		}
		else
		{
			return ' ORDER BY '. $order . ' ASC';
		}
	}	
	
	function getGroupSyntax($group)
	{
		return ' GROUP BY '. $group;
	}
	
	function getSourceDefinition()
	{
		return $this->_dsDef;
	}
	
	function makeSearchQuery($input)
	{
		$dsDef = $this->_dsDef;
		//$queryObject = new XCMSParser($dsDef,&$this->_controller);
		return $this->_form2SQL($input);
	}
}// end of ClassName
?>
