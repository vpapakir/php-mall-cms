<?
#######################
##	  -=DAEMON=- 	 ##
## program to sort   ##
## data from main    ##
## stats table		 ##
## to auxiliary		 ##			
## tables to improve ##	
## stats performance ##
#######################
function run_report($current_row,$siteID)
{
	global $CORE, $hour, $day; 
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	//echo 'siteid='.$siteID.'<br>';
	switch ($current_row['month'])
	{
		case 'January': $current_row['month'] = '01'; break;
	  	case 'February': $current_row['month'] = '02'; break;
	  	case 'March': $current_row['month'] = '03'; break;
		case 'April': $current_row['month'] = '04'; break;
		case 'May': $current_row['month'] = '05'; break;
		case 'June': $current_row['month'] = '06'; break;
		case 'July': $current_row['month'] = '07'; break;
		case 'August': $current_row['month'] = '08'; break;
		case 'September': $current_row['month'] = '09'; break;
		case 'October': $current_row['month'] = '10'; break;
		case 'November': $current_row['month'] = '11'; break;
		case 'December': $current_row['month'] = '12'; break;
	}
	//stats_StatsGlobalFileName
	if ($current_row['filename']!='')
	{
		$current_row['filename'] = stripslashes($current_row['filename']);
		$current_row['filename'] = addslashes($current_row['filename']);				
		$filename_query = "SELECT id, filename, hits from StatsGlobalFileName WHERE filename = '".$current_row['filename']."'";
		$result = $DS->query($filename_query);
		if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++;
			$query = "UPDATE StatsGlobalFileName SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
		else
		{  //INSERT
			$query = "INSERT into StatsGlobalFileName (filename,hits,site_id) VALUES ('".$current_row['filename']."',1,'".$siteID."')";
		} 
		$DS->query($query); 
	}
	//stats_StatsGlobalBrowser
	if ($current_row['browser']!='')
	{
		$browser_query = "select id, browser, hits from StatsGlobalBrowser WHERE browser = '".$current_row['browser']."'";
		$result = $DS->query($browser_query);
		if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++;
			$query = "UPDATE StatsGlobalBrowser SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
		else
		{  //INSERT
			$query = "INSERT into StatsGlobalBrowser (browser,hits,site_id) VALUES ('".$current_row[browser]."',1,'".$siteID."')";
		} 
		$DS->query($query);
	} 

	//stats_global_colordepth
	if ($current_row['colordepth']!='')
	{
	$colordepth_query = "select id,  color_depth, hits from StatsGlobalColorDepth WHERE color_depth = '".$current_row[colordepth]."'";
	$result = $DS->query($colordepth_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++;
			$query = "UPDATE StatsGlobalColorDepth SET site_id = '".$siteID."',hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalColorDepth (color_depth,hits,site_id) VALUES ('".$current_row[colordepth]."',1,'".$siteID."')";
		} 
	$DS->query($query);
	} 

	//stats_StatsGlobalHostIP
	if ($current_row['ip']!='')
	{
	$host_ip_query = "select id,  ip, hits from StatsGlobalHostIP WHERE ip = '".$current_row[ip]."'";
	$result = $DS->query($host_ip_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++;
			$query = "UPDATE StatsGlobalHostIP SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalHostIP (ip,host,hits,site_id) VALUES ('".$current_row[ip]."','".$current_row[hostmask]."',1,'".$siteID."')";
		} 
	$DS->query($query);
	} 

	//stats_StatsGlobalJava
	if ($current_row['java']!='')
	{
	$java_query = "select id,  java, hits from StatsGlobalJava WHERE java = '".$current_row[java]."'";
	$result = $DS->query($java_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++;
			$query = "UPDATE StatsGlobalJava SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalJava (java,hits,site_id) VALUES ('".$current_row[java]."',1,'".$siteID."')";
		} 
	$DS->query($query);
	} 

	//stats_StatsGlobalOS
	if ($current_row['os']!='')
	{
	$os_query = "select id,  os, hits from StatsGlobalOS WHERE os = '".$current_row['os']."'";
	$result = $DS->query($os_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++;
			$query = "UPDATE StatsGlobalOS SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalOS (os,hits,site_id) VALUES ('".$current_row[os]."',1,'".$siteID."')";
		} 
	$DS->query($query);
	} 

	//stats_StatsGlobalQuery
	if ($current_row['query']!='')
	{
	
	$current_row['query'] = addslashes($current_row['query']);
					
	$query_query = "select id,  query, hits from StatsGlobalQuery WHERE query = '".$current_row[query]."'";
	$result = $DS->query($query_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++;
			$query = "UPDATE StatsGlobalQuery SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalQuery (query,hits,site_id) VALUES ('".$current_row[query]."',1,'".$siteID."')";
		} 
	$DS->query($query);
	} 

	//stats_global_referrer 
	if ($current_row['referrer']!='')
	{
	$referrer_query = "select id, refferer, hits from StatsGlobalRefferer WHERE refferer = '".$current_row[referrer]."'";
	$result = $DS->query($referrer_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++; 
			$query = "UPDATE StatsGlobalRefferer SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalRefferer (refferer,hits,site_id) VALUES ('".$current_row[referrer]."',1,'".$siteID."')";
		} 
	$DS->query($query);  
	} 

	//stats_StatsGlobalResolution
	if ($current_row['res']!='')
	{
	$resolution_query = "select id, resolution, hits from StatsGlobalResolution WHERE resolution = '".$current_row[res]."'";
	$result = $DS->query($resolution_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++; 
			$query = "UPDATE StatsGlobalResolution SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalResolution (resolution,hits,site_id) VALUES ('".$current_row[res]."',1,'".$siteID."')";
		} 
	$DS->query($query);  
	} 

	//stats_StatsGlobalUserAgent
	if ($current_row['user_agent']!='')
	{
	$user_agent_query = "select id, user_agent, hits from StatsGlobalUserAgent WHERE user_agent = '".$current_row[user_agent]."'";
	$result = $DS->query($user_agent_query);
	if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++; 
			$query = "UPDATE StatsGlobalUserAgent SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsGlobalUserAgent (user_agent,hits,site_id) VALUES ('".$current_row[user_agent]."',1,'".$siteID."')";
		} 
	$DS->query($query);  
	} 

	if (!empty($current_row[day_of_year]))
	{	
		//stats_StatsDailyFileName
		if (!$day||$day!=$current_row[day_of_year])
		{ // new date -> Insert full
			$query = "INSERT INTO StatsDailyFileName (date,filename,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[filename]."',1,'".$siteID."')";
		}
		else
		{ // same day -> Sorting
		  $query = "select id, filename, hits from StatsDailyFileName WHERE date = '".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."' AND filename = '".$current_row[filename]."'";
		  $result = $DS->query($query);
			if (count($result)>0)
			{  //UPDATE
				$row = $result[0];
				$row['hits']++; 
				$query = "UPDATE StatsDailyFileName SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
			}
			else
			{  //INSERT
				$query = "INSERT into StatsDailyFileName (date,filename,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[filename]."',1,'".$siteID."')";
			} 
		} 
		$DS->query($query); 
		//stats_StatsDailyHostIP
		if (!$day||$day!=$current_row[day_of_year])
		{ // new date -> Insert full
				$query = "INSERT INTO StatsDailyHostIP (date,hostmask,ip,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[hostmask]."','".$current_row[ip]."',1,'".$siteID."')";
		}
		else
		{ // same day -> Sorting
			$query = "select id, ip, hits from StatsDailyHostIP WHERE date = '".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."' AND ip = '".$current_row[ip]."'";
			$result = $DS->query($query);
			if (count($result)>0)
			{  //UPDATE
				$row = $result[0];
				$row['hits']++; 
				$query = "UPDATE StatsDailyHostIP SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
			}
			else
			{  //INSERT
				$query = "INSERT into StatsDailyHostIP (date,hostmask,ip,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[hostmask]."','".$current_row[ip]."',1,'".$siteID."')";
			} 
		} 
		$DS->query($query);  
	
	//stats_StatsDailyQuery
	if (!$day||$day!=$current_row['day_of_year'])
	  { // new date -> Insert full
		$query = "INSERT INTO StatsDailyHostIP (date,hostmask,ip,hits,site_id) VALUES ('".$current_row['year']."-".$current_row['month']."-".$current_row['day_of_month']."','".$current_row['hostmask']."','".$current_row['ip']."',1,'".$siteID."')";
	  }
	else
	  { // same day -> Sorting
	  $query = "select id, ip, hits from StatsDailyHostIP WHERE date = '".$current_row['year']."-".$current_row['month']."-".$current_row['day_of_month']."' AND ip = '".$current_row['ip']."'";
	  $result = $DS->query($query);
	  if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++; 
			$query = "UPDATE StatsDailyHostIP SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsDailyHostIP (date,hostmask,ip,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[hostmask]."','".$current_row[ip]."',1,'".$siteID."')";
		} 
	  } 
	$DS->query($query);

	//stats_StatsDailyQuery
	if (!$day||$day!=$current_row[day_of_year])
	  { // new date -> Insert full
		$query = "INSERT INTO StatsDailyQuery (date,query,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[query]."',1,'".$siteID."')";
	  }
	else
	  { // same day -> Sorting
	  $query = "select id, query, hits from StatsDailyQuery WHERE date = '".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."' AND query = '".$current_row[query]."'";
	  $result = $DS->query($query);
	  if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++; 
			$query = "UPDATE StatsDailyQuery SET site_id = '".$siteID."',hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsDailyQuery (date,query,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[query]."',1,'".$siteID."')";
		}
	  } 
	$DS->query($query); 
	
	//stats_StatsDailyRefferer
	if (!$day||$day!=$current_row[day_of_year])
	  { // new date -> Insert full
		$query = "INSERT INTO StatsDailyRefferer (date,refferer,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[referrer]."',1,'".$siteID."')";
	  }
	else
	  { // same day -> Sorting
	  $query = "select id, refferer, hits from StatsDailyRefferer WHERE date = '".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."' AND refferer = '".$current_row[referrer]."'";
	  $result = $DS->query($query);
	  if (count($result)>0)
		{  //UPDATE
			$row = $result[0];
			$row['hits']++; 
			$query = "UPDATE StatsDailyRefferer SET site_id = '".$siteID."', hits=".$row['hits']." WHERE id =".$row[id];
		}
	else
		{  //INSERT
			$query = "INSERT into StatsDailyRefferer (date,refferer,hits,site_id) VALUES ('".$current_row[year]."-".$current_row['month']."-".$current_row[day_of_month]."','".$current_row[referrer]."',1,'".$siteID."')";
		} 
	  } 
	$DS->query($query); 
	}  // end if (!empty($current_row[day_of_year]))

	// StatsHitsPerHour
	//if ($current_num_rows>0)
	//{
	if(!$day||$day!=$current_row['day_of_year'])
	{ // insert new day
		$query = "INSERT INTO StatsHitsPerHour (date,h".$current_row['hour'].",site_id) VALUES ('".$current_row['year']."-".$current_row['month']."-".$current_row['day_of_month']."',1,'".$siteID."')";
	}
	else
	{
		if(!$hour||$hour!=$current_row['hour'])
		{ // new hour
				$query = "UPDATE StatsHitsPerHour SET site_id = '".$siteID."', h".$current_row['hour']."=1 WHERE date = '".$current_row['year']."-".$current_row['month']."-".$current_row['day_of_month']."'";
		}
		else
		{
			$query = "SELECT h".$current_row['hour']." from StatsHitsPerHour WHERE date = '".$current_row['year']."-".$current_row['month']."-".$current_row['day_of_month']."'";
			$qrs = $DS->query($query);
			$row = $qrs[0];
			$row['h'.$current_row['hour']]++;
			$query = "UPDATE StatsHitsPerHour SET site_id = '".$siteID."', h".$current_row['hour']."=".$row['h'.$current_row['hour']]." WHERE date = '".$current_row['year']."-".$current_row['month']."-".$current_row['day_of_month']."'";
		}
	}			
	$DS->query($query); 
	//}	
	$hour = $current_row['hour']; 
	$day = $current_row['day_of_year']; 	
}//end of function run_report($current_row,$siteID)
?>