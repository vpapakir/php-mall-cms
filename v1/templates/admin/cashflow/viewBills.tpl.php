<?=boxHeader(array('title'=>'viewBills.cashflow.title'))?>
<?=showTabForm($out)?>

		<tr>
			<td class="row1">
				<form name="viewBills" method="post" onSubmit="submitonce(this)">
					<input type="hidden" name="SID" value="<?=input('SID')?>" />
					<input type="hidden" name="CashFlowCompany" value="<?=input('CashFlowCompany')?>"/>
					<? $fromDate = input('CashFlowBillsDateFrom'); if(empty($fromDate)) {$fromDate = date('Y-m-d H:i:s',time()-60*60*24*30);} ?>
					<?=lang('DateFrom.cashflow.tip')?>&nbsp;<?=getFormated($fromDate,'Date','form',array('mode'=>'dropdowns','fieldName'=>'CashFlowBillsDateFrom'))?>
					&nbsp;<?=lang('DateTo.cashflow.tip')?>&nbsp;<?=getFormated(input('CashFlowBillsDateTo'),'Date','form',array('mode'=>'dropdowns','fieldName'=>'CashFlowBillsDateTo'))?>
					<? $statusOptions[0]['id']=''; $statusOptions[0]['value']=lang('-all'); ?>
					&nbsp;<?=getReference('CashFlowBillStatus','CashFlowBillStatus',input('CashFlowBillStatus'),array('code'=>'Y','type'=>'dropdown','options'=>$statusOptions))?>
					&nbsp;<?=getReference('CashFlowBillPurpose','CashFlowBillPurpose',input('CashFlowBillPurpose'),array('code'=>'Y','type'=>'dropdown','options'=>$statusOptions))?>
					&nbsp;<?
							$options[0]['id'] = '';
							$options[0]['value'] = lang('-all');
							echo getLists($out['DB']['CashFlowAccounts'],input('CashFlowAccountID'),array('name'=>'CashFlowAccountID','id'=>'CashFlowAccountID','value'=>'CashFlowAccountName','options'=>$options));
						  ?>
					<input type="submit" value="<?=lang('-refresh')?>"/>
				</form>
			</td>
		</tr>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">&nbsp;</td> 
		</tr>
	<? if(!empty($out['DB']['CashFlowBills'][0]['CashFlowBillID'])) {?>
			<!-- <input type="hidden" name="actionMode" value="savelist" /> -->
			<tr> 
				<td valign="top" class="row1">
						<!-- <br/>
						<div align="center">
						<a href="<?=setting('url')?>manageBill/CategoryID/<?=input('CategoryID')?>/BillType/<?=input('BillType')?>" class="boldLink">[<?=lang('AddBill.blog.link')?>]</a>
						</div>		
						<br/> -->				
						<table cellpadding="1" cellspacing="2" width="100%" border="0">
						<tr>
							<td class="subtitle" align="left"><?=lang('CashFlowBill.CashFlowAccount')?></td>
							<td class="subtitle" align="left" width="12%"><?=lang('CashFlowBill.CashFlowBillDate')?></td>
							<td class="subtitle" align="right" width="8%"><?=lang('CashFlowBill.CashFlowBillAmount')?>&nbsp;<?=setting('currency')?></td>
							<td class="subtitle" align="right" width="8%"><?=lang('CashFlowBill.CashFlowBillVAT')?>&nbsp;<?=setting('currency')?></td>
							<td width="8px"></td>
							<td class="subtitle" align="left" width="8%"><?=lang('CashFlowBill.CashFlowBillStatus')?></td>
							<td class="subtitle" align="left"><?=lang('CashFlowBill.CashFlowBillPurpose')?></td>
							<td class="subtitle" align="left"><?=lang('CashFlowBill.CashFlowBillComments')?></td>
						</tr>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="center" colspan="8">
								<hr size="1"/>
							</td> 
						</tr>
						<? if(is_array($out['DB']['CashFlowBills'])){ foreach($out['DB']['CashFlowBills'] as $row){ $totalAmount = $totalAmount + $row['CashFlowBillAmount']; $totalVAT = $totalVAT + $row['CashFlowBillVAT']; }}?>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="left" class="subtitle" colspan="2"><?=lang('Total.cashflow.tip')?>:</td> 
							<td bgcolor="#FFFFFF" align="right"><?=getFormated($totalAmount,'Money','',array('nocurrency'=>'Y'));?></td>
							<td bgcolor="#FFFFFF" align="right"><?=getFormated($totalVAT,'Money','',array('nocurrency'=>'Y'));?></td>							
							<td bgcolor="#FFFFFF" colspan="4"></td>
						</tr>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="center" colspan="8">
								<hr size="1"/>
							</td> 
						</tr>
						<? foreach($out['DB']['CashFlowBills'] as $id=>$row) {?>
							<!-- <input type="hidden" name="CashFlowBill<?=DTR?>CashFlowBillID[<?=$id?>]" value="<?=$row['CashFlowBillID']?>"/> -->
							<tr>
								<td bgcolor="#ffffff" width="20%">
									<a href="<?=setting('url')?>manageBill/CashFlowBillID/<?=$row['CashFlowBillID']?>/CashFlowCompany/<?=$row['CashFlowCompanyID']?>">
										<?=getListValue($out['DB']['CashFlowAccounts'],$row['CashFlowAccountID'],array('id'=>'CashFlowAccountID','value'=>'CashFlowAccountName'));?>
									</a>
								</td>
								<td bgcolor="#ffffff" align="left">
									<?=getFormated($row['CashFlowBillDate'],'DATE');?>
								</td>
								<td bgcolor="#ffffff" align="right">
									<font <? if($row['CashFlowBillAmount']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowBillAmount'],'Money','',array('nocurrency'=>'Y'));?></font>
								</td>
								<td bgcolor="#ffffff" align="right">
									<font <? if($row['CashFlowBillVAT']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowBillVAT'],'Money','',array('nocurrency'=>'Y'));?></font>
								</td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#ffffff" align="left">
									<?=getReferenceValue('CashFlowBillStatus',$row['CashFlowBillStatus'])?>
								</td>
								<td bgcolor="#ffffff" align="left">
									<?=getReferenceValue('CashFlowBillPurpose',$row['CashFlowBillPurpose'])?>
								</td>
								<td bgcolor="#ffffff">
									<?=getFormated($row['CashFlowBillComments'],'TEXT');?>
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
		<!-- </form>  -->
	<?  }// end of  if(!empty($out['DB']['Bills'][0]['BillID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br><br>
					<!--<div align="center">
					<a href="<?=setting('url')?>manageBill" class="boldLink">[<?=lang('AddBill.cashflow.link')?>]</a>
					</div>		
					<br/> -->
					<?=lang('NoBillFound.cashflow.tip')?>
					<br><br>
			</td> 
		</tr>
	<? } ?>	
<?=boxFooter()?>