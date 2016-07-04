<?=boxHeader(array('title'=>'ManageCashFlowCompany.cashflow.title'))?>
<? //showTabForm($out)?>
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
									echo getLists($out['DB']['Companies'],input('CashFlowCompany'),array('name'=>'CashFlowCompany','id'=>'CashFlowCompanyID','value'=>'CashFlowCompanyName','action'=>'document.getDomains.SID.value = \'viewAccounts\';submit();','options'=>$options));	
								?>	
							</td>
							<td>
								<input type="button" value="<?=lang('Settings.cashflow.tip')?>" onClick="document.getDomains.SID.value = 'manageCompany';submit();"/>
							</td>
						</tr>
					</table>	
				</td> 
			</form>
		</tr>
		<tr>	
			<td width="100%" bgcolor="#FFFFFF">&nbsp;</td>
		</tr>
		<form name="manageCashFlowCompanies" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<tr> 
				<td valign="top" class="row1">
					<table class="row1" cellpadding="0" cellspacing="2" width="100%" border="0">
						<tr>
							<td class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyName')?></td>
							<td class="subtitle" width="8%" align="right"><?=lang('CashFlowAccount.CashFlowCompanyAmount')?>&nbsp;<?=setting('currency')?></td>
							<td class="subtitle" width="8%" align="right"><?=lang('CashFlowAccount.CashFlowCompanyVAT')?>&nbsp;<?=setting('currency')?></td>
							<td class="subtitle" align="right" width="8px">&nbsp;</td>						
							<td class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyComments')?></td>
						</tr>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="center" colspan="5">
								<hr size="1"/>
							</td> 
						</tr>
						<? if(is_array($out['DB']['Companies'])){ foreach($out['DB']['Companies'] as $row){ $totalAmount = $totalAmount + $row['CashFlowCompanyAmount']; $totalVAT = $totalVAT + $row['CashFlowCompanyVAT']; }}?>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="left" class="subtitle"><?=lang('Total.cashflow.tip')?>:</td> 
							<td bgcolor="#FFFFFF" align="right"><?=getFormated($totalAmount,'Money','',array('nocurrency'=>'Y'));?></td>
							<td bgcolor="#FFFFFF" align="right"><?=getFormated($totalVAT,'Money','',array('nocurrency'=>'Y'));?></td>							
							<td bgcolor="#FFFFFF" colspan="2"></td>
						</tr>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="center" colspan="5">
								<hr size="1"/>
							</td> 
						</tr>
						<? if(is_array($out['DB']['Companies'])){ 
							foreach($out['DB']['Companies'] as $row){ $totalAmount = $totalAmount + $row['CashFlowCompanyAmount']; $totalVAT = $totalVAT + $row['CashFlowCompanyVAT'];  ?>
							<tr>
								<td bgcolor="#ffffff">
									 <a href="<?=setting('url')?>viewAccounts/CashFlowCompany/<?=$row['CashFlowCompanyID']?>"><?=$row['CashFlowCompanyName']?></a>
								</td>
								<td bgcolor="#ffffff" align="right"><font <? if($row['CashFlowCompanyAmount']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowCompanyAmount'],'Money','',array('nocurrency'=>'Y'));?></font></td>
								<td bgcolor="#ffffff" align="right"><font <? if($row['CashFlowCompanyVAT']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowCompanyVAT'],'Money','',array('nocurrency'=>'Y'));?></font></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#ffffff">&nbsp;<?=getFormated($row['CashFlowCompanyComments'],'TEXT');?></td>
							</tr>
							<? }
							}?>
					</table>			
				</td> 
			</tr>
		</form> 
<?=boxFooter()?>