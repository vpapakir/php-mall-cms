<?=boxHeader(array('title'=>'ManagePaymentMethodSettings.billing.title'))?>
	<tr> 
		<form name="getResourceTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td valign=top bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('PaymentMethodTypeNew.billing.tip').' -';
					echo getLists($out['DB']['PaymentMethods'],$out['DB']['PaymentMethod'][0]['PaymentMethodID'],array('name'=>'PaymentMethodID','id'=>'PaymentMethodID','value'=>'PaymentMethodName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
		</form>
	</tr> 
	<form name="PaymentMethod" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['PaymentMethod'][0]['PaymentMethodID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="PaymentMethod<?=DTR?>PaymentMethodID" value="<?=$out['DB']['PaymentMethod'][0]['PaymentMethodID'];?>" />
		<input type="hidden" name="PaymentMethodID" value="<?=$out['DB']['PaymentMethod'][0]['PaymentMethodID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('PaymentMethod.PaymentMethodAlias')?>*:<br/>
					<input type="text" name="PaymentMethod<?=DTR?>PaymentMethodAlias" value="<?=$out['DB']['PaymentMethod'][0]['PaymentMethodAlias'];?>" size="50">
					<br/><br/>
					<?=lang('PaymentMethod.PaymentMethodName')?>*:
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="PaymentMethod<?=DTR?>PaymentMethodName" value="<?=getValue($out['DB']['PaymentMethod'][0]['PaymentMethodName'],$langCode);?>" size="50">
							<br/><br/>
					<? }?>
					<?=lang('PaymentMethod.PaymentMethodPosition')?>:<br/>
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['PaymentMethods']))
						{
							foreach($out['DB']['PaymentMethods'] as $row)
							{
								if ($row['PaymentMethodID']!=$out['DB']['PaymentMethod'][0]['PaymentMethodID'])
								{
									$i++;
									$options[$i]['id']=$row['PaymentMethodPosition']+1;	
									$options[$i]['value']=$row['PaymentMethodName'];
								}
							}
						}
						echo getLists('',$out['DB']['PaymentMethod'][0]['PaymentMethodPosition']-1,array('name'=>'PaymentMethod'.DTR.'PaymentMethodPosition','id'=>'PaymentMethodPosition','value'=>'PaymentMethod','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<?=lang('PaymentMethod.PaymentMethodDescription')?>:
						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="PaymentMethod<?=DTR?>PaymentMethodDescription<?=$settingID?>[<?=$langCode?>]" cols="40" rows="3"><?=getValue($out['DB']['PaymentMethod'][0]['PaymentMethodDescription'],$langCode);?></textarea>
						<? }?>
					<br/><br/>
					<hr size="1">
					<?=lang('Resource.products.PermAll')?>:<br/>
					<?=getReference('PermAll','Resource'.DTR.'PermAll',$out['DB']['Resource'][0]['PermAll'],array('code'=>'Y'))?>
					<br/><br/>
					<? if(empty($out['DB']['ResourceType'][0]['ResourceTypeID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceTypes.actionMode.value='delete';confirmDelete('manageResourceTypes', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/><br/>
			</td> 
		</tr> 
	</form>
	<? if(!empty($out['DB']['PaymentMethod'][0]['PaymentMethodID'])) {?>
	<!-- <tr> 
	<form name="getPaymentMethodSettings" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td valign=top bgcolor="#ffffff" >
				<? 
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('PaymentMethodSettingNew.billing.tip').' -';
					echo getLists($out['DB']['PaymentMethodSettings'],input('GroupID'),array('name'=>'SettingsID','id'=>'PaymentMethodSettingID','value'=>'PaymentMethodSettingName','action'=>'submit();','style'=>'width:230px;','options'=>$options));?>
				<br/><br/>
				<?=$out['Refs']['PaymentMethodSettingGroups']?><? if (hasRights('root')) {?>&nbsp;&nbsp;<a href="<?=setting('url')?>managePaymentMethodSettingGroups">[<?=lang('EditPaymentMethodSettingGroup.billing.link')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageStyle">[<?=lang('EditStyleFile.billing.link')?>]</a> <? } ?>
			</td> 
		</form>
	</tr> --> 
	<tr>
		<td  bgcolor="#ffffff" align="center">
			<br/>
				<div align="center">
					<a href="<?=setting('url')?>managePaymentMethodSetting/PaymentMethodID/<?=$out['DB']['PaymentMethod'][0]['PaymentMethodID'];?>" class="boldLink">[<?=lang('AddPaymentMethodSetting.billing.link')?>]</a>
				</div>		
			<br/>	
		</td>
	</tr>
	<? if(!empty($out['DB']['PaymentMethodSettings'][0]['PaymentMethodSettingID'])) {?>
	<form name="managePaymentMethodSettings" method="post">
		<input type="hidden" name="SID" value="managePaymentMethodSettings" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<? if(hasRights('root')) {?>
					<br/>
						<div align="center">
							<a href="<?=setting('url')?>managePaymentMethodSetting/GroupID/<?=input('GroupID')?>" class="boldLink">[<?=lang('AddPaymentMethodSetting.billing.link')?>]</a>
						</div>		
					<br/>
					<? } ?>
				<table cellspacing="1" cellpadding="5" border="0" width="100%">
					<? foreach($out['DB']['PaymentMethodSettings'] as $row) {?>
					<input type="hidden" name="PaymentMethodSetting<?=DTR?>PaymentMethodSettingID" value="<?=$row['PaymentMethodSettingID']?>"/>
					<tr>
						<td valign="top" class="row1" width="70%">
							<b><?=getValue($row['PaymentMethodSettingName'])?></b>
							<br/>
							<?=getValue($row['PaymentMethodSettingDescription'])?>
							<? if(hasRights('root')) {?>
							<a href="<?=setting('url')?>managePaymentMethodSetting/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>managePaymentMethodSettings/PaymentMethodSetting<?=DTR?>PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeletePaymentMethodSetting.billing.tip')?>')">[<?=lang('-delete')?>]</a>
							&nbsp;<small>(<?=$row['PaymentMethodSettingVariableName']?>)</small>
							<? } ?>
						</td>
						<td valign="top" class="row1">
							<? if($row['PaymentMethodSettingValueType']=='file') { ?>			
								<? if(!empty($row['PaymentMethodSettingValue'])) { ?>
								<a href="<?=setting('urlfiles').$row['PaymentMethodSettingValue']?>"><?=lang('-download')?></a>
								<? } ?>			
									<br/>
									<a href="<?=setting('url')?>managePaymentMethodSettingFile/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/GroupID/<?=input('GroupID')?>"><?=lang('-uploadimage')?></a>
							
							<? } elseif($row['PaymentMethodSettingValueType']=='image') { ?>
								<? if(!empty($row['PaymentMethodSettingValue'])) { ?>
									<img src="<?=setting('urlfiles').$row['PaymentMethodSettingValue']?>" border="0" />
									<br/>
									<a href="<?=setting('url').input('SID')?>/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/GroupID/<?=input('GroupID')?>/actionMode/deletefile/fileField/PaymentMethodSettingValue"><?=lang('-deleteimage')?></a>
								<? } ?>			
									<br/>
									<a href="<?=setting('url')?>managePaymentMethodSettingFile/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/GroupID/<?=input('GroupID')?>"><?=lang('-uploadimage')?></a>
							<? } elseif ($row['PaymentMethodSettingValueType']=='checkboxes' || $row['PaymentMethodSettingValueType']=='radioboxes' || $row['PaymentMethodSettingValueType']=='dropdown')  { ?>
							<?
								$settingID = $row['PaymentMethodSettingID'];
								$settingOptions = explode(";",$row['PaymentMethodSettingValueOptions']);
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
								echo getLists($options,$row['PaymentMethodSettingValue'],array('name'=>'PaymentMethodSetting'.DTR.'PaymentMethodSettingValue_'.$settingID,'type'=>$row['PaymentMethodSettingValueType']));	
							?>	
							<? } elseif($row['PaymentMethodSettingValueType']=='text') { $settingID = $row['PaymentMethodSettingID']; foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="PaymentMethodSetting<?=DTR?>PaymentMethodSettingValue_<?=$settingID?>[<?=$langCode?>]" cols="40" rows="3"><?=getValue($row['PaymentMethodSettingValue'],$langCode);?></textarea>
								<br/>
							<? } } else { ?>
							<input type="text" name="PaymentMethodSetting<?=DTR?>PaymentMethodSettingValue[]" value="<?=getValue($row['PaymentMethodSettingValue'])?>" size="30"/>
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
	<?  }// end of  if(!empty($out['DB']['PaymentMethodSettings'][0]['PaymentMethodSettingID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<br><br>
					<?=lang('NoPaymentMethodSettingFound.billing.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } }?>		
<?=boxFooter()?>