<?php
class StyleClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	var $_settings;
	var $_currentLevel;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function StyleClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$DS = new DataSource('main');
		$this->_DS = &$DS;
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$this->_currentLevel = 1;	
	}
	// PUBLIC METHODS
     /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getStyle($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StyleServer.getStyle.Start','Start');
		$DS = &$this->_DS;
		//print_r($input);
		$config = $this->_config;
		$user = $this->_user;
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Style'.DTR.'StyleID'];
		if(empty($entityID)) {$entityID = $input['Style'];}
		$entityAlias = $input['Style'.DTR.'StyleAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['StyleAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['Style'];}
		//set filters
		//set queries
		$query = "Style[StyleAlias='$entityAlias' $filter]/"; 
		//get the content
		//echo $query;
		$result = $DS->query($query); 		

		$SERVER->setDebug('StyleServer.getStyle.End','End');		
		return $result;		
	}
	/**
    * gets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getStyles($input='')
	{
		//get global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$manageMode = $input['manageMode'];
		$searchWord = $input['searchWord'];
		$orderMode = $input['orderMode'];
		$orderField = $input['orderField'];
		//set filters
		//set queries
			
		$settinggroupID = '11365480442006051812025318f111';
		$order = 'SettingName';
			
		$result = $DS->query("SELECT * FROM Setting WHERE SettingGroup='$settinggroupID' ORDER BY $order ASC");
		//get the content
		$SERVER->setDebug('StyleServer.getStyles.End','End');
		return $result;
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setStyle($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StyleServer.setStyle.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$styleRS = $this->getStyles($input);
		$i = 0;
		foreach($styleRS as $key=>$row){
			if(ereg("box",$row['SettingVariableName'])){
				$boxs[$row['SettingVariableName']] = $row;
				$i++;
			}
		}
		
		foreach($styleRS as $key=>$row){
			$styles[$row['SettingVariableName']] = $row;
		}
		
		$style .= "div.popup {
						position: absolute;
						display: none;
						padding: 3px;
						border: 1px solid #999999;
						background-color: #FDFDFD;
						z-index: 99;
					}\n
					div.popup p {
						margin: 0;
					}\n
					div.popup ul {
						margin: 0 0 .3em;
						padding: 0 0 0 1.8em;
					}\n\n
					";
		$defStyleName = $config['OwnerStyle'].'.styles.box.defaultbox';			
		$style .= "body{\n"
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."font-size:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						."color:".$styles[getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'color'))].";\n"
						."font-weight: ".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
						."background-image:".setting('urlfiles').setting('page.PageBackground').";\n"
						."background-color:".setting('page.PageColor').";\n"
					."}\n"	
					."hr{border-width:".setting('HRWidth').";\n"
					."}\n"	
					."a:hover \n{"
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."color:".$styles[getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"
						."text-decoration:".setting('styles.LinkHoverDecoration').";\n"
					."}\n"	
					."a {\n"	 
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."text-decoration:".setting('styles.LinkDecoration').";\n"
						."color:".$styles[getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n"
					."}\n"	
					."a.td {\n"	 
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."text-decoration:".setting('styles.LinkDecoration').";\n"
						."color:".$styles[getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n"
					."}\n"	
					."a.td:hover \n{"
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."color:".$styles[getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"
						."text-decoration:".setting('styles.LinkHoverDecoration').";\n"
					."}\n"
					/*."td{\n"	
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."font-size:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						."color:".$styles[getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
						."font-weight:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					."}\n"*/
					."input, textarea, select, file {\n" 
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textareainputfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."font-size:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textareainputfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						."color:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textareainputfont'))]['SettingValue'],'Style','',array('name'=>'color')).";\n"
						."background-color:".$styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textareabackgroundcolor'))]['SettingValue'].";\n"
					."}\n"
					.".input { \n"
						."font-family:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						."font-size:".getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						."color:".$styles[getFormated($styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
						."background-color:".$styles[getFormated($styles[$defStyleName]['SettingValue'],'Style','',array('name'=>'textareabackgroundcolor'))]['SettingValue'].";\n"
					."}\n";
		//print_r($boxs);	
		foreach($boxs as $id=>$value){
			$name = $value['SettingVariableName'];
			$stylename = str_replace($config['OwnerStyle'].'.styles.box.',"",$value['SettingVariableName']);

			if(!empty($stylename)){
				if($stylename=='defaultcenter'){
					$style .= " td{\n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'boxfill'))]['SettingValue'].";\n"
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'topmargin')).";\n"
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin')).";\n"
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin')).";\n"
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin')).";\n"
					."}\n\n".
					" .text{ \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
						.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'boxfill'))]['SettingValue'].";\n"
						.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'topmargin')).";\n" 
						.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin')).";\n"
						.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin')).";\n"
						.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin')).";\n"
					."}\n\n".
					" a.text{ \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n" 
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					."}	\n\n".
					" a.text:hover { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n" 
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"  
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"  
					."}	\n\n".
					" td.subtitleline {\n"
						.'height:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecellfontsizes')).";\n"   
						.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecell'))]['SettingValue'].";\n"  
					."}	\n\n".
					" .boxtitle{ \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"  
						.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"  
						.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'header'))]['SettingValue'].";\n"  
						.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n"
						.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n"
						.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n"
						.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n"
					."}	\n\n".
					" .boxtitle a{ \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"  
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n"  
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"  
						.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"  
					."}	\n\n".
					" .boxtitle a:hover{ \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"  
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
						.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n" 
					."}	\n\n".
					" .subtitle { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n" 
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
						.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n" 
						.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefontside')).";\n"  
					."}	\n\n".
					" td.subtitle{ \n"
						.'height:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecellfontsizes'))."px;\n"  
						.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecell'))]['SettingValue'].";\n" 
						.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n"   
						.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n"  
						.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n"  
						.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n"  
						.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefontside')).";\n"
					."}	\n\n".
					" a.subtitle { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n"
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					."}	\n\n".	
					" a.subtitle:hover { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					."}	\n\n".
					
					" .introductionfont  { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
						.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfontside')).";\n"
						.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"
						.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n" 
						.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n" 
						.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n" 
						.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n" 
					."}	\n\n".
					" a.introductionfont   { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					."}	\n\n".	
					" a.introductionfont:hover   { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					."}	\n\n".
					
					" .listingfont { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
						.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfontside')).";\n"
						.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"
						.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n" 
						.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n" 
						.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n" 
						.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n" 
					."}	\n\n".
					" a.listingfont { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					."}	\n\n".
					" a.listingfont:hover { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					."}	\n\n".
					
					" .commentfont { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
						.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfontside')).";\n"
						.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"
						.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n" 
						.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n" 
						.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n" 
						.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n" 
					."}	\n\n".
					" a.commentfont { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					."}	\n\n".
					" a.commentfont:hover { \n"
						.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
						.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
						.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n" 
						.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					."}	\n\n";
				}
				
				$style .= '.'.$stylename." td{\n"
				.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
				.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
				.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
				.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
				.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'boxfill'))]['SettingValue'].";\n"
				.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'topmargin')).";\n"
				.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin')).";\n"
				.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin')).";\n"
				.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin')).";\n"
				."}\n\n".
				'.'.$stylename." .text{ \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'boxfill'))]['SettingValue'].";\n"
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'topmargin')).";\n" 
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin')).";\n"
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin')).";\n"
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin')).";\n"
				."}\n\n".
				'.'.$stylename." a.text{ \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n" 
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
				."}	\n\n".
				'.'.$stylename." a.text:hover { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n" 
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"  
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'textfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"  
				."}	\n\n".
				" td.subtitleline {\n"
					.'height:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecellfontsizes')).";\n"   
					.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecell'))]['SettingValue'].";\n"  
				."}	\n\n".
				'.'.$stylename." .boxtitle{ \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"  
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"  
					.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'header'))]['SettingValue'].";\n"  
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n"
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n"
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n"
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n"
				."}	\n\n".
				'.'.$stylename." .boxtitle a{ \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"  
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n"  
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"  
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"  
				."}	\n\n".
				'.'.$stylename." .boxtitle a:hover{ \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"  
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'titlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n" 
				."}	\n\n".
				'.'.$stylename." .subtitle { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n" 
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n"
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n" 
					.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefontside')).";\n"  
				."}	\n\n".
				
				
				'.'.$stylename." td.subtitle{ \n"
					.'height:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecellfontsizes'))."px;\n"  
					.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlecell'))]['SettingValue'].";\n" 
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n"   
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n"  
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n"  
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n"  
					.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefontside')).";\n"
				."}	\n\n".
				'.'.$stylename." a.subtitle { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n"
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
				."}	\n\n".	
				'.'.$stylename." a.subtitle:hover { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'subtitlefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
				."}	\n\n".
				
				'.'.$stylename." .introductionfont  { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfontside')).";\n"
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n" 
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n" 
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n" 
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n" 
				."}	\n\n".
				'.'.$stylename." a.introductionfont   { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
				."}	\n\n".	
				'.'.$stylename." a.introductionfont:hover   { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n"
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'introductionfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
				."}	\n\n".
				
				'.'.$stylename." .listingfont { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfontside')).";\n"
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n" 
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n" 
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n" 
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n" 
				."}	\n\n".
				'.'.$stylename." a.listingfont { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
				."}	\n\n".
				'.'.$stylename." a.listingfont:hover { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'listingfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
				."}	\n\n".
				
				'.'.$stylename." .commentfont { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfontside')).";\n"
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n" 
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n" 
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n" 
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n" 
				."}	\n\n".
				'.'.$stylename." a.commentfont { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'linkcolor'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n" 
				."}	\n\n".
				'.'.$stylename." a.commentfont:hover { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'hovercolor'))]['SettingValue'].";\n" 
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'commentfont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
				."}	\n\n".

				'.'.$stylename." .message { \n"
					.'font-family:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'fonts')).";\n"
					.'font-size:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'fontsizes'))."px;\n" 
					.'color:'.$styles[getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'color'))]['SettingValue'].";\n"
					.'font-weight:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'fontweights')).";\n"
					.'text-align:'.getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefontside')).";\n"
					.'font-style:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'fontstyles')).";\n"
					.'margin-top:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'topmargin'))."px;\n" 
					.'margin-left:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'leftmargin'))."px;\n" 
					.'margin-right:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'rightmargin'))."px;\n" 
					.'margin-bottom:'.getFormated($styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagefont'))]['SettingValue'],'Style','',array('name'=>'bottommargin'))."px;\n" 
					.'background-color:'.$styles[getFormated($styles[$name]['SettingValue'],'Style','',array('name'=>'messagecell'))]['SettingValue'].";\n"
				."}	\n\n";
			}
		}
		
		$stylePath = $config['RootPath'].'templates/front/layouts/default/css/style.css';
		$fp = fopen($stylePath,'w+');
		fwrite($fp,$style);
		fclose($fp);
		
	 /*
	
				
				
				
				
	
	
	
	
	
	
	
	*/	
			
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteStyle($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StyleServer.deleteStyle.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Style'.DTR.'StyleID'];
		if(empty($entityID)) {$entityID = $input['StyleID'];}		
		//set filters
		//set queries
		$input['actionMode']='delete';
		$where['Style'] = "StyleID = '".$entityID."'$filter";
		$result = $DS->save($input,$where);	
//		$SERVER->setMessage('StyleServer.deleteStyle.msg.DataDeleted');
		$SERVER->setDebug('StyleServer.deleteStyle.End','End');		
		return $result;		
	}	
	
	
	/*function setIndexPage($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('StyleServer.setStyle.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		if(!$handle = fopen("../index.html",'w'))
		{
			echo "Cannot open to file";
			exit;
		}
		
		$input['Content'] = stripslashes($input['Content']);
		$decode = html_entity_decode($input['Content']);
		$Content = $decode;
		
		if(fwrite($handle,$Content)===FALSE)
		{
			echo "Cannot write to file";
			exit;
		}
			else
			{ 
				//echo "write to file";
			}
		
		fclose($handle);
	}*/	
} // end of StyleServer
?>