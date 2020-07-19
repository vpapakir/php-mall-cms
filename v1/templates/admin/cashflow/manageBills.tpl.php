<? //echo $out['DB']['CashFlowBill'][0]['CashFlowBillDate'];?>
<?=boxHeader(array('title'=>'ManageBills.cashflow.title'))?>
<?=showTabForm($out)?>
<? $formName = 'manageBill'?>		
		<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<? if(!empty($out['DB']['CashFlowBill'][0]['CashFlowBillID'])){?>
				<input type="hidden" name="actionMode" value="save" />
			<? }else{?>
				<input type="hidden" name="actionMode" value="add" />
			<? }?>
			<!-- <input type="hidden" name="CashFlowBillID" value="<?=input('CashFlowBillID')?>"/> -->
			<input type="hidden" name="CashFlowCompany" value="<?=input('CashFlowCompany')?>"/>
			<input type="hidden" name="CashFlowBill<?=DTR?>CashFlowBillID" value="<?=$out['DB']['CashFlowBill'][0]['CashFlowBillID']?>"/>
			<input type="hidden" name="CashFlowBill<?=DTR?>CashFlowCompanyID" value="<?=input('CashFlowCompany')?>"/>
			<tr> 
				<td valign="top" class="row1">
					<table cellpadding="0" cellspacing="2" width="100%" border="0">
						<tr>
							<td class="listtitle" align="center"><?=lang('CashFlowBill.CashFlowAccount')?></td>
							<td class="listtitle" align="center"><?=lang('CashFlowBill.CashFlowBillDate')?></td>
							<td class="listtitle" align="right"><?=lang('CashFlowBill.CashFlowBillAmount')?>&nbsp;<?=setting('currency')?></td>
							<td class="listtitle" align="right"><?=lang('CashFlowBill.CashFlowBillVAT')?>&nbsp;<?=setting('currency')?></td>
							<td class="listtitle" align="center"><?=lang('CashFlowBill.CashFlowBillComments')?></td>
							<td class="listtitle" align="center"><?=lang('CashFlowBill.CashFlowBillStatus')?></td>
							<td class="listtitle" align="center"><?=lang('CashFlowBill.CashFlowBillPurpose')?></td>
						</tr>
						<tr>
							<td bgcolor="#ffffff" align="center"><? echo getLists($out['DB']['CashFlowAccounts'],$out['DB']['CashFlowBill'][0]['CashFlowAccountID'],array('name'=>'CashFlowBill'.DTR.'CashFlowAccountID','id'=>'CashFlowAccountID','value'=>'CashFlowAccountName'));?></td>
							<td bgcolor="#ffffff" align="center">
								<? 
									if(empty($out['DB']['CashFlowBill'][0]['CashFlowBillDate']))
										{ 
											$out['DB']['CashFlowBill'][0]['CashFlowBillDate'] = date("d-m-Y");
										}else{
											 	$patterns = array ("/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/","/^\s*{(\w+)}\s*=/");
												$replace = array ("\\3-\\4-\\1\\2", "$\\1 =");
												$out['DB']['CashFlowBill'][0]['CashFlowBillDate'] = preg_replace($patterns, $replace,$out['DB']['CashFlowBill'][0]['CashFlowBillDate']);
											 }
										?>
									<?=getFormated($out['DB']['CashFlowBill'][0]['CashFlowBillDate'],'Date','form',array('fieldName'=>'CashFlowBill'.DTR.'CashFlowBillDate','formName'=>$formName))?>
							</td>
							<td bgcolor="#ffffff" align="center"><input type="text" name="CashFlowBill<?=DTR?>CashFlowBillAmount" value="<?=$out['DB']['CashFlowBill'][0]['CashFlowBillAmount']?>"  <? if($out['DB']['CashFlowBill'][0]['CashFlowBillAmount']<0){?>style="color:#FF0000"<? }?> size="15" align="right"/></td>
							<td bgcolor="#ffffff" align="center"><input type="text" name="CashFlowBill<?=DTR?>CashFlowBillVAT" value="<?=$out['DB']['CashFlowBill'][0]['CashFlowBillVAT']?>"  <? if($out['DB']['CashFlowBill'][0]['CashFlowBillVAT']<0){?>style="color:#FF0000"<? }?> size="15" align="right"/></td>
							<td bgcolor="#ffffff" align="center"><input type="text" name="CashFlowBill<?=DTR?>CashFlowBillComments" value="<?=$out['DB']['CashFlowBill'][0]['CashFlowBillComments']?>" size="35"/></td>
							<td bgcolor="#ffffff" align="center"><? echo getReference('CashFlowBillStatus','CashFlowBill'.DTR.'CashFlowBillStatus',$out['DB']['CashFlowBill'][0]['CashFlowBillStatus'],array('code'=>'Y','type'=>'dropdown'))?></td>
							<td bgcolor="#ffffff" align="center"><? echo getReference('CashFlowBillPurpose','CashFlowBill'.DTR.'CashFlowBillPurpose',$out['DB']['CashFlowBill'][0]['CashFlowBillPurpose'],array('code'=>'Y','type'=>'dropdown','style'=>'width:130px;'))?></td>
						</tr>
						 <!-- <tr>
							<td bgcolor="#ffffff" valign="top">
								<span class="subtitle"><?=lang('CashFlowBill.PermAll')?></span>
							</td>
							<td>
								<?=getReference('PermAll','CashFlowBill'.DTR.'PermAll',$out['DB']['CashFlowBill'][0]['PermAll'],array('code'=>'Y'))?>
							</td>
						</tr> -->
					</table>			
				</td> 
			</tr>
			<tr> 
				<td align="center" class="subtitleline">
					<? if(!empty($out['DB']['CashFlowBill'][0]['CashFlowBillID'])){?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;<input type="button" value="-delete" onClick="document.<?=$formName?>.actionMode.value='delete';submit();"/>
					<? }else{?>	
						<input type="submit" value="<?=lang('-add')?>"/>&nbsp;<input type="button" value="<?=lang('-cancell')?>" onClick="document.<?=$formName?>.actionMode.value='cancell';submit();"/> 
					<? }?>
				</td>
			</tr>
		</form> 
		<?=boxFooter()?>
		<?=boxHeader(array('title'=>'LastBills.cashflow.title'))?>
		<? if(!empty($out['DB']['CashFlowBills'][0]['CashFlowBillID'])) {?>
			<!-- <input type="hidden" name="actionMode" value="savelist" /> -->
			<tr> 
				<td valign="top" class="row1">
						<!-- <br/>
						<div align="center">
						<a href="<?=setting('url')?>manageBill/CategoryID/<?=input('CategoryID')?>/BillType/<?=input('BillType')?>" class="boldLink">[<?=lang('AddBill.blog.link')?>]</a>
						</div>		
						<br/> -->				
						<table cellpadding="0" cellspacing="2" width="100%" border="0">
						<tr>
							<td align="left"><?=lang('CashFlowBill.CashFlowAccount')?></td>
							<td align="left" width="12%"><?=lang('CashFlowBill.CashFlowBillDate')?></td>
							<td align="right" width="8%"><?=lang('CashFlowBill.CashFlowBillAmount')?>&nbsp;<?=setting('currency')?></td>
							<td align="right" width="8%"><?=lang('CashFlowBill.CashFlowBillVAT')?>&nbsp;<?=setting('currency')?></td>
							<td width="8px"></td>
							<td align="left" width="8%"><?=lang('CashFlowBill.CashFlowBillStatus')?></td>
							<td align="left"><?=lang('CashFlowBill.CashFlowBillPurpose')?></td>
							<td align="left"><?=lang('CashFlowBill.CashFlowBillComments')?></td>
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
								<td bgcolor="#ffffff">
									<?=getFormated($row['CashFlowBillDate'],'DATE');?>
								</td>
								<td bgcolor="#ffffff" align="right">
									<font <? if($row['CashFlowBillAmount']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowBillAmount'],'Money','',array('nocurrency'=>'Y'));?></font>
								</td>
								<td bgcolor="#ffffff" align="right">
									<font <? if($row['CashFlowBillVAT']<=0){?>style="color:#FF0000"<? }?>><?=getFormated($row['CashFlowBillVAT'],'Money','',array('nocurrency'=>'Y'));?></font>
								</td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#ffffff">
									<?=getReferenceValue('CashFlowBillStatus',$row['CashFlowBillStatus'])?>
								</td>
								<td bgcolor="#ffffff">
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
				<td valign="top" bgcolor="#ffffff" align="center" colspan="4">
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