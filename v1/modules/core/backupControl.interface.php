<?php


function backupControl()
{
echo "";
}

function backupList()
{

    global $CORE;
    global $mainConfig;
    //get input
    $input = $CORE->getInput();
    $config = $CORE->getConfig();
    $DS = new DataSource('main');
//echo "http://".$_SERVER['SERVER_NAME'].setting('WebFolder');
    $user = user('UserID');
    if (empty($input['downloadItem']) && !empty($input['actionMode'])) {
//echo setting('RootPath');
//print_r($config);

	$BackupFileName = date('Y_m_d_H_is').'_backup.tar';
	$BackupWebPath = "http://".$_SERVER['SERVER_NAME'].setting('WebFolder');
	$BackupFilePath = setting('RootPath');

	$backupsPath = "backups/";
	$MySQLDumpPath = "/usr/bin/mysqldump";
	$DBHost = $mainConfig['db']['main']['host'];
	$DBName = $mainConfig['db']['main']['name'];
	$DBUser = $mainConfig['db']['main']['user'];
	$DBPassword = $mainConfig['db']['main']['password'];
	if (!is_dir(setting('RootPath').$backupsPath))
	{
	    if (is_writable(setting('RootPath'))){
	    mkdir(setting('RootPath').$backupsPath);
	    $tmpPath = setting('RootPath').$backupsPath;
	    chmod($tmpPath, 0777);
	    } else {
		echo "You cannot create backup directory, you has no right for writing";
	    }
	}
	
	if (is_writable(setting('RootPath').$backupsPath)) {

	    $excludeFile = fopen(setting('RootPath').$backupsPath.'file.list','w');
	    $backupDir = setting('RootPath').$backupsPath;
	    if ($dp=@opendir($backupDir)) {
		while (false!==($file=readdir($dp))) {
		    $filename = $modulePath.'/'.$file."\n";
		    fwrite($excludeFile, $filename);
		}
		closedir($dp);
	    }
	    fclose($excludeFile);

	    $tarPath = "/bin/tar";
	    if ($input['actionMode']=='full'){
		$command = $MySQLDumpPath . " -h$DBHost -u$DBUser -p$DBPassword --add-drop-table $DBName > ".setting('RootPath')."db.sql"; 
		exec($command);
		$command = $tarPath.' --exclude='.setting('RootPath').$backupsPath.'*.tar -cf '.setting('RootPath').$backupsPath.$BackupFileName.' '.setting('RootPath');
		exec($command);
		if(is_file(setting('RootPath')."db.sql")) {unlink(setting('RootPath')."db.sql");}
	    }

	    if ($input['actionMode']=='db'){
		$command = $MySQLDumpPath . " -h$DBHost -u$DBUser -p$DBPassword --add-drop-table $DBName > ".setting('RootPath')."db.sql"; 
		exec($command);
		$command = $tarPath.' --exclude-from='.setting('RootPath').$backupsPath.'file.list -cf '.setting('RootPath').$backupsPath.$BackupFileName.' '.setting('RootPath')."db.sql";
		exec($command);
		if(is_file(setting('RootPath')."db.sql")) {unlink(setting('RootPath')."db.sql");}
	    }

	    if (filesize(setting('RootPath').$backupsPath.$BackupFileName)){
		$BackupLogFileSize = filesize(setting('RootPath').$backupsPath.$BackupFileName);}
	    else {$BackupLogFileSize = 0;}
    
	    if (is_file(setting('RootPath').$backupsPath.$BackupFileName)){
		$query = "INSERT INTO BackupLog (`BackupFileName`, `BackupPath`, `BackupLogFileSize`, `BackupType`, `OwnerID`, `UserID`, `TimeCreated`) VALUES ('".$BackupFileName."', '".$BackupWebPath.$backupsPath ."', '".$BackupLogFileSize."', '".$input['actionMode']."', 'root', '".$user."', '".date('Y-m-d H:i:s')."')";
		$result = $DS->query($query);
	    }else{
		echo "File is not created, please check the space on you disk and permissions for writing";	
	    }
	}else{
	    echo "Directory ".setting('RootPath').$backupsPath." has no right for writing";
	}

    


    }elseif (!empty($input['downloadItem'])){

	$query = "SELECT * FROM BackupLog WHERE BackupLogID='".input('downloadItem')."'";
	$result['Download'] = $DS->query($query);

	$query = "INSERT INTO BackupDownloadLog (`BackupDownloadFileSize`, `TimeCreated`, `OwnerID` ,`UserID`, `BackupDownloadFileName`) VALUES ('".$result['Download'][0]['BackupLogFileSize']."', '".date('Y-m-d H:i:s')."', 'root', '".user('UserID')."', '".$result['Download'][0]['BackupFileName']."')";
    //echo $query;
	$DS->query($query);
    }
    $query = "SELECT * FROM BackupLog ORDER BY TimeCreated DESC";
    $result['BackupLog'] = $DS->query($query);
//print_r($result['Download']);
    return $result;
}

function backupDownloadList()
{
    $DS = new DataSource('main');
    $query = "SELECT * FROM BackupDownloadLog ORDER BY TimeCreated DESC";
    $result = $DS->query($query);	
    return $result;
}

function addBackupDownload()
{
    $DS = new DataSource('main');

    $query = "SELECT * FROM BackupLog WHERE BackupLogID='".input('item')."'";
    $result['Download'] = $DS->query($query);


    $query = "INSERT INTO BackupDownloadLog (`BackupDownloadFileSize`, `TimeCreated`, `OwnerID` ,`UserID`, `BackupDownloadFileName`) VALUES ('".$result[0]['BackupLogFileSize']."', '".$result[0]['TimeCreated']."', 'root', '".user('UserID')."', '".$result[0]['BackupFileName']."')";
    //echo $query;
    $DS->query($query);

return $result;
}

?>