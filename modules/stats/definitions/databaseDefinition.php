<?
	$databaseDefinition['t']['StatsSite']='site_id,UserID,name,description,gmt,monitorsite,monitorlink,monitorcode,monitoremail,monitorsms';
	$databaseDefinition['k']['site_id']='site_id';	
	$databaseDefinition['langs']['StatsSite']['description']='infield';

	$databaseDefinition['t']['StatsResource']='resourceid,UserID,resourcename,resourcetitle,site_id';
	$databaseDefinition['k']['StatsResource']='resourceid';	
	$databaseDefinition['langs']['StatsResource']['resourcename']='infield';
	
	$databaseDefinition['t']['StatsReport']='StatsReportID,UserID,OwnerID,PermAll,StatsReportCode,StatsReportName,StatsReportDescription,StatsReportPosition,StatsReportParentID';
	$databaseDefinition['k']['StatsReport']='StatsReportID';	
	$databaseDefinition['langs']['StatsReport']['StatsReportDescription']='infield';
	$databaseDefinition['langs']['StatsReport']['StatsReportName']='infield';
?>