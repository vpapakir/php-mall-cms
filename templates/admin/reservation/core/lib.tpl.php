<?
	function getFont($param,$out)
	{
		foreach($out['DB']['Settings'] as $value)
		{
			if($param == $value['SettingVariableName'])
			{
				//$result =  $value['SettingValue'];
				$result['fontRS'] = getFormated($value['SettingValue'],'Style','',array('name'=>'fonts'));
				$result['fontsizes'] = getFormated($value['SettingValue'],'Style','',array('name'=>'fontsizes'));
				$result['fontweights'] = getFormated($value['SettingValue'],'Style','',array('name'=>'fontweights'));
				$result['colorRS'] = getColor(getFormated($value['SettingValue'],'Style','',array('name'=>'color')),$out);
				$result['fontstyles'] = getFormated($value['SettingValue'],'Style','',array('name'=>'fontstyles'));
				$result['fontdecorations'] = getFormated($value['SettingValue'],'Style','',array('name'=>'fontdecorations'));
				$result['linkcolor'] = getColor(getFormated($value['SettingValue'],'Style','',array('name'=>'linkcolor')),$out);
				$result['hovercolor'] = getColor(getFormated($value['SettingValue'],'Style','',array('name'=>'hovercolor')),$out);
				$result['topmargin'] = getFormated($value['SettingValue'],'Style','',array('name'=>'topmargin'));
				$result['leftmargin'] = getFormated($value['SettingValue'],'Style','',array('name'=>'leftmargin'));
				$result['rightmargin'] = getFormated($value['SettingValue'],'Style','',array('name'=>'rightmargin'));
				$result['bottommargin'] = getFormated($value['SettingValue'],'Style','',array('name'=>'bottommargin'));
			}
		}
		return $result;
	}
	
	function getColor($param,$out)
	{
		foreach($out['DB']['Settings'] as $value)
		{
			if($param == $value['SettingVariableName'])
			{
				$result =  $value['SettingValue'];
			}
		}
		return $result;
	}
	
?>