<? if(!empty($user['UserID'])) { $prevLevel =1; $i=1; $result='';?>
<? $count = count($out['DB']['Sections']);  
//print_r($out['DB']['Sections']);
foreach($out['DB']['Sections'] as $id=>$row) {
	
	if(!empty($row['SectionLink']))
	{
		$sectionLink = $row['SectionLink'];
		$SectionTarget = $row['SectionTarget'];
		if($row['SectionAlias']=='website'){
			$sectionLink = setting('rooturl').'go/'.setting('lang').'/home/frontBackLinkAction/do/';
		}
	}
	else
	{
		if($row['SectionAlias']=='support'){
			if(!empty($config['SystemLicense'])){
				$sectionLink = "http://coorda.com/coobox/support/support_mailbox.php?serial=".setting('SystemLicense');		
			 	$SectionTarget = "_blank";
			 }
		} elseif($row['SectionAlias']=='website'){
			$sectionLink = setting('rooturl').'go/'.setting('lang').'/home/frontBackLinkAction/do/';
		}else{
			$sectionLink = setting('url').$row['SectionAlias'];
			$SectionTarget = $row['SectionTarget'];
		}
	}
	//echo setting('url')."---<br/>";
	//print_r($config);
	$result .= $endTag.$prevMenu;
	if(!empty($row['SectionIcon'])) {$sectionIcon = "'".$row['SectionIcon']."'";} else {$sectionIcon ='null';}
	if($row['SectionAlias']=='username') $row['SectionName'] = user('UserName'); 
	$prevMenu = "[".$sectionIcon.", '".getValue($row['SectionName'])."', '".$sectionLink."', '".$SectionTarget."', null";
		if($i>1)
		{
			if($row['SectionLevel']>$prevLevel )
			{
				$endTag = ",\n";
			}
			elseif($row['SectionLevel']<$prevLevel)
			{
				$dif = $prevLevel - $row['SectionLevel'];
				$closeTag = '';
				for ($i = 0; $i < $dif; $i++)
				{
					$closeTag .= ']';
				}
				$endTag = "]\n".$closeTag.",\n"; //$closeTag='';
			}
			else
			{
				$endTag = "],\n";
			}
			
			 $prevLevel = $row['SectionLevel'];
		}
		 $i++;
	}
$result .= $endTag.$prevMenu."]]\n";
//echo $result;
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="100%" id="topMenuID" height="23">&nbsp;</td>		
	</tr>
</table>
<script language="JavaScript"><!-- 
	var topMenu =
	[
		<?=$result?>
	];
--></script>
	<script language="JavaScript"><!--
		cmDraw ('topMenuID', topMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
	--></script>
<? } ?>