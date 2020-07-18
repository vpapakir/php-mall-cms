<form method=post>
<?=boxHeader(array('title'=>'ManageNewMessages.mail.title'))?>
		<tr> 
			<td class='subtitleline' align=center>
<?				echo getReference('Mail.OrderNewMessages','OrderNewMessages',$input['OrderNewMessages'],array('code'=>'Y','type'=>'dropdown','isEmptyValue'=>'Y','skipEmpty'=>'Y','action'=>'submit();'))
?>
				<input name='searchWord' type=text size=10 value="<?=input('searchWord')?>">
				<input type=submit value="<?=lang('-search')?>">
			</td> 
		</tr> 
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('NewMessagesHistoryTitle.mail.tip')?></b>
			</td> 
		</tr>
	<? if(!empty($out['DB']['NewMessages'][0]['MessageID'])) { ?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">	
				<? foreach($out['DB']['NewMessages'] as $row) { if($row['UserID']!=1) { ?>
					<a href="<?=setting('url')?>mailboxadm/MessageID/<?=$row['MessageID']?>/MailBoxID/<?=$row['UserID']?>"><b><?=$row['MessageSubject']?></b></a>
					<br/>
					<? //getFormated($row['MessageText'],'TEXT')?>
					<i><?=lang('MessageSentOn.mail.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('MessageSentBy.mail.tip')?> <?=$row['MessageSenderNickName']?></i>
					<hr size="1"/>
				<? } }  ?>
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['Resources'][0]['ResourceID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
				<?=lang('NoNewMessageFound.mail.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>	
<?=boxFooter()?>
</form>