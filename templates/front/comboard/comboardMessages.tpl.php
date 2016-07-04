<?
//print_r($out['DB']['NewComboardMessagesAtt']);
$actionModeBase='send';
if(!empty($out['att']['ComboardMessageAddedID']))
{
	$actionModeField='attach2';
}
else
{
	$actionModeField='attach';
}
//echo "Template: ".$actionModeField." MessID: ".$out['att']['ComboardMessageAddedID']."<br>";
?>
<?=boxHeader(array('title'=>lang('UserMailbox.comboard.title')))?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('NewComboardMessagesHistoryTitle.comboard.tip')?></b>
			</td> 
		</tr>
	<? if(!empty($out['DB']['NewComboardMessages'][0]['ComboardMessageID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">	
				<? foreach($out['DB']['NewComboardMessages'] as $row) {?>
					<a href="<?=setting('url')?><?=input('SID')?>/ComboardMessageID/<?=$row['ComboardMessageID']?>"><b><?=$row['ComboardMessageSubject']?></b></a>
					<br/>
					<?=getFormated($row['ComboardMessageText'],'TEXT')?>
					<br/>
					<i><?=lang('ComboardMessageSentOn.comboard.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('ComboardMessageSentBy.comboard.tip')?> <?=$row['ComboardMessageSenderNickName']?></i>
					<br/>
					<?
					if(is_array($out['DB']['NewComboardMessagesAtt']))
					{
					foreach($out['DB']['NewComboardMessagesAtt'] as $key=>$val)
					{
						if($row['ComboardMessageID']==$val['ComboardMessageID'])
						{
							$temp=explode("/",$val['ComboardMessageFile']); echo "<div align=left>&nbsp;&nbsp;-&nbsp;<a href='".setting('urlfiles').$val['ComboardMessageFile']."' target='_blank'>".end($temp)."</a></div>";
						}
					}#foreach
					}#if
					?>
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
	<form name="sendComboardMessage" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="send" />
		<? if(!empty($out['DB']['ComboardMessage'][0]['ComboardMessageID'])) { ?>
		<input type="hidden" name="ComboardMessageID" value="<?=input('ComboardMessageID')?>" />
		<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageReceiverID" value="<?=$out['DB']['ComboardMessage'][0]['UserID']?>" />
		<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageReceiverNickName" value="<?=$out['DB']['ComboardMessage'][0]['ComboardMessageSenderNickName']?>" />
		<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageReceiverGroup" value="admin" />
		
		<? } else {?>
		<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageReceiverGroup" value="admin" />
		<? } ?>
		<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageStatus" value="new" />
		<input type="hidden" name="ComboardMessageAddedID" value="<?=$out['att']['ComboardMessageAddedID']?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">
				<br/>
				<?=lang('ComboardMessage.ComboardMessageSubject')?><br/>
				<? if(input('ComboardMessage'.DTR.'ComboardMessageSubject')) {$subject=input('ComboardMessage'.DTR.'ComboardMessageSubject');} elseif(!empty($out['DB']['ComboardMessage'][0]['ComboardMessageSubject'])) {$subject='Re: '.$out['DB']['ComboardMessage'][0]['ComboardMessageSubject'];} ?>
				<input type="text" name="ComboardMessage<?=DTR?>ComboardMessageSubject" value="<?=$subject?>" size="30">
				<br/>
				<?=lang('ComboardMessage.ComboardMessageText')?><br/>
				<textarea name="ComboardMessage<?=DTR?>ComboardMessageText" cols="25" rows="10"><?=input('ComboardMessage'.DTR.'ComboardMessageText')?></textarea>
				<hr>
				
				<? if(is_array($out['attachments'])){ ?>
				
					<?=lang('ComboardMessage.ComboardMessageAttachments')?>:<br>
					<?
					$actionModeBase='updateNew';
					foreach($out['attachments'] as $k=>$v)
					{
						$temp=explode("/",$v['ComboardMessageFile']); echo "<div align=left>&nbsp;&nbsp;-&nbsp;".end($temp)."</div>";
					}
					?>
				<? } ?>
				<?=lang('ComboardMessage.ComboardMessageAttachment')?>:
				<input size="20" type="file" name="uploadFile[ComboardMessageAttachment]" />
				<input type="hidden" name="oldUploadFile[ComboardMessageAttachment]" value="<?=$out['DB']['ComboardMessage'][0]['ComboardMessageAttachment']?>" />
				<input type="button" value="<?=lang('ComboardMessage.AttachText')?>" onClick="sendComboardMessage.actionMode.value='<?=$actionModeField?>';sendComboardMessage.ComboardMessage<?=DTR?>ComboardMessageStatus.value='draft';sendComboardMessage.submit();"/>

				<br/>
				<hr>
				<input type="checkbox" name="sendEmail" value=""/>&nbsp;<?=lang('SendComboardMessageToEcomboard.comboard.tip')?>
				<hr>
				<? if(!empty($out['DB']['ComboardMessage'][0]['UserID'])) {$toAuthor = $out['DB']['ComboardMessage'][0]['ComboardMessageSenderNickName'];} else {$toAuthor = lang('SendToAdministrators.comboard.tip');} ?>
				<input type="button" value="<?=lang("-sendto").' '.$toAuthor?> " onClick="sendComboardMessage.actionMode.value='<?=$actionModeBase?>';sendComboardMessage.submit();">
				<br/>
			</td> 
		</tr> 
	</form>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('ComboardMessagesHistoryTitle.comboard.tip')?></b>
			</td> 
		</tr>	
	<? if(!empty($out['DB']['ComboardMessages'][0]['ComboardMessageID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">		
				<? foreach($out['DB']['ComboardMessages'] as $row) {?>
					<b><?=$row['ComboardMessageSubject']?></b>
					<br/>
					<?=getFormated($row['ComboardMessageText'],'TEXT')?>
					<br/>
					<?
						if(empty($row['ComboardMessageReceiverNickName'])) {$receiverName=$row['ComboardMessageReceiverGroup'];} else {$receiverName=$row['ComboardMessageReceiverNickName'];}
					?>
					<i><?=lang('ComboardMessageSentOn.comboard.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('ComboardMessageSentBy.comboard.tip')?> <?=$row['ComboardMessageSenderNickName']?> <?=lang('ComboardMessageSentTo.comboard.tip')?> <?=$receiverName?></i>
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
				<?=lang('NoComboardMessageFound.comboard.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>