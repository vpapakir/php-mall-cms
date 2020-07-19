<input type="hidden" name="TaskboardProject<?=DTR?>TaskboardProjectID" value="<?=$out['DB']['Project'][0]['TaskboardProjectID'];?>" />
<input type="hidden" name="ProjectID" value="<?=$out['DB']['Project'][0]['TaskboardProjectID'];?>" />
<?=boxHeader(array('title'=>'ManageProjects.taskboard.title'))?>
	
		<tr> 
			<td valign="top" bgcolor="#efefef" class="fieldNames" align=center>
					<?=getLists($out['DB']['Taskboards'],
										(isset($input['ProjectID'])?('ProjectID/'.$input['ProjectID']):('TaskboardID/'.$input['TaskboardID'])),
										array(	'name'=>'',
										'id'=>'ID',
										'value'=>'Title',
										'action'=>'location.replace(\''.setting('url').'manageTaskboards/\'+this.value);',
										'type'=>'select')
						);
?>
			</td>
		</tr>

		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
<?
				$resourceTemplate = 'Taskboard';
				$formName = 'manageTaskboard';
?>
				<table cellpadding="2" cellspacing="0" width="100%">
					<tr>
						<td align="left" valign="top">
						<span class="subtitle"><?=lang('Taskboard.ProjectTitle')?></span><br>
						<input type="text" name="TaskboardProject<?=DTR?>TaskboardProjectTitle" value="<?=$out['DB']['Project'][0]['TaskboardProjectTitle'];?>" size="30">
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.ProjectContent')?></span><br>
							<textarea name="TaskboardProject<?=DTR?>TaskboardProjectContent" cols="30" rows="10"><?=$out['DB']['Project'][0]['TaskboardProjectContent'];?></textarea>
						</td>
					</tr>

					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td width="100%" align="center" bgcolor="efefef" valign="top">
							<? if(empty($out['DB']['Project'][0]['TaskboardProjectID'])) { ?>
								<input type="button" value="<?=lang("-add")?>" onClick="set_submit(this.form,'addProject');">
							<? } else { ?>
								<input type="button" value="<?=lang("-save")?>" onClick="set_submit(this.form,'saveProject');">&nbsp;&nbsp;
								<input type="button" value="<?=lang("-delete")?>" onClick="confirmDeleteEx('manageTaskboards', '<?=lang("-deleteconfirmation")?>','deleteProject');"> 
							<? } ?>
						</td>
					</tr>
				</table>
		</td> 
	</tr> 
<?=boxFooter()?>