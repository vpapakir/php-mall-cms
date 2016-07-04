<?=boxHeader(array('title'=>'ManageCashFlowCompany.cashflow.title'))?>
<?=showTabForm($out)?>

		<form name="manageCashFlowCompanies" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<? if(!empty($out['DB']['CashFlowCompany'][0]['CashFlowCompanyID'])){?>
				<input type="hidden" name="actionMode" value="save1" />
			<? }else{?>
				<input type="hidden" name="actionMode" value="add1" />
			<? }?>
			<input type="hidden" name="CashFlowCompany" value="<?=input('CashFlowCompany')?>"/>
			<input type="hidden" name="CashFlowCompany<?=DTR?>CashFlowCompanyID" value="<?=$out['DB']['CashFlowCompany'][0]['CashFlowCompanyID']?>"/>
			<tr> 
				<td valign="top" class="row1">
					<table class="row1" cellpadding="0" cellspacing="2" width="100%" border="0">
						<tr>
							<!-- <td valign="top" bgcolor="#ffffff" width="1%">
								<? if($out['DB']['CashFlowCompany'][0]['PermAll']==1) { ?>
									<input type="checkbox" name="CashFlowCompany<?=DTR?>PermAll" value="1" checked="checked"/>
								<? } else {?>
									<input type="checkbox" name="CashFlowCompany<?=DTR?>PermAll" value="1" />							
								<? } ?>
							</td> -->
							<td bgcolor="#ffffff"><span class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyName')?></span></td>
							<td bgcolor="#ffffff">
								<input type="text" name="CashFlowCompany<?=DTR?>CashFlowCompanyName" size="35" value="<?=$out['DB']['CashFlowCompany'][0]['CashFlowCompanyName']?>"/>
							</td>
						</tr>
						<tr>
							<td bgcolor="#ffffff"><span class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyPref1')?></span></td>
							<td bgcolor="#ffffff">
								<input type="text" name="CashFlowCompany<?=DTR?>CashFlowCompanyPref1" size="35" value="<?=$out['DB']['CashFlowCompany'][0]['CashFlowCompanyPref1']?>"/>
							</td>
						</tr>
						<tr>
							<td bgcolor="#ffffff"><span class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyPref2')?></span></td>
							<td bgcolor="#ffffff">
								<input type="text" name="CashFlowCompany<?=DTR?>CashFlowCompanyPref2" size="35" value="<?=$out['DB']['CashFlowCompany'][0]['CashFlowCompanyPref2']?>"/>
							</td>
						</tr>
						<tr>
							<td bgcolor="#ffffff" valign="top"><span class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyComments')?></span></td>
							<td bgcolor="#ffffff">
								<textarea name="CashFlowCompany<?=DTR?>CashFlowCompanyComments" cols="25" rows="7"><?=$out['DB']['CashFlowCompany'][0]['CashFlowCompanyComments']?></textarea>
							</td>
						</tr>
						<tr>
							<td bgcolor="#ffffff" valign="top"><span class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyUsers')?></span></td>
							<td bgcolor="#ffffff">
								<? if(is_array($out['DB']['Users'])) { foreach($out['DB']['Users'] as $group=>$user) { ?>
								<b>
								<? foreach($out['DB']['UserGroups'] as $groupInfo) { if($groupInfo['GroupID']==$group) { echo getValue($groupInfo['GroupName']);}}?>
								<br/></b>
								<? echo getLists($user,$out['DB']['CashFlowCompany'][0]['CashFlowCompanyUsers'],array('name'=>'CashFlowCompany'.DTR.'CashFlowCompanyUsers','id'=>'UserID','value'=>'UserName','type'=>'checkboxes'))?>
								<? }} ?>
							</td>
						</tr>
						<!-- <tr>
							<td bgcolor="#ffffff" valign="top"><span class="subtitle"><?=lang('CashFlowCompany.CashFlowCompanyAccounts')?></span></td>
							<td bgcolor="#ffffff">
								<? //echo getLists($out['DB']['CashFlowAccounts'],$out['DB']['CashFlowCompany'][0]['CashFlowCompanyAccounts'],array('name'=>'CashFlowCompany'.DTR.'CashFlowCompanyAccounts','id'=>'CashFlowAccountID','value'=>'CashFlowAccountName','type'=>'checkboxes'))?>
							</td>
						</tr> -->
						<tr>
							<td bgcolor="#ffffff">
								<span class="subtitle"><?=lang('CashFlowCompany.PermAll')?></span>
							</td>
							<td bgcolor="#ffffff">
								<?=getReference('PermAll','CashFlowCompany'.DTR.'PermAll',$out['DB']['CashFlowCompany'][0]['PermAll'],array('code'=>'Y'))?>
							</td>
						</tr>
					</table>			
				</td> 
			</tr>
			<? if(!empty($out['DB']['CashFlowCompany'][0]['CashFlowCompanyID'])){?>
			<tr> 
				<td valign=top  class="row1" align="center">
					<input type="submit" value="<?=lang("-save")?>">&nbsp;
					<input type="button" value="<?=lang("-delete")?>" onClick="document.manageCashFlowCompanies.actionMode.value = 'delete1';submit();">
				</td> 
			</tr>
			<? }else{?>
			<tr>
				<td class="row1" align="center">
					<input type="submit" value="<?=lang("-add")?>">
				</td>
			</tr>
			<? }?>
		</form> 
<?=boxFooter()?>