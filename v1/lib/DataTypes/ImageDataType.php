<?
class ImageDataType
{
    // PRIVATE PROPERTIES
	var $_config;
	var $_input;
	var $_controller;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function ImageDataType($controller)
	{
		//global $CORE;
		$this->_controller = &$controller;
		$this->_config = $controller->getConfig();
		$this->_input = $controller->getInput();
	}	
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value to show in output
 	*/	
	function getDataType($value,$options='')
	{
		$config = $this->_config;
		
		$attributes = $options['attributes'];
		$lang = $options['lang'];
		if(!empty($lang))
		{
			$value = getValue($value,$lang);
		}
		
		if($options['fieldValue']){
			$result = '<a href="javascript://" onClick="popup(\''.setting('urlfiles').$value.'\')" class="subtitle"><img src="'.setting('urlfiles').$options['fieldValue'].'" border="0" '.$attributes.' /></a>';
		}else{
			$result = '<img src="'.setting('urlfiles').$value.'" border="0" '.$attributes.' />';
		}
		return $result;
	}
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function setDataType($value,$options='')
	{
		$config = $this->_config;
		$result = $value;
		return $result;
	}

	function formDataType($value,$options)
	{
		$config = $this->_config;
		//$value = getValue($value);
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		$langCode = $options['langCode'];
		$langMode = $options['langMode'];
		$deleteLink = $options['deleteLink'];
		$deleteLinkOnClick = $options['deleteLinkOnClick'];
		
		$heightLimit = $options['heightLimit'];
		$widthLimit = $options['widthLimit'];
		$limitsStringMode = $options['limitsStringMode'];
		
		$attributes = $options['attributes'];

		if(ereg('Icon',$fieldName))
		{
			$heightLimitString = $config['ImageIconHeightLimit'];
			$widthLimitString = $config['ImageIconWidthLimit'];
			$imageSizeType = 'icon';
		}
		elseif(ereg('Preview',$fieldName))
		{
			$heightLimitString = $config['ImagePreviewHeightLimit'];
			$widthLimitString = $config['ImagePreviwWidthLimit'];
			$imageSizeType = 'preview';
		}
		else
		{
			$heightLimitString = $config['ImageHeightLimit'];
			$widthLimitString = $config['ImageWidthLimit'];
			$imageSizeType = 'full';
		}
		
		if(!empty($options['imageSizeType']))
		{
			$imageSizeType = $options['imageSizeType'];
		}
		//$imageSizeType = '';
		if(!empty($heightLimit)) {$heightLimitString = $heightLimit;}
		if(!empty($widthLimit)) {$widthLimitString = $widthLimit;}
		$limitsString = lang('-imageHeightLimit').': '.$heightLimitString.' px '. lang('-imageWidthLimit').': '.$widthLimitString.' px<br/>';
		if($limitsStringMode=='N') {$limitsString='';}
		if($langMode=='Y')
		{
			$languagesList = $this->_controller->getLanguages();
			if(is_array($languagesList))
			{
				foreach($languagesList['languageCodes'] as $langID=>$langCodeID) {
					$langValue = getValue($value,$langCodeID);
					$options['fieldValue'] = getValue($options['fieldValue']);
					if(!empty($langValue)) {
						$result .= $this->getDataType($langValue,$options);
						$result .= '<br/>';
						if(!empty($deleteLinkOnClick))
						{
							$result .= '<a href="#" onClick="javascript:'.$deleteLinkOnClick.'document.'.$formName.'.lang.value=\''.$langCodeID.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>';
						}
						elseif(!empty($deleteLink))
						{
							$result .= $deleteLink;
						}
						$result .= '<br/>';
					}
					else
					{
						if($imageSizeType=='icon')
						{
							$imageSizeType='';
						}
					}	
					if(!empty($langCode))
					{
						$result .= lang($langCode.'.'.$fieldName).': ';
					}
					if(count($languagesList['languageNames'])>1) { $result .= $languagesList['languageNames'][$langID];}
					$result .= '<br/>';
					$result .= $limitsString;
					$result .= '<input size="22" type="file" name="uploadFile['.$fieldName.'_lang_'.$langCodeID.']" />';
					$result .= '<input type="hidden" name="oldUploadFile['.$fieldName.'_lang_'.$langCodeID.']" value="'.$langValue.'" />';
					if(!empty($imageSizeType))
					{
						$result .= '<input type="hidden" name="uploadFileSettings['.$fieldName.'_lang_'.$langCodeID.'][ImageSizeType]" value="'.$imageSizeType.'" />';
					}
					$result .= '<br/><br/>';
							
				}
			}			
		}
		else
		{
			$result .= '<br/>';			
			if(!empty($value)) {
				$result .= $this->getDataType($value,$options);
				$result .= '<br/>';
				$result .= $deleteLink;
				$result .= '<br/>';
			}
			else
			{
				if($imageSizeType=='icon')
				{
					$imageSizeType='';
				}
			}			
			if(!empty($langCode))
			{			
				$result .= lang($langCode.'.'.$fieldName).':<br/>';
			}
			$result .= $limitsString;
			$result .= '<input size="22" type="file" name="uploadFile['.$fieldName.']" />';
			if(!empty($widthLimit))
			{
				$result .= '<input type="hidden" name="uploadFileSettings['.$fieldName.'][ImageWidthLimit]" value="'.$widthLimit.'" />';
			}
			if(!empty($heightLimit))
			{
				$result .= '<input type="hidden" name="uploadFileSettings['.$fieldName.'][ImageHeightLimit]" value="'.$heightLimit.'" />';
			}		
			if(!empty($imageSizeType))
			{
				$result .= '<input type="hidden" name="uploadFileSettings['.$fieldName.'][ImageSizeType]" value="'.$imageSizeType.'" />';
			}
			$result .= '<input type="hidden" name="oldUploadFile['.$fieldName.']" value="'.$value.'" />';
			$result .= '<br/><br/>';
		}

		return $result;
	}	
}
?>