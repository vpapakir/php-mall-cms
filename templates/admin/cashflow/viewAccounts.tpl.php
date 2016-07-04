<? //getBox('cashflow.manageAccounts');?>
<?=boxHeader(array('title'=>'viewAccounts.cashflow.title'))?>
<?=showTabForm($out)?>

		<form name="manageAccounts" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<!-- <input type="hidden" name="actionMode" value="savelist" /> -->
			<tr> 
				<td valign="top" class="row1">
				<table cellpadding="0" cellspacing="2" width="100%" border="0">
					<tr>
						<td class="subtitle" align="left"><?=lang('CashFlowAccount.CashFlowAccountName')?></td>
						<td class="subtitle" align="right" width="8%"><?=lang('CashFlowAccount.CashFlowAccountAmount')?>&nbsp;<?=setting('currency')?></td>
						<td class="subtitle" align="right" width="8%"><?=lang('CashFlowAccount.CashFlowAccountVAT')?>&nbsp;<?=setting('currency')?></td>
						<td class="subtitle" align="right" width="8px">&nbsp;</td>						
						<td class="subtitle" align="left"><?=lang('CashFlowAccount.CashFlowAccountComments')?></td>
						<td width="10%" align="left"><?=lang('Action.cashflow.tip')?></td>
					</tr>
					<tr> 
						<td valign="top" bgcolor="#ffffff" align="center" colspan="6">
							<hr size="1"/>
						</td> 
					</tr>
					<tr>
						<td bgcolor="#ffffff">
							<span class="subtitle"><?=lang('Overall.cashflow.tip')?></span>
						</td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($out['DB']['Overall']['SumAmount']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($out['DB']['Overall']['SumAmount'],'Money','',array('nocurrency'=>'Y'));?></font>
						</td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($out['DB']['Overall']['SumVAT']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($out['DB']['Overall']['SumVAT'],'Money','',array('nocurrency'=>'Y'));?></font>
						</td>
						<td bgcolor="#FFFFFF" colspan="3"></td>
					</tr>
					<tr> 
						<td valign="top" bgcolor="#ffffff" align="center" colspan="6">
							<hr size="1"/>
						</td> 
					</tr>
					
				<? if (is_array($out['DB']['CashFlowAccounts'])) {?>
					<? foreach($out['DB']['CashFlowAccounts'] as $id=>$row) {?>
					<input type="hidden" name="CashFlowAccount<?=DTR?>CashFlowAccountID[<?=$id?>]" value="<?=$row['CashFlowAccountID']?>"/>
					<tr>
						<td bgcolor="#ffffff">
							<a href="<?=setting('url')?>viewBills/CashFlowAccountID/<?=$row['CashFlowAccountID']?>/CashFlowCompany/<?=input('CashFlowCompany')?>"><?=$row['CashFlowAccountName']?></a>
						</td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($row['CashFlowAccountAmount']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowAccountAmount'],'Money','',array('nocurrency'=>'Y'));?></font>
						</td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($row['CashFlowAccountVAT']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowAccountVAT'],'Money','',array('nocurrency'=>'Y'));?></font>
						</td>
						<td bgcolor="#FFFFFF"></td>
						<td bgcolor="#ffffff">
							&nbsp;<?=getFormated($row['CashFlowAccountComments'],'TEXT');?>
						</td>
						<td bgcolor="#ffffff" align="left"><a href="<?=setting('url')?>manageAccounts/CashFlowAccountID/<?=$row['CashFlowAccountID']?>/CashFlowCompany/<?=input('CashFlowCompany')?>"><?=lang('EditAccount.cashflow.tip')?></a></td>
					</tr>
					<? } ?>			
				<? }  // end of if(is_array($out['DB']['CashFlowAccounts'])
					else {	?>
					<tr> 
						<td valign="top" bgcolor="#ffffff" align="center" colspan="5">
							<br><br>
							<?=lang('NoAccountFound.cashflow.tip')?>
							<br><br>
						</td> 
					</tr>
				<? } ?>			
				</table>			
				</td> 
			</tr>
			<!-- <tr> 
				<td valign=top bgcolor="#ffffff">
					<input type="submit" value="<?=lang("-save")?>">
				</td> 
			</tr> -->
		</form> 
<?=boxFooter()?>