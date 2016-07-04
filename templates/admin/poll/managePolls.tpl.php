<?=boxHeader(array('title'=>'ManagePollQuestion.poll.title'))?>
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr> 
	<form name="getPollQuestions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td align="left" bgcolor="#efefef" width="30%">&nbsp;</td>
	<td valign=top bgcolor="#efefef" align="left">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('PollQuestionNew.poll.tip').' -';
			echo getLists($out['DB']['PollQuestions'],$out['DB']['PollQuestion'][0]['PollQuestionID'],array('name'=>'PollQuestionID','id'=>'PollQuestionID','value'=>'PollQuestionContent','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	</table>
	<form name="managePollQuestions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['PollQuestion'][0]['PollQuestionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="PollQuestion<?=DTR?>PollQuestionID" value="<?=$out['DB']['PollQuestion'][0]['PollQuestionID'];?>" />
		<input type="hidden" name="PollQuestionID" value="<?=$out['DB']['PollQuestion'][0]['PollQuestionID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
				<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<tr>
					<td valign="top" align="left" width="30%">
							<span class="subtitle"><?=lang('PollQuestion.PollQuestionContent')?>*: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
					</td>
					<td align="left">
						<input type="text" name="PollQuestion<?=DTR?>PollQuestionContent" value="<?=getValue($out['DB']['PollQuestion'][0]['PollQuestionContent'],$langCode)?>" size="50"/>
					</td>
				</tr>	
				<? } ?>	
				<tr>
					<td align="left" valign="top">
					<span class="subtitle"><?=lang('-addafter')?>:&nbsp;</span>
					</td>
					<td align="left" valign="top">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['PollQuestions']))
						{
							foreach($out['DB']['PollQuestions'] as $row)
							{
								if ($row['PollQuestionID']!=$out['DB']['PollQuestion'][0]['PollQuestionID'])
								{
									$i++;
									$options[$i]['id']=$row['PollQuestionPosition']+1;	
									$options[$i]['value']=$row['PollQuestionContent'];
								}
							}
						}
						//print_r($out);
						//echo $out['DB']['PollQuestion'][0]['PollQuestionPosition']-1;
						echo getLists('',$out['DB']['PollQuestion'][0]['PollQuestionPosition'],array('name'=>'PollQuestion'.DTR.'PollQuestionPosition','id'=>'id','value'=>'value','options'=>$options));	
						$options='';
					?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('PollQuestion.PermAll')?></span>
					</td>
					<td>
						<? if(empty($out['DB']['PollQuestion'][0]['PermAll'])) {$out['DB']['PollQuestion'][0]['PermAll']=1;} ?>
						<?=getReference('PermAll','PollQuestion'.DTR.'PermAll',$out['DB']['PollQuestion'][0]['PermAll'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td bgcolor="#efefef" align="center" colspan="2">
					<? if(empty($out['DB']['PollQuestion'][0]['PollQuestionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.managePollQuestions.actionMode.value='delete';confirmDelete('managePollQuestions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			 		</td>
    			</tr>
			</table>
		</td> 
	</tr> 
	</form>
	<? if (!empty($out['DB']['PollQuestion'][0]['PollQuestionID'])) {?>
	<tr>
	<td valign="top" bgcolor="#ffffff" class="fieldNames">
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<? if(is_array($out['DB']['PollAnswers'])){foreach($out['DB']['PollAnswers'] as $row){?>
				<tr>
					<td width="30%" align="left"><?=$row['PollAnswerContent']?></td>
					<td align="left"><? if($out['DB']['PollQuestion'][0]['PollQuestionVotes']!=0){echo (floor($row['PollAnswerVotes']/$out['DB']['PollQuestion'][0]['PollQuestionVotes']*100).'%');}?></td>
					<td align="left"><? if($out['DB']['PollQuestion'][0]['PollQuestionVotes']!=0){?><img src="<?=setting('layout')?>images/poll.gif" height="5px" width="<?=floor($row['PollAnswerVotes']/$out['DB']['PollQuestion'][0]['PollQuestionVotes']*100)?>" border="0"/><? }?></td>
				</tr>
			<? }}?>
		</table>
	</td>
	</tr>
	<? }?>
	<? if (!empty($out['DB']['PollQuestion'][0]['PollQuestionID'])) {?>
	<form name="getPollAnswers" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="PollQuestionID" value="<?=$out['DB']['PollQuestion'][0]['PollQuestionID'];?>" />	
	<tr> 
	<td valign="top" bgcolor="#ffffff" class="fieldNames">
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr>
			<td align="left" bgcolor="#efefef" width="30%">&nbsp;</td>
			<td valign=top bgcolor="#efefef" align="left">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('PollAnswerNew.poll.tip').' -';
					echo getLists($out['DB']['PollAnswers'],$out['DB']['PollAnswer'][0]['PollAnswerID'],array('name'=>'PollAnswerID','id'=>'PollAnswerID','value'=>'PollAnswerContent','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
		</tr> 
	</table>
	</td> 
	</tr> 
	</form>
	
	<form name="managePollAnswers" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['PollAnswer'][0]['PollAnswerID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="PollQuestionID" value="<?=$out['DB']['PollQuestion'][0]['PollQuestionID'];?>" />
		<input type="hidden" name="PollAnswer<?=DTR?>PollAnswerID" value="<?=$out['DB']['PollAnswer'][0]['PollAnswerID'];?>" />
		<input type="hidden" name="PollAnswer<?=DTR?>PollQuestionID" value="<?=$out['DB']['PollQuestion'][0]['PollQuestionID'];?>" />
		<!-- <input type="hidden" name="PollAnswer<?=DTR?>PollQuestion" value="<?=$out['DB']['PollQuestion'][0]['PollQuestionAlias'];?>" /> -->
		
		<input type="hidden" name="PollAnswerID" value="<?=$out['DB']['PollAnswer'][0]['PollAnswerID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="2" width="100%" border="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" align="left" width="30%">
							<span class="subtitle"><?=lang('PollAnswer.PollAnswerContent')?>*:</span>
						</td>
						<td align="left"> 
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
							<? }?>
							<input type="text" name="PollAnswer<?=DTR?>PollAnswerContent[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['PollAnswer'][0]['PollAnswerContent'],$langCode);?>" />
						</td>
					</tr>	
					<? }?>
					<tr>
						<td valign="top" align="left" width="30%">
							<span class="subtitle"><?=lang('PollAnswer.PermAll')?></span>
						</td>
						<td align="left">
							<? if(empty($out['DB']['PollAnswer'][0]['PermAll'])) {$out['DB']['PollAnswer'][0]['PermAll']=1;} ?>
							<?=getReference('PermAll','PollAnswer'.DTR.'PermAll',$out['DB']['PollAnswer'][0]['PermAll'],array('code'=>'Y'))?>
						</td>
					</tr>			
					<tr>
						<td valign="top" align="left" width="30%">
							<span class="subtitle"><?=lang('-addafter')?>:</span>
						</td>
						<td align="left">
							<?
								$options[0]['id']='1';	
								$options[0]['value']='- '.lang('-first').' -';
								if(is_array($out['DB']['PollAnswers']))
								{
									foreach($out['DB']['PollAnswers'] as $row)
									{
										if ($row['PollAnswerID']!=$out['DB']['PollAnswer'][0]['PollAnswerID'])
										{
											$i++;
											$options[$i]['id']=$row['PollAnswerPosition']+1;	
											$options[$i]['value']=$row['PollAnswerContent'];
										}
									}
								}
								echo getLists('',$out['DB']['PollAnswer'][0]['PollAnswerPosition'],array('name'=>'PollAnswer'.DTR.'PollAnswerPosition','id'=>'PollAnswerPosition','value'=>'PollAnswerContent','options'=>$options));	
								$options='';
							?>
						</td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>	
						<td bgcolor="#efefef" align="center" colspan="2">
							<? if(empty($out['DB']['PollAnswer'][0]['PollAnswerID'])) { ?>
							<input type="submit" value="<?=lang("-add")?>">
							<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.managePollAnswers.actionMode.value='delete';confirmDelete('managePollAnswers', '<?=lang("-deleteconfirmation")?>');">
							<? } ?>					
						</td>
					</tr>
				</table>
			</td> 
		</tr> 
	</form>
	<? } ?>
	<? if (!empty($out['DB']['PollAnswer'][0]['PollAnswerID']) && ($out['DB']['PollAnswer'][0]['PollAnswerType']=='dropdown' || $out['DB']['PollAnswer'][0]['PollAnswerType']=='checkboxes' || $out['DB']['PollAnswer'][0]['PollAnswerType']=='radioboxes')) {?>
	<form name="getPollQuestionOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="PollQuestionID" value="<?=$out['DB']['PollQuestion'][0]['PollQuestionID'];?>" />
		<input type="hidden" name="PollAnswerID" value="<?=$out['DB']['PollAnswer'][0]['PollAnswerID'];?>" />
		<tr>
			<td valign=top bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('PollQuestionOptionNew.poll.tip').' -';
					echo getLists($out['DB']['PollQuestionOptions'],$out['DB']['PollQuestionOption'][0]['PollQuestionOptionID'],array('name'=>'PollQuestionOptionID','id'=>'PollQuestionOptionID','value'=>'PollQuestionOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedPollQuestionID'))) ?>
<?=boxFooter()?>