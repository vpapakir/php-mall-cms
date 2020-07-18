<?=boxHeader(array('title'=>'ManageShippingRate.resource.title'))?>
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr> 
	<form name="getShippingRates" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td align="left" width="30%">&nbsp;</td>
	<td valign=top bgcolor="#ffffff" align="left">
		<?=getReference('transport','ShippingRateTransport',$input['ShippingRateTransport'],array('code'=>'Y','action'=>'submit();','style'=>'width:200px;'))?>
	</td> 
	</form>
	</tr> 
	</table>
	<form name="addShippingRate"  method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="ShippingRate<?=DTR?>ShippingRateTransport" value="<?=input('ShippingRateTransport')?>" />
		<input type="hidden" name="ShippingRateTransport" value="<?=input('ShippingRateTransport')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
				<tr>
					<td align="left" class="subtitle" width="30%">
						<?=lang('ShippingRate.ShippingRateDestination')?>*:
					</td>
					<td align="left">
						<?=getLists($out['DB']['Regions'],$input['ShippingRate'.DTR.'ShippingRateDestination'],array('name'=>'ShippingRate'.DTR.'ShippingRateDestination','id'=>'RegionID','value'=>'RegionName','style'=>'width:200px;'))?>					
					</td>
				</tr>
				<tr>
					<td align="left" class="subtitle" width="30%">
					<?=lang('ShippingRate.ShippingRateFee')?>*:<br/>
					</td>
					<td align="left">
					<input type="text" name="ShippingRate<?=DTR?>ShippingRateFee"  size="10">
					</td>
				</tr>
				<tr>
					<td align="left" class="subtitle" width="30%">
					<?=lang('ShippingRate.ShippingRateExtraSize')?>:<br/>
					</td>
					<td align="left">
					<input type="text" name="ShippingRate<?=DTR?>ShippingRateExtraSize"  size="10">
					</td>
				</tr>
				<tr>
					<td align="left" class="subtitle" width="30%">
					<?=lang('ShippingRate.ShippingRateExtraWeight')?>:<br/>
					</td>
					<td align="left">
					<input type="text" name="ShippingRate<?=DTR?>ShippingRateExtraWeight"  size="10">
					</td>
				</tr>
				<tr>
					<td align="left" class="subtitle" width="30%">
					<?=lang('ShippingRate.ShippingRateDeliveryTime')?>:<br/>
					</td>
					<td align="left">
					<input type="text" name="ShippingRate<?=DTR?>ShippingRateDeliveryTime"  size="10">
					</td>
				</tr>
				<tr><td width="100%" align="center" colspan="2">&nbsp;</td></tr>
				<tr>
					<td align="center" bgcolor="efefef" width="100%" colspan="2">
					<? if(empty($out['DB']['ShippingRate'][0]['ShippingRateID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageShippingRates.actionMode.value='delete';confirmDelete('manageShippingRates', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>
					</td>
				</tr>
				</table>
			</td> 
		</tr> 
	</form>	
	<? if(!empty($out['DB']['ShippingRates'])) { ?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<form name="manageShippingRates" id="manageShippingRates" method="post">
					<input type="hidden" name="SID" value="<?=input('SID')?>" />
					<input type="hidden" name="actionMode" value="save" />
					<input type="hidden" name="ShippingRateTransport" value="<?=input('ShippingRateTransport')?>" />
					<table cellpadding="2" cellspacing="0" border="0" width="100%">
					<tr>
						<td align="left" class="subtitle" width="30%">
							<?=lang('ShippingRate.ShippingRateDestination')?>
						</td>
						<td align="left">
						<? foreach($out['DB']['ShippingRates'] as $row) {?>
							<input type="hidden" name="ShippingRate<?=DTR?>ShippingRateID[]" value="<?=$row['ShippingRateID']?>" />		
							<b><?=getListValue($out['DB']['Regions'],$row['ShippingRateDestination'],array('id'=>'RegionID','name'=>'RegionName'))?></b>
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="left" class="subtitle" width="30%">
							<?=lang('ShippingRate.ShippingRateFee')?>
						</td>
						<td align="left">
						<? foreach($out['DB']['ShippingRates'] as $row) {?>
							<input type="text" name="ShippingRate<?=DTR?>ShippingRateFee[]" value="<?=$row['ShippingRateFee']?>" size="7" />
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="left" class="subtitle" width="30%">
							<?=lang('ShippingRate.ShippingRateExtraSize')?>
						</td>	
						<td align="left">
						<? foreach($out['DB']['ShippingRates'] as $row) {?>
							<input type="text" name="ShippingRate<?=DTR?>ShippingRateExtraSize[]" value="<?=$row['ShippingRateExtraSize']?>" size="7" />
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="left" class="subtitle" width="30%">
							<?=lang('ShippingRate.ShippingRateExtraWeight')?>
						</td>	
						<td align="left">
						<? foreach($out['DB']['ShippingRates'] as $row) {?>
							<input type="text" name="ShippingRate<?=DTR?>ShippingRateExtraWeight[]" value="<?=$row['ShippingRateExtraWeight']?>" size="7" />
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="left" class="subtitle" width="30%">
							<?=lang('ShippingRate.ShippingRateDeliveryTime')?>
						</td>	
						<td align="left">
						<? foreach($out['DB']['ShippingRates'] as $row) {?>
							<input type="text" name="ShippingRate<?=DTR?>ShippingRateDeliveryTime[]" value="<?=$row['ShippingRateDeliveryTime']?>" size="7" />
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="left" class="subtitle" width="30%">&nbsp;
						</td>	
						<td align="left">
						<? foreach($out['DB']['ShippingRates'] as $row) {?>
							<select name="manageR<?=$row['ShippingRateID']?>" onChange="selectLink('manageShippingRates', 'manageR<?=$row['ShippingRateID']?>', '<?=lang('AreYouSureToDelete.resource.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url').input('SID')?>/ShippingRate<?=DTR?>ShippingRateID/<?=$row['ShippingRateID']?>/actionMode/delete/ShippingRateTransport/<?=input('ShippingRateTransport')?>"><?=lang('-delete')?></option>
							</select>								
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">&nbsp;
						</td>																					
					</tr>
<!--					<? foreach($out['DB']['ShippingRates'] as $row) {?>
						<tr>
							<td width="30%">
								<input type="hidden" name="ShippingRate<?=DTR?>ShippingRateID[]" value="<?=$row['ShippingRateID']?>" />		
								<b><?=getListValue($out['DB']['Regions'],$row['ShippingRateDestination'],array('id'=>'RegionID','name'=>'RegionName'))?></b>
							</td>
							<td>
								<input type="text" name="ShippingRate<?=DTR?>ShippingRateFee[]" value="<?=$row['ShippingRateFee']?>" size="7" />
							</td>
							<td>
								<input type="text" name="ShippingRate<?=DTR?>ShippingRateExtraSize[]" value="<?=$row['ShippingRateExtraSize']?>" size="7" />
							</td>
							<td>
								<input type="text" name="ShippingRate<?=DTR?>ShippingRateExtraWeight[]" value="<?=$row['ShippingRateExtraWeight']?>" size="7" />
							</td>
							<td>
								<input type="text" name="ShippingRate<?=DTR?>ShippingRateDeliveryTime[]" value="<?=$row['ShippingRateDeliveryTime']?>" size="7" />
							</td>							
							<td>
							<select name="manageR<?=$row['ShippingRateID']?>" onChange="selectLink('manageShippingRates', 'manageR<?=$row['ShippingRateID']?>', '<?=lang('AreYouSureToDelete.resource.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url').input('SID')?>/ShippingRate<?=DTR?>ShippingRateID/<?=$row['ShippingRateID']?>/actionMode/delete/ShippingRateTransport/<?=input('ShippingRateTransport')?>"><?=lang('-delete')?></option>
							</select>								
							</td>
						</tr>
					<? } ?>
-->
					<tr>
						<td align="center" bgcolor="efefef" width="100%" colspan="2">
						<input type="submit" value="<?=lang("-save")?>">
						</td>																					
					</tr>
					</table>
				</form>						
			</td> 
		</tr> 

	<? } //edn of if(!empty($out['DB']['ShippingRate'][0]['ShippingRateID'])) ?>
<?=boxFooter()?>