<?

function makeReports()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	//creat objects			
	$statsObject = new StatsClass();
	$statsObject->updateStatsSitelist();
	$StatsSiteResult = $DS->query("SELECT * FROM StatsSite");
	
	$modulePath = dirname(ereg_replace("\\\\","/",__FILE__));
	$reportspath = $modulePath.'/reports';
	
	foreach($StatsSiteResult as $siteRow)
	{
		$siteID = $siteRow['site_id'];
		$siteName = $siteRow['name'];
		if(!empty($siteName))
		{
			//monitor site
			/*
			if($siteRow['monitorsite'] == 'Y')
			{
				cron_monitorSite($siteID);
			}
			*/
			//get the list of available reports
			if ($dir = @opendir($reportspath)) 
			{
				while (($file = readdir($dir)) !== false) 
				{
					$filepath = $reportspath.'/'.$file;
					if(is_file($filepath))
					{
						//check the status of this report for this site
						$statusSQL = "SELECT status, hitid FROM StatsStatus WHERE siteid = '$siteID' AND reportid = '$file'"; 
						$statusRS = $DS->query($statusSQL);
						$S= $statusRS[0]; $status = $S['status'];
						if($status <> 'Y')
						{
							if(count($statusRS) > 0)
							{
								$DS->query("UPDATE StatsStatus SET status='Y' WHERE siteid = '$siteID' AND reportid = '$file'");
								$startHitID = $S['hitid'];
							}
							else
							{
								//find starting hit id for this site
								$startSQL = "SELECT id FROM StatsStatus WHERE siteid = '".$siteID."' LIMIT 0,1"; 
								$startRS = $DS->query($startSQL);
								$SS= $startRS[0]; $startHitid = $SS['hitid'];
								$DS->query("INSERT INTO StatsStatus (status,siteid,reportid,hitid) VALUES ('Y','$siteID','$file','$startHitid')");					
								$startHitID = $startHitid-1;
							}
							include_once($filepath);
							//echo 'hitid='.$startHitID.'<br>';
							$main_query = "SELECT * FROM StatsRecord WHERE id > '".$startHitID."' AND website='".$siteName."'"; 
							$main_result = $DS->query($main_query);
							if (count($main_result)>0) 
							{
								foreach($main_result as $current_row)
								{
									//echo 'd='.$current_row['filename'].'<br>';
									run_report($current_row,$siteID);						
									$currenttime = date("Y-m-d h:i:s");
									$DS->query("UPDATE StatsStatus SET hitid = ".$current_row['id'].", datetime = '$currenttime' WHERE siteid = '$siteID' AND reportid = '$file'");
									//echo $i.'- ';	
								}//end of while ($current_row = coredb_fetch($main_result))			
							}//end of if (coredb_numrows($main_result)>0)
							//echo "$filepath<br>";
							$DS->query("UPDATE StatsStatus SET status='N' WHERE siteid = '$siteID' AND reportid = '$file'");										
						}//end of if($status <> 'Y')
					}// end of if(is_file($filepath))
				}  //end of while (($file = readdir($dir)) !== false) 
				closedir($dir);
			}
		}
		
	}
	
}

function getReport()
{

	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	
	$CORE->callService('makeReports','statsServer',$input);
	//creat objects			
	$statsObject = new StatsClass();

	$rs = 	$statsObject->getReport($input);
	$result['Report'] = $rs;
	
	$StatsReportsRS = $statsObject->getStatsReports($input);
	$result['DB']['StatsReports'] = $StatsReportsRS;
	
	
	//print_r($result['Report']);
	return $result;
}

function manageStatsReports()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityID = $input['StatsReportID'];

	//creat objects			
	$statsObject = new StatsClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$statsObject->deleteStatsReport($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$statsObject->setStatsReport($input);
	}
	
	$StatsReportsRS = $statsObject->getStatsReports($input);
	$result['DB']['StatsReports'] = $StatsReportsRS;
	
	if(!empty($entityID))
	{
		$result['DB']['StatsReport'] = $statsObject->getStatsReport($input);
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function output($query,$report) {
	global $page,$results, $core_conf;
	if(empty($report)) {$report = "global_StatsHitsPerHour";}
	if (!empty($date_from)&&$date_from != $_date_from) $_date_from = $date_from;
	if (!empty($date_to)&&$date_to != $_date_to) $_date_to = $date_to;

	
	if ($report=='global_StatsHitsPerHour'||$report=='hits') {
		## HITS hourly and daily output 
			$row = coredb_fetch(coredb_query($query[2])); 
			$all = $row[all_value];
			$result = coredb_query($query[1]); 
			$amount = coredb_numrows($result);
		if ($amount > 0) {			
			$i = 0;
			$print = '<br><b>Total hits: '.$all.'</b><br>';
			$print .= '<br><b>Daily summary</b><br>';
			$print .= '<table border=0 width="100%">';
			while ($row = @coredb_fetch($result)) {
				$percent = round(($row[amount]/$all)*100,2);
				// daily hits output
				$ic = $i/2;
				if($ic == round($ic)){$className = 'rowoff';} else {$className = 'rowon';}				
				$print .= '<tr><td width="10%" class="'.$className.'">'.$row['date'].'</td>
							   <td width="10%" align="center" class="'.$className.'">'.$row['amount'].'</td>
							   <td width="10%" align="center" class="'.$className.'">'.$percent.'</td>
							   <td width="10%" align="center" class="'.$className.'">'.$percent.'%</td><td width="60%" class="'.$className.'"><img src="'.$core_conf['layout_url'].'images/bar.gif" width="'.$percent*RATIO.'" height="10"></td>
						   </tr>';
				$i++;
			}
			$print .= '</table>';		
		$print .= '<br><b>Hourly summary</b><br><table border=0 width="100%">';
		$result = coredb_query($query[0]); 
		//$amount = coredb_numrows($result);
		$row = @coredb_fetch($result); 
		$amount = 0;
		for ($i=0;$i<24;$i++) $amount += $row['h'.$i];
			// hourly hits output
			for ($i=0;$i<24;$i++)
			{
				$ic = $i/2;
				if($ic == round($ic)){$className = 'rowoff';} else {$className = 'rowon';}
				 $print .= '<tr><td width="10%" align="center" class="'.$className.'"> '.$i.' </td>
												 <td width="10%" align="center" class="'.$className.'">'.($row['h'.$i]).'</td>
												 <td width="10%" align="center" class="'.$className.'">'.round(($row['h'.$i]/$amount)*100,2).'%</td>
												 <td width="70%" class="'.$className.'"><img src="'.$core_conf['layout_url'].'images/bar.gif" width="'.round(($row['h'.$i]/$amount)*100,2)*RATIO.'" height="10"></td>
											 </tr>';
			}
			$print .= '</table>';
		} else $print .= '<font color="red"><center><b>ERROR! No data for selected period!</b></center></font>';	
	} else  { 
		## OTHER reports output 
		$count = coredb_countsql($query['count']);
		$pref = '&report='.$report;
		$pages = coreGetPages ($count,$pref,$maxpages='');
		$all = @coredb_fetch(coredb_query($query['all']));
		if ($all['overall']>0) {
			if($query['showsearch'])
			{
				$print .= '<form method="post">Search: <input type="text" name="searchword" size=30> <input type="submit" value="Search"></form>';
			}		
			$print .= '<table border=0 width="100%">';
			$result = coredb_query($query[0].' LIMIT '.$pages['begin'].','.$pages['step'].''); 
			$i=0;
			while ($row = @coredb_fetch($result)) {
				$ic = $i/2;
				if($ic == round($ic)){$className = 'rowoff';} else {$className = 'rowon';}
				$percent = round(($row[hits]/$all['overall'])*100,2);
				$print .= '<tr><td width="50%" class="'.$className.'">'.$row['var'].'</td>
							   <td width="10%" align="center" class="'.$className.'">'.$row['hits'].'</td>
							   <td width="10%" align="center" class="'.$className.'">'.$percent.'%</td>
							   <td width="30%" class="'.$className.'"><img src="'.$core_conf['layout_url'].'images/bar.gif" width="'.$percent*RATIO.'" height="10"></td></tr>';
				$i++;
			}
			## showing pages bar
			/*
			if ($show_pages==1||!empty($page)) {
				$print .= '<tr><td colspan="4" align="center">';
				for($i=0;$i<$results;$i+=30) {
					$print .= '<a href="/xstats/index.php?report='.$report.'&page='.($i/30).'"> '.($i/30).' </a>';
				}	
				
			}*/
			$print .= '</table><br>';
			$print .= '<center>'.$pages['pages'].'</center>';
		} else $print .= '<font color="red">ERROR! No data for selected period!</font>';	
	}	
return $print;
}
?>

