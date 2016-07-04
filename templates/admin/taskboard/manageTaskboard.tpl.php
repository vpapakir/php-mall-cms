<input type="hidden" name="Taskboard<?=DTR?>TaskboardID" value="<?=$out['DB']['Taskboard'][0]['TaskboardID'];?>" />
<input type="hidden" name="TaskboardID" value="<?=$out['DB']['Taskboard'][0]['TaskboardID'];?>" />
<table cellspacing=0 cellpadding=0><tr><td valign=top>
<?=boxHeader(array('title'=>'ManageTaskboard.taskboard.title'))?>
	
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
						<span class="subtitle"><?=lang('Taskboard.TaskboardTitle')?></span><br>
						<input type="text" name="Taskboard<?=DTR?>TaskboardTitle" value="<?=$out['DB']['Taskboard'][0]['TaskboardTitle'];?>" size="30">
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardContent')?></span><br>
							<textarea name="Taskboard<?=DTR?>TaskboardContent" cols="30" rows="10"><?=$out['DB']['Taskboard'][0]['TaskboardContent'];?></textarea>
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardProject')?></span><br>
							<?=getLists($out['DB']['Projects'],
										($out['DB']['Taskboard'][0]['TaskboardProject']?$out['DB']['Taskboard'][0]['TaskboardProject']:$input['Taskboard'.DTR.'TaskboardProject']),
										array(	'name'=>'Taskboard'.DTR.'TaskboardProject',
										'id'=>'TaskboardProjectID',
										'value'=>'TaskboardProjectTitle',
										'attributes'=>'size=10',
										'type'=>'select')
						);
?>

							<?//=getReference('Taskboard.TaskboardProject','Taskboard'.DTR.'TaskboardProject',$out['DB']['Taskboard'][0]['TaskboardProject'],array('code'=>'Y','isEmptyValue'=>'Y'))?>
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardResponsable')?></span><br>
							<?=getLists($out['DB']['Taskboard']['Users'],
										($out['DB']['Taskboard'][0]['TaskboardResponsable']?$out['DB']['Taskboard'][0]['TaskboardResponsable']:$out['UserID']),
										array(	'name'=>'Taskboard'.DTR.'TaskboardResponsable',
										'id'=>'UserID',
										'value'=>'UserName',
										'attributes'=>'size=10',
										'type'=>'select')
						);
?>
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardType')?></span><br>
							<?=getReference('Taskboard.TaskboardType','Taskboard'.DTR.'TaskboardType',$out['DB']['Taskboard'][0]['TaskboardType'],array('code'=>'Y','isEmptyValue'=>'Y','skipEmpty'=>'Y'))?>
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardStatus')?></span><br>
							<?=getReference('Taskboard.TaskboardStatus','Taskboard'.DTR.'TaskboardStatus',$out['DB']['Taskboard'][0]['TaskboardStatus'],array('code'=>'Y','isEmptyValue'=>'Y','skipEmpty'=>'Y'))?>
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardPriority')?></span><br>
							<?=getReference('Taskboard.TaskboardFlag','Taskboard'.DTR.'TaskboardFlag',$out['DB']['Taskboard'][0]['TaskboardFlag'],array('code'=>'Y','isEmptyValue'=>'Y'))?>
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardSign')?></span><br>
							<?=getReference('Taskboard.TaskboardSign','Taskboard'.DTR.'TaskboardSign',$out['DB']['Taskboard'][0]['TaskboardSign'],array('code'=>'Y'))?>
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.TaskboardDeadline')?></span><br>
						<?=GetFormated(($out['DB']['Taskboard'][0]['TaskboardDeadline']?$out['DB']['Taskboard'][0]['TaskboardDeadline']:date("d-m-Y H:i:s")),'DateTime','form',array('fieldName'=>'Taskboard'.DTR.'TaskboardDeadline','formName'=>'manageTaskboards'));?>	
						</td>
					</tr>

					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('Taskboard.VisibleBy')?></span><br>
							<input type=hidden name="<?='Taskboard'.DTR.'TaskboardUsers'?>" value=' '>
							<input type=hidden name="<?='Taskboard'.DTR.'TaskboardGroups'?>" value=' '>
<?
//print_r($out['DB']['Taskboard'][0]['TaskboardUsers']);

			echo getLists(	$out['DB']['Taskboard']['Users'],
							$out['DB']['Taskboard'][0]['TaskboardUsers'].'|'.$out['UserID'].'|',
							array(	'name'=>'Taskboard'.DTR.'TaskboardUsers',
									'id'=>'UserID',
									'value'=>'UserName',
									'attributes'=>'size=10',
									'type'=>'multiple')
						);
			echo getLists(	$out['DB']['Taskboard']['Groups'],
							$out['DB']['Taskboard'][0]['TaskboardGroups'],
							array(	'name'=>'Taskboard'.DTR.'TaskboardGroups',
									'id'=>'GroupID',
									'value'=>'GroupName',
									'attributes'=>'size=10',
									'type'=>'multiple')
						);

?>
						</td>
					</tr>

					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td width="100%" align="center" bgcolor="efefef" valign="top">
							<? if(empty($out['DB']['Taskboard'][0]['TaskboardID'])) { ?>
								<input type="button" value="<?=lang("-add")?>" onClick="set_submit(this.form,'add');">
							<? } else { ?>
								<input type="button" value="<?=lang("-save")?>" onClick="set_submit(this.form,'save');">&nbsp;&nbsp;
								<input type="button" value="<?=lang("-delete")?>" onClick="confirmDelete('manageTaskboards', '<?=lang("-deleteconfirmation")?>');">&nbsp;&nbsp;
								<input type="button" value="<?=lang("-cancel")?>" onClick="window.open('<?=setting('url')?>manageTaskboards', '_self');">
							<? } ?>
						</td>
					</tr>
				</table>
		</td> 
	</tr> 
<?=boxFooter()?></table>