<?=boxHeader(array('title'=>'ManagePaymentMethodSettings.billing.title'))?>
	<tr> 
		<form name="getResourceTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td valign=top bgcolor="#efefef" width="100%" align="center">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('PaymentMethodTypeNew.billing.tip').' -';
					echo getLists($out['DB']['PaymentMethods'],$out['DB']['PaymentMethod'][0]['PaymentMethodID'],array('name'=>'PaymentMethodID','id'=>'PaymentMethodID','value'=>'PaymentMethodName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
		</form>
	</tr> 
	<tr>
	<td>
	&nbsp;
	</td>
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
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<tr>
			<td align="left" class="subtitle">
					<?=lang('PaymentMethod.PaymentMethodAlias')?>*:<br/>
			</td>
			<td align="left">
					<input type="text" name="PaymentMethod<?=DTR?>PaymentMethodAlias" value="<?=$out['DB']['PaymentMethod'][0]['PaymentMethodAlias'];?>" size="50">
			</td>
			</tr>
			<tr>
			<td align="left" class="subtitle">
					<?=lang('PaymentMethod.PaymentMethodName')?>*: 
			</td>
			<td align="left">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<input type="text" name="PaymentMethod<?=DTR?>PaymentMethodName" value="<?=getValue($out['DB']['PaymentMethod'][0]['PaymentMethodName'],$langCode);?>" size="50">
							<br/>
					<? }?>
			</td>
			</tr>
			<tr>
			<td align="left" class="subtitle">
					<?=lang('PaymentMethod.PaymentMethodPosition')?>: 
			</td>
			<td align="left">
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
			</td>
			</tr>
			<tr>
			<td align="left" class="subtitle">
					<?=lang('PaymentMethod.PaymentMethodDescription')?>:
			</td>
			<td align="left">
						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<?=getFormated(getValue($out['DB']['PaymentMethod'][0]['PaymentMethodDescription'],$langCode),'HTML','form',array('fieldName'=>'PaymentMethod'.DTR.'PaymentMethodDescription['.$langCode.']','editorName'=>'PaymentMethodDescription'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
								<!-- <textarea name="PaymentMethod<?=DTR?>PaymentMethodDescription<?=$settingID?>[<?=$langCode?>]" cols="40" rows="3"><?=getValue($out['DB']['PaymentMethod'][0]['PaymentMethodDescription'],$langCode);?></textarea> -->
						<? }?>
			</td>
			</tr>
			<tr>
			<td align="left" class="subtitle">
					<?=lang('Resource.products.PermAll')?>: 
			</td>
			<td align="left">
					<?=getReference('PermAll','PaymentMethod'.DTR.'PermAll',$out['DB']['PaymentMethod'][0]['PermAll'],array('code'=>'Y'))?>
					<? if(hasRights('root')){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
			</td>
			</tr>
			<tr>
			<td align="center" width="100%" colspan="2" bgcolor="#efefef">
					<? if(empty($out['DB']['PaymentMethod'][0]['PaymentMethodID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.PaymentMethod.actionMode.value='delete';confirmDelete('PaymentMethod', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			</td>
			</tr>
			</table>
			</td> 
		</tr> 
	</form>
	<? if(!empty($out['DB']['PaymentMethod'][0]['PaymentMethodID'])) {?>
	<? if(!empty($out['DB']['PaymentMethodSettings'][0]['PaymentMethodSettingID'])) {?>
	<form name="managePaymentMethodSettings" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="PaymentMethodID" value="<?=input('PaymentMethodID');?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<? if(hasRights('root')) {?>
					<br/>
						<div align="center">
							<a href="<?=setting('url')?>managePaymentMethodSetting/PaymentMethodID/<?=input('PaymentMethodID')?>" class="boldLink">[<?=lang('AddPaymentMethodSetting.billing.link')?>]</a>
						</div>		
					<br/>
					<? } ?>
				<table cellspacing="1" cellpadding="5" border="0" width="100%">
					<? foreach($out['DB']['PaymentMethodSettings'] as $row) {?>
					<input type="hidden" name="PaymentMethodSetting<?=DTR?>PaymentMethodSettingID[]" value="<?=$row['PaymentMethodSettingID']?>"/>
					<tr>
						<td valign="top" class="row1" width="70%">
							<b><?=getValue($row['SettingName'])?></b>
							<br/>
							<?=getValue($row['SettingDescription'])?>
							<? if(hasRights('root')) {?>
							<a href="<?=setting('url')?>managePaymentMethodSetting/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/PaymentMethodID/<?=input('PaymentMethodID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>managePaymentMethod/PaymentMethodSetting<?=DTR?>PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/actionMode/delete1/PaymentMethodID/<?=input('PaymentMethodID')?>" onClick="return confirm('<?=lang('AreYouSureToDeletePaymentMethodSetting.billing.tip')?>')">[<?=lang('-delete')?>]</a>
							&nbsp;<small>(<?=$row['SettingVariableName']?>)</small>
							<? } ?>
						</td>
						<td valign="top" class="row1">
							<? if($row['SettingValueType']=='file') { ?>			
								<? if(!empty($row['SettingValue'])) { ?>
								<a href="<?=setting('urlfiles').$row['SettingValue']?>"><?=lang('-download')?></a>
								<? } ?>			
									<br/>
									<a href="<?=setting('url')?>managePaymentMethodSettingFile/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/GroupID/<?=input('GroupID')?>"><?=lang('-uploadimage')?></a>
							
							<? } elseif($row['SettingValueType']=='image') { ?>
								<? if(!empty($row['SettingValue'])) { ?>
									<img src="<?=setting('urlfiles').$row['SettingValue']?>" border="0" />
									<br/>
									<a href="<?=setting('url').input('SID')?>/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/PaymentMethodID/<?=input('PaymentMethodID')?>/actionMode/deletefile/fileField/PaymentMethodSettingValue"><?=lang('-deleteimage')?></a>
								<? } ?>			
									<br/>
									<a href="<?=setting('url')?>managePaymentMethodSettingFile/PaymentMethodSettingID/<?=$row['PaymentMethodSettingID']?>/PaymentMethodID/<?=input('PaymentMethodID')?>"><?=lang('-uploadimage')?></a>
							<? } elseif ($row['SettingValueType']=='checkboxes' || $row['SettingValueType']=='radioboxes' || $row['SettingValueType']=='dropdown')  { ?>
							<?
								$settingID = $row['PaymentMethodSettingID'];
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
								echo getLists($options,$row['SettingValue'],array('name'=>'PaymentMethodSetting'.DTR.'SettingValue_'.$settingID,'type'=>$row['SettingValueType']));	
							?>	
							<? } elseif($row['SettingValueType']=='text') { $settingID = $row['PaymentMethodSettingID']; foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="PaymentMethodSetting<?=DTR?>SettingValue_<?=$settingID?>[<?=$langCode?>]" cols="40" rows="3"><?=getValue($row['SettingValue'],$langCode);?></textarea>
								<br/>
							<? } } else { ?>
							<input type="text" name="PaymentMethodSetting<?=DTR?>SettingValue[]" value="<?=getValue($row['SettingValue'])?>" size="30"/>
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
			<td  bgcolor="#ffffff" align="center">
				<br/>
					<div align="center">
						<a href="<?=setting('url')?>managePaymentMethodSetting/PaymentMethodID/<?=$out['DB']['PaymentMethod'][0]['PaymentMethodID'];?>" class="boldLink">[<?=lang('AddPaymentMethodSetting.billing.link')?>]</a>
					</div>		
				<br/>	
			</td>
		</tr>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<br><br>
					<?=lang('NoPaymentMethodSettingFound.billing.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } }?>		
<?=boxFooter()?>