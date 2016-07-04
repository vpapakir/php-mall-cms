<? if(input('filterMode')=='last'){?>
	<?=boxHeader(array('title'=>'ManageLastUsers.session.title'))?>
<? }else{?>
	<?=boxHeader(array('title'=>'ManageUsers.session.title'))?>
<? }?>	
<? if ($input['windowAction'] == 'close') { ?>
<?//=$out['DB']['ReservationOrders']['0']['ReservationOrderID']+10000?>
<script type = "text/javascript">
window.opener.document.ReservationOrder.ReservationOrder<?=DTR?>ReservationOrderClientType.value='<?=$input['ReservationOrderID']+10000?> <?=ucwords($input['UserField'.DTR.'FirstName'])?> <?=strtoupper($input['UserField'.DTR.'LastName'])?>';
window.opener.document.ReservationOrder.ReservationOrder<?=DTR?>UserID.value='<?=$out['DB']['Users']['0']['UserID']?>';
window.close();
</script>
<? } ?>
	<form name="manageUsersSelector" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="view" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />	
	<tr>
		<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('UserGroupSelect.session.tip').' -';
			echo getLists($out['DB']['UserGroups'],input('GroupID'),array('name'=>'GroupID','id'=>'GroupID','value'=>'GroupName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>
		&nbsp;<a href="<?=setting('url')?>manageUsers/PermAll/4"><?=lang('BlockedUsers.session.tip')?></a>	
		</td> 
	</tr>
	</form>
	</tr> 
	<form name="manageUsers" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="actionMode" value="view" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />	
		
	<? if(!empty($out['DB']['Users'][0]['UserID'])) {?>
		<tr>
			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">
				<br/>
				<a href="<?=setting('url')?>manageUser/registerMode/register/UserGroupID/<?=input('GroupID')?>/GroupID/<?=input('GroupID')?>" class="boldLink">
					[<?=lang('RegisterUser.session.link')?>]
				</a>
				<br/><br/>
			</td>
		</tr>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Users'] as $id=>$row) {?>
					<input type="hidden" name="User<?=DTR?>UserID[<?=$id?>]" value="<?=$row['UserID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<? if(!empty($row['PermAll'])) {$permAll = $row['PermAll']; } else {$permAll = 4;}?>
							<img src="<?=setting('layout')?>images/icons/status-<?=$permAll?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="User<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="User<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>																
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['UserName'])?>
						</td>
						<td valign="top" class="row1" width="70%">
							<?=getListValue($out['DB']['UserGroups'],$row['GroupID'],array('id'=>'GroupID','value'=>'GroupName'))?>
						</td>												
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageUser/UserID/<?=$row['UserID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageUsers/User<?=DTR?>UserID/<?=$row['UserID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteUser.session.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['UserID']?>" onChange="selectLink('manageUsers', 'manageR<?=$row['UserID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageUser/UserID/<?=$row['UserID']?>/GroupID/<?=input('GroupID')?>/UserType/<?=input('GroupID')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageUsers/User<?=DTR?>UserID/<?=$row['UserID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/UserType/<?=input('UserType')?>"><?=lang('-delete')?></option>
							</select>
							<!--br/>
							<a href="<?=setting('url')?>manageUser/UserParentID/<?=$row['UserParentID']?>/GroupID/<?=input('GroupID')?>/UserPosition/<? $newUserPosition=$row['UserPosition'] + 1; echo $newUserPosition; ?>">[<?=lang('AddUserAfter.session.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageUser/UserParentID/<?=$row['UserID']?>/GroupID/<?=input('GroupID')?>/UserPosition/1">[<?=lang('AddUserUnder.session.link','nospace')?>]</a-->
						</td>										
					</tr>	
				<? } ?>			
				<tr>  
					<td valign="top" align="center" colspan="5"> 
						<?=getPages($out['pages']['Users'])?>
					</td> 
				</tr>					
						
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign="top" bgcolor="#ffffff">
				<input type="button" value="<?=lang("-save")?>" onClick="document.manageUsers.actionMode.value='savelist';submit();">
			</td> 
		</tr>		
	<?  }// end of  if(!empty($out['DB']['Users'][0]['UserID']))
		else{?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<br/><br/>
					<?=lang('NoUserFound.session.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
	</form>
<?=boxFooter()?>