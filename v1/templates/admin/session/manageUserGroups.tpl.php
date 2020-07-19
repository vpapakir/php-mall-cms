<?=boxHeader(array('title'=>'ManageUserGroups.UserGroup.title'))?>
	<table cellpadding="2" cellspacing="0" width="100%" border="0">
	<tr> 
	<form name="getUserGroups" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td width="252" bgcolor="#efefef">&nbsp;
	 
	</td>
	<td valign="top" bgcolor="#efefef" align="left">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('UserGroupNew.UserGroup.tip').' -';
			echo getLists($out['DB']['UserGroups'],$out['DB']['UserGroup'][0]['GroupID'],array('name'=>'GroupID','id'=>'GroupID','value'=>'GroupName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr>
	</table>
<!--	<tr>
	<td>&nbsp;
	 
	</td>
	</tr>-->
	<form name="manageUserGroups" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="GroupID" value="<?=$out['DB']['UserGroup'][0]['GroupID'];?>" />
		<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
				<? if(empty($out['DB']['UserGroup'][0]['GroupID'])) { ?>
			<tr>
				<td align="left" valign="top" class="subtitle" width="252">
					<input type="hidden" name="actionMode" value="add" />
					<?=lang('UserGroup.GroupID')?>*:
				</td>
				<td align="left" valign="top">
					<input type="text" name="UserGroup<?=DTR?>GroupID" value="<?=$out['DB']['UserGroup'][0]['GroupID'];?>" size="30" maxlength="30" />
				</td>
			</tr>
					<? } else { ?>
					<input type="hidden" name="actionMode" value="save" />
					<input type="hidden" name="UserGroup<?=DTR?>GroupID" value="<?=$out['DB']['UserGroup'][0]['GroupID'];?>" />
					<? } ?>
			<tr>
				<td align="left" valign="top" class="subtitle" width="252">
					<?=lang('UserGroup.GroupName')?>*:
				</td>
				<td align="left" valign="top">
					<input type="text" name="UserGroup<?=DTR?>GroupName" value="<?=$out['DB']['UserGroup'][0]['GroupName'];?>" size="50">
				</td>
			</tr>
					<? if(!empty($out['DB']['UserGroup'][0]['GroupID'])) { ?>
					<tr>
					<td align="left" colspan="2" valign="top">
						<a href="<?=setting('url')?>manageMailTemplates/MailTemplateCode/registration.<?=$out['DB']['UserGroup'][0]['GroupID'];?>.session"><?=lang('RegistrationEmailRemind.session.link')?></a>
					</td>
					</tr>
					<tr>
					<td align="left" colspan="2" valign="top">
						<a href="<?=setting('url')?>manageMailTemplates/MailTemplateCode/registrationAdmin.<?=$out['DB']['UserGroup'][0]['GroupID'];?>.session"><?=lang('RegistrationEmailRemindForAdmin.session.link')?></a>
					</td>
					</tr>
					<tr>
					<td align="left" colspan="2" valign="top">
						<a href="<?=setting('url')?>manageMailTemplates/MailTemplateCode/passwordRemind.<?=$out['DB']['UserGroup'][0]['GroupID'];?>.session"><?=lang('PasswordRemindEmail.session.link')?></a>
					</td>
					</tr>
					<tr>
					<td align="left" colspan="2" valign="top">
						<a href="<?=setting('url')?>manageMailTemplates/MailTemplateCode/passwordRemindAdmin.<?=$out['DB']['UserGroup'][0]['GroupID'];?>.session"><?=lang('PasswordRemindEmailForAdmin.session.link')?></a>
					</td>
					</tr>
					<? } ?>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left" width="252">
							<span class="subtitle"><?=lang('UserGroup.GroupDescription')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?></span>
						</td>
						<td align="left" valign="top">
							<textarea name="UserGroup<?=DTR?>GroupDescription[<?=$langCode?>]" rows="5" cols="60" ><?=getValue($out['DB']['UserGroup'][0]['GroupDescription'],$langCode)?></textarea>
						</td>
					</tr>	
					<? } ?>			
					<!--hr size="1"/>
					<? //lang('UserGroup.GroupRights')?>:<br/>
					<textarea name="rights" rows="5" cols="50" readonly><?=$out['DB']['UserGroup'][0]['GroupRights'];?></textarea-->
					<tr>
						<td align="left" valign="top" width="252" class="subtitle" width="35%">
						<?=lang('GlobalRightsList.session.tip')?>:
						</td>
						<td align="left" valign="top">
						<? foreach($out['DB']['RightsList']['global'] as $rightRow){ ?>
							<? if(eregi($rightRow['id'].',',$out['DB']['UserGroup'][0]['GroupRights'])) { ?>
								<input type="checkbox" name="UserGroup<?=DTR?>GroupRights[]" value="<?=$rightRow['id']?>" checked />
							<? } else {?>
								<input type="checkbox" name="UserGroup<?=DTR?>GroupRights[]" value="<?=$rightRow['id']?>" />
							<? } ?>
							<?=$rightRow['name']?><br/>
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" width="252">
						<span class="subtitle"><?=lang('FuntionsRightsList.session.tip')?>: </span>
						</td>
						<td align="left">
						<? foreach($out['DB']['RightsList'] as $moduleCode=>$rightRow1)
							{ if($moduleCode!='DB' && $moduleCode!='global') 
							{ ?>
						<span class="subtitle"><b>Module - <?=$moduleCode?>: </span></b><br/>
						<? foreach ($rightRow1 as $rightRow) { ?>
						<? if(eregi($rightRow['id'].',',$out['DB']['UserGroup'][0]['GroupRights'])) { ?>
							<input type="checkbox" name="UserGroup<?=DTR?>GroupRights[]" value="<?=$rightRow['id']?>" checked />
						<? } else {?>
							<input type="checkbox" name="UserGroup<?=DTR?>GroupRights[]" value="<?=$rightRow['id']?>" />
						<? } ?>						
						<?=$rightRow['name']?><br/>
						
						<? }//foreach ($rightRow1 as $rightRow) 
						}// if($moduleCode!='DB' && $moduleCode!='global') 
						}//foreach($out['DB']['RightsList'] as $moduleCode=>$rightRow1)
						?>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" width="252">
						<span class="subtitle"><?=lang('DatabaseTablesRightsList.session.tip')?>: </span>
						</td>
						<td align="left" valign="top">
						<? foreach($out['DB']['RightsList']['DB'] as $rightRow){ ?>
						<? if(eregi($rightRow['id'].',',$out['DB']['UserGroup'][0]['GroupRights'])) { ?>
							<input type="checkbox" name="UserGroup<?=DTR?>GroupRights[]" value="<?=$rightRow['id']?>" checked />
						<? } else {?>
							<input type="checkbox" name="UserGroup<?=DTR?>GroupRights[]" value="<?=$rightRow['id']?>" />
						<? } ?>						
						<?=$rightRow['name']?><br/>
						
						<? } ?>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top" width="252" class="subtitle">
						<?=lang('UserGroup.GroupStatus')?>:
						</td>
						<td align="left" valign="top">
						<?=getReference('PermAll','UserGroup'.DTR.'GroupStatus',$out['DB']['UserGroup'][0]['GroupStatus'],array('code'=>'Y'))?>
						</td>
					</tr>
					<tr>
					<td>&nbsp;
					 
					</td>
					</tr>
					<tr>
						<td align="center" bgcolor="#efefef" colspan="2" valign="top">
						<? if(empty($out['DB']['UserGroup'][0]['GroupID'])) { ?>
						<input type="submit" value="<?=lang("-add")?>">
						<? } else { ?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageUserGroups.actionMode.value='delete';confirmDelete('manageUserGroups', '<?=lang("-deleteconfirmation")?>');">
						<? } ?>					
						</td>
					</tr>
			</table>
			</td>
		</tr> 
	</form>	
<?=boxFooter()?>