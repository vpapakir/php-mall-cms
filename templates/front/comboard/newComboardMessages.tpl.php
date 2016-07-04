<?=boxHeader(array('title'=>'ManageNewComboardMessages.comboard.title'))?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('NewComboardMessagesHistoryTitle.comboard.tip')?></b>
			</td> 
		</tr>
	<? if(!empty($out['DB']['NewComboardMessages'][0]['ComboardMessageID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">	
				<? foreach($out['DB']['NewComboardMessages'] as $row) {?>
					<a href="<?=setting('url')?>mailbox/ComboardMessageID/<?=$row['ComboardMessageID']?>/MailBoxID/<?=$row['UserID']?>"><b><?=$row['ComboardMessageSubject']?></b></a>
					<br/>
					<?=getFormated($row['ComboardMessageText'],'TEXT')?>
					<br/>
					<i><?=lang('ComboardMessageSentOn.comboard.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('ComboardMessageSentBy.comboard.tip')?> <?=$row['ComboardMessageSenderNickName']?></i>
					<hr size="1"/>
				<? } ?>
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['Resources'][0]['ResourceID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
				<?=lang('NoNewComboardMessageFound.comboard.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>	
<?=boxFooter()?>