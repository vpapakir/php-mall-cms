<?php
//XCMSPro: Web Service entity class
class StatsClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function StatsClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	
	function getReport($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];

		$page = $input['page'];
		$results = $input['results'];
		
		$report = $input['report'];
		if(empty($report)) {$report = "StatsHitsPerHour";}

		if (!empty($date_from)&&$date_from != $_date_from) $_date_from = $date_from;
		if (!empty($date_to)&&$date_to != $_date_to) $_date_to = $date_to;

		$query = $this->getQueries($report);

		if ($report=='StatsHitsPerHour'||$report=='hits') {
			## HITS hourly and daily output 
				$dbrs = $DS->query($query[2]);
				$row = $dbrs[0]; 
				$all = $row['all_value'];
				//echo 'fff='.$query[1];
				$result = $DS->query($query[1]); 
				//print_r($result);
				$amount = count($result);
				if ($amount > 0) {			
					$i = 0;
					$retval['TotalHits'] = $all;
					// daily hits
					foreach($result as $id=>$row)
					{
						$percent = round(($row['amount']/$all)*100,2);
						$retval['DailyHits'][$id]['date'] = $row['date'];
						$retval['DailyHits'][$id]['amount'] = $row['amount'];
						$retval['DailyHits'][$id]['percent'] = $percent;
					}
					//$print .= '<br><b>Hourly summary</b><br><table border=0 width="100%">';
					$result = '';
					$result = $DS->query($query[0]); 
					//$amount = coredb_numrows($result);
					$row = $result[0]; 
					$amount = 0;
					for ($i=0;$i<24;$i++) $amount += $row['h'.$i];
					// hourly hits output
					for ($i=0;$i<24;$i++)
					{
						$retval['HourlyHits'][$i]['h'] = $row['h'.$i];
						$retval['HourlyHits'][$i]['percent'] = round(($row['h'.$i]/$amount)*100,2);
					}
				} ;	
		} else  { 
			## OTHER reports output 
			$countRS = $DS->query($query['count']); 
			$count = count($countRS);
			$pref = '&report='.$report;
			//$pages = coreGetPages ($count,$pref,$maxpages='');
			
			$allRS = $DS->query($query['all']);
			
			$all = $allRS[0];
			if ($all['overall']>0) {
				//if($query['showsearch'])
				//{
					//$print .= '<form method="post">Search: <input type="text" name="searchword" size=30> <input type="submit" value="Search"></form>';
				//}		
				//$print .= '<table border=0 width="100%">';
				//$result = coredb_query($query[0].' LIMIT '.$pages['begin'].','.$pages['step'].''); 
				$result = $DS->query($query[0]);
				$i=0;
				//while ($row = @coredb_fetch($result)) {
				foreach($result as $row) {
					$percent = round(($row['hits']/$all['overall'])*100,2);
					$retval['Result'][$i]['percent'] = $percent;
					$retval['Result'][$i]['var'] = $row['var'];
					$retval['Result'][$i]['hits'] = $row['hits'];
					$i++;
				}
				//$print .= '</table><br>';
				//$print .= '<center>'.$pages['pages'].'</center>';
			}// else $print .= '<font color="red">ERROR! No data for selected period!</font>';	
		}	

	return $retval;
	}

	function isMySite()
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		
		$session = $SERVER->getSessionData();
		$currentSite = $session['statsCurrentSite'];
		
		if(!empty($userID))
		{
			$rs = $DS->query("SELECT * FROM StatsSite WHERE site_id='".$currentSite."'");
			if(count($rs)>0)
			{
				return true;
			}
		}
	
		return false;
	}

	function getQueries($report) {

		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
	
		$input = $SERVER->getInput();
		$session = $SERVER->getSessionData();
		
		$dateFrom = $session['statsDateFrom'];
		$dateTo = $session['statsDateTo'];
		$currentSite = $session['statsCurrentSite'];
		
		$page = $input['page'];
		$results = $input['results'];
		$searchword = $input['searchword'];
		//$report = $input['report'];
				
		if(empty($currentSite)) $currentSite=1;
		$showsearch = '';
		$gfilter = " AND site_id='$currentSite' ";
		switch ($report) {
			// global stats from static tables
			case 'global_ip' : 
									$query['showsearch'] = 1;
									if($searchword)
									{
										$gfilter .= " AND ip LIKE '%$searchword%' ";
									}								
									$query[0] = ' SELECT ip as var, hits FROM  StatsGlobalHostIP WHERE 1 '.$gfilter.' ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalHostIP  WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalHostIP  WHERE 1 '.$gfilter.' ';
									break;
			case 'global_host' :
									$query['showsearch'] = 1;
									if($searchword)
									{
										$gfilter .= " AND host LIKE '%$searchword%' ";
									}										 
									$query[0] = ' SELECT host as var, hits FROM  StatsGlobalHostIP  WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalHostIP  WHERE 1 '.$gfilter.' ';
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalHostIP  WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalUserAgent' : 
									$query[0] = ' SELECT user_agent as var, hits FROM  StatsGlobalUserAgent  WHERE 1 '.$gfilter.' ORDER by hits desc';
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalUserAgent WHERE 1 '.$gfilter.' ';
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalUserAgent WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalOS' : 		
									$query[0] = ' SELECT os as var, hits FROM  StatsGlobalOS WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalOS WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalOS WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalBrowser' : 
									$query[0] = ' SELECT browser as var, hits FROM  StatsGlobalBrowser WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalBrowser WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalBrowser WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalResolution' : 
									$query[0] = ' SELECT resolution as var, hits FROM  StatsGlobalResolution WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalResolution WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalResolution WHERE 1 '.$gfilter.' ';
									break;
			/*case 'global_max_resolution' : 
									$query[0] = ' SELECT max_resolution as var, hits FROM  global_max_resolution WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  global_max_resolution WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  global_max_resolution WHERE 1 '.$gfilter.' ';
									break;*/
			case 'StatsGlobalColorDepth' : 
									$query[0] = ' SELECT color_depth as var, hits FROM  StatsGlobalColorDepth WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalColorDepth WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalColorDepth WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalJava' : 
									$query[0] = ' SELECT java as var, hits FROM  StatsGlobalJava WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalJava WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalJava WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalRefferer' :
									$query['showsearch'] = 1; 
									if($searchword)
									{
										$gfilter .= " AND refferer LIKE '%$searchword%' ";
									}		
									$query[0] = ' SELECT refferer as var, hits FROM  StatsGlobalRefferer WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalRefferer WHERE 1 '.$gfilter.'  '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalRefferer WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalQuery' : 
									$query[0] = ' SELECT query as var, hits FROM  StatsGlobalQuery WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalQuery WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalQuery WHERE 1 '.$gfilter.' ';
									break;
			case 'StatsGlobalFileName' : 
									$query['showsearch'] = 1;
									if($searchword)
									{
										$gfilter .= " AND filename LIKE '%$searchword%' ";
									}								
									$query[0] = ' SELECT filename as var, hits FROM  StatsGlobalFileName WHERE 1 '.$gfilter.'  ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalFileName WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalFileName WHERE 1 '.$gfilter.' ';
									break;
			/*
			case 'global_tld' : 
									$query[0] = ' SELECT filename as var, hits FROM  StatsGlobalFileName ORDER by hits desc'; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsGlobalFileName '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsGlobalFileName';
									break;*/
			case 'StatsHitsPerHour' : 
									$query[0] = ' SELECT SUM(h0) as h0, SUM(h1) as h1, SUM(h2) as h2, SUM(h3) as h3, SUM(h4) as h4, SUM(h5) as h5, SUM(h6) as h6, SUM(h7) as h7, SUM(h8) as h8, SUM(h9) as h9, SUM(h10) as h10, SUM(h11) as h11, SUM(h12) as h12, SUM(h13) as h13, SUM(h14) as h14, SUM(h15) as h15, SUM(h16) as h16,SUM(h17) as h17, SUM(h18) as h18, SUM(h19) as h19, SUM(h20) as h20, SUM(h21) as h21, SUM(h22) as h22, SUM(h23) as h23 FROM  StatsHitsPerHour WHERE 1 '.$gfilter.'  GROUP by site_id';
									$query[1] = ' SELECT date, h0+h1+h2+h3+h4+h5+h6+h7+h8+h9+h10+h11+h12+h13+h14+h15+h16+h17+h18+h19+h20+h21+h22+h23 AS amount FROM  StatsHitsPerHour WHERE 1 '.$gfilter.'  ORDER by date DESC';
									$query[2] = ' SELECT SUM(h0+h1+h2+h3+h4+h5+h6+h7+h8+h9+h10+h11+h12+h13+h14+h15+h16+h17+h18+h19+h20+h21+h22+h23) AS all_value FROM  StatsHitsPerHour  WHERE 1 '.$gfilter.' ';
									$query['count'] = ' SELECT  COUNT(*) FROM  StatsHitsPerHour';
									 break;
	
			// dynamic StatsHitsPerHour
			case 'hits' : 
									$query[0] = ' SELECT SUM(h0) as h0, SUM(h1) as h1, SUM(h2) as h2, SUM(h3) as h3, SUM(h4) as h4, SUM(h5) as h5, SUM(h6) as h6, SUM(h7) as h7, SUM(h8) as h8, SUM(h9) as h9, SUM(h10) as h10, SUM(h11) as h11, SUM(h12) as h12, SUM(h13) as h13, SUM(h14) as h14, SUM(h15) as h15, SUM(h16) as h16,SUM(h17) as h17, SUM(h18) as h18, SUM(h19) as h19, SUM(h20) as h20, SUM(h21) as h21, SUM(h22) as h22, SUM(h23) as h23 FROM  StatsHitsPerHour  WHERE 1 '.$gfilter.' ';
									$query[1] = ' SELECT date, h0+h1+h2+h3+h4+h5+h6+h7+h8+h9+h10+h11+h12+h13+h14+h15+h16+h17+h18+h19+h20+h21+h22+h23 AS amount FROM  StatsHitsPerHour  WHERE 1 '.$gfilter.' ';
									$query[2] = ' SELECT SUM(h0+h1+h2+h3+h4+h5+h6+h7+h8+h9+h10+h11+h12+h13+h14+h15+h16+h17+h18+h19+h20+h21+h22+h23) AS all_value FROM  StatsHitsPerHour  WHERE 1 '.$gfilter.' ';
									$query['count'] = ' SELECT  COUNT(*) FROM  StatsHitsPerHour';
									if ($dateFrom) {
										$query[0] .= ' AND date >= "'.$dateFrom.'"';
										$query[1] .= ' AND date >= "'.$dateFrom.'"';
										$query[2] .= ' AND date >= "'.$dateFrom.'"';
									}
									if ($dateTo) {
										$query[0] .= ' AND date <= "'.$dateTo.'"';
										$query[1] .= ' AND date <= "'.$dateTo.'"';
										$query[2] .= ' AND date <= "'.$dateTo.'"';
									}
									break;
					
			// filenames -> day/period
			case 'pages' : 
									$query['showsearch'] = 1;
									$query[0] = ' SELECT filename as var, SUM(hits) as hits FROM StatsDailyFileName  WHERE 1 '.$gfilter.'  '; 
									$query['count'] = ' SELECT COUNT(*) FROM StatsDailyFileName  WHERE 1 '.$gfilter.'  '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM StatsDailyFileName  WHERE 1 '.$gfilter.' ';
									if ($dateFrom) { $filter = ' AND date >= "'.$dateFrom.'"'; $query['all'] .= ' AND date >= "'.$dateFrom.'"'; }
									if ($dateTo) { $filter .= ' AND date <= "'.$dateTo.'"'; $query['all'] .= ' AND date <= "'.$dateTo.'"';  }
									$query['count'] .= $filter; $query[0] .= $filter;
									$query[0] .= ' GROUP by filename ORDER by hits desc';
									break;
			case 'refferer' : 
									$query['showsearch'] = 1;
									if($searchword)
									{
										$gfilter .= " AND refferer LIKE '%$searchword%' ";
									}		
									$query[0] = ' SELECT refferer as var, SUM(hits) as hits FROM  StatsDailyRefferer  WHERE 1 '.$gfilter.' '; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsDailyRefferer  WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsDailyRefferer  WHERE 1 '.$gfilter.'  ';
									if ($dateFrom) {
										$filter = ' AND date >= "'.$dateFrom.'"';  
									}
									if ($dateTo) {
										$filter = ' AND date <= "'.$dateTo.'"';
									}
									$query[0] .= $filter;  $query['all'] .= $filter; $query['count'] .= $filter;
									$query[0] .= ' GROUP BY refferer ORDER by hits desc';
									break;
			case 'IP' : 
									$query['showsearch'] = 1;
									$query[0] = ' SELECT ip as var, SUM(hits) as hits FROM  StatsDailyHostIP  WHERE 1 '.$gfilter.' '; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsDailyHostIP  WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsDailyHostIP  WHERE 1 '.$gfilter.'  ';
									if ($dateFrom) {
										$filter = ' AND date >= "'.$dateFrom.'"';  
									}
									if ($dateTo) {
										$filter =  ' AND date <= "'.$dateTo.'"';
									}
									$query[0] .= $filter;  $query['all'] .= $filter; $query['count'] .= $filter;								
									$query[0] .= ' GROUP BY ip ORDER by hits desc';
									break;
			case 'host' : 
									$query['showsearch'] = 1;
									$query[0] = ' SELECT hostmask as var, SUM(hits) as hits FROM  StatsDailyHostIP  WHERE 1 '.$gfilter.' '; 
									$query['count'] = ' SELECT COUNT(*) FROM  StatsDailyHostIP  WHERE 1 '.$gfilter.' '; 
									$query['all'] = ' SELECT SUM(hits) as overall FROM  StatsDailyHostIP  WHERE 1 '.$gfilter.'  ';
									if ($dateFrom) {
										$filter = ' AND date >= "'.$dateFrom.'"';  
									}
									if ($dateTo) {
										$filter =  ' AND date <= "'.$dateTo.'"';
									}
									$query[0] .= $filter;  $query['all'] .= $filter; $query['count'] .= $filter;								
									$query[0] .= ' GROUP BY hostmask ORDER by hits desc';
									break;
	   } // END switch
	   $ttrs = $DS->query($query[0]);
	$results = count($ttrs);
	//if ($page) $query[0] .= ' LIMIT '.($page*30).', 30';
	return $query;
	}
	
	function getStatsReports($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StatsClass.getStatsReports.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		//set filters

		if(!empty($searchWord))
		{
			$filter .= " AND (StatsReportName LIKE '{ls}%$searchWord%{le}' OR StatsReportName LIKE '%$searchWord%' OR StatsReportDescription LIKE '{ls}%$searchWord%{le}' OR StatsReportDescription LIKE '%$searchWord%')";
		}
		
		if(!empty($input['PermAll']))
		{
			$filter .= " AND PermAll!=4";
		}

		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM StatsReport WHERE StatsReportID>0 $filter ORDER BY StatsReportPosition";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('StatsClass.getStatsReports.End','End');
		return $result;
	}
	
	function setStatsReport($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StatsClass.setStatsReport.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['StatsReport'.DTR.'StatsReportID'];
		if(empty($entityID)) {$entityID = $input['StatsReportID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		//set queries	

		$where['StatsReport'] = "StatsReportID = '".$entityID."'".$filter;

		$input['actionMode']='save';					
		$result = $DS->save($input,$where);	
		$SERVER->setDebug('StatsClass.setStatsReport.End','End');		
		return $result;		
	}
	
	function deleteStatsReport($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StatsClass.deleteStatsReport.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['StatsReport'.DTR.'StatsReportID'];
		//if(empty($entityID)) {$entityID = $input['PollQuestionID'];}		
		//set filters
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM StatsReport WHERE StatsReportID='$entityID'");
		}
		$SERVER->setMessage('StatsClass.deleteStatsReport.msg.DataDeleted');
		$SERVER->setDebug('StatsClass.deletePollQuestion.End','End');		
		return $result;		
	}
	
	function getStatsReport($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StatsClass.getStatsReport.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['StatsReport'.DTR.'StatsReportID'];
		if(empty($entityID)) {$entityID = $input['StatsReportID'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		//set queries
		if(!empty($entityID))
		{
			$filter = " StatsReportID='$entityID' ";
		}
		$query = "SELECT * FROM StatsReport WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('StatsClass.getStatsReport.End','End');		
		return $result;		
	}
	
	function updateStatsSitelist()
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
	
		$input = $SERVER->getInput();
		$session = $SERVER->getSessionData();
	
		$StatsSiteResult = $DS->query("SELECT DISTINCT(website) FROM StatsRecord");
		foreach($StatsSiteResult as $siteRow)
		{
			if(!empty($siteRow['website']))
			{
				$checkSQL = "SELECT site_id FROM StatsSite  WHERE name = '".$siteRow['website']."'"; 
				$checkRS = $DS->query($checkSQL);
				if(count($checkRS) == 0)
				{
					$DS->query("INSERT INTO StatsSite (name,uid) VALUES ('".$siteRow['website']."','2')");
				}
			}
		}	
	}

} // end of StatsServer
?>