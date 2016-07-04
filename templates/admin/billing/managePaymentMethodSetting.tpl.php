<?=boxHeader(array('title'=>'ManagePaymentMethodSettings.billing.title'))?>
	<!-- <tr> 
	<form name="getPaymentMethodSettings" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td valign=top bgcolor="#ffffff" >
				<?=getLists($out['DB']['PaymentMethodSettingGroups'],input('GroupID'),array('name'=>'GroupID','id'=>'PaymentMethodSettingGroupID','value'=>'PaymentMethodSettingGroupName','action'=>'submit();','style'=>'width:230px;'))?>
				<br/><br/>
				<?=$out['Refs']['PaymentMethodSettingGroups']?><? if (hasRights('root')) {?>&nbsp;&nbsp;<a href="<?=setting('url')?>managePaymentMethodSettingGroups">[<?=lang('EditPaymentMethodSettingGroup.billing.link')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageStyle">[<?=lang('EditStyleFile.billing.link')?>]</a> <? } ?>
			</td> 
		</form>
	</tr> --> 
	<form name="managePaymentMethodSetting" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="managePaymentMethod" />
		<input type="hidden" name="PaymentMethodID" value="<?=input('PaymentMethodID')?>" />
		<input type="hidden" name="PaymentMethodSettingID" value="<?=input('PaymentMethodSettingID')?>" />
		<? if(empty($out['DB']['PaymentMethodSetting'][0]['PaymentMethodSettingID'])) { ?>
		<input type="hidden" name="actionMode" value="add1" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="PaymentMethodSetting<?=DTR?>PaymentMethodSettingID" value="<?=$out['DB']['PaymentMethodSetting'][0]['PaymentMethodSettingID']?>">
		<? } ?>		
		<!--input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$out['DB']['Setting'][0]['SettingID'];?>" /-->
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
							<?=getLists($out['DB']['PaymentMethods'],input('PaymentMethodID'),array('name'=>'PaymentMethodSetting'.DTR.'PaymentMethodID','id'=>'PaymentMethodID','value'=>'PaymentMethodName','action'=>'submit();','style'=>'width:230px;'))?>
							<br/>
							<?=lang('PaymentMethodSetting.SettingVariableName')?>*:<br/>
							<input type="text" name="PaymentMethodSetting<?=DTR?>SettingVariableName" value="<?=$out['DB']['PaymentMethodSetting'][0]['SettingVariableName'];?>" size="30">
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('PaymentMethodSetting.SettingName')?>*: 
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
								<br/>
								<input type="text" name="PaymentMethodSetting<?=DTR?>SettingName[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['PaymentMethodSetting'][0]['SettingName'],$langCode);?>">
								<br/>
							<? } ?>									
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('PaymentMethodSetting.SettingDescription')?>: 
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
								<br/>
								<textarea name="PaymentMethodSetting<?=DTR?>SettingDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['PaymentMethodSetting'][0]['SettingDescription'],$langCode);?></textarea>
								<br/>
							<? } ?>			
							<?=lang('PaymentMethodSetting.SettingValueType')?>*:<br/>
							<?=getReference('DataTypes','PaymentMethodSetting'.DTR.'SettingValueType',$out['DB']['PaymentMethodSetting'][0]['SettingValueType'],array('code'=>'Y','action'=>'document.managePaymentMethodSetting.SID.value=\'managePaymentMethodSetting\';submit();'))?>
							<? if(hasRights('root')){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
							<br/>
							<? if ($out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='checkboxes' || $out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='radioboxes' || $out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='dropdown') { ?>							
							<?=lang('PaymentMethodSetting.SettingValueOptions')?>:<br/>
							<textarea name="PaymentMethodSetting<?=DTR?>SettingValueOptions" cols="40" rows="5"><?=$out['DB']['PaymentMethodSetting'][0]['SettingValueOptions'];?></textarea>
							<br/><br/>
							<? } ?>
							<?  if ($out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='checkboxes' || $out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='radioboxes' || $out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='dropdown')  { ?>
							<?=lang('PaymentMethodSetting.SettingValue')?>:<br/>
							<?
								$settingOptions = explode(";",$out['DB']['PaymentMethodSetting'][0]['SettingValueOptions']);
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
								echo getLists($options,$out['DB']['PaymentMethodSetting'][0]['SettingValue'],array('name'=>'PaymentMethodSetting'.DTR.'SettingValue','type'=>$out['DB']['PaymentMethodSetting'][0]['SettingValueType']));	
							?>	
							<br/>	
							<br/>
							<? } elseif($out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='text') { foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('PaymentMethodSetting.SettingValue')?>: 
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
								<br/>
								<textarea name="PaymentMethodSetting<?=DTR?>SettingValue[<?=$langCode?>]" cols="40" rows="3"><?=getValue($out['DB']['PaymentMethodSetting'][0]['SettingValue'],$langCode);?></textarea>
								<br/>
							<? } } elseif($out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='image') { ?>
							<?=lang('PaymentMethodSetting.SettingValue')?>:<br/>
							<? if(!empty($out['DB']['PaymentMethodSetting'][0]['SettingValue'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['PaymentMethodSetting'][0]['SettingValue']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/SettingID/<?=$out['DB']['PaymentMethodSetting'][0]['PaymentMethodSettingID']?>/GroupID/<?=input('GroupID')?>/actionMode/deletefile/fileField/SettingValue"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<input size="22" type="file" name="uploadFile[SettingValue]" />
							<input type="hidden" name="oldUploadFile[SettingValue]" value="<?=$out['DB']['PaymentMethodSetting'][0]['SettingValue']?>" />
							<br/>	
							<br/>
							<? } elseif($out['DB']['PaymentMethodSetting'][0]['SettingValueType']=='file') { ?>
							<?=lang('PaymentMethodSetting.SettingValue')?>:<br/>
							<? if(!empty($out['DB']['PaymentMethodSetting'][0]['SettingValue'])) { ?>
								<a href="<?=setting('urlfiles').$out['DB']['PaymentMethodSetting'][0]['SettingValue']?>"><?=lang('-download')?></a>
								<br/>
								<a href="<?=setting('url').input('SID')?>/SettingID/<?=$out['DB']['PaymentMethodSetting'][0]['PaymentMethodSettingID']?>/GroupID/<?=input('GroupID')?>/actionMode/deletefile/fileField/SettingValue"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<input size="22" type="file" name="uploadFile[SettingValue]" />
							<input type="hidden" name="oldUploadFile[SettingValue]" value="<?=$out['DB']['PaymentMethodSetting'][0]['SettingValue']?>" />
							<br/>	
							<br/>												
							<? } else { ?>
							<?=lang('PaymentMethodSetting.SettingValue')?>:<br/>
							<input type="text" name="PaymentMethodSetting<?=DTR?>SettingValue" value="<?=$out['DB']['PaymentMethodSetting'][0]['SettingValue'];?>" size="30">
							<br/>	
							<br/>
							<? } ?>
							<br/>
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['PaymentMethodSetting'][0]['PaymentMethodSettingID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.managePaymentMethodSetting.actionMode.value='delete';confirmDelete('manageSettings', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>
