<?=boxHeader(array('title'=>'ManageAccount.cashflow.title'))?>
<? $formName = 'manageAccount'?>	
<?=showTabForm($out)?>	
		<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<? if(!empty($out['DB']['CashFlowAccount'][0]['CashFlowAccountID'])){?>
				<input type="hidden" name="actionMode" value="save" />
			<? }else{?>
				<input type="hidden" name="actionMode" value="add" />
			<? }?>
			<!-- <input type="hidden" name="CashFlowAccountID" value="<?=input('CashFlowAccountID')?>"/> -->
			<input type="hidden" name="CashFlowCompany" value="<?=input('CashFlowCompany')?>"/>
			<input type="hidden" name="CashFlowAccount<?=DTR?>CashFlowAccountID" value="<?=$out['DB']['CashFlowAccount'][0]['CashFlowAccountID']?>"/>
			<tr> 
				<td valign="top" class="row1">
					<table cellpadding="0" cellspacing="2" width="100%" border="0">
						<tr>
							<td align="center"><?=lang('CashFlowAccount.CashFlowAccountName')?></td>
							<td align="center"><?=lang('CashFlowAccount.CashFlowAccountNumber')?></td>
							<td align="center"><?=lang('CashFlowAccount.CashFlowAccountInitValue')?>&nbsp;<?=setting('currency')?></td>
							<td align="center" width="8px">&nbsp;</td>
							<td align="center"><?=lang('CashFlowAccount.CashFlowAccountCompany')?></td>
							<td align="center"><?=lang('CashFlowAccount.CashFlowAccountComments')?></td>
							<td align="center"><?=lang('CashFlowAccount.PermAll')?></td>
						</tr>
						<tr>
							<td bgcolor="#ffffff" align="center"><input type="text" name="CashFlowAccount<?=DTR?>CashFlowAccountName" value="<?=$out['DB']['CashFlowAccount'][0]['CashFlowAccountName']?>"/></td>
							<td bgcolor="#ffffff" align="center"><input type="text" name="CashFlowAccount<?=DTR?>CashFlowAccountNumber" value="<?=$out['DB']['CashFlowAccount'][0]['CashFlowAccountNumber']?>"/></td>
							<td bgcolor="#ffffff" align="center"><input type="text" name="CashFlowAccount<?=DTR?>CashFlowAccountInitValue" <? if($out['DB']['CashFlowAccount'][0]['CashFlowAccountInitValue']<0){?>style="color:#FF0000"<? }?> value="<?=$out['DB']['CashFlowAccount'][0]['CashFlowAccountInitValue']?>" size="15" align="right"/></td>
							<td bgcolor="#FFFFFF"></td>
							<td bgcolor="#ffffff" align="center">
								<? if(empty($out['DB']['CashFlowAccount'][0]['CashFlowAccountCompany'])) {$out['DB']['CashFlowAccount'][0]['CashFlowAccountCompany']=input('CashFlowCompany');} echo getLists($out['DB']['Companies'],$out['DB']['CashFlowAccount'][0]['CashFlowAccountCompany'],array('name'=>'CashFlowAccount'.DTR.'CashFlowAccountCompany','id'=>'CashFlowCompanyID','value'=>'CashFlowCompanyName','options'=>$options));?>
							</td>
							<td bgcolor="#ffffff" align="center"><input type="text" name="CashFlowAccount<?=DTR?>CashFlowAccountComments" value="<?=$out['DB']['CashFlowAccount'][0]['CashFlowAccountComments']?>" size="35"/></td>
							<td bgcolor="#ffffff" align="center"><?=getReference('PermAll','CashFlowAccount'.DTR.'PermAll',$out['DB']['CashFlowAccount'][0]['PermAll'],array('code'=>'Y'))?></td>
						</tr>
					</table>			
				</td> 
			</tr>
			<tr> 
				<td align="center" class="subtitleline">
					<? if(!empty($out['DB']['CashFlowAccount'][0]['CashFlowAccountID'])){?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;<input type="button" value="-delete" onClick="document.<?=$formName?>.actionMode.value='delete';submit();"/>
					<? }else{?>	
						<input type="submit" value="<?=lang('-add')?>"/>&nbsp;<input type="button" value="<?=lang('-cancell')?>" onClick="document.<?=$formName?>.actionMode.value='cancell';submit();"/> 
					<? }?>
				</td>
			</tr>
		</form> 
<?=boxFooter()?>
<?=boxHeader(array('title'=>'viewAccounts.cashflow.title'))?>
		<form name="manageAccounts" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<!-- <input type="hidden" name="actionMode" value="savelist" /> -->
			<tr> 
				<td valign="top" class="row1">
				<table cellpadding="0" cellspacing="2" width="100%" border="0">
					<tr>
							<td align="left"><?=lang('CashFlowAccount.CashFlowAccountName')?></td>
							<td align="left"><?=lang('CashFlowAccount.CashFlowAccountNumber')?></td>
							<td align="right" width="8%"><?=lang('CashFlowAccount.CashFlowAccountAmount')?>&nbsp;<?=setting('currency')?></td>
							<td class="subtitle" align="right" width="8%"><?=lang('CashFlowAccount.CashFlowAccountVAT')?>&nbsp;<?=setting('currency')?></td>
							<td align="center" width="8px">&nbsp;</td> 
							<td align="left"><?=lang('CashFlowAccount.CashFlowAccountCompany')?></td> 
							<td align="left"><?=lang('CashFlowAccount.CashFlowAccountComments')?></td>
							<!-- <td class="subtitle"><?=lang('CashFlowAccount.PermAll')?></td> -->
							<td width="10%" align="left"><?=lang('Action.cashflow.tip')?></td>
						</tr>
					<tr> 
						<td valign="top" bgcolor="#ffffff" align="center" colspan="8">
							<hr size="1"/>
						</td> 
					</tr>
						
					<tr>
						<td bgcolor="#ffffff" colspan="2">
							<span class="subtitle"><?=lang('Overall.cashflow.tip')?></span>
						</td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($out['DB']['Overall']['SumAmount']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($out['DB']['Overall']['SumAmount'],'Money','',array('nocurrency'=>'Y'));?></font>
						</td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($out['DB']['Overall']['SumVAT']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($out['DB']['Overall']['SumVAT'],'Money','',array('nocurrency'=>'Y'));?></font>
						</td>
						<td bgcolor="#FFFFFF" colspan="4"></td>
					</tr>
					<tr> 
						<td valign="top" bgcolor="#ffffff" align="center" colspan="8">
							<hr size="1"/>
						</td> 
					</tr>
						
				<? if (is_array($out['DB']['CashFlowAccounts'])) {?>
					<? foreach($out['DB']['CashFlowAccounts'] as $id=>$row) {?>
					<input type="hidden" name="CashFlowAccount<?=DTR?>CashFlowAccountID[<?=$id?>]" value="<?=$row['CashFlowAccountID']?>"/>
					<tr>
						<td bgcolor="#ffffff">
							<a href="<?=setting('url')?><?=input('SID')?>/CashFlowAccountID/<?=$row['CashFlowAccountID']?>/CashFlowCompany/<?=input('CashFlowCompany')?>"><?=$row['CashFlowAccountName']?></a>
						</td>
						<td bgcolor="#ffffff"><?=$row['CashFlowAccountNumber']?></td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($row['CashFlowAccountAmount']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowAccountAmount'],'Money','',array('nocurrency'=>'Y'));?></font>
							<!-- <font <? if($row['CashFlowAccountInitValue']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowAccountInitValue'],'Money','',array('nocurrency'=>'Y'));?></font> -->
						</td>
						<td bgcolor="#ffffff" align="right">
							<font <? if($row['CashFlowAccountVAT']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowAccountVAT'],'Money','',array('nocurrency'=>'Y'));?></font>
						</td>
						<td bgcolor="#FFFFFF"></td>
						<td bgcolor="#ffffff" align="left"><?  echo getListValue($out['DB']['Companies'],$row['CashFlowAccountCompany'],array('id'=>'CashFlowCompanyID','value'=>'CashFlowCompanyName'));?></td>
						<td bgcolor="#ffffff"><?=$row['CashFlowAccountComments']?></td>
						<!-- <td bgcolor="#ffffff"><?=getReference('PermAll','CashFlowAccount'.DTR.'PermAll',$out['DB']['CashFlowAccount'][0]['PermAll'],array('code'=>'Y'))?></td> -->
						<td bgcolor="#ffffff" align="left"><a href="<?=setting('url')?>viewBills/CashFlowAccountID/<?=$row['CashFlowAccountID']?>/CashFlowCompany/<?=input('CashFlowCompany')?>"><?=lang('ShowEntries.cashflow.tip')?></a></td>
					</tr>
					<? } ?>			
				<? }  // end of if(is_array($out['DB']['CashFlowAccounts'])
					else {	?>
					<tr> 
						<td valign="top" bgcolor="#ffffff" align="center" colspan="7">
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