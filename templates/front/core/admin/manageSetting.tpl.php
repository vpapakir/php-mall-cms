<?=boxHeader(array('title'=>'ManageSettings.core.title'))?>
	<form name="manageSettings" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="settingsadminfront" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
		<input type="hidden" name="SettingID" value="<?=input('SettingID')?>" />
		<? if(empty($out['DB']['Setting'][0]['SettingID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$out['DB']['Setting'][0]['SettingID']?>">
		<? } ?>		
		<!--input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$out['DB']['Setting'][0]['SettingID'];?>" /-->
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('Setting.SettingGroup')?>*:<br/>
							<? if(!empty($out['DB']['Setting'][0]['SettingGroup'])) {$currentGroupID = $out['DB']['Setting'][0]['SettingGroup'];} else {if(input('Level2GroupID')) {$currentGroupID = input('Level2GroupID');} else{ $currentGroupID = input('GroupID');}} ?>
							<? if(input('Level2GroupID')) { ?>
								<?=getLists($out['DB']['SettingGroupLevel2'],$currentGroupID,array('name'=>'Setting'.DTR.'SettingGroup','id'=>'SettingGroupID','value'=>'SettingGroupName','style'=>"width:300px;"))?>
							<? } else { ?>
								<?=getLists($out['DB']['SettingGroups'],$currentGroupID,array('name'=>'Setting'.DTR.'SettingGroup','id'=>'SettingGroupID','value'=>'SettingGroupName','style'=>"width:300px;"))?>
							<? } ?>
							<br/>
							<?=lang('Setting.SettingVariableName')?>*:<br/>
							<input type="text" name="Setting<?=DTR?>SettingVariableName" value="<?=$out['DB']['Setting'][0]['SettingVariableName'];?>" size="30">
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Setting.SettingName')?>*: 
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
								<br/>
								<input type="text" name="Setting<?=DTR?>SettingName[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['Setting'][0]['SettingName'],$langCode);?>">
								<br/>
							<? } ?>									
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Setting.SettingDescription')?>: 
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
								<br/>
								<textarea name="Setting<?=DTR?>SettingDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Setting'][0]['SettingDescription'],$langCode);?></textarea>
								<br/>
							<? } ?>			
							<?=lang('Setting.SettingValueType')?>*:<br/>
							<?=getReference('DataTypes','Setting'.DTR.'SettingValueType',$out['DB']['Setting'][0]['SettingValueType'],array('code'=>'Y','action'=>'document.manageSettings.SID.value=\'manageSetting\';submit();'))?>
							<br/>
							<? if ($out['DB']['Setting'][0]['SettingValueType']=='checkboxes' || $out['DB']['Setting'][0]['SettingValueType']=='radioboxes' || $out['DB']['Setting'][0]['SettingValueType']=='dropdown'  || $out['DB']['Setting'][0]['SettingValueType']=='multiple') { ?>							
							<?=lang('Setting.SettingReference')?>:<br/>
							<? $options[0]['id']=' '; $options[0]['value']='-';?>
							<?=getLists($out['DB']['SettingReferences'],$out['DB']['Setting'][0]['SettingReference'],array('name'=>'Setting'.DTR.'SettingReference','id'=>'ReferenceCode','value'=>'ReferenceName','options'=>$options))?>
							<br/>
							<?=lang('Setting.SettingValueOptions')?>:<br/>
							<textarea name="Setting<?=DTR?>SettingValueOptions" cols="40" rows="5"><?=$out['DB']['Setting'][0]['SettingValueOptions'];?></textarea>
							<br/><br/>
							<? } ?>
							<?  if ($out['DB']['Setting'][0]['SettingValueType']=='checkboxes' || $out['DB']['Setting'][0]['SettingValueType']=='radioboxes' || $out['DB']['Setting'][0]['SettingValueType']=='dropdown' || $out['DB']['Setting'][0]['SettingValueType']=='multiple')  { ?>
							<?=lang('Setting.SettingValue')?>:<br/>
							<?
								if(!empty($out['DB']['Setting'][0]['SettingReference']))
								{
									echo getReference($out['DB']['Setting'][0]['SettingReference'],'Setting'.DTR.'SettingValue',$out['DB']['Setting'][0]['SettingValue'],array('code'=>'Y'));
								}
								else
								{							
									$settingOptions = explode(";",$out['DB']['Setting'][0]['SettingValueOptions']);
									if(is_array($settingOptions))
									{
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
									echo getLists($options,$out['DB']['Setting'][0]['SettingValue'],array('name'=>'Setting'.DTR.'SettingValue','type'=>$out['DB']['Setting'][0]['SettingValueType']));	
								}
							?>	
							<br/>	
							<br/>
							<? } elseif($out['DB']['Setting'][0]['SettingValueType']=='text') { foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Setting.SettingValue')?>: 
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
								<br/>
								<textarea name="Setting<?=DTR?>SettingValue[<?=$langCode?>]" cols="40" rows="3"><?=getValue($out['DB']['Setting'][0]['SettingValue'],$langCode);?></textarea>
								<br/>
							<? } } elseif($out['DB']['Setting'][0]['SettingValueType']=='image') { ?>
							<?=lang('Setting.SettingValue')?>:<br/>
							<? if(!empty($out['DB']['Setting'][0]['SettingValue'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['Setting'][0]['SettingValue']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/SettingID/<?=$out['DB']['Setting'][0]['SettingID']?>/GroupID/<?=input('GroupID')?>/actionMode/deletefile/fileField/SettingValue"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<input size="22" type="file" name="uploadFile[SettingValue]" />
							<input type="hidden" name="oldUploadFile[SettingValue]" value="<?=$out['DB']['Setting'][0]['SettingValue']?>" />
							<br/>	
							<br/>
							<? } elseif($out['DB']['Setting'][0]['SettingValueType']=='file') { ?>
							<?=lang('Setting.SettingValue')?>:<br/>
							<? if(!empty($out['DB']['Setting'][0]['SettingValue'])) { ?>
								<a href="<?=setting('urlfiles').$out['DB']['Setting'][0]['SettingValue']?>"><?=lang('-download')?></a>
								<br/>
								<a href="<?=setting('url').input('SID')?>/SettingID/<?=$out['DB']['Setting'][0]['SettingID']?>/GroupID/<?=input('GroupID')?>/actionMode/deletefile/fileField/SettingValue"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<input size="22" type="file" name="uploadFile[SettingValue]" />
							<input type="hidden" name="oldUploadFile[SettingValue]" value="<?=$out['DB']['Setting'][0]['SettingValue']?>" />
							<br/>	
							<br/>												
							<? } elseif($out['DB']['Setting'][0]['SettingValueType']=='styletype') { ?>
								<br/>
								<?=lang('StyleColor.setting.tip')?><br/>
								<?=getReference('color','Setting'.DTR.'SettingValue[color]',getFormated($out['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'color')),array('code'=>'Y'));?>
								<? //getFormated($out['DB']['Setting'][0]['SettingOptionStyle'],'Style','form',array('name'=>'color'))?>
								<br/>
								<?=lang('StyleSize.setting.tip')?><br/>
								<input type="text" name="Setting<?=DTR?>SettingValue[size]" value="<?=getFormated($out['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'size'));?>" size="15">
								<br/>
								<? //getFormated($out['DB']['Setting'][0]['SettingValue'],'Style','form',array('name'=>'size'))?>
								<?=lang('StyleFonts.setting.tip')?><br/>
								<?=getReference('fonts','Setting'.DTR.'SettingValue[fonts]',getFormated($out['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fonts')),array('code'=>'Y'));?>
								<br/>
								<?=lang('StyleWeights.setting.tip')?><br/>
								<?=getReference('fontweights','Setting'.DTR.'SettingValue[fontweights]',getFormated($out['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontweights')),array('code'=>'Y'));?>
								<br/>
								<?=lang('StyleFontStyles.setting.tip')?><br/>
								<?=getReference('fontstyles','Setting'.DTR.'SettingValue[fontstyles]',getFormated($out['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontstyles')),array('code'=>'Y'));?>
								<br/>
							<? } else { ?>
							<?=lang('Setting.SettingValue')?>:<br/>
							<input type="text" name="Setting<?=DTR?>SettingValue" value="<?=$out['DB']['Setting'][0]['SettingValue'];?>" size="30">
							<br/>	
							<br/>
							<? } ?>
							<br/>
							<?=lang('-addafter')?>:
							&nbsp;
							<?
								$options = '';
								$options[0]['id']='1';	
								$options[0]['value']='- '.lang('-first').' -';
								if(is_array($out['DB']['Settings']))
								{
									foreach($out['DB']['Settings'] as $row)
									{
										if ($row['SettingID']!=$out['DB']['Setting'][0]['SettingID'])
										{
											$i++;
											$options[$i]['id']=$row['SettingPosition']+1;	
											$options[$i]['value']=$row['SettingName'];
										}
									}
								}
								echo getLists('',$out['DB']['Setting'][0]['SettingPosition']-1,array('name'=>'Setting'.DTR.'SettingPosition','id'=>'SettingPosition','value'=>'SettingName','options'=>$options));	
								$options='';
							?>
							<br/><br/>
							
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['Setting'][0]['SettingID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageSettings.actionMode.value='delete';confirmDelete('manageSettings', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageSettings.actionMode.value='cancell';submit();">
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>