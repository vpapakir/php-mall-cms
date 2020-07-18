<?
	if(count($systemMessages)>0)
	{
		$messages = ' <tr>
		<td height="23" align="left" valign="middle" class="systemmessages">';
		foreach($systemMessages as $messageCode=>$messageValue)
		{
			if(eregi("\.msg\.",$messageCode))
			{
				$messages .= '<font color="#00FF00">';
			}
			else
			{
				$messages .= '<font color="#FF0000">';
			}
			if(is_array($messageValue))
			{
				$messages .= lang($messageCode).' '.$messageValue[1].'<br/>';
			}
			else
			{
				$messages .= lang($messageCode).'<br/>';
			}
			$messages .= '</font>';
		}
		$messages .= '	 </td>
	  </tr>   
	  <tr>
		<td background="'.setting('layout').'images/grd.gif"><img src="'.setting('layout').'images/grd.gif" width="1" height="1"></td>
	  </tr>';	
	}
?>