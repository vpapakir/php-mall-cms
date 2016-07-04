<pre><?//print_r($out['DB']['Taskboard'][0]);?></pre>
<?=boxHeader(array('title'=>$out['DB']['Taskboard'][0]['TaskboardTitle']))?>

	<input type="hidden" name="TaskboardRecord<?=DTR?>TaskboardRecordID" value="<?=input('TaskboardRecordID')?>" />
	<input type="hidden" name="TaskboardRecord<?=DTR?>TaskboardID" value="<?=input('TaskboardID')?>" />
	<input type="hidden" name="TaskboardID" value="<?=input('TaskboardID')?>" />
	<tr>
		<td>
			<span class="subtitle"><?=lang('Taskboard.taskboard.TaskboardContent')?></span><br/>
			<?=$out['DB']['Taskboard'][0]['TaskboardContent'];?>
		</td>
	</tr>
	<tr>
		<td>
			<a class="boldlink" href="<?=setting('url')?><?=input('SID')?>/TaskboardID/<?=input('TaskboardID')?><?=input('Timestamp')?'':'/Timestamp/1'?>"><?=lang('Taskboard.taskboard.TaskboardTimestamp')?></a>:
			<?=$out['DB']['Taskboard'][0]['time_spent'];?>
		</td>
	</tr>
<?		$formName = 'manageTaskboards';
		if(!input('Timestamp')){
?>
	<tr>
		<td><span class="subtitle"><?=lang('TaskboardRecord.taskboard.TaskboardRecordTimestamp')?></span><br/>
			<input type="text" name="TaskboardRecord<?=DTR?>TaskboardRecordTimestamp" value="<?=$out['DB']['TaskboardRecord'][0]['TaskboardRecordTimestamp'];?>" size="30">
		</td> 
	</tr>
	<tr>
		<td valign="top">
			<span class="subtitle"><?=lang('TaskboardRecord.taskboard.TaskboardRecordContent')?></span><br/>
			<textarea name="TaskboardRecord<?=DTR?>TaskboardRecordContent" cols="30" rows="10"><?=$out['DB']['TaskboardRecord'][0]['TaskboardRecordContent'];?></textarea><br><br>
		</td> 
	</tr>
	<tr>
		<td valign="top" bgcolor="efefef" align="center">
			<? if(!input('TaskboardRecordID')) { ?>
				<input type="button" value="<?=lang("-add")?>" onClick="set_submit(this.form,'addRecord');">&nbsp;&nbsp;
				<input type="button" value="<?=lang("MarkAllRead.taskboard.link")?>" onClick="set_submit(this.form,'markAllRead');">
			<? } else { ?>
				<input type="button" value="<?=lang("-save")?>" onClick="set_submit(this.form,'saveRecord');">&nbsp;&nbsp;
				<input type="button" value="<?=lang("-delete")?>" onClick="confirmDeleteEx('manageTaskboards', '<?=lang("-deleteconfirmation")?>','deleteRecord');"> 
			<? } ?>
		</td>
	</tr>

<?		}
		if(!empty($out['DB']['TaskboardRecords'][0]['TaskboardRecordID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<? foreach($out['DB']['TaskboardRecords'] as $id=>$row) {
						if(!$row['TaskboardSeenBy'])
							$color='#F9CE91';
						else
							$color='';
?>
					<tr>
						<td valign="center" bgcolor="<?=$color?>">
							<span class="subtitle">
								[<?=$out['DB']['Taskboard'][0]['TaskboardProjectTitle']?>]
								<?=getFormated($row['TimeCreated'],'DateTime')?>		
								<?=lang('-by')?>
								<?=$row['UserName']?>
							</span>
							<?if($row['TaskboardRecordTimestamp']){?>
							<br>
							<span style="color:red">
								<?=lang('TaskboardRecord.taskboard.TaskboardRecordTimestamp')?> <?=$row['TaskboardRecordTimestamp']?>
							</span>
							<?}?>
							
						</td>
						<td align="right" bgcolor="<?=$color?>">
							<a href="<?=setting('url')?><?=input('SID')?>/TaskboardRecordID/<?=$row['TaskboardRecordID']?>/TaskboardID/<?=input('TaskboardID')?>"><?=lang('-editbox')?></a>
						</td>
					</tr>
					<tr>
						<td valign="top" colspan=2 bgcolor="<?=$color?>">
							<?=nl2br(getValue($row['TaskboardRecordContent']))?><hr>
						</td>
					</tr>	
				<? } ?>					
				</table>		
			</td> 
		</tr> 
<?	}else{
?>
		<tr> 
			<td valign="top" align="center">
				<br/><br/>
				<?=lang('NoTaskboardRecordFound.resource.tip')?>
				<br><br>
			</td> 
		</tr>
<?	}
?>		
<?=boxFooter()?>