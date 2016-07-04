<?
//print_r($out['DB']['NewMessagesAtt']);
$actionModeBase='send';
if(!empty($out['att']['MessageAddedID']))
{
	$actionModeField='attach2';
}
else
{
	$actionModeField='attach';
}
//echo "Template: ".$actionModeField." MessID: ".$out['att']['MessageAddedID']."<br>";
?>
<?=boxHeader(array('title'=>lang('UserMailbox.mail.title')))?>
		<tr> 
			<td valign="top" class="subtitleline" align="center">
				<b><?=lang('NewMessagesHistoryTitle.mail.tip')?></b>
			</td> 
		</tr>
	<? if(!empty($out['DB']['NewMessages'][0]['MessageID'])) {?>
		<tr> 
			<td valign="top">
				<? foreach($out['DB']['NewMessages'] as $row) {?>
					<?
						if(!empty($row['OrderID'])) {$link = '/OrderID/'.$row['OrderID'].'/';} 
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/MessageID/<?=$row['MessageID'].$link?>"><b><?=$row['MessageSubject']?></b></a>
					<br/>
					<?=getFormated($row['MessageText'],'TEXT')?>
					<br/>
					<i><?=lang('MessageSentOn.mail.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('MessageSentBy.mail.tip')?> <?=$row['MessageSenderNickName']?></i>
					<br/>
					<?

					if(is_array($out['DB']['NewMessagesAtt']))
					{
					foreach($out['DB']['NewMessagesAtt'] as $key=>$val)
					{
						if($row['MessageID']==$val['MessageID'])
						{
							$temp=explode("/",$val['MessageFile']); echo "<div align=left>&nbsp;&nbsp;-&nbsp;<a href='".setting('urlfiles').$val['MessageFile']."' target='_blank'>".end($temp)."</a></div>";
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
			<td valign="top" class="subtitleline" align="center">
				<?=lang('NoNewMessageFound.mail.tip')?>
			</td> 
		</tr>
	<? } ?>	
	<tr><td>&nbsp;fffffffffffffffffffff</td></tr>
	<form name="sendMessage" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="send" />
		<? if(!empty($out['DB']['Message'][0]['MessageID'])) { ?>
		<input type="hidden" name="MessageID" value="<?=input('MessageID')?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverID" value="<?=$out['DB']['Message'][0]['UserID']?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverNickName" value="<?=$out['DB']['Message'][0]['MessageSenderNickName']?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
		<? } elseif(!empty($out['DB']['User'][0]['UserID'])) { ?>
		<input type="text" name="Message<?=DTR?>MessageReceiverID" value="<?=$out['DB']['User'][0]['UserID']?>" />
		<input type="text" name="Message<?=DTR?>MessageReceiverNickName" value="<?=$out['DB']['User'][0]['UserName']?>" />
		<input type="text" name="Message<?=DTR?>MessageReceiverGroup" value="user" />
		<input type="text" name="Message<?=DTR?>MessageSenderGroup" value="admin" />
		<? } else {?>
		<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
		<? } ?>
		<input type="hidden" name="Message<?=DTR?>MessageStatus" value="new" />
		<input type="hidden" name="MessageAddedID" value="<?=$out['att']['MessageAddedID']?>" />
		<input type="hidden" name="Message<?=DTR?>OrderID" value="<?=input('OrderID')?>" />
		<input type="hidden" name="OrderID" value="<?=input('OrderID')?>" />
		<?=$params['fields'];?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<tr>
				<td align="left" class="subtitle" valign="top">
					<?=lang('Message.MessageSubject')?>: 
				</td>
				<? if(input('Message'.DTR.'MessageSubject')) {$subject=input('Message'.DTR.'MessageSubject');} elseif(!empty($out['DB']['Message'][0]['MessageSubject'])) {$subject='Re: '.$out['DB']['Message'][0]['MessageSubject']; $subject = str_replace("Re: Re:","Re: ",$subject);} ?>
				<td align="left" valign="top">
				<? if(!empty($out['DB']['Message'][0]['MessageSubject'])) { ?>
					<?=lang('ReplyToMessage.mail.tip')?>: <?=$out['DB']['Message'][0]['MessageSubject']?>
					<hr size="1"/>
					<?=getFormated($out['DB']['Message'][0]['MessageText'],'TEXT')?>
					<hr size="1"/>
				<? } ?>
				<input type="text" name="Message<?=DTR?>MessageSubject" value="<?=$subject?>" size="50">
				</td>
			</tr>
			<tr>
				<td align="left" class="subtitle" valign="top">
				<?=lang('Message.MessageText')?>: 
				</td>
				<td align="left" valign="top">
				<textarea name="Message<?=DTR?>MessageText" cols="47" rows="10"><?=input('Message'.DTR.'MessageText')?></textarea>
				</td>
			</tr>
				
				<? if(is_array($out['attachments'])){ ?>
			<tr>
				<td align="left" valign="top" class="subtitle">
					<?=lang('Message.MessageAttachments')?>: 
				</td>
				<td align="left" valign="top">
					<?
					$actionModeBase='updateNew';
					foreach($out['attachments'] as $k=>$v)
					{
						$temp=explode("/",$v['MessageFile']); echo "<div align=left>&nbsp;&nbsp;-&nbsp;".end($temp)."</div>";
					}
					?>
				</td>
			</tr>
				<? } ?>
			<tr>
				<td align="left" valign="top" class="subtitle">
				<?=lang('Message.MessageAttachment')?>:
				</td>
				<td align="left" valign="top">
				<input size="49" type="file" name="uploadFile[MessageAttachment]" class="input"/>
				<input type="hidden" name="oldUploadFile[MessageAttachment]" value="<?=$out['DB']['Message'][0]['MessageAttachment']?>" />
				<input type="button" value="<?=lang('AttachText.mail.button')?>" onClick="sendMessage.actionMode.value='<?=$actionModeField?>';sendMessage.Message<?=DTR?>MessageStatus.value='draft';sendMessage.submit();"/>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="subtitle" colspan="2">
				<hr size="1">
				<input type="checkbox" name="sendEmail" value=""/>&nbsp;<?=lang('SendMessageToEmail.mail.tip')?>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" colspan="2">
				<hr size="1">
				<br>
				<? if(!empty($out['DB']['Message'][0]['UserID'])) {$toAuthor = $out['DB']['Message'][0]['MessageSenderNickName'];} elseif(!empty($out['DB']['User'][0]['UserID'])) {$toAuthor = $out['DB']['User'][0]['UserName'];} else {$toAuthor = lang('SendToAdministrators.mail.tip');} ?>
				<input type="button" value="<?=lang("-sendto").' '.$toAuthor?> " onClick="sendMessage.actionMode.value='<?=$actionModeBase?>';sendMessage.submit();">
				dddddddddddddddd</td>
			</tr>
			</table>
			</td> 
		</tr> 
	</form>	
	<tr><td>&nbsp;</td></tr>
		<tr> 
			<td valign="top" class="subtitleline" align="center">
				<b><?=lang('MessagesHistoryTitle.mail.tip')?></b>
			</td> 
		</tr>	
	<? if(!empty($out['DB']['Messages'][0]['MessageID'])) {?>
		<tr> 
			<td valign="top">		
				<? foreach($out['DB']['Messages'] as $row) {?>
					<b><?=$row['MessageSubject']?></b>
					<br/>
					<?=getFormated($row['MessageText'],'TEXT')?>
					<br/>
					<?
						if(empty($row['MessageReceiverNickName'])) {$receiverName=$row['MessageReceiverGroup'];} else {$receiverName=$row['MessageReceiverNickName'];}
					?>
					<i><?=lang('MessageSentOn.mail.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('MessageSentBy.mail.tip')?> <?=$row['MessageSenderNickName']?> <?=lang('MessageSentTo.mail.tip')?> <?=$receiverName?></i>
					<hr size="1"/>
				<? } ?>				
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['Resources'][0]['ResourceID']))
		else{
	?>
		<tr> 
			<td valign="top" class="subtitleline" align="center">
				<br/>
				<?=lang('NoMessageFound.mail.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>