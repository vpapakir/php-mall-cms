<?
class CacheController
{
    // PRIVATE PROPERTIES
	//configuration info
	var $_config = array();
	//temporary data 
	var $_input = array();// GET+POST data
	var $_setPage;
	// PRIVATE METHODS
    /**
    * Deletes all unallowed HTML tags
    *
    * @param	string	$value	the value
    * @param	string	$mode	the mode ofclening: NULL - full clean, notags - do not delete tags, nocheckwords 
	* @return	string			cleaned string
    * @access 	private
    */		

	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function CacheController()
	{	 
		global $cacheConfig;
		$this->_config = $cacheConfig;
		$this->_setPage='N';
	}
	
	// PUBLIC METHODS
	function getPage($input)
	{
		global $HTTP_SERVER_VARS;
		$config = $this->_config;
		$this->_config;
		$path = $config['CachePath'];
		$cacheStatus = $config['CacheStatus'];
		$cacheControlType = $config['CacheCotrolType'];
		$cacheTime = $config['CacheTime'];
		
		$uri = $HTTP_SERVER_VARS["REQUEST_URI"];
		$uri = str_replace("/","-",$uri);
		//$uri = str_replace("=","-",$uri);
		//$uri = str_replace("&","-",$uri);
		//$uri = str_replace("?","-",$uri);
		if(isset(input['cacheAction']) && $input['cacheAction']=='delete')
		{
			$this->deleteCache();
		}
		if(($input['SID']==='home' || eregi("\.html",$uri)) && ($input['SID']!=='homeadmin') && empty($input['nocache']) && $cacheStatus=='Y')
		//if(eregi("\.html",$uri) && empty($input['nocache']) && $cacheStatus=='Y')
		{
			if(is_array($input))
			{
				foreach($input as $varName=>$varValue)
				{
					if(!empty($config['folders'][$varName]))
					{
						$pagePath = $path.$varName.'/'.$varValue.'/'.$uri;
						if(is_file($pagePath))
						{
							if($cacheControlType=='time')
							{
								$time = filemtime($pagePath);
								$endCacheTime = time() - $cacheTime*60*60;		
								if($time > $endCacheTime)
								{
									readfile($pagePath);
									die('');
								}
							}
							else
							{
								readfile($pagePath);
								die('');						
							}
						}
					}
				}  

				$pagePath = $path.$uri;
				if(is_file($pagePath))
				{
					if($cacheControlType=='time')
					{
						$time = filemtime($pagePath);
						$endCacheTime = time() - $cacheTime*60*60;		
						if($time > $endCacheTime)
						{
							readfile($pagePath);
							die('');
						}
					}
					else
					{
						readfile($pagePath);
						die('');						
					}
				}		
				
			}
		}
		
		$this->_setPage='Y';
		$this->_pagePath=$pagePath;
	}
	
	function setPage($pageContent,$input)
	{
		$config = $this->_config;
		$path = $config['CachePath'];
		$cacheStatus = $config['CacheStatus'];
		$cacheControlType = $config['CacheCotrolType'];
		$cacheTime = $config['CacheTime'];
				
		$filename = $this->_pagePath;
		if($this->_setPage=='Y' && $cacheStatus=='Y')
		{
			if(!empty($pageContent))
			{
				if(is_array($input))
				{
					foreach($input as $varName=>$varValue)
					{
						if(!empty($config['folders'][$varName]))
						{
							$pagePath = $path.$varName.'/'.$varValue.'/'.$uri;
							if(!is_dir($path.$varName)) { mkdir($path.$varName);}
							if(!is_dir($path.$varName.'/'.$varValue)) { mkdir($path.$varName.'/'.$varValue);}
							$fp = fopen($filename,'w+');
							fwrite($fp,$pageContent);
							fclose($fp);
							return $pageContent;
						}

						$pagePath = $path.$uri;
						$fp = fopen($filename,'w+');
						fwrite($fp,$pageContent);
						fclose($fp);
						return $pageContent;
						
					}  
					
				}			
			}			
		}
		return $pageContent;
	}	
	
	function deleteCache($folder='')
	{
		$config = $this->_config;
		$path = $config['CachePath'];
		$cacheStatus = $config['CacheStatus'];
		$cacheControlType = $config['CacheCotrolType'];
		$cacheTime = $config['CacheTime'];
		
		if(!empty($folder)) {$path = $path.$folder.'/';}
		$this->deleteCacheRecursive($path);
	}
	
	function deleteCacheRecursive($dir)
	{
		if ($dp=@opendir($dir)) {
			while (false!==($file=readdir($dp))) {
				$filename = $dir.'/'.$file;
				if ($file!='.' && $file!='..' && is_file($filename)) {
					@unlink($filename);
				}
				elseif($file!='.' && $file!='..' && is_dir($filename))
				{
					$this->deleteCacheRecursive($filename);
					@rmdir($filename);
				}
			}
			closedir($dp);
		}			
	}
}
?>
