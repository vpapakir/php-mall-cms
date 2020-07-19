<? function showTabForm($out)
{?>
<tr> 
	<form name="getDomains" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<td valign="top" class="row1">
			<table>
				<tr>
					<td>
						<?
							$options[0]['id'] = '';
							$options[0]['value'] = lang('AllCashFlowCompany.cashflow.tip');
							echo getLists($out['DB']['Companies'],input('CashFlowCompany'),array('name'=>'CashFlowCompany','id'=>'CashFlowCompanyID','value'=>'CashFlowCompanyName','action'=>'submit();','options'=>$options));	
						?>	
					</td>
					<? if(input('CashFlowCompany')) { ?>
					<td>
						<input type="button" value="<?=lang('New.cashflow.tip')?>" onClick="document.getDomains.SID.value = 'manageBill';submit();"/>
					</td>
					<td>
						<input type="button" value="<?=lang('Show.cashflow.tip')?>" onClick="document.getDomains.SID.value = 'viewBills';submit();"/>
					</td>
					<td>
						<input type="button" value="<?=lang('ShowAccounts.cashflow.tip')?>" onClick="document.getDomains.SID.value = 'manageAccounts';submit();"/>
					</td>
					<td>
						<input type="button" value="<?=lang('Search.cashflow.tip')?>" onClick="document.getDomains.SID.value = 'viewBills';submit();"/>
					</td>
					<? } ?>
					<td>
						<input type="button" value="<?=lang('Settings.cashflow.tip')?>" onClick="document.getDomains.SID.value = 'manageCompany';submit();"/>
					</td>
					<td>
						<input type="button" value="<?=lang('EditStatus.cashflow.tip')?>" onClick="document.location = '<?=setting('url')?>manageReferences/ReferenceCode/CashFlowBillStatus'"/>
					</td>
					<td>
						<input type="button" value="<?=lang('EditPurpose.cashflow.tip')?>" onClick="document.location = '<?=setting('url')?>manageReferences/ReferenceCode/CashFlowBillStatus'"/>
					</td>
				</tr>
			</table>	
		</td> 
	</form>
</tr>
<tr>	
	<td width="100%" bgcolor="#FFFFFF">&nbsp;</td>
</tr>
<? }?>