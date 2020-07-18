<?=boxHeader(array('title'=>'ManageSectionGroups.core.title'))?>
	<tr> 
	<form name="getSectionGroups" method="post">
	<input type="hidden" name="SID" value="manageSectionGroups" />
	<td valign=top bgcolor="#efefef" align="center">
		<?=$out['Refs']['SectionGroups']?>
	</td> 
	</form>
	</tr> 
	<form name="manageSectionGroups" method="post">
		<input type="hidden" name="SID" value="manageSectionGroups" />
		<? if(empty($out['DB']['SectionGroup'][0]['SectionGroupID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="SectionGroup<?=DTR?>SectionGroupID" value="<?=$out['DB']['SectionGroup'][0]['SectionGroupID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
			 <tr>
			 <td align="left" width="30%" class="subtitle">
					<?=lang('SectionGroups.SectionGroupCode')?>:
			 </td>
			 <td align="left">
					<input type="text" name="SectionGroup<?=DTR?>SectionGroupCode" value="<?=$out['DB']['SectionGroup'][0]['SectionGroupCode'];?>" size="50">
			 </td>
			 </tr>
				<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<tr>
				 <td valign="top" align="left" width="30%" class="subtitle">
						<?=lang('SectionGroup.SectionGroupName')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
					</td>
					<td align="left">
						<input type="text" name="SectionGroup<?=DTR?>SectionGroupName[<?=$langCode?>]" value="<?=getValue($out['DB']['SectionGroup'][0]['SectionGroupName'],$langCode)?>" size="50">
					</td>
				</tr>	
				<? } ?>			
				<!-- jb 8.03.06 -->
				<tr>
					 <td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('SectionGroup.SectionGroupType')?></td>
					<td><?=getReference('SectionGroup.SectionGroupType','SectionGroup'.DTR.'SectionGroupType',$out['DB']['SectionGroup'][0]['SectionGroupType'],array('code'=>'Y'))?></td>
				</tr>
				<tr>
					 <td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('SectionGroup.SectionGroupViewOptions')?></td>
					<td><?=getReference('SectionGroup.SectionGroupViewOptions','SectionGroup'.DTR.'SectionGroupViewOptions',$out['DB']['SectionGroup'][0]['SectionGroupViewOptions'],array('code'=>'Y'))?></td>
				</tr>
				<tr>
					 <td valign="top" align="left" width="30%" class="subtitle">
						<?=lang('SectionGroup.SectionGroupModule')?>:
					</td>
					<td align="left">
						<? $options[0]['id']=' '; $options[0]['value']='--';?>
						<?=getLists($out['DB']['Modules'],$out['DB']['SectionGroup'][0]['SectionGroupModule'],array('name'=>'SectionGroup'.DTR.'SectionGroupModule','id'=>'ModuleAlias','value'=>'ModuleName','options'=>$options))?>
					</td>
				</tr>
				<tr>
	   			    <td valign="top" align="left" width="30%" class="subtitle">
						<?=lang('SectionGroup.SectionGroupPosition')?>:
					</td>
					<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['SectionGroups']))
						{
							foreach($out['DB']['SectionGroups'] as $row)
							{
								if ($row['SectionGroupID']!=$out['DB']['SectionGroup'][0]['SectionGroupID'])
								{
									$i++;
									$options[$i]['id']=$row['SectionGroupPosition']+1;	
									$options[$i]['value']=$row['SectionGroupName'];
								}
							}
						}
						echo getLists('',$out['DB']['SectionGroup'][0]['SectionGroupPosition']-1,array('name'=>'SectionGroup'.DTR.'SectionGroupPosition','id'=>'SectionGroupPosition','value'=>'SectionGroupName','options'=>$options));	
						$options='';
					?>					
					</td>
				</tr>
				<!-- jb 8.03.06 -->
				<tr>
					 <td valign="top" align="left" width="30%" class="subtitle">
						<?=lang('SectionGroup.AccessGroups')?>:
					</td>
					<td align="left">
						<?
							$options[0]['id']='all';	
							$options[0]['value']=lang('-allgroups');
							echo getLists($out['DB']['UserGroups'],$out['DB']['SectionGroup'][0]['AccessGroups'],array('name'=>'SectionGroup'.DTR.'AccessGroups','id'=>'GroupID','value'=>'GroupName','type'=>'checkboxes','options'=>$options));	
						?>
					</td>
				</tr>
				<tr><td width="100%" colspan="2">&nbsp;</td></tr>
				<tr><td align="center" bgcolor="#efefef" colspan="2">
					<? if(empty($out['DB']['SectionGroup'][0]['SectionGroupID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageSectionGroups.actionMode.value='delete';confirmDelete('manageSectionGroups', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			 </td>
			 </tr>
			</table>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>