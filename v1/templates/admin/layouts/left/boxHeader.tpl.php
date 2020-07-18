<? if(is_array($out['DB']['tabs'])) { $formName= $out['formName']; ?>
	<tr> 
		<td height=25  valign=middle bgcolor="#eeeeee">
			<?  foreach($out['DB']['tabs'] as $row) { ?>
			<? if(!empty($formName)) { ?>
			<?
				if(!empty($row['TabLinkValue'])) 
				{
					
					$parts = explode("/",$row['TabLinkValue']); $partsNumber = count($parts)-1;
					$link = 'document.'.$formName.'.SID.value=\''.$parts[0].'\';';
					for ($i = 1; $i <= $partsNumber; $i=$i+2)
					{
						$valueNumber = $i+1; $variableValue = $parts[$valueNumber]; $variableName = $parts[$i];
						$link .= 'document.'.$formName.'.'.$variableName.'.value=\''.$variableValue.'\';';
					}	
				}				
			?>
			<a href="#" onClick="javascript:document.<?=$formName?>.tabLink.value='<?=$row['TabLinkID']?>';<?=$link?>document.<?=$formName?>.submit();"><b>[<?=getValue($row['TabLinkName'])?>]</b></a>
			<? } else { ?>
			<a href="<?=setting('url').$row['TabLinkValue'].'/'.$out['tabslink']?>/tabLink/<?=$row['TabLinkID']?>/" target="<?=$row['TabLinkTarget']?>"><b>[<?=getValue($row['TabLinkName'])?>]</b></a>
			<? } } ?> 
			<? if(hasRights('root')) { ?><a href="<?=setting('url')?>manageTabLinks/TabLinkAlias/<?=$out['tabs']?>/" target="_blank">[+]</a> <? } ?>
			
		</td> 
	</tr>
<? } ?>	
<? if (!empty($out['title'])) { ?>
<?
	if(setting('BoxHeaderBackgroundImage')) {$BoxHeaderBackground = ' background="'.setting('urlfiles').setting('BoxHeaderBackgroundImage').'"';}
	else{$BoxHeaderBackground = ' bgcolor="'.setting('BoxHeaderBackgroundColor').'"';}

?>
	<tr>
		<td  height="25" align="center" valign="middle" <?=$BoxHeaderBackground?> class="boxtitle"><? if(eregi('\.title',$out['title'])) { echo lang($out['title']); } else { echo $out['title']; }?></td>
	</tr>
  <? } ?>
  <tr> 
	<td bgcolor="#FFFFFF" class="boxContent" align="center" valign="top">
		<table cellpadding="0" cellspacing="0"  border="0" width="100%" >  