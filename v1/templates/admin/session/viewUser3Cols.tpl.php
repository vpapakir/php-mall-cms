<?=boxHeader(array('title'=>lang('ViewUser.session.title')))?>
<? $entityID = $out['DB']['User'][0]['UserID']; ?>
	<? if(!empty($out['DB']['User'][0]['GroupID']) || input('UserGroupID')) { ?>
		
		<tr>
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<div align="center">
			<a href="javascript://" onClick="popup('<?=setting('url')?>manageUser/UserID/<?=$out['DB']['User'][0]['UserID']?>/GroupID/<?=$out['DB']['User'][0]['GroupID']?>/windowMode/popup/')"><b><?=lang('EditUser.session.link')?></b></a>
			&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="javascript://" onClick="popup('<?=setting('url')?>notesManager/CreatorID/<?=$out['DB']['User'][0]['UserID']?>/CreatorCode/customer/windowMode/popup/')"><b><?=lang('ManageNotes.session.link')?></b></a>
			&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?=setting('url')?>confirmregistrationuser/UserID/<?=$out['DB']['User'][0]['UserID']?>"><b><?=lang('logAsUser.mail.link')?></b></a>
			<br/>
			</div>
			
			<table cellspacing="0" cellpadding="2" width="100%">
				<tr>
				<td valign="top" align="left" class="subtitle" width="100">
					<?=lang('User.UserName')?>:
				</td>
				<td align="left" width="*">
					<?=$out['DB']['User'][0]['UserName']?>
				</td>
				</tr>
				<tr>
				<td valign="top" align="left" class="subtitle">
					<?=lang('User.Email')?>:
				</td>
				<td align="left" width="*">
					<?=$out['DB']['User'][0]['Email']?>
				</td>
				</tr>
			</table>		
			<table cellspacing="0" cellpadding="2" width="100%">
				<tr>
				<td valign="top" class="fieldNames">
					<tr>
					<td valign="top" align="left" class="subtitle" width="100">
						<?=lang('User.Status')?>:<br/>
					</td>
					<td align="left">
						<?=getReferenceValue('User.Status',$out['DB']['User'][0]['Status'],array('code'=>'Y'))?>
					</td>
					</tr>
					<tr>
					<td valign="top" align="left" class="subtitle">
						<?=lang('User.PermAll')?>:<br/>
					</td>
					<td align="left">
						<?=getReferenceValue('PermAll',$out['DB']['User'][0]['PermAll'],array('code'=>'Y'))?>
						<br/>								
					</td>
					</tr>
					<tr>
						<td><?=lang('User.UserLanguage')?>:</td>
						<td>
							<? 
								foreach($out['DB']['Languages']['languageCodes'] as $key=>$value){
									$Languages[$key]['id'] = $value;
									$Languages[$key]['value'] = $out['DB']['Languages']['languageNames'][$key];
								}
							?>
							<? echo getListValue($Languages,$out['DB']['User'][0]['UserLanguage'],array('name'=>'User'.DTR.'UserLanguage'));	?>
						</td>
					</tr>
					<tr>
						<td><?=lang('User.OwnerParentID')?>:</td>
						<td>
							<?
								$administrators[0]['id'] = "";
								$administrators[0]['value'] = "--";
							
								foreach($out['DB']['Administrators'] as $key=>$row){
									$administrators[$key+1]['id'] = $row['UserID'];
									$administrators[$key+1]['value'] = $row['UserName'];
								}
							?>
							<? echo getListValue($administrators,$out['DB']['User'][0]['OwnerParentID'],array('name'=>'User'.DTR.'OwnerParentID'));	?>
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
					<?=showUserExtraFieldsView($out,$part['id'])?>
				<?  } ?>				
			</table>		
			<?  } ?>							
		
			</td> 
		</tr> 
	<? } ?>
<?=boxFooter()?>