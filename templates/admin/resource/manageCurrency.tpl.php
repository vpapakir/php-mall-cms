<?=boxHeader(array('title'=>'ManageCurrency.resource.title'))?>
	<table cellspacing="0" cellpadding="2" width="100%">
	<tr> 
	<form name="getCurrencies" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td bgcolor="efefef" width="30%">&nbsp;</td>
	<td valign=top bgcolor="#efefef" align="left">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('CurrencyNew.core.tip').' -';
			echo getLists($out['DB']['Currencies'],$out['DB']['Currency'][0]['CurrencyID'],array('name'=>'CurrencyID','id'=>'CurrencyID','value'=>'CurrencyName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	</table>
	<form name="manageCurrencies" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['Currency'][0]['CurrencyID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="Currency<?=DTR?>CurrencyID" value="<?=$out['DB']['Currency'][0]['CurrencyID'];?>" />
		<input type="hidden" name="CurrencyID" value="<?=$out['DB']['Currency'][0]['CurrencyID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="2" width="100%">
					<tr>
						<td align="left" width="30%" class="subtitle">
						<?=lang('Currency.CurrencyCode')?>*:
						</td>
						<td align="left">
						<input type="text" name="Currency<?=DTR?>CurrencyCode" value="<?=$out['DB']['Currency'][0]['CurrencyCode'];?>" size="54">
						</td>
					</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td align="left" width="30%" class="subtitle">
						<?=lang('Currency.CurrencyName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
						</td>
						<td valign="top" class="fieldNames" align="left">
							<input type="text" name="Currency<?=DTR?>CurrencyName[<?=$langCode?>]" size="54" value="<?=getValue($out['DB']['Currency'][0]['CurrencyName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<tr>
						<td align="left" width="30%" class="subtitle">
					<?=lang('Currency.CurrencyIsMain')?>:
						</td>
						<td align="left">
						<? if (empty($out['DB']['Currency'][0]['CurrencyIsMain'])) {$out['DB']['Currency'][0]['CurrencyIsMain']='N';}?>
						<?=getReference('YesNo','Currency'.DTR.'CurrencyIsMain',$out['DB']['Currency'][0]['CurrencyIsMain'],array('code'=>'Y'))?>
						</td>
					</tr>	

					<tr>
						<td align="left" width="30%" class="subtitle">
						<?=lang('Currency.PermAll')?>:
						</td>
						<td align="left">
						<?=getReference('PermAll','Currency'.DTR.'PermAll',$out['DB']['Currency'][0]['PermAll'],array('code'=>'Y'))?>
						</td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td align="center" bgcolor="efefef" width="30%" colspan="2">
					<? if(empty($out['DB']['Currency'][0]['CurrencyID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageCurrencies.actionMode.value='delete';confirmDelete('manageCurrencies', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
						</td>
					</tr>	
					</table>	
			</td> 
		</tr> 
	</form>	
	<? if(!empty($out['DB']['Currency'][0]['CurrencyID'])) { ?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<form name="manageCurrencyRates" method="post">
					<input type="hidden" name="SID" value="<?=input('SID')?>" />
					<input type="hidden" name="actionMode" value="save" />
					<input type="hidden" name="CurrencyID" value="<?=$out['DB']['Currency'][0]['CurrencyID'];?>" />
					<table cellpadding="2" cellspacing="0" border="0" width="100%">
					<? foreach($out['DB']['Currencies'] as $row) { if($row['CurrencyID'] != $out['DB']['Currency'][0]['CurrencyID']) { ?>
						<tr>
							<td width="30%" align="left" class="subtitle">
									
								<input type="hidden" name="CurrencyRate<?=DTR?>CurrencyFrom[]" value="<?=$out['DB']['Currency'][0]['CurrencyCode']?>" />		
								<input type="hidden" name="CurrencyRate<?=DTR?>CurrencyTo[]" value="<?=$row['CurrencyCode']?>" />
								
								1 <?=getValue($row['CurrencyName'])?> =
							</td>
							<td align="left">
								<?
									$rateValue='';
									if(is_array($out['DB']['CurrencyRates']))
									{
								 	foreach($out['DB']['CurrencyRates'] as $ratesRow)
									{
										if($ratesRow['CurrencyTo']==$row['CurrencyCode']) {$rateValue = $ratesRow['CurrencyRateValue']; $rateID = $ratesRow['CurrencyRateID'];}
									}
									}
								?>
								<input type="hidden" name="CurrencyRate<?=DTR?>CurrencyRateID[]" value="<?=$rateID?>" />	
								<input type="text" name="CurrencyRate<?=DTR?>CurrencyRateValue[]" value="<?=$rateValue?>" size="5">
							</td>
						</tr>							
					<? } } ?>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td width="100%" align="center" bgcolor="efefef" colspan="2">
						<input type="submit" value="<?=lang("-save")?>">
						</td>
					</tr>
				</form>						
					</table>
			</td> 
		</tr> 

	<? } //edn of if(!empty($out['DB']['Currency'][0]['CurrencyID'])) ?>
<?=boxFooter()?>