<?=boxHeader(array('title'=>lang('EditUser.session	.title')))?>
<? $entityID = $out['DB']['User'][0]['UserID']; ?>
	<? if(!empty($input['UserGroupID']) || !empty($out['DB']['User'][0]['GroupID'])) { ?>
	<? /* tr> 
		<td valign=top bgcolor="#ffffff">
			<? $UserType = $out['DB']['User'][0]['GroupID']; if(empty($UserType)) {$UserType=$input['UserType'];} if(empty($UserType)) {$UserType=$input['UserGroupID'];}?>
			<? lang('User.UserGroupID')?>: <b><?=getListValue($out['DB']['UserGroups'],$UserType,array('id'=>'GroupID','value'=>'GroupName'))?></b>
			
		</td> 
	</tr */ ?>
	<? } else { ?>
	<tr>
	<form name="getUserGroups" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="registerMode" value="<?=input('registerMode')?>" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="User<?=DTR?>UserID" value="<?=$out['DB']['User'][0]['UserID']?>">
		<input type="hidden" name="UserID" value="<?=$out['DB']['User'][0]['UserID']?>">
		<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('UserGroupsSelect.User.tip').' -';
				echo getLists($out['DB']['UserGroups'],$input['UserGroupID'],array('name'=>'UserGroupID','id'=>'GroupID','value'=>'GroupName','action'=>'submit();','style'=>'width:200px;','options'=>$options));	
			?>	
		</td> 
	</form>
	</tr> 
	<? } ?>
	<? if(!empty($out['DB']['User'][0]['GroupID']) || input('UserGroupID')) { ?>
	
	<form name="manageUsers" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageUsers" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="registerMode" value="<?=input('registerMode')?>" />
		<? if(empty($out['DB']['User'][0]['UserID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="UserGroupID" value="<?=input('UserGroupID')?>" />
		<input type="hidden" name="windowAction" value="<?=input('windowAction')?>">
		<input type="hidden" name="ReservationOrderID" value="<?=$out['DB']['ReservationOrders']['0']['ReservationOrderID']?>">
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
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellspacing="0" cellpadding="2" width="100%">
				<tr>
				<td valign="top" class="fieldNames">
					<? /* if(input('registerMode')!='register') { ?>
					<?=lang('User.UserName')?>:  <b><?=$out['DB']['User'][0]['UserName']?></b>
					<br/><br/>
					<? } else { ?>
					<? } ?>
					*/ ?>
					<?if ($input['windowAction'] != 'close') {?>
					<tr>
					<td valign="top" align="left" class="subtitle" width="252">
						<?=lang('User.GroupID')?>: 
					</td>
					<td align="left" width="*">
						<?
							$userGroupID = $out['DB']['User'][0]['GroupID'];
							if(empty($userGroupID)) {$userGroupID = input('UserGroupID');} 
							$options[0]['id']='';	
							$options[0]['value']='- '.lang('UserGroupsSelect.User.tip').' -';
							echo getLists($out['DB']['UserGroups'],$userGroupID,array('name'=>'User'.DTR.'GroupID','id'=>'GroupID','value'=>'GroupName','action'=>'submit();','style'=>'width:200px;','options'=>$options));	
						?>	<br/>
					</td>
					</tr>
					<?}?>
					<tr>
					<td valign="top" align="left" class="subtitle" width="252">
						<?=lang('User.UserName')?>:
					</td>
					<td align="left" width="*">
						<input type="text" name="User<?=DTR?>UserName" value="<?=$out['DB']['User'][0]['UserName']?>" size="30">
						<br/>
					</td>
					</tr>
							
					<tr>
					<td valign="top" align="left" class="subtitle" width="252">
						<?=lang('User.Email')?>:
					</td>
					<td align="left" width="*">
						<input type="text" name="User<?=DTR?>Email" value="<?=$out['DB']['User'][0]['Email']?>" size="30">
						<br/>
					</td>
					</tr>
					<tr>
					<td valign="top" align="left" class="subtitle" width="252">
						<?=lang('User.Password')?>:
					</td>
					<td align="left" width="*">
						<? if(input('viewMode')=='changePassword' || input('registerMode')=='register') { ?>
						<input type="text" name="User<?=DTR?>Password" value="<?=$out['DB']['User'][0]['Password']?>" size="30">
						<? } else { ?>
						<a href="<?=setting('url').input('SID')?>/viewMode/changePassword/windowMode/<?=input('windowMode')?>/UserID/<?=input('UserID')?>/"><?=lang('ChangePassword.session.link')?></a>
						<? } ?>
						<br/>
					</td>
					</tr>
				</td>
				</tr>
			</table>		
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
			<hr size="1">
							
			<table cellspacing="0" cellpadding="2" width="100%">
				<tr>
				<td valign="top" class="fieldNames">
					<tr>
					<td valign="top" align="left" class="subtitle" width="252">
						<?=lang('User.PermAll')?>:<br/>
					</td>
					<td align="left">
					    <?if ($input['windowAction'] == 'close') {?>
						    <?=getReference('PermAll','User'.DTR.'PermAll', '1',array('code'=>'Y'))?>
						<?} else {?>
						    <?=getReference('PermAll','User'.DTR.'PermAll',$out['DB']['User'][0]['PermAll'],array('code'=>'Y'))?>
						<?}?>
						<br/>								
					</td>
					</tr>
				</td>
				</tr>
			</table>		
			<br/>
			<? if(empty($out['DB']['User'][0]['UserID'])) { ?>
			<input type="submit" value="<?=lang("-add")?>">
			<? } else { ?>
			<input type="submit" value="<?=lang("-save")?>">
			<? } ?>					
			<br/>
			</td> 
		</tr> 
	</form>	
	<? } ?>
<?=boxFooter()?>