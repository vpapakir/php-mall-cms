<?=boxHeader(array('title'=>lang('EditUserProducts.User.title')))?>
<? $entityID = $out['DB']['User'][0]['UserID']; ?>
	<? if(!empty($input['UserGroupID']) || !empty($out['DB']['User'][0]['GroupID'])) { ?>
	<tr> 
		<td valign=top bgcolor="#ffffff">
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr>
		<td align="left" width="253">
			<? $UserType = $out['DB']['User'][0]['GroupID']; if(empty($UserType)) {$UserType=$input['UserType'];} if(empty($UserType)) {$UserType=$input['UserGroupID'];}?>
			<span class="subtitle"><?=lang('User.UserGroupID')?>: </span>
		</td>
		<td align="left">
		<b><?=getListValue($out['DB']['UserGroups'],$UserType,array('id'=>'GroupID','value'=>'GroupName'))?></b>
		</td></tr></table>
		</td> 
	</tr>
	<? } else { ?>
	<tr> 
	<form name="getUserGroups" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="registerMode" value="<?=input('registerMode')?>" />
		<input type="hidden" name="User<?=DTR?>UserID" value="<?=$out['DB']['User'][0]['UserID']?>">
		<input type="hidden" name="UserID" value="<?=$out['DB']['User'][0]['UserID']?>">
		<td valign=top bgcolor="#ffffff">
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr>
		<td align="left" width="253">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('UserGroupsSelect.User.tip').' -';
				echo getLists($out['DB']['UserGroups'],$input['UserGroupID'],array('name'=>'UserGroupID','id'=>'GroupID','value'=>'GroupName','action'=>'submit();','style'=>'width:200px;','options'=>$options));	
			?>	
		</td>
		</tr>
		</table>
		</td> 
	</form>
	</tr> 
	<? } ?>
	<? if(!empty($out['DB']['User'][0]['GroupID']) || input('UserGroupID')) { ?>
	<form name="manageUsers" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=setting('SID')?>" />
		<input type="hidden" name="registerMode" value="<?=setting('registerMode')?>" />
		<? if(empty($out['DB']['User'][0]['UserID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="UserGroupID" value="<?=input('UserGroupID')?>" />	
		<input type="hidden" name="User<?=DTR?>GroupID" value="<?=input('UserGroupID')?>">
		
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="User<?=DTR?>UserID" value="<?=$out['DB']['User'][0]['UserID']?>">
		<input type="hidden" name="User<?=DTR?>GroupID" value="<?=$out['DB']['User'][0]['GroupID']?>">
		<? } ?>		
		<? if(empty($out['DB']['User'][0]['UserType'])) { ?>
		<input type="hidden" name="User<?=DTR?>GroupID" value="<?=input('UserGroupID')?>" />		
		<? } else { ?>
		<input type="hidden" name="User<?=DTR?>GroupID" value="<?=$out['DB']['User'][0]['GroupID']?>">
		<? } ?>			
		<tr> 
			<td valign="top" bgcolor="#ffffff" width="100%">
					<table cellspacing="0" cellpadding="2" border="0" width="100%">
					<tr>
							<? if(input('registerMode')!='register') { ?>
						<td align="left" width="253">
							<span class="subtitle"><?=lang('User.UserName')?>:  </span>
						</td>
						<td align="left">
							<b><?=$out['DB']['User'][0]['UserName']?></b>
						</td>
					<!--	</td>
					</tr>-->
						<!--<td align="left" width="242">-->
							<? } else { ?>
							<!--<td align="left">-->
						<td align="left" width="253" class="subtitle">
							<?=lang('User.UserName')?>:
						</td>
						<td align="left">
							<input type="text" name="User<?=DTR?>UserName" value="<?=$out['DB']['User'][0]['UserName']?>" size="30">
						</td>
							<? } ?>
					 </tr>
						 <tr>
						 <td align="left" class="subtitle">
							<?=lang('User.Email')?>:
						</td>
						<td align="left">
							<input type="text" name="User<?=DTR?>Email" value="<?=$out['DB']['User'][0]['Email']?>" size="30">
						</td>
						</tr>
						<tr>
						<td align="left">
							<span class="subtitle"><?=lang('User.Password')?>: </span>
						</td>
						<td align="left">
						<? if(input('viewMode')=='changePassword') { ?>
						<input type="text" name="User<?=DTR?>Password" value="<?=$out['DB']['User'][0]['Password']?>" size="30">
						<? } else { ?>
						<a href="<?=input('url').input('SID')?>/viewMode/changePassword"><?=lang('ChangePassword.session.link')?></a>
						<? } ?>
						<br/>
						</td>
						</tr>

				</table>
			</td> 
		</tr> 

		<tr> 
			<td valign="top" bgcolor="#ffffff" width="100%">
			<? if(count($out['DB']['UserField'])>0) {?>
			<table cellspacing="0" cellpadding="2" width="100%">
				<? $parts = getReference('UserTypeField.UserTypeFieldGroups','UserTypeField'.DTR.'UserTypeFieldGroups','',array('code'=>'Y','type'=>'array'));
					//print_r($parts);
					foreach($parts as $part)
					{
				?>
				<tr>
					<td valign="top" class="subtitle" colspan="2">
						<?=getValue($part['value'])?>
					<td>
				</tr>
					<?=showUserExtraFieldsForm($out,$part['id'])?>
				<?  } ?>				
			</table>		
			<?  } ?>	
			</td> 
		</tr> 

		<tr> 
			<td valign="top" bgcolor="#ffffff" width="100%">
					<table cellspacing="0" cellpadding="2" border="0" width="100%">
					<tr>
					<td align="center" bgcolor="#efefef" colspan="2">
					<? if(empty($out['DB']['User'][0]['UserID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">
					<? } ?>
					</td>
					</tr>
				</table>
			</td> 
		</tr> 
	</form>	
	<? } ?>
<?=boxFooter()?>