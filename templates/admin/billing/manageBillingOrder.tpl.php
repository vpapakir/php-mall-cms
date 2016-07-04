<?=boxHeader(array('title'=>'ManageBillingOrder.resource.title'))?>
	<tr> 
	<form name="getBillingOrders" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('BillingOrderNew.resource.tip').' -';
			echo getLists($out['DB']['BillingOrders'],$out['DB']['BillingOrder'][0]['BillingOrderID'],array('name'=>'BillingOrderID','id'=>'BillingOrderID','value'=>'BillingOrderName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageBillingOrders" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['BillingOrder'][0]['BillingOrderID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="BillingOrder<?=DTR?>BillingOrderID" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderID'];?>" />
		<input type="hidden" name="BillingOrderID" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('BillingOrder.BillingOrderAlias')?>*:<br/>
					<input type="text" name="BillingOrder<?=DTR?>BillingOrderAlias" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('BillingOrder.BillingOrderName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="BillingOrder<?=DTR?>BillingOrderName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['BillingOrder'][0]['BillingOrderName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['BillingOrders']))
						{
						foreach($out['DB']['BillingOrders'] as $row)
						{
							if ($row['BillingOrderID']!=$out['DB']['BillingOrder'][0]['BillingOrderID'])
							{
								$i++;
								$options[$i]['id']=$row['BillingOrderPosition']+1;	
								$options[$i]['value']=$row['BillingOrderName'];
							}
						}
						}
						echo getLists('',$out['DB']['BillingOrder'][0]['BillingOrderPosition']-1,array('name'=>'BillingOrder'.DTR.'BillingOrderPosition','id'=>'BillingOrderPosition','value'=>'BillingOrderName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['BillingOrder'][0]['BillingOrderID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageBillingOrders.actionMode.value='delete';confirmDelete('manageBillingOrders', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
	<? if (!empty($out['DB']['BillingOrder'][0]['BillingOrderID'])) {?>
	<form name="getBillingOrderFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="BillingOrderID" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderID'];?>" />	
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('BillingOrderFieldNew.resource.tip').' -';
			echo getLists($out['DB']['BillingOrderFields'],$out['DB']['BillingOrderField'][0]['BillingOrderFieldID'],array('name'=>'BillingOrderFieldID','id'=>'BillingOrderFieldID','value'=>'BillingOrderFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageBillingOrderFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['BillingOrderField'][0]['BillingOrderFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="BillingOrderID" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderID'];?>" />
		<input type="hidden" name="BillingOrderField<?=DTR?>BillingOrderFieldID" value="<?=$out['DB']['BillingOrderField'][0]['BillingOrderFieldID'];?>" />
		<input type="hidden" name="BillingOrderField<?=DTR?>BillingOrderID" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderID'];?>" />
		<input type="hidden" name="BillingOrderField<?=DTR?>BillingOrder" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderAlias'];?>" />
		
		<input type="hidden" name="BillingOrderFieldID" value="<?=$out['DB']['BillingOrderField'][0]['BillingOrderFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('BillingOrderField.BillingOrderFieldAlias')?>*:<br/>
					<input type="text" name="BillingOrderField<?=DTR?>BillingOrderFieldAlias" value="<?=$out['DB']['BillingOrderField'][0]['BillingOrderFieldAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('BillingOrderField.BillingOrderFieldName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="BillingOrderField<?=DTR?>BillingOrderFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['BillingOrderField'][0]['BillingOrderFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/>
					<?=lang('BillingOrderField.BillingOrderFieldMode')?>:<br/>
					<?=getReference('BillingOrderField.BillingOrderFieldMode','BillingOrderField'.DTR.'BillingOrderFieldMode',$out['DB']['BillingOrderField'][0]['BillingOrderFieldMode'],array('code'=>'Y'))?>
					<? if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
					<br/>
					<br/>
					<?=lang('BillingOrderField.BillingOrderFieldType')?>:<br/>
					<?=getReference('Setting.SettingValueType','BillingOrderField'.DTR.'BillingOrderFieldType',$out['DB']['BillingOrderField'][0]['BillingOrderFieldType'],array('code'=>'Y'))?>
					<? if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
					<br/>
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['BillingOrderFields']))
						{
						foreach($out['DB']['BillingOrderFields'] as $row)
						{
							if ($row['BillingOrderFieldID']!=$out['DB']['BillingOrderField'][0]['BillingOrderFieldID'])
							{
								$i++;
								$options[$i]['id']=$row['BillingOrderFieldPosition']+1;	
								$options[$i]['value']=$row['BillingOrderFieldName'];
							}
						}
						}
						echo getLists('',$out['DB']['BillingOrderField'][0]['BillingOrderFieldPosition']-1,array('name'=>'BillingOrderField'.DTR.'BillingOrderFieldPosition','id'=>'BillingOrderFieldPosition','value'=>'BillingOrderFieldName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['BillingOrderField'][0]['BillingOrderFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageBillingOrderFields.actionMode.value='delete';confirmDelete('manageBillingOrderFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>
	<? } ?>
	<? if (!empty($out['DB']['BillingOrderField'][0]['BillingOrderFieldID']) && ($out['DB']['BillingOrderField'][0]['BillingOrderFieldType']=='dropdown' || $out['DB']['BillingOrderField'][0]['BillingOrderFieldType']=='checkboxes' || $out['DB']['BillingOrderField'][0]['BillingOrderFieldType']=='radioboxes')) {?>
	<form name="getBillingOrderOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="BillingOrderID" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderID'];?>" />
	<input type="hidden" name="BillingOrderFieldID" value="<?=$out['DB']['BillingOrderField'][0]['BillingOrderFieldID'];?>" />
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('BillingOrderOptionNew.resource.tip').' -';
			echo getLists($out['DB']['BillingOrderOptions'],$out['DB']['BillingOrderOption'][0]['BillingOrderOptionID'],array('name'=>'BillingOrderOptionID','id'=>'BillingOrderOptionID','value'=>'BillingOrderOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageBillingOrderOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['BillingOrderOption'][0]['BillingOrderOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="BillingOrderID" value="<?=$out['DB']['BillingOrder'][0]['BillingOrderID'];?>" />
		<input type="hidden" name="BillingOrderFieldID" value="<?=$out['DB']['BillingOrderField'][0]['BillingOrderFieldID'];?>" />
		<input type="hidden" name="BillingOrderOptionID" value="<?=$out['DB']['BillingOrderOption'][0]['BillingOrderOptionID'];?>" />

		<input type="hidden" name="BillingOrderOption<?=DTR?>BillingOrderOptionID" value="<?=$out['DB']['BillingOrderOption'][0]['BillingOrderOptionID'];?>" />
		<input type="hidden" name="BillingOrderOption<?=DTR?>BillingOrderFieldID" value="<?=$out['DB']['BillingOrderField'][0]['BillingOrderFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('BillingOrderOption.BillingOrderOptionAlias')?>*:<br/>
					<input type="text" name="BillingOrderOption<?=DTR?>BillingOrderOptionAlias" value="<?=$out['DB']['BillingOrderOption'][0]['BillingOrderOptionAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('BillingOrderOption.BillingOrderOptionName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="BillingOrderOption<?=DTR?>BillingOrderOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['BillingOrderOption'][0]['BillingOrderOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>	
					<br/>
					<? if($out['DB']['BillingOrderField'][0]['BillingOrderFieldMode'] =='option') { ?>
					<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('BillingOrderOption.BillingOrderOptionPrice')?>:<br/>
							<input type="text" name="BillingOrderOption<?=DTR?>BillingOrderOptionPrice" value="<?=$out['DB']['BillingOrderOption'][0]['BillingOrderOptionPrice'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('BillingOrderOption.BillingOrderOptionPriceAction')?>*:<br/>
							<?=getReference('plusminus','BillingOrderOption'.DTR.'BillingOrderOptionPriceAction',$out['DB']['BillingOrderOption'][0]['BillingOrderOptionPriceAction'],array('code'=>'Y'))?>
							<? if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
						</td>						
					</tr>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('BillingOrderOption.BillingOrderOptionWeight')?>:<br/>
							<input type="text" name="BillingOrderOption<?=DTR?>BillingOrderOptionWeight" value="<?=$out['DB']['BillingOrderOption'][0]['BillingOrderOptionWeight'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('BillingOrderOption.BillingOrderOptionWeightAction')?>:<br/>
							<?=getReference('plusminus','BillingOrderOption'.DTR.'BillingOrderOptionWeightAction',$out['DB']['BillingOrderOption'][0]['BillingOrderOptionWeightAction'],array('code'=>'Y'))?>
							<? if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
						</td>						
					</tr>							
					</table>					
					<? } ?>
					<br/>				
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['BillingOrderOptions']))				
						{		
						foreach($out['DB']['BillingOrderOptions'] as $row)
						{
							if ($row['BillingOrderOptionID']!=$out['DB']['BillingOrderOption'][0]['BillingOrderOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['BillingOrderOptionPosition']+1;	
								$options[$i]['value']=$row['BillingOrderOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['BillingOrderOption'][0]['BillingOrderOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'BillingOrderOption'.DTR.'BillingOrderOptionPosition','id'=>'BillingOrderOptionPosition','value'=>'BillingOrderOptionName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['BillingOrderOption'][0]['BillingOrderOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageBillingOrderOptions.actionMode.value='delete';confirmDelete('manageBillingOrderOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedBillingOrderID'))) ?>
<?=boxFooter()?>