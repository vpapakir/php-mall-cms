<? //boxHeader(array('title'=>'ManageSettings.core.title'))?>

	<? if(!empty($out['DB']['Settings'][0]['SettingID'])) {?>
	<form name="manageSettings" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<? if(hasRights('root')) {?>
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageSetting/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>/" class="subtitle">[<?=lang('AddSetting.core.link')?>]</a>
					</div>		
					<br/>
					<? } ?>
				<table cellspacing="1" cellpadding="5" border="0" width="100%">
					<? foreach($out['DB']['Settings'] as $row) {?>
					<input type="hidden" name="Setting<?=DTR?>SettingID[]" value="<?=$row['SettingID']?>"/>
					<tr>
						<td valign="top" class="row1" width="70%">
							<b><?=getValue($row['SettingName'])?></b>
							<br/>
							<?=getValue($row['SettingDescription'])?>
							<? if(hasRights('root')) {?>
							<a href="<?=setting('url')?>manageSetting/SettingID/<?=$row['SettingID']?>/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageSettings/Setting<?=DTR?>SettingID/<?=$row['SettingID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteSetting.core.tip')?>')">[<?=lang('-delete')?>]</a>
							&nbsp;<small>(<?=$row['SettingVariableName']?>)</small>
							<? } ?>
						</td>
						<td valign="top" class="row1">
							<? if($row['SettingValueType']=='file') { ?>			
								<? if(!empty($row['SettingValue'])) { ?>
								<a href="<?=setting('urlfiles').$row['SettingValue']?>"><?=lang('-download')?></a>
								<? } ?>			
									<br/>
									<a href="<?=setting('url')?>manageOwnerSettingFile/SettingID/<?=$row['SettingID']?>/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>"><?=lang('-uploadimage')?></a>
							
							<? } elseif($row['SettingValueType']=='image') { ?>
								<? if(!empty($row['SettingValue']) && $row['OwnerID']==setting('OwnerID')) { ?>
									<img src="<?=setting('urlfiles').$row['SettingValue']?>" border="0" width="200" />
									<br/>
									<a href="<?=setting('url').input('SID')?>/SettingID/<?=$row['SettingID']?>/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>/actionMode/deletefile/fileField/SettingValue"><?=lang('-deleteimage')?></a>
								<? } ?>			
									<br/>
									<a href="<?=setting('url')?>manageOwnerSettingFile/SettingID/<?=$row['SettingID']?>/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>"><?=lang('-uploadimage')?></a>
							<? } elseif ($row['SettingValueType']=='color')  { ?>
							<?=getFormated($row['SettingValue'],'Color','form',array('fieldName'=>'Setting'.DTR.'SettingValue_'.$row['SettingID'],'formName'=>'manageSettings'))?>
							<? } elseif ($row['SettingValueType']=='location')  { ?>
							<?=getFormated($row['SettingValue'],'Location','form',array('fieldName'=>'Setting'.DTR.'SettingValue_'.$row['SettingID'],'formName'=>'manageSettings'))?>
							<? } elseif ($row['SettingValueType']=='checkboxes' || $row['SettingValueType']=='radioboxes' || $row['SettingValueType']=='dropdown' || $row['SettingValueType']=='multiple')  { ?>
							<?
								$settingID = $row['SettingID'];
								if(!empty($row['SettingReference']))
								{
									echo getReference($row['SettingReference'],'Setting'.DTR.'SettingValue_'.$settingID,$row['SettingValue'],array('code'=>'Y'));
								}
								else
								{
									$options='';
									$settingOptions = explode(";",$row['SettingValueOptions']);
									if(is_array($settingOptions))
									{
										$i=0;
										foreach($settingOptions as $line)
										{
											$i++;
											$lineValues = explode("|",$line);
											if(!empty($lineValues[0]))
											{
												$options[$i]['id']=trim($lineValues[0]);	
												$options[$i]['value']=trim($lineValues[1]);
											}
										}
									}
									echo getLists($options,$row['SettingValue'],array('name'=>'Setting'.DTR.'SettingValue_'.$settingID,'type'=>$row['SettingValueType']));	
								}
							?>	
							<? } elseif($row['SettingValueType']=='text') { $settingID = $row['SettingID']; foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
								<br/>
								<textarea name="Setting<?=DTR?>SettingValue_<?=$settingID?>[<?=$langCode?>]" cols="40" rows="3"><?=getValue($row['SettingValue'],$langCode);?></textarea>
								<? /*br/>
								<a href="<?=setting('url')?>editSettingText/SettingID/<?=$row['SettingID']?>/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>"><?=lang('EditSettingText.core.link')?></a>
								<br/*/ ?>
							<? } } else { ?>
							<input type="text" name="Setting<?=DTR?>SettingValue[<?=$row['SettingID']?>]" value="<?=getValue($row['SettingValue'])?>" size="30"/>
							<? } ?>
						</td>										
					</tr>	
				<? } ?>					
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['Settings'][0]['SettingID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
			<br/>
			<div align="center">
			<a href="<?=setting('url')?>manageSetting/GroupID/<?=input('GroupID')?>/Level2GroupID/<?=input('Level2GroupID')?>" class="boldLink">[<?=lang('AddSetting.core.link')?>]</a>
			</div>		
			<br/>			
			<br><br>
				<?=lang('NoSettingFound.core.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<? //boxFooter()?>