<?=boxHeader(array('title'=>'ManageResourceOrder.resource.title'))?>
	<tr> 
	<form name="getResourceOrders" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('ResourceOrderNew.resource.tip').' -';
			echo getLists($out['DB']['ResourceOrders'],$out['DB']['ResourceOrder'][0]['ResourceOrderID'],array('name'=>'ResourceOrderID','id'=>'ResourceOrderID','value'=>'ResourceOrderName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageResourceOrders" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ResourceOrder'][0]['ResourceOrderID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceOrder<?=DTR?>ResourceOrderID" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderID'];?>" />
		<input type="hidden" name="ResourceOrderID" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('ResourceOrder.ResourceOrderAlias')?>*:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderAlias" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('ResourceOrder.ResourceOrderName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ResourceOrder'][0]['ResourceOrderName'],$langCode);?>" />
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
						if(is_array($out['DB']['ResourceOrders']))
						{
						foreach($out['DB']['ResourceOrders'] as $row)
						{
							if ($row['ResourceOrderID']!=$out['DB']['ResourceOrder'][0]['ResourceOrderID'])
							{
								$i++;
								$options[$i]['id']=$row['ResourceOrderPosition']+1;	
								$options[$i]['value']=$row['ResourceOrderName'];
							}
						}
						}
						echo getLists('',$out['DB']['ResourceOrder'][0]['ResourceOrderPosition']-1,array('name'=>'ResourceOrder'.DTR.'ResourceOrderPosition','id'=>'ResourceOrderPosition','value'=>'ResourceOrderName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['ResourceOrder'][0]['ResourceOrderID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceOrders.actionMode.value='delete';confirmDelete('manageResourceOrders', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
	<? if (!empty($out['DB']['ResourceOrder'][0]['ResourceOrderID'])) {?>
	<form name="getResourceOrderFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="ResourceOrderID" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderID'];?>" />	
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('ResourceOrderFieldNew.resource.tip').' -';
			echo getLists($out['DB']['ResourceOrderFields'],$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'],array('name'=>'ResourceOrderFieldID','id'=>'ResourceOrderFieldID','value'=>'ResourceOrderFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageResourceOrderFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceOrderID" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderID'];?>" />
		<input type="hidden" name="ResourceOrderField<?=DTR?>ResourceOrderFieldID" value="<?=$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'];?>" />
		<input type="hidden" name="ResourceOrderField<?=DTR?>ResourceOrderID" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderID'];?>" />
		<input type="hidden" name="ResourceOrderField<?=DTR?>ResourceOrder" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderAlias'];?>" />
		
		<input type="hidden" name="ResourceOrderFieldID" value="<?=$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('ResourceOrderField.ResourceOrderFieldAlias')?>*:<br/>
					<input type="text" name="ResourceOrderField<?=DTR?>ResourceOrderFieldAlias" value="<?=$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('ResourceOrderField.ResourceOrderFieldName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="ResourceOrderField<?=DTR?>ResourceOrderFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ResourceOrderField'][0]['ResourceOrderFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/>
					<?=lang('ResourceOrderField.ResourceOrderFieldMode')?>:<br/>
					<?=getReference('ResourceOrderField.ResourceOrderFieldMode','ResourceOrderField'.DTR.'ResourceOrderFieldMode',$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldMode'],array('code'=>'Y'))?>

					<br/>
					<br/>
					<?=lang('ResourceOrderField.ResourceOrderFieldType')?>:<br/>
					<?=getReference('Setting.SettingValueType','ResourceOrderField'.DTR.'ResourceOrderFieldType',$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldType'],array('code'=>'Y'))?>
					<br/>
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['ResourceOrderFields']))
						{
						foreach($out['DB']['ResourceOrderFields'] as $row)
						{
							if ($row['ResourceOrderFieldID']!=$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'])
							{
								$i++;
								$options[$i]['id']=$row['ResourceOrderFieldPosition']+1;	
								$options[$i]['value']=$row['ResourceOrderFieldName'];
							}
						}
						}
						echo getLists('',$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldPosition']-1,array('name'=>'ResourceOrderField'.DTR.'ResourceOrderFieldPosition','id'=>'ResourceOrderFieldPosition','value'=>'ResourceOrderFieldName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceOrderFields.actionMode.value='delete';confirmDelete('manageResourceOrderFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>
	<? } ?>
	<? if (!empty($out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID']) && ($out['DB']['ResourceOrderField'][0]['ResourceOrderFieldType']=='dropdown' || $out['DB']['ResourceOrderField'][0]['ResourceOrderFieldType']=='checkboxes' || $out['DB']['ResourceOrderField'][0]['ResourceOrderFieldType']=='radioboxes')) {?>
	<form name="getResourceOrderOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="ResourceOrderID" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderID'];?>" />
	<input type="hidden" name="ResourceOrderFieldID" value="<?=$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'];?>" />
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('ResourceOrderOptionNew.resource.tip').' -';
			echo getLists($out['DB']['ResourceOrderOptions'],$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionID'],array('name'=>'ResourceOrderOptionID','id'=>'ResourceOrderOptionID','value'=>'ResourceOrderOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageResourceOrderOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceOrderID" value="<?=$out['DB']['ResourceOrder'][0]['ResourceOrderID'];?>" />
		<input type="hidden" name="ResourceOrderFieldID" value="<?=$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'];?>" />
		<input type="hidden" name="ResourceOrderOptionID" value="<?=$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionID'];?>" />

		<input type="hidden" name="ResourceOrderOption<?=DTR?>ResourceOrderOptionID" value="<?=$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionID'];?>" />
		<input type="hidden" name="ResourceOrderOption<?=DTR?>ResourceOrderFieldID" value="<?=$out['DB']['ResourceOrderField'][0]['ResourceOrderFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('ResourceOrderOption.ResourceOrderOptionAlias')?>*:<br/>
					<input type="text" name="ResourceOrderOption<?=DTR?>ResourceOrderOptionAlias" value="<?=$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('ResourceOrderOption.ResourceOrderOptionName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="ResourceOrderOption<?=DTR?>ResourceOrderOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>	
					<br/>
					<? if($out['DB']['ResourceOrderField'][0]['ResourceOrderFieldMode'] =='option') { ?>
					<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('ResourceOrderOption.ResourceOrderOptionPrice')?>:<br/>
							<input type="text" name="ResourceOrderOption<?=DTR?>ResourceOrderOptionPrice" value="<?=$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionPrice'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('ResourceOrderOption.ResourceOrderOptionPriceAction')?>*:<br/>
							<?=getReference('plusminus','ResourceOrderOption'.DTR.'ResourceOrderOptionPriceAction',$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionPriceAction'],array('code'=>'Y'))?>
						</td>						
					</tr>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('ResourceOrderOption.ResourceOrderOptionWeight')?>:<br/>
							<input type="text" name="ResourceOrderOption<?=DTR?>ResourceOrderOptionWeight" value="<?=$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionWeight'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('ResourceOrderOption.ResourceOrderOptionWeightAction')?>:<br/>
							<?=getReference('plusminus','ResourceOrderOption'.DTR.'ResourceOrderOptionWeightAction',$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionWeightAction'],array('code'=>'Y'))?>
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
						if(is_array($out['DB']['ResourceOrderOptions']))				
						{		
						foreach($out['DB']['ResourceOrderOptions'] as $row)
						{
							if ($row['ResourceOrderOptionID']!=$out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['ResourceOrderOptionPosition']+1;	
								$options[$i]['value']=$row['ResourceOrderOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'ResourceOrderOption'.DTR.'ResourceOrderOptionPosition','id'=>'ResourceOrderOptionPosition','value'=>'ResourceOrderOptionName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['ResourceOrderOption'][0]['ResourceOrderOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceOrderOptions.actionMode.value='delete';confirmDelete('manageResourceOrderOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedResourceOrderID'))) ?>
<?=boxFooter()?>