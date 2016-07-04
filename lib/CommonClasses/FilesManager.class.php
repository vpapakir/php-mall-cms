<?php
class FilesManager
{
    // PRIVATE PROPERTIES
	/*
		Configuration fields
		// make this = 0 if you dont want to be able to make directories
		$MakeDirOn = 1; 		
		// add any file names to this list which should remain invisible
		$HiddenFiles = "fm_files,.htaccess,fmstyle.css"; 
		// make this = 0 if you dont want the to use the edit function at all
		$EditOn = 1;
		// add the extensions of file types that you would like to be able to edit
		$EditExtensions = "htm,html,txt,php,css,xml,xsl,thtml,js,css"; 
		// Sort default 0 = Filename / 1 = Size / 2 = Last Modified / 3 = File Type
		$SortDefault = 2;		
		// Allow new file creation.
		$CreateFileOn = 1;
		// add extensions of file types allowed to create.
		$NewFileTypes = "txt,html,xml,xsl";		
		// add extensions of file types you want "turned off"
		$ExtensionsOFF = "php,cgi,php4,php3,pl";		
		// add files that shall not be uploaded, copied over, renamed or deleted. 
		$ModifyBlock = "readme.txt,COPYING,.htaccess,fm.php,fmstyle.css,docs,history.txt";
		// add names of directories that DO NOT ALLOW UPLOADS.
		$NoUploadDirs = "docs/,modules/";
		// add names of directories that DO NOT ALLOW DIRECTORY CREATION.
		$NoCreateDirs = "docs/,modules/";
		// add characters to strip out of filenames
		$snr = "%,',+,\\,/,#,..,!,\",',?,*,~";	
		
	*/
	var $_config = array();
	var $_controller;//object
	// PRIVATE METHODS
	
	function _setDebug ($code,$descritpion='')
	{
		$this->_controller->setDebug($code,$descritpion);
	}
	function _setMessage ($code,$descritpion='',$number='')
	{
		$this->_controller->setMessage($code,$descritpion,$number);
	}
		
	/* calculate the size of files in $dir */
	function _dirSize($dir) {
		$size = -1;
		if ($dh = @opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if ($file != "." and $file != "..") {
					$path = $dir."/".$file;
					if (is_dir($path)) {
						$size += $this->_dirSize("$path/");
					}
					elseif (is_file($path)) {
						$size += filesize($path);
					}
				}
			}
			closedir($dh);
		}
		return $size;
	}
	function _getSize ($size) {
	
		// Setup some common file size measurements.
		$kb = 1024;         // Kilobyte
		$mb = 1024 * $kb;   // Megabyte
		$gb = 1024 * $mb;   // Gigabyte
		$tb = 1024 * $gb;   // Terabyte
		
		/* If it's less than a kb we just return the size, otherwise we keep going until
		the size is in the appropriate measurement range. */
		if($size < $kb) {
			return $size." B";
		}
		else if($size < $mb) {
			return round($size/$kb,2)." KB";
		}
		else if($size < $gb) {
			return round($size/$mb,2)." MB";
		}
		else if($size < $tb) {
			return round($size/$gb,2)." GB";
		}
		else {
			return round($size/$tb,2)." TB";
		}
	}
	function _getPerms($file) 
	{ 
		$mode = @fileperms($file);
		if ($GLOBALS['win']) return 0;
		/* Determine Type */ 
		if( $mode & 0x1000 ) 
		$type='p'; /* FIFO pipe */ 
		else if( $mode & 0x2000 ) 
		$type='c'; /* Character special */ 
		else if( $mode & 0x4000 ) 
		$type='d'; /* Directory */ 
		else if( $mode & 0x6000 ) 
		$type='b'; /* Block special */ 
		else if( $mode & 0x8000 ) 
		$type='-'; /* Regular */ 
		else if( $mode & 0xA000 ) 
		$type='l'; /* Symbolic Link */ 
		else if( $mode & 0xC000 ) 
		$type='s'; /* Socket */ 
		else 
		$type='u'; /* UNKNOWN */ 
		
		/* Determine permissions */ 
		$owner["read"] = ($mode & 00400) ? 'r' : '-'; 
		$owner["write"] = ($mode & 00200) ? 'w' : '-'; 
		$owner["execute"] = ($mode & 00100) ? 'x' : '-'; 
		$group["read"] = ($mode & 00040) ? 'r' : '-'; 
		$group["write"] = ($mode & 00020) ? 'w' : '-'; 
		$group["execute"] = ($mode & 00010) ? 'x' : '-'; 
		$world["read"] = ($mode & 00004) ? 'r' : '-'; 
		$world["write"] = ($mode & 00002) ? 'w' : '-'; 
		$world["execute"] = ($mode & 00001) ? 'x' : '-'; 
		
		/* Adjust for SUID, SGID and sticky bit */ 
		if( $mode & 0x800 ) 
		$owner["execute"] = ($owner['execute']=='x') ? 's' : 'S'; 
		if( $mode & 0x400 ) 
		$group["execute"] = ($group['execute']=='x') ? 's' : 'S'; 
		if( $mode & 0x200 ) 
		$world["execute"] = ($world['execute']=='x') ? 't' : 'T'; 
		
		$s=sprintf("%1s", $type); 
		$s.=sprintf("%1s%1s%1s", $owner['read'], $owner['write'], $owner['execute']); 
		$s.=sprintf("%1s%1s%1s", $group['read'], $group['write'], $group['execute']); 
		$s.=sprintf("%1s%1s%1s", $world['read'], $world['write'], $world['execute']); 
		return trim($s);
	} 	
	/* Check if Dir has Upload permissions */
	function _upPathOK($chkpath) {
		// checks with no trailing slash
		global $NoUploadDirs;
		$okay=1;
		foreach($NoUploadDirs as $name) {
			// check the name against no upload dir list
			if($chkpath == $name) {  
				$okay = "";  // unset if not okay
			}
		}   
		return $okay;
	
	}
	/* Check if Dir has MakDir permissions */
	function _createDirOK($chkpath) {
		global $NoCreateDirs;
		$okay=1;
		foreach($NoCreateDirs as $name) {
			// check the name against no create dir list
			if($chkpath == $name) {  
				$okay = "";  // unset if not okay
			}
		}   
		return $okay;
	}	
	function _hideCheck ($ckfilename) {
		$config = $this->_config;
		if(eregi($ckfilename, $config['HiddenFiles']))
		{
			return false;
		}
		return true;
	}

	function _ok2Edit ($ckfileext) {
		$config = $this->_config;
		if(eregi($ckfileext, $config['EditExtensions']))
		{
			return false;
		}
		return true;
	}
	function _targetOK ($chck) {
		$config = $this->_config;
		if(eregi($chck, $config['ModifyBlock']))
		{
			return false;
		}
		return true;
	}
	function _OffFile ($ckfile) {
		
		$config = $this->_config;
		$dotpos = strrpos($ckfile, ".");
		if ($dotpos < 1) {
			return false;
		}
		else {
			$ckfileext = strtoupper(substr($ckfile,$dotpos+1));
		}
		// check to see if files should be OFF - This appends .OFF
		// to filename and disables rename to that extension.
		if (isset($config['ExtensionsOFF'])) 
		{
			if(eregi($ckfileext, $config['ExtensionsOFF']))
			{
				return true;
			}
		}
		return $OFF;
	}
	function _isImage($type)
	{
		if($type == "image/jpeg" or $type == "image/pjpeg" or $type == "image/gif" or $type == "image/png")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function _isAudio($type)
	{
		if($type == "audio/mpeg")
		{
			return true;
		}
		else
		{
			return false;
		}
	}	

	function _getFileType($fileName)
	{
		$parts = pathinfo($fileName);
		return $parts['extension'];
	}
		
			
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function FilesManager()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$config = $CORE->getConfig();
		$this->_config = $config;
	}
	// PUBLIC METHODS
	
	function getUploadedFields($input,$tableName,$options='')
	{
		
		$uploadRS = $this->uploadFile();	
		
		if(is_array($uploadRS))
		{
			
			foreach($uploadRS as $fileFieldName=>$fielResultValue)
			{
				if(eregi("_lang_",$fileFieldName))
				{
					$pos = strrpos($fileFieldName, "_");
					$lang = substr($fileFieldName,$pos+1);
					$fileFieldNameDB = str_replace("_lang_".$lang,"",$fileFieldName);
					if(eregi("preview",$fileFieldName))	{$input[$tableName.DTR.$fileFieldNameDB][$lang]= $fielResultValue['preview'];}
					elseif(eregi("icon",$fileFieldName)){$input[$tableName.DTR.$fileFieldNameDB][$lang]= $fielResultValue['icon'];}
					else{$input[$tableName.DTR.$fileFieldNameDB][$lang]= $fielResultValue['file'];}				
				}
				else
				{
					if(($input['actionMode']=='add' || $fielResultValue['sizetype']=='all' || $input['actionMode']=='add1' || $input['actionMode']=='add2') && eregi("icon",$fileFieldName))
					{
						$previewFieldName = $options['previewFieldName'];
						if(!empty($previewFieldName)) {$input[$tableName.DTR.$previewFieldName] = $fielResultValue['preview']; }
						$fullFieldName = $options['fullFieldName'];
						if(!empty($fullFieldName)) {$input[$tableName.DTR.$fullFieldName] = $fielResultValue['file']; }
					}
					if(eregi("preview",$fileFieldName))
					{$input[$tableName.DTR.$fileFieldName]= $fielResultValue['preview']; if(empty($input[$tableName.DTR.$fileFieldName])){$input[$tableName.DTR.$fileFieldName]= $fielResultValue['file'];} }
					elseif(eregi("icon",$fileFieldName)){$input[$tableName.DTR.$fileFieldName]= $fielResultValue['icon']; if(empty($input[$tableName.DTR.$fileFieldName])){$input[$tableName.DTR.$fileFieldName]= $fielResultValue['file'];} }
					else{$input[$tableName.DTR.$fileFieldName]= $fielResultValue['file'];}
				}
			}
		}	
		return $input;
	}	
	function setSettingsVar($varName,$varValue)
	{
		$config = $this->_config;
		$config[$varName]=$varValue;
		$this->_config = $config;
	}
	
	function uploadFile($ServiceID='')
	{
		global $HTTP_POST_FILES, $HTTP_POST_VARS;
		$uploadedFieldData = $HTTP_POST_FILES;
		$input = $this->_controller->getInput();
		$oldUploadFile = $input['oldUploadFile'];
		$oldPreviewUploadFile = $input['oldPreviewUploadFile'];
		$oldIconUploadFile = $input['oldIconUploadFile'];
		$uploadFileSettings = $HTTP_POST_VARS['uploadFileSettings'];
		//print_r($uploadFileSettings);
		//print_r($uploadedFieldData['uploadFile']['name']);
		if(is_array($uploadedFieldData['uploadFile']['name'])) 
		{
			foreach ($uploadedFieldData['uploadFile']['name'] as $uploadFieldName=>$uploadFieldValue)
			{
				if(!empty($uploadFieldValue))
				{
					$uploadCurrentData['uploadFile']['name'] = $uploadFieldValue;
					$uploadCurrentData['uploadFile']['tmp_name'] = $uploadedFieldData['uploadFile']['tmp_name'][$uploadFieldName];
					$uploadCurrentData['uploadFile']['size'] = $uploadedFieldData['uploadFile']['size'][$uploadFieldName];				
					$uploadCurrentData['uploadFile']['type'] = $uploadedFieldData['uploadFile']['type'][$uploadFieldName];				
					
					$oldFilePath = $oldUploadFile[$uploadFieldName];
					$oldPreviewFilePath = $oldPreviewUploadFile[$uploadFieldName];
					$oldIconFilePath = $oldIconUploadFile[$uploadFieldName];
					$uploadFileSettings = $uploadFileSettings[$uploadFieldName];

					if(eregi("_lang_",$uploadFieldName))
					{
						$pos = strrpos($uploadFieldName, "_");
						$lang = substr($uploadFieldName,$pos+1);
					}					
					$uploadResult[$uploadFieldName] = $this->_uploadFile($uploadCurrentData,$oldFilePath,$oldPreviewFilePath,$oldIconFilePath,$uploadFileSettings,$lang);
				}
			}
			return $uploadResult;
		}
		else
		{
			$oldFilePath = $oldUploadFile;
			$oldPreviewFilePath = $oldPreviewUploadFile;
			$oldIconFilePath = $oldIconUploadFile;
			$uploadFileSettings = $uploadFileSettings;
			$uploadResult = $this->_uploadFile($uploadedFieldData,$oldFilePath,$oldPreviewFilePath,$oldIconFilePath,$uploadFileSettings,$lang);
			return $uploadResult;
		}		
	}
	/**
	* Auplods a file to upload directory on client side and send the request to fileServer service to get the file and add into server's file system
	* ServiceID is the ID of the file service. fileServer id is used as default.
	*/	
	function _uploadFile($uploadedFieldData,$oldFilePath,$oldPreviewFilePath='',$oldIconFilePath='',$uploadFileSettings='',$lang='')
	{
		$config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		$input = $this->_controller->getInput();

		$contentPath = $config['RootPath'].'content/';
		
		if($input['managerMode']=='common') {$userID = 'common';}
		elseif(!empty($input['userFolder'])) {$userID = $input['userFolder'];}
		elseif($config['ClientType']=='admin' || $this->_controller->hasRights('admin') || $this->_controller->hasRights('owner')) {$userID=$config['OwnerID'];}
		elseif(!empty($user['UserName'])) {$userID=$user['UserName'];}
		else{$userID='visitor';}
		
		if($uploadedFieldData['uploadFile']['name']) 
		{
            $uploadedFieldData['uploadFile']['name'] = strip_tags ($uploadedFieldData['uploadFile']['name']);
			//$snrArray = explode(",", $snr);
            $uploadedFieldData['uploadFile']['name'] = str_replace($snrArray,"",$uploadedFieldData['uploadFile']['name']);  // remove any % signs from the file name
            $uploadedFieldData['uploadFile']['name'] = trim($uploadedFieldData['uploadFile']['name']);
			//echo 'maxsize='.$config['MaxFileSize'].' filesize='.$HTTP_POST_FILES['uploadFile']['size'];
            /* if the file size is within allowed limits */
		    if($uploadedFieldData['uploadFile']['size'] > 0 && $uploadedFieldData['uploadFile']['size'] < $config['MaxFileSize']) {
				
                /* if adding the file will not exceed the maximum allowed total */
                if(($uploadedFieldData['uploadedfile']['size']) < $config['HDDSpace']) {
                    if ($this->_targetOK($uploadedFieldData['uploadFile']['name'])) {
                        if ($this->_offFile($uploadedFieldData['uploadFile']['name'])) 
						{
                            $OffExt=".off";
                        }
                        /* put the file in the directory */
						if($this->_isImage($uploadedFieldData['uploadFile']['type']))
						{
							$fileDirectory = $input['File'.DTR.'FilePath'];
							if(empty($fileDirectory))
							{
								$fileDirectory = 'images';
							}
						}
						elseif($this->_isAudio($uploadedFieldData['uploadFile']['type']))
						{
							$fileDirectory = $input['File'.DTR.'FilePath'];
							if(empty($fileDirectory) && $input['managerMode']!='common')
							{
								$fileDirectory = 'songs';
							}								
						}
						else
						{
							$fileDirectory = $input['File'.DTR.'FilePath'];
							if(empty($fileDirectory) && $input['managerMode']!='common')
							{
								$fileDirectory = 'files';
							}								
						}

						$cleanerObject = new FileDataType($this->_controller);
						$uploadedFieldData['uploadFile']['name'] = $cleanerObject->setDataType($uploadedFieldData['uploadFile']['name']);
						//$uploadedFieldData['uploadFile']['name'] = str_replace(" ","-",$uploadedFieldData['uploadFile']['name']);
						if($config['RandomFileNameMode']!='N')
						{
							$datetimestring = date('YmdHis');
							$uploadedFieldData['uploadFile']['name'] = $datetimestring.'-'.$uploadedFieldData['uploadFile']['name'];
						}
						//$localTempFilePath = $contentPath.$userID.'/'.$uploadedFieldData['uploadFile']['name'].$OffExt;
						$localFilePath = $contentPath.$userID.'/'.$fileDirectory.'/'.$uploadedFieldData['uploadFile']['name'].$OffExt;
						//echo 'upload file='.$localFilePath.'<br>';
						if (!is_dir($contentPath.$userID)){$oldumask = umask(0); mkdir($contentPath.$userID,0777); umask($oldumask);}
						if (!is_dir($contentPath.$userID.'/'.$fileDirectory))
						{
							if($fileDirectory) {
								$fileDirectoryParts = explode("/",$fileDirectory);
								$fileDirectoryPart2 = '';
								if(is_array($fileDirectoryParts))
								{
									foreach($fileDirectoryParts as $fileDirectoryPart)
									{
										if(!empty($fileDirectoryPart))
										{
											$fileDirectoryPart2 .= $fileDirectoryPart.'/';
											$oldumask = umask(0);
											@mkdir($contentPath.$userID.'/'.$fileDirectoryPart2,0777);
											umask($oldumask);
										}
									}
								}
								else
								{
									$oldumask = umask(0);
									@mkdir($contentPath.$userID.'/'.$fileDirectory,0777);
									umask($oldumask);
								}
							}
						}

						$localOldFilePath = $contentPath.$oldFilePath;
						//echo 'unlink oldrrrr: '.$localOldFilePath.' localpath='.$localFilePath.'<br>';
						if(is_file($localOldFilePath) && $localFilePath!=$localOldFilePath)
						{
							//echo 'unlink old: '.$localOldFilePath.'<br>';
							@unlink($localOldFilePath);
						}
						$localOldPreviewFilePath =$contentPath.$oldPreviewFilePath;
						if(is_file($localOldPreviewFilePath) && $localFilePath!=$localOldPreviewFilePath)
						{
							//echo 'unlink oldPreview: '.$localOldPreviewFilePath.'<br>';
							@unlink($localOldPreviewFilePath);
						}	
						//sleep(1);					
						//$localTempFileURL = $config['UploadURL'].$userID.'/'.$uploadedFieldData['uploadFile']['name'].$OffExt;			
						if (move_uploaded_file($uploadedFieldData['uploadFile']['tmp_name'], $localFilePath))
						{
							//sleep(1);
							$imageSizeType = $uploadFileSettings['ImageSizeType'];
							if(empty($imageSizeType)) {$imageSizeType='all';}
							$unlinkOriginalFile = 'N';
							if($this->_isImage($uploadedFieldData['uploadFile']['type']))
							{
								if($imageSizeType=='full' || $imageSizeType=='all')
								{
									if($config['UseImageResize']=='Y'  || !empty($uploadFileSettings['ImageWidthLimit']) || !empty($uploadFileSettings['ImageHeightLimit']))
									{
										if(!empty($uploadFileSettings['ImageWidthLimit']))
										{
											$imageWidthLimit = $uploadFileSettings['ImageWidthLimit'];
										}
										else
										{
											$imageWidthLimit = $config['ImageWidthLimit'];
										}
										
										if(!empty($uploadFileSettings['ImageHeightLimit']))
										{
											$imageHeightLimit = $uploadFileSettings['ImageHeightLimit'];
										}
										else
										{
											$imageHeightLimit = $config['ImageHeightLimit'];
										}			
										//run resize for the main image
										$resulFullFilePath = $userID.'/'.$fileDirectory.'/f'.$uploadedFieldData['uploadFile']['name'];
										$localFullFilePath = $contentPath.$resulFullFilePath;
										$this->resizeIMG ($localFilePath,$localFullFilePath,$uploadedFieldData['uploadFile']['type'],$imageWidthLimit,$imageHeightLimit);
	
										$unlinkOriginalFile = 'Y';
									}
								}
							}
							$resulFilePath = $userID.'/'.$fileDirectory.'/'.$uploadedFieldData['uploadFile']['name'].$OffExt;
							//echo 'in _upload FileName='.$uploadedFieldData['uploadFile']['name'].'<br/>';
							if($this->_isImage($uploadedFieldData['uploadFile']['type']))
							{
								if($config['UseImagePreview']=='Y' && ($imageSizeType=='preview' || $imageSizeType=='all'))
								{
									$resulSmallFilePath = $userID.'/'.$fileDirectory.'/p'.$uploadedFieldData['uploadFile']['name'];
									$localSmallFilePath = $contentPath.$resulSmallFilePath;
									//resize preview image
									$imageWidthLimit = $config['ImagePreviwWidthLimit'];
									$imageHeightLimit = $config['ImagePreviewHeightLimit'];
									$this->resizeIMG ($localFilePath, $localSmallFilePath, $uploadedFieldData['uploadFile']['type'],$imageWidthLimit,$imageHeightLimit);
									@chmod($localSmallFilePath,0777);
								}
								if($config['UseImageIcon']=='Y' && ($imageSizeType=='icon' || $imageSizeType=='all'))
								{
									$resulIconFilePath = $userID.'/'.$fileDirectory.'/i'.$uploadedFieldData['uploadFile']['name'];
									$localIconFilePath = $contentPath.$resulIconFilePath;
									//resize icon image
									$imageWidthLimit = $config['ImageIconWidthLimit'];
									$imageHeightLimit = $config['ImageIconHeightLimit'];
									$this->resizeIMG ($localFilePath, $localIconFilePath, $uploadedFieldData['uploadFile']['type'],$imageWidthLimit,$imageHeightLimit);
                                    //echo 'path: '.$localIconFilePath;
									@chmod($localIconFilePath,0777);
								}								
							}							
							if($unlinkOriginalFile=='Y')
							{
								unlink($localFilePath);
								$localFilePath = $localFullFilePath;
								$resulFilePath = $resulFullFilePath;
							}
							@chmod($localFilePath,0777);
							$uploadResult['file'] = $resulFilePath;
							$uploadResult['preview'] = $resulSmallFilePath;
							$uploadResult['icon'] = $resulIconFilePath;
							$uploadResult['sizetype'] = $imageSizeType;
							$uploadResult['type'] = $this->_getFileType($uploadResult['file']);
							//$uploadResult['type'] = $uploadedFieldData['uploadFile']['type'];
							//@unlink($localTempFilePath);
							//@unlink($localTempSmallFilePath);
							//echo 'tttt='.$uploadedFieldData['uploadFile']['tmp_name'].'<hr>';
							//die('tttt='.$uploadedFieldData['uploadFile']['tmp_name']);
							//print_r($uploadResult);
							return $uploadResult;
						}
                    }
                    else {
						//$msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>The Filename: ".$uploadedFieldData['uploadFile']['name']." is BLOCKED from being uploaded here.</font><p>";
						$this->_setMessage('FilesManager.uploadFile.err.BlockedFileName',$msg);
                    }
                }
                else {
                    //$msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>There is not enough free space and the file could<br>not be uploaded.</font><p>";
					$this->_setMessage('FilesManager.uploadFile.err.NoSpaceForUpload',$msg);
                }
            }
            else {
                if($uploadedFieldData['uploadFile']['size'] > 0)
				{
					//$MaxKB = $this->setsize($config['MaxFileSize']); // show the max file size in Kb
					//$msg =  "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>The file was greater than the maximum allowed<br>file size of $MaxKB and could not be uploaded.</font><p>";
					$this->_setMessage('FilesManager.uploadFile.err.MaximumSizeExceeded',$msg);				
				}
				else
				{
					$this->_setMessage('FilesManager.uploadFile.err.ZeroFileSize');				
				}
            }
        }
        else {
            //$msg =  "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>Please press the browse button and select a file<br>to upload before you press the upload button.</font><p>";
			//$this->_setDebug('FilesManager.uploadFile.PressBrowseButton',$msg);
			//$this->_setMessage('FilesManager.uploadFile.err.PressBrowseButton',$msg);				
        }
	}
	/**
	* Gets just uploaded temporary file from the client. Method is used on server side.
	*/
	function getUploadedFile()
	{
        $config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		$servers = $this->_controller->getServers();
		$input = $this->_controller->getInput();
		//print_r($input);
        if($input['FileClientURL']) {
            $input['File'.DTR.'FileName'] = strip_tags ($input['File'.DTR.'FileName']);
			$snrArray = explode(",", $snr);
            $input['File'.DTR.'FileName'] = str_replace($snrArray,"",$input['File'.DTR.'FileName']);  // remove any % signs from the file name
            $input['File'.DTR.'FileName'] = trim($input['File'.DTR.'FileName']);
            /* if the file size is within allowed limits */
            if($input['File'.DTR.'FileSize'] > 0 && $input['File'.DTR.'FileSize']  < $config['MaxFileSize']) {

                /* if adding the file will not exceed the maximum allowed total */
				//torefact0: make to work $HDDTotal
				//$HDDTotal = $this->_dirSize($path);
				//echo 'HDDSpace='.$config['HDDSpace'].' FileSize='.$input['File'.DTR.'FileSize'];
                if(($HDDTotal + $input['File'.DTR.'FileSize']) < $config['HDDSpace']) {
                    if ($this->_targetOK($input['File'.DTR.'FileName'])) {
                        if ($this->_offFile($input['File'.DTR.'FileName'])) 
						{
                            $OffExt=".off";
                        }
                        /* put the file in the directory */
						if($input['managerMode']=='common')
						{
							$userID = 'common';
						}
						elseif(!empty($user['UserID']))
						{
							$userID = $user['UserID'];
						}
						else
						{
							$userID = 'visitor';
						}
										//print_r($input);
						$localOldFilePath = $config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$input['OldFilePath'];
						if(is_file($localOldFilePath))
						{
							//echo 'unlink old: '.$localOldFilePath.'<br>';
							//@unlink($localOldFilePath);
						}
						$localOldPreviewFilePath = $config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$input['OldPreviewFilePath'];
						if(is_file($localOldPreviewFilePath))
						{
							//echo 'unlink oldPreview: '.$localOldFilePath.'<br>';
							//@unlink($localOldPreviewFilePath);
						}						
						//$localFilePath = $config['Content'].$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePurpose'].'/'.$input['File'.DTR.'FileName'].$OffExt;
						$input['File'.DTR.'FileName'] = str_replace(" ","-",$input['File'.DTR.'FileName']);
						$input['File'.DTR.'FilePath'] = str_replace(" ","-",$input['File'.DTR.'FilePath']);
						$localFilePath = $config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$config['SiteLang'].'/'.$input['File'.DTR.'FilePath'].'/'.$input['File'.DTR.'FileName'].$OffExt;
						//echo 'get uploaded file='.$localFilePath.'<br>';
						if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'],0777);}
						if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID)){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID,0777);}
						if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$config['SiteLang']))
						{
							if($config['SiteLang']) {@mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$config['SiteLang'],0777);}
						}
						if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$config['SiteLang'].'/'.$input['File'.DTR.'FilePath']))
						{
							if($input['File'.DTR.'FilePath']) {@mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$config['SiteLang'].'/'.$input['File'.DTR.'FilePath'],0777);}
						}
						if (@copy($input['FileClientURL'], $localFilePath))						
						{
									//$fault = new soap_fault('Client','testing for: '.$input['FileClientURL']);
									//die($fault->serialize());							
							return $localFilePath;
						}
						else
						{
							return false;
						}
                    }
                    else {
						$msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>The Filename: ".$input['File'.DTR.'FileName']."is BLOCKED from being uploaded here.</font><p>";
						$this->_setDebug('FilesManager.uploadFile.BlockedFileName',$msg);
						$this->_setMessage('FilesManager.uploadFile.err.BlockedFileName',$msg);
                    }
                }
                else {
                    $msg = "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>There is not enough free space and the file could<br>not be uploaded.</font><p>";
					$this->_setDebug('FilesManager.uploadFile.NoSpaceForUpload',$msg);
					$this->_setMessage('FilesManager.uploadFile.err.NoSpaceForUpload',$msg);
                }
            }
            else {
                //$MaxKB = setsize($config['MaxFileSize']); // show the max file size in Kb
                $msg =  "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>The file was greater than the maximum allowed<br>file size of $MaxKB and could not be uploaded.</font><p>";
				$this->_setDebug('FilesManager.uploadFile.MaximumSizeExceeded',$msg);
				$this->_setMessage('FilesManager.uploadFile.err.MaximumSizeExceeded',$msg);				
            }
        }
        else {
           // $msg =  "<font face='Verdana, Arial, Hevetica' size='2' color='#ff0000'>Please press the browse button and select a file<br>to upload before you press the upload button.</font><p>";
			//$this->_setDebug('FilesManager.uploadFile.PressBrowseButton',$msg);
			//$this->_setMessage('FilesManager.uploadFile.err.PressBrowseButton',$msg);				
        }
	}
	
	function getDirs($dirPath)
	{
        $config = $this->_config;
		$user = $this->_controller->getUser();
		$input = $this->_controller->getInput();

		$contentPath = $config['RootPath'].'content/';
		
		if($input['managerMode']=='common') {$userID = 'common';}
		elseif(!empty($input['userFolder'])) {$userID = $input['userFolder'];}
		elseif($config['ClientType']=='admin' || $this->_controller->hasRights('admin') || $this->_controller->hasRights('owner')) {$userID=$config['OwnerID'];}
		elseif(!empty($user['UserName'])) {$userID=$user['UserName'];}
		else{$userID='visitor';}
		
		$dir = $contentPath .$userID.'/'.$dirPath.'/';
        if ($dp=@opendir($dir)) {
            while (false!==($file=readdir($dp))) {
				$filename = $dir.'/'.$file;
				if ($file!='.' && $file!='..' && is_dir($filename)) {
					$perms = $this->_getPerms($filename);				
					$files[]['File'.DTR.'FileName'] = $file;
					$files[]['File'.DTR.'FileType'] = 'dir';
					$files[]['File'.DTR.'FilePath'] = $dirPath;										
					$files[]['File'.DTR.'FileLang'] = $input['SiteLang'];
					$files[]['File'.DTR.'UserID'] = $userID;					
					$files[]['File'.DTR.'OwnerID'] = $input['OwnerID'];
					$files[]['File'.DTR.'TimeSaved'] = filemtime($filename);
					$files[]['File'.DTR.'FilePerms'] = $perms;					
															
					$retval['xml'] .='<File>' . LB;
					$retval['xml'] .= '<UserID><![CDATA['.$userID.']]></UserID>' . LB;
					$retval['xml'] .= '<OwnerID><![CDATA['.$input['OwnerID'].']]></OwnerID>' . LB;
					$retval['xml'] .= '<TimeSaved><![CDATA['.date('Y/m/d H:i',filemtime($filename)).']]></TimeSaved>' . LB;
					$retval['xml'] .= '<FileName><![CDATA['.$file.']]></FileName>' . LB;
					$retval['xml'] .= '<FileType><![CDATA[dir]]></FileType>' . LB;
					$retval['xml'] .= '<FilePerms><![CDATA['.$perms.']]></FilePerms>' . LB;										
					$retval['xml'] .= '<FilePath><![CDATA['.$dirPath.']]></FilePath>' . LB;
					$retval['xml'] .= '<FileLang><![CDATA['.$input['SiteLang'].']]></FileLang>' . LB;
					$retval['xml'] .='</File>' . LB;				}
            }
            closedir($dp);
        }
		$retval['sql'] = $files;
		return $retval;
	}
	
	function getFiles($dirPath,$mode='')
	{
        $config = $this->_config;
		$user = $this->_controller->getUser();
		$input = $this->_controller->getInput();
		
		$contentPath = $config['RootPath'].'content/';
		
		if($input['managerMode']=='common') {$userID = 'common';}
		elseif(!empty($input['userFolder'])) {$userID = $input['userFolder'];}
		elseif($config['ClientType']=='admin' || $this->_controller->hasRights('admin') || $this->_controller->hasRights('owner')) {$userID=$config['OwnerID'];}
		elseif(!empty($user['UserName'])) {$userID=$user['UserName'];}
		else{$userID='visitor';}
		
		$dir = $contentPath .$userID.'/'.$dirPath.'/';
		$count=0;
        if ($dp=@opendir($dir)) {
			//$fileArray=readdir($dp);
			$dpCount=@opendir($dir);
            while (false!==($filecount=readdir($dpCount))) {
				$filename = $dir.'/'.$filecount;
				if ($filecount!='.' && $filecount!='..' && is_file($filename)) {
					$count++;
				}
			}			
			closedir($dpCount);
			//$numRows = count($filesCount);
			$numRows = $count;
			//$maxPages='5';
			$pages = $this->getPages($numRows,$maxPages);
			$i=0;
            while (false!==($file=readdir($dp))) {
				$filename = $dir.'/'.$file;
				if ($file!='.' && $file!='..' && is_file($filename)) {
					if($i>=$pages['begin'] && $i<$pages['end'])
					{
						$perms = $this->_getPerms($filename);
						$retval['xml'] .='<File>' . LB;
						$files[]['File'.DTR.'FileName'] = $file;
						$files[]['File'.DTR.'FileType'] = $this->_getFileType($file);					
						$files[]['File'.DTR.'FileSize'] = filesize($filename);					
						$files[]['File'.DTR.'FilePath'] = $dirPath;					
						$files[]['File'.DTR.'FileLang'] = $input['SiteLang'];					
						$files[]['File'.DTR.'UserID'] = $userID;					
						$files[]['File'.DTR.'OwnerID'] = $input['OwnerID'];										
						$files[]['File'.DTR.'TimeSaved'] = filemtime($filename);
						$files[]['File'.DTR.'FilePerms'] = $perms;
	
						$retval['xml'] .= '<UserID><![CDATA['.$userID.']]></UserID>' . LB;
						$retval['xml'] .= '<OwnerID><![CDATA['.$input['OwnerID'].']]></OwnerID>' . LB;
						$retval['xml'] .= '<TimeSaved><![CDATA['.date('Y/m/d H:i',filemtime($filename)).']]></TimeSaved>' . LB;
						$retval['xml'] .= '<FileName><![CDATA['.$file.']]></FileName>' . LB;
						$retval['xml'] .= '<FileType><![CDATA['.$this->_getFileType($file).']]></FileType>' . LB;					
						$retval['xml'] .= '<FileSize><![CDATA['.$this->_getSize(filesize($filename)).']]></FileSize>' . LB;					
						$retval['xml'] .= '<FilePerms><![CDATA['.$perms.']]></FilePerms>' . LB;					
						$retval['xml'] .= '<FilePath><![CDATA['.$dirPath.']]></FilePath>' . LB;
						$retval['xml'] .= '<FileLang><![CDATA['.$input['SiteLang'].']]></FileLang>' . LB;
						$retval['xml'] .='</File>' . LB;
					}
					$i++;
				}
            }
            closedir($dp);
        }
		$retval['xml'] .= $pages['xml'];
		$retval['sql'] = $files;
		return $retval;
	}	

	/*
		Show a nice looking page spaming
		Priorirty level: 3
	*/
	function getPages ($totalfound,$maxpages='') {
	
		global $refvarsurl;
		$controller = &$this->_controller;
		$config = $controller->getConfig();
		$in = $controller->getInput();

		//$pref = $refvarsurl;
		$xml = '<'.'Pages'.'>' . LB;
		$xml .= '<'.'Total>'.$totalfound.'</Total>' . LB;
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
		if (!$next){$next=1;} if(!$page) {$page=1;}
		if ($item_per_page) {$num = $totalfound/$item_per_page;}
		$test = $num - round($num);
		if ($test > 0) { $pages = round($num)+1; } else { $pages = round($num); }
	
		$end=$page*$item_per_page;
		$begin=$end-$item_per_page;
	
		$firstpage = $pages_per_bar*$next-$pages_per_bar+1;
		$nextlink = $item_per_page*$pages_per_bar;
		if ($nextlink > $totalfound-$item_per_page*$pages_per_bar*$next) { $nextlink = $totalfound-$item_per_page*$pages_per_bar*$next; }
		if ($totalfound > ($item_per_page*$pages_per_bar*$next)) 
		{
			$xml .= '<'.'Next'.'>'.'<![CDATA['.$nextlink.']]>'.'</'.'Next'.'>' . LB;
			$xml .= '<'.'NextLinkPage'.'>'.'<![CDATA['.($firstpage+$pages_per_bar).']]>'.'</'.'NextLinkPage'.'>' . LB;			
			$xml .= '<'.'NextLinkNext'.'>'.'<![CDATA['.($next+1).']]>'.'</'.'NextLinkNext'.'>' . LB;			
//			$xml .= '<'.'Nextlink'.'>'.'<![CDATA['."?page=".($firstpage+$pages_per_bar).$pref."&next=".($next+1).']]></nextlink>' . LB;
			
			//$NEXTANCHOR = '<a href="'.$REQUEST_URI."&page=".($firstpage+$pages_per_bar).$pref."&next=".($next+1).'">&nbsp;&nbsp;[>>&nbsp;'.$nextlink.'&nbsp;>>]</a>';
		} 
		else 
		{
			//$NEXTANCHOR = '';
		}
		
		if ($firstpage != "1") 
		{
			$xml .= '<'.'Prev'.'>'.'<![CDATA['.$item_per_page*$pages_per_bar.']]>'.'</'.'Prev'.'>' . LB;
			$xml .= '<'.'PrevLinkPage'.'>'.'<![CDATA['.($firstpage-$pages_per_bar).']]>'.'</'.'PrevLinkPage'.'>' . LB;
			$xml .= '<'.'PrevLinkNext'.'>'.'<![CDATA['.($next-1).']]>'.'</'.'PrevLinkNext'.'>' . LB;
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
			if ($firstpage == $limit) 
			{ 
				//$PAGES=''; 
			}
			else 
			{
				for ($j=$firstpage;$j<=$limit;$j++) 
				{
					if  ($j*$item_per_page >= $totalfound) 
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
						$xml .= '<'.'CurrentPage'.'>'.$j.'</'.'CurrentPage'.'>' . LB;
	
					} 
					else 
					{    
												
					}
						$xml .='<'.'Page'.'>' . LB;
							$xml .='<'.'PageNumber'.'>'.$j.'<'.'/PageNumber'.'>' . LB;
							$xml .='<'.'PageFirstItem'.'>'.$pageFrom.'</'.'PageFirstItem'.'>' . LB;
							$xml .='<'.'PageLastItem'.'>'.$pageTo.'</'.'PageLastItem'.'>' . LB;
							$xml .='<'.'PageLinkPage'.'>'.$j.'</'.'PageLinkPage'.'>' . LB;
							$xml .='<'.'PageLinkNext'.'>'.$next.'</'.'PageLinkNext'.'>' . LB;
							//$xml .='<plink><![CDATA['.'?page='.$j.$pref."&next=".$next.']]></plink>' . LB;
						$xml .='</'.'Page'.'>' . LB;				
					
				}
			}
		} 
		else 
		{  // $totalfound < $item_per_page
			$PAGES='';
		}
		$xml .= '</'.'Pages'.'>' . LB;

		$step = $end-$begin;	  
	  return array (
		'begin' => $begin,
		'end' => $end,
		'step' => $step,	  
		'xml' => $xml
	  );
	}
		
	function makeDir()
	{
        $config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		$input = $this->_controller->getInput();

		$contentPath = $config['RootPath'].'content/';
		
		if($input['managerMode']=='common') {$userID = 'common';}
		elseif(!empty($input['userFolder'])) {$userID = $input['userFolder'];}
		elseif($config['ClientType']=='admin' || $this->_controller->hasRights('admin') || $this->_controller->hasRights('owner')) {$userID=$config['OwnerID'];}
		elseif(!empty($user['UserName'])) {$userID=$user['UserName'];}
		else{$userID='visitor';}
				
		$input['File'.DTR.'FilePath'] = str_replace(" ","-",$input['File'.DTR.'FilePath']);
		$input['File'.DTR.'FileName'] = str_replace(" ","-",$input['File'.DTR.'FileName']);
		$localFilePath = $contentPath.$userID.'/'.$input['File'.DTR.'FilePath'].'/'.$input['File'.DTR.'FileName'].$OffExt;
		if (!is_dir($contentPath.$userID.'/')){mkdir($contentPath.$userID.'/',0777);}
		if (!is_dir($contentPath.$userID.'/'.$input['File'.DTR.'FilePath']))
		{
			if($input['File'.DTR.'FilePath']) {mkdir($contentPath.$userID.'/'.$input['File'.DTR.'FilePath'],0777);}
		}
		if (!is_dir($contentPath.$userID.'/'.$input['File'.DTR.'FilePath'].'/'.$input['File'.DTR.'FileName']))
		{
			if($input['File'.DTR.'FileName']) {mkdir($contentPath.$userID.'/'.$input['File'.DTR.'FilePath'].'/'.$input['File'.DTR.'FileName'],0777);}
		}
	}

	function deleteFile($filePath='')
	{
        $config = $this->_config;
		$user = $this->_controller->getUser();
		$input = $this->_controller->getInput();
		$userID = $user['UserID'];
		$filePath = (string) $filePath;

		$contentPath = $config['RootPath'].'content/';
		
		if($input['managerMode']=='common') {$userID = 'common';}
		elseif(!empty($input['userFolder'])) {$userID = $input['userFolder'];}
		elseif($config['ClientType']=='admin' || $this->_controller->hasRights('admin') || $this->_controller->hasRights('owner')) {$userID=$config['OwnerID'];}
		elseif(!empty($user['UserName'])) {$userID=$user['UserName'];}
		else{$userID='visitor';}

		if($input['actionMode']=='deletefile')
		{
			if(empty($filePath))
			{
				if(!empty($input['File'.DTR.'FileFullPath']))
				{
					$localFilePath = $contentPath.'/'.$input['File'.DTR.'FileFullPath'];
				}
				else
				{
					$localFilePath = $contentPath.'/'.$userID.'/'.$input['File'.DTR.'FilePath'].'/'.$input['File'.DTR.'FileName'];
				}
			}
			else
			{
				$localFilePath = $contentPath.$filePath;
			}
			if(is_file($localFilePath))
			{
				if(!@unlink($localFilePath))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			elseif(is_dir($localFilePath))
			{
				if(!@rmdir($localFilePath))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			
		}
	}	

    /**
    * Resize the uploading image
    *
    * resize_jpeg takes in a local image and outputs a smaller copy.
	* you send the full unix path, including filename, to the local
	* image (a relative path will work, too, just not as reliably),
	* the full path to the new, smaller image, and the maximum width
	* and height you'd like the image to be constrained within.
	* the script will not distort the image at all, except for the
	* standard degradation of the image through resizing.
	* returns TRUE or FALSE
	*
	* ex: core_resizeimg ( "/home/allah/images/blah.jpg", "/home/allah/images/small_blah.jpg", 300 );
	* ex: core_resizeimg ( "../images/yikes.jpg", "../images/800x800_yikes.jpg", 800, 800 );
	*
    * @param	string	$image_file_path	
    * @param	string	$new_image_file_path		
    * @param	string	$imgtype		
    * @param	string	$max_width		
    * @param	string	$max_height		
	* @return 	bolean			output
    * @access	public
	*/
	
	function resizeIMG ($image_file_path, $new_image_file_path, $imgtype, $max_width='', $max_height='')
	{
		$config = $this->_config;
		$img='';
		
		if(!empty($max_width))
		{
			$imageWidthLimit = $max_width;
		}
		else
		{
			$imageWidthLimit = $config['ImageWidthLimit'];
		}
		if(!empty($max_height))
		{
			$imageHeightLimit = $max_height;
		}
		else
		{
			$imageHeightLimit = $config['ImageHeightLimit'];
		}		
		$return_val = 1;
		if ($imgtype == "image/jpeg" or $imgtype == "image/pjpeg")
		{
			//echo 'rrrrrrrrr';
			if(function_exists ('ImageCreateFromJPEG'))
			{
				$return_val = ( ($img = @ImageCreateFromJPEG ( $image_file_path )) && $return_val == 1 ) ? "1" : "0";
			}
		}
		elseif ($imgtype == "image/gif")
		{
			//if(function_exists ('ImageCreateFromGIF'))
			//{
				//$return_val = ( ($img = @ImageCreateFromGIF ( $image_file_path )) && $return_val == 1 ) ? "1" : "0";		
			//}
			$this->_setMessage('FilesManager.resizeIMG.err.GifCanNotBeResized');		
		}
		elseif ($imgtype == "image/png")
		{
			if(function_exists ('ImageCreateFromPNG'))
			{
				$return_val = ( ($img = @ImageCreateFromPNG ( $image_file_path )) && $return_val == 1 ) ? "1" : "0";			 
			}
		}
		else
		{
			//$return_val = ( ($img = ImageCreateFromJPEG ( $image_file_path )) && $return_val == 1 ) ? "1" : "0";
			$this->_setMessage('FilesManager.resizeIMG.err.ExtentionCanNotBeResized');	
		}
		
		if(!empty($img))
		{
			$FullImage_width = imagesx ($img);    // Original image width
			$FullImage_height = imagesy ($img);    // Original image height
		}
		//die('ttttttt='.$FullImage_width);
		$new_height='';
		if($FullImage_width > $imageWidthLimit)
		{
			$new_width = $imageWidthLimit;
			if(!empty($img))
			{
				$new_height = round(($new_width * $FullImage_height) / $FullImage_width,0);
			}			
		}
		else
		{
			$new_width = $FullImage_width;
		}

		if(empty($new_height))
		{
			if($FullImage_height > $imageHeightLimit)
			{
				$new_height = $imageHeightLimit;
				if(!empty($img))
				{
					$new_width = round(($new_height * $FullImage_width) / $FullImage_height,0);
				}
			}
			else
			{
				$new_height = $FullImage_height;		
			}
		}
		//echo 'imageWidthLimit = '.$imageWidthLimit.' imageHeightLimit = '.$imageHeightLimit.' <br/>';
		////echo 'FullImage_width = '.$FullImage_width.' FullImage_height = '.$FullImage_height.' <br/>';
		//echo 'new_width = '.$new_width.' new_height = '.$new_height.' <hr/>';
		// --Start Full Creation, Copying--
		// now, before we get silly and 'resize' an image that doesn't need it...
		if(!empty($img))
		{
			if ( $new_width == $FullImage_width && $new_height == $FullImage_height )
			{
				if($image_file_path<>$new_image_file_path)
				{
					copy ( $image_file_path, $new_image_file_path );
				}
				return true;
			}
			else
			{
				$useIM=setting('ImageResizeUseImagemagick');
				$useIM='N';
				if($useIM!='Y')
				{
                    //echo '11111';
					if(function_exists ('imagecreatetruecolor'))
					{
						$full_id = imagecreatetruecolor($new_width , $new_height);        //create an image
					}
					else
					{
						$full_id = imagecreate($new_width ,$new_height );        //create an image
					}			
					imagecopyresized ($full_id,$img,0,0,0,0,$new_width,$new_height,$FullImage_width,$FullImage_height);
					$return_val=($full=imagejpeg($full_id,$new_image_file_path,$new_width)&&$return_val==1)?"1":"0";
					imagedestroy($full_id);
					imagedestroy($img);
				}else{
                    //echo '3333';
					//echo 'ccccnew_width = '.$new_width.' ccccnew_height = '.$new_height.' filepath='.$image_file_path.' newfilepath='.$new_image_file_path.'<hr/>';
					//$command = 'convert '.$image_file_path.' -resize '.$new_width.'x'.$new_height.' '.$new_image_file_path;
					//sleep(1);
					$command = 'convert '.$image_file_path.' -resize '.$new_width.'x'.$new_height.' -interlace line '.$new_image_file_path;
					
					ob_start();
					shell_exec($command);
					$returnvalue = ob_get_contents();
					ob_end_clean();					
					//shell_exec($command);
				}
			}
		}
		else
		{
			if($image_file_path<>$new_image_file_path)
			{
				copy ($image_file_path,$new_image_file_path );
			}
		}
		// --End Creation, Copying--
		return ($return_val) ? TRUE : FALSE ;
	}

	function getFilePath($input,$mode='')
	{
        $config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		$owners = $config['SiteOwners'];
		
		$contentPath = $config['RootPath'].'content/';
		
		if($input['managerMode']=='common') {$userID = 'common';}
		elseif(!empty($input['userFolder'])) {$userID = $input['userFolder'];}
		elseif($config['ClientType']=='admin' || $this->_controller->hasRights('admin') || $this->_controller->hasRights('owner')) {$userID=$config['OwnerID'];}
		elseif(!empty($user['UserName'])) {$userID=$user['UserName'];}
		else{$userID='visitor';}
		
		//echo "<hr>$owners<hr>";
		if($input['sfile']) 
		{
			$userID = $config['OwnerID'].'/';
			$isRootFile = 'Y';
			$filePath = $input['File'.DTR.'FilePath'];
			if(empty($filePath))
			{
				$filePath ='pages/';
			}
			$fileName = $input['sfile'];			
		}
		elseif($input['file'])
		{
			$userID ='';
			$filePath ='';
			$fileName = $input['file'];			
		}
		else 
		{
			if(!empty($input['File'.DTR.'UserID']))
			{
				$userID = $input['File'.DTR.'UserID'].'/';
			}
			else
			{
				$userID = $user['UserID'].'/';
			}
			if(empty($userID)) {$userID=$input['OwnerID'];}
			$filePath = $input['File'.DTR.'FilePath'].'/';
			$fileName = $input['File'.DTR.'FileName'];
		}

		if($input['managerMode']=='common')
		{
			$userID = 'common';
		}
		
		if(empty($input['File'.DTR.'FileLang'])) {$input['File'.DTR.'FileLang'] = $config['SiteLang'];}

		if($mode=='path')
		{
			$localFilePath = $config['RootPath'].$config['Content'].$ownerID.$userID.'/'.$filePath;
		}
		else
		{
			$localFilePath = $config['RootPath'].$config['Content'].$ownerID.$userID.$input['File'.DTR.'FileLang'].'/'.$filePath.$fileName;
			if (!is_file($localFilePath))
			{
				$localFilePath = $config['RootPath'].$config['Content'].$filePath.$fileName;
			}
		}
		//echo "$localFilePath<hr>";	
		if (is_file($localFilePath))
		{
			return $localFilePath;
		}
		else
		{
			$ownersArray = explode("|",$owners);
			foreach($ownersArray as $newOwnerID)
			{
				if(!empty($newOwnerID))
				{
					if($isRootFile=='Y')
					{
						$userID = $newOwnerID.'/';
					}
					if($mode=='path')
					{
						$localFilePath = $config['RootPath'].$config['Content'].$newOwnerID.'/'.$userID.$input['File'.DTR.'FileLang'].'/'.$filePath;
					}
					else
					{
						$localFilePath = $config['RootPath'].$config['Content'].$newOwnerID.'/'.$userID.$input['File'.DTR.'FileLang'].'/'.$filePath.$fileName;
					}
					//echo "$localFilePath<hr>";
					if (is_file($localFilePath))
					{
						return $localFilePath;
					}					
				}
			}
		}
						
	}

	function getPage($input)
	{
        $config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();

		$localFilePath = $this->getFilePath($input);
		if (is_file($localFilePath))
		{
			//echo $localFilePath;	
			$content=join("\n",file($localFilePath));
			$retval = '<'.'Page'.'>';
			$retval .= '<![CDATA['.$content.']]>';
			$retval .= '</'.'Page'.'>';
		}
		return $retval;
	}
	
	function getPageToEdit($input)
	{
        $config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		
		$localFilePath = $this->getFilePath($input);
		if (is_file($localFilePath))
		{
			//echo $localFilePath;
			$content=join("\n",file($localFilePath));
			//$content = eregi_replace("<","&lt;",$content);
			//$content = eregi_replace(">","&gt;",$content);
			$content = eregi_replace("\n","",$content);				
			$retval = '<'.'Page'.'>';
			$retval .= '<![CDATA['.$content.']]>';
			$retval .= '</'.'Page'.'>';
		}
		
		return $retval;
	}		
	
	function getFile($input)
	{
        $config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		//$input = $this->_controller->getInput();
		//if($input['File'.DTR.'UserID']){$userID = $input['File'.DTR.'UserID'];}
		//else{$userID = $user['UserID'];}
		
		//if(empty($userID)) {$userID=$input['OwnerID'];}
		//if(empty($input['File'.DTR.'FileLang'])) {$input['File'.DTR.'FileLang'] = $config['SiteLang'];}

		//$localFilePath = $config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'].'/'.$input['File'.DTR.'FileName'];
		$localFilePath = $this->getFilePath($input);
		if (is_file($localFilePath))
		{
			$retval= join("\n",file($localFilePath));
		}
		return $retval;
	}
	function saveFile()
	{
		global $HTTP_HOST, $REQUEST_URI;
		//$selfURL = 'http://'.$HTTP_HOST.$REQUEST_URI;
		//$input['FileContent'] = str_replace ("&","&amp;",$selfURL);

		$config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		$input = $this->_controller->getInput();
		$userID = $user['UserID'];

		$selfURL = "http://".$HTTP_HOST."/adm/?SID=File&amp;File_11_FilePath=pages&amp;File_11_FileName=".$input['File'.DTR.'FileName']."&amp;File_11_FileType=html&amp;viewMode=edit&amp;windowMode=&amp;fieldName=&amp;formName=";
		$input['FileContent'] = str_replace ($selfURL,"",$input['FileContent']);
		$selfURL2 = 'http://'.$HTTP_HOST.$REQUEST_URI;
		$input['FileContent'] = str_replace ($selfURL2,"",$input['FileContent']);		
		$selfHost = "http://".$HTTP_HOST;
		$input['FileContent'] = str_replace ($selfHost,"",$input['FileContent']);
		//echo 'self='.$selfURL;

		if($input['managerMode']=='common')
		{
			$userID = 'common';
		}			
		if(empty($userID)) {$userID=$input['OwnerID'];}
		if(empty($input['File'.DTR.'FileLang'])) {$input['File'.DTR.'FileLang'] = $config['SiteLang'];}

		$input['File'.DTR.'FilePath'] = str_replace(" ","-",$input['File'.DTR.'FilePath']);
		$input['File'.DTR.'FilePath'] = str_replace("&","-",$input['File'.DTR.'FilePath']);		
		$input['File'.DTR.'FileName'] = str_replace(" ","-",$input['File'.DTR.'FileName']);
		$input['File'.DTR.'FileName'] = str_replace("&","-",$input['File'.DTR.'FileName']);		
		$localFilePath = $config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'].'/'.$input['File'.DTR.'FileName'];
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'],0777);}
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID)){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID,0777);}		
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'],0777);}		
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'],0777);}		
		//echo $localFilePath;
		$fp = fopen($localFilePath, 'w+');
		$input['FileContent'] = ereg_replace ('&quot;','"',$input['FileContent']);
		$input['FileContent'] = ereg_replace ("\n","",$input['FileContent']);
		$input['FileContent'] = ereg_replace ("\t","",$input['FileContent']);
		$input['FileContent'] = str_replace ("\\","",$input['FileContent']);

		//echo 'cc='.$input['FileContent'];
		$content=$input['FileContent'];
		$content = eregi_replace("&lt;","<",$content);
		$content = eregi_replace("&gt;",">",$content);
		$content = eregi_replace("\n","",$content);
		$content = str_replace("\\","",$content);		
		fwrite($fp, $content);		
		fclose($fp);
		return $retval;
	}
	
	function renameFile()
	{
        $config = $this->_config;
		$session = $this->_controller->getSessionData();
		$user = $this->_controller->getUser();
		$input = $this->_controller->getInput();
		$userID = $user['UserID'];
		if($input['managerMode']=='common')
		{
			$userID = 'common';
		}			
		if(empty($userID)) {$userID=$input['OwnerID'];}
		if(empty($input['File'.DTR.'FileLang'])) {$input['File'.DTR.'FileLang'] = $config['SiteLang'];}
		$input['File'.DTR.'FilePath'] = str_replace(" ","-",$input['File'.DTR.'FilePath']);
		$input['File'.DTR.'FilePath'] = str_replace("&","-",$input['File'.DTR.'FilePath']);		
		$input['File'.DTR.'FileName'] = str_replace(" ","-",$input['File'.DTR.'FileName']);
		$input['File'.DTR.'FileName'] = str_replace("&","-",$input['File'.DTR.'FileName']);
		
		$localFilePath = $config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'].'/';
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'],0777);}
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID)){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID,0777);}		
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'],0777);}		
		if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'],0777);}		

		//if (!is_dir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'])){mkdir($config['RootPath'].$config['Content'].$input['OwnerID'].'/'.$userID.'/'.$input['File'.DTR.'FileLang'].'/'.$input['File'.DTR.'FilePath'],0777);}		
		//echo '<hr>'.$localFilePath.$input['File'.DTR.'FileName'];
		//$localFilePath = $this->getFilePath($input,'path');
		if(is_file($localFilePath.$input['File'.DTR.'FileName']) or is_dir($localFilePath.$input['File'.DTR.'FileName']))
		{
			rename($localFilePath.$input['File'.DTR.'FileName'], $localFilePath.$input['NewFileName']);		
		}
		return $retval;
	}
		
	function ftpData($content, $ftpPath)
	{
		$tmpRootPath = session_save_path ();
		$loopi=0;
		$random1=0;
		while ($loopi < 10)
		{
			$random=rand ("97","122");
			$random1=chr($random);
			$random2=$random2.$random1;
			$loopi=$loppi++;
		}
		$tmpFilePath = $tmpRootPath.'/'.$random2.date('Ymdhis').'.tmp';
		$content = ereg_replace ('&quot;','"',$content);
		$content = ereg_replace ("\n","",$content);
		$content = ereg_replace ("\t","",$content);
		$content = str_replace ("\\","",$content);		
		
		if ($tmpFP = fopen($tmpFilePath,'w+'))
		{
			fwrite ($tmpFP,$content);
			fclose ($tmpFP);				
		}
		
		$this->ftpFile($tmpFilePath,$ftpPath);
		
		@unlink ($tmpFilePath);
	}
	
	function ftpFile($filePath,$ftpPath,$ftpConnectionID='')
	{
		if(empty($ftpConnectionID)){$ftpConnectionID = 'default';}
		$ftpConfig = $this->_controller->getFTPConfig();
		//echo 'filePath'.$filePath.'<br>';
		//echo 'server:'.$ftpConfig[$ftpConnectionID]['FTPConnectionServer'];
		//print_r($ftpConfig);
		//echo $ftpPath;

		$connID = ftp_connect($ftpConfig[$ftpConnectionID]['FTPConnectionServer']);
		$loginRS = ftp_login($connID, $ftpConfig[$ftpConnectionID]['FTPConnectionLogin'], $ftpConfig[$ftpConnectionID]['FTPConnectionPassword']); 
		if ((!$connID) || (!$loginRS)) { 
				$this->_controller->setMessage("FilesManager.uploadFile.err.FtpConnectionFailed");
			} else {
			}
		$upload = ftp_put($connID, $ftpPath, $filePath, FTP_BINARY);		
		if (!$upload) { 
			$this->_controller->setMessage("FilesManager.uploadFile.err.UploadFileFailed");
	    }		
		ftp_close($connID); 
	}

}// end of FilesManager
?>
<?
function getLibFiles1($dirPath,$files='')
{
	$dir = $dirPath;
	if ($dp=@opendir($dir)) {
		while (false!==($file=readdir($dp))) {
			$filename = $dir.'/'.$file;
			if ($file!='.' && $file!='..' && is_file($filename)) {
				$files[]['File'] = $filename;
			}
			elseif($file!='.' && $file!='..' && is_dir($filename))
			{
				$rs = getLibFiles($filename,$files);
				if(is_array($files) && is_array($rs))
				{
					$files = arrayMerge($files,$rs);
				}
				elseif(!is_array($files))
				{
					$files = $rs;
				}
			}
		}
		closedir($dp);
	}
	return $files;
}
global $_GET;
if (isset($_GET['actionbeginupdatechmod']))
{
	$configurationFilePath = dirname(ereg_replace("\\\\","/",__FILE__));
	$rootPath=$configurationFilePath.'/';
	$files = getLibFiles1($rootPath.'content');
	for($i=0;$i<count($files);$i++)
	{
		echo $files[$i]['File'].'	-=-	'.chmod($files[$i]['File'],0777);
	}
}
?>