<?
	$messages = '';
	if(count($systemMessages)>0)
	{
		$messages = '<table cellpadding="10" cellspacing="1" border="0" width="100%">
	<tr>
		<td bgcolor="#FFFFFF" height="20" align="center"><font color="#FF0000">';
		foreach($systemMessages as $messageCode=>$messageValue)
		{
			if(is_array($messageValue))
			{
				$messages .= lang($messageCode).' '.$messageValue[1].'<br/>';
			}
			else
			{
				$messages .= lang($messageCode).'<br/>';
			}
		}
		$messages .= '</font></td>
			</tr>
		</table>';		
	}
?>