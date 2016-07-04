<?
if(input('actionMode')=='replayed')
{
	goLink(setting('url').'mailboxadm/');
}

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

	<? if(!empty($out['DB']['Messages'][0]['MessageID'])) {?>
		<tr><td>&nbsp;</td></tr>
		<tr> 
			<td valign="middle" class="subtitleline" align="center">
				<b><?=lang('LastMessageTitle.mail.tip')?></b>
			</td> 
		</tr>	
		<tr> 
			<td valign="top">		
					<b><?=$out['DB']['Messages'][0]['MessageSubject']?></b>
					<br/>
					<?=getFormated($out['DB']['Messages'][0]['MessageText'],'TEXT')?>
					<br/>
					<?
						if(empty($out['DB']['Messages'][0]['MessageReceiverNickName'])) {
							$receiverName=$out['DB']['Messages'][0]['MessageReceiverGroup'];
						} else {
							$receiverName=$out['DB']['Messages'][0]['MessageReceiverNickName'];
						}
					?>
					<i><?=lang('MessageSentOn.mail.tip')?> <?=getFormated($out['DB']['Messages'][0]['TimeCreated'],'DateTime')?> <?=lang('MessageSentBy.mail.tip')?> <?=$out['DB']['Messages'][0]['MessageSenderNickName']?> <?=lang('MessageSentTo.mail.tip')?> <?=$receiverName?></i>
			</td> 
		</tr>
		<tr><td align="center"><input type="button" value="<?=lang('Print.mail.button')?>" onClick="popup('<?=setting('url')?>viewLastMessage/MessageID/<?=input('MessageID')?>/ReceiverID/<?=input('ReceiverID')?>/windowMode/print')"/></td></tr> 
		<tr><td>&nbsp;</td></tr>
	<? } ?>		

		<tr> 
			<td valign="middle" class="subtitleline" align="center">
				<b><?=lang('NewMessageTitle.mail.tip')?></b>
			</td> 
		</tr>	
		<tr><td>&nbsp;</td></tr>
	<form name="sendMessage" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="send" />
		<input type="hidden" name="ReceiverID" value="<?=input('ReceiverID')?>" />
		<input type="hidden" name="MailBoxID" value="<?=input('MailBoxID')?>" />
		
		<? if(!empty($out['DB']['Message'][0]['MessageID'])) { ?>
		<input type="hidden" name="MessageID" value="<?=input('MessageID')?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverID" value="<?=$out['DB']['Message'][0]['UserID']?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverNickName" value="<?=$out['DB']['Message'][0]['MessageSenderNickName']?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
		<? } elseif(!empty($out['DB']['User'][0]['UserID'])) { ?>
		<input type="hidden" name="Message<?=DTR?>MessageReceiverID" value="<?=$out['DB']['User'][0]['UserID']?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverNickName" value="<?=$out['DB']['User'][0]['UserName']?>" />
		<input type="hidden" name="Message<?=DTR?>MessageSenderGroup" value="<?=user('GroupID')?>" />
		<input type="hidden" name="Message<?=DTR?>MessageSenderNickName" value="<?=user('FirstName')?> <?=user('LastName')?>" />
		<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
		<? } else {?>
		<?  if(input('ReceiverID')) { ?>
			<input type="hidden" name="Message<?=DTR?>MessageReceiverID" value="<?=input('ReceiverID')?>" />
		<? } ?>
		<?  if(input('MailBoxID')) { ?>
			<input type="hidden" name="Message<?=DTR?>MessageReceiverID" value="<?=input('MailBoxID')?>" />
		<? } ?>
		
		<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
		<? } ?>
		<input type="hidden" name="Message<?=DTR?>MessageStatus" value="new" />
		<input type="hidden" name="MessageAddedID" value="<?=$out['att']['MessageAddedID']?>" />
		<? if(input('PropertyOrderID')) { ?>
			<input type="hidden" name="PropertyOrderID" value="<?=input('PropertyOrderID')?>" />
			<input type="hidden" name="Message<?=DTR?>OrderID" value="<?=input('PropertyOrderID')?>" />
		<? } else { ?>
			<input type="hidden" name="Message<?=DTR?>OrderID" value="<?=input('OrderID')?>" />
			<input type="hidden" name="OrderID" value="<?=input('OrderID')?>" />
		<? } ?>
		<?=$params['fields'];?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<? if(!empty($out['DB']['Message'][0]['MessageSubject'])) { ?>
			<tr>
				<td colspan="2">
					<b><?=lang('ReplyToMessage.mail.tip')?>:</b> 
					<hr size="1"/>
					<b><?=$out['DB']['Message'][0]['MessageSubject']?></b>
					<hr size="1"/>
					<?=getFormated($out['DB']['Message'][0]['MessageText'],'TEXT')?>
					<hr size="1"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="button" name="replayed" value="<?=lang('setReplayed.mail.tip')?>" onClick="document.sendMessage.actionMode.value='replayed';submit();"/>
					<hr size="1"/>
				</td>
			</tr>
			<? } ?>						
			<tr>
				<td align="left" class="subtitle" valign="top">
					<?=lang('Message.MessageSubject')?>: 
				</td>
				<? 
					if(input('Message'.DTR.'MessageSubject')){
						$subject=input('Message'.DTR.'MessageSubject');
					}elseif(!empty($out['DB']['Message'][0]['MessageSubject'])){
						$subject='Re: '.$out['DB']['Message'][0]['MessageSubject'];
					}else{
						$subject = lang('NewMessageSubject.mail.tip');
					}
				?>
				<td align="left" valign="top">
		
				<input type="text" name="Message<?=DTR?>MessageSubject" value="<?=$subject?>" size="30">
				</td>
			</tr>
			<tr>
				<td align="left" class="subtitle" valign="top">
				<?=lang('Message.MessageText')?>: 
				</td>
				<td align="left" valign="top">
				<textarea name="Message<?=DTR?>MessageText" cols="20" rows="10"><?=input('Message'.DTR.'MessageText')?></textarea>
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
							$temp=explode("/",$v['MessageFile']); ?>
								<div align=left>&nbsp;&nbsp;-&nbsp;
									<a href="<?=setting('urlfiles').$v['MessageFile']?>"><?=end($temp)?></a>
								</div>
					<? }?>
				</td>
			</tr>
				<? } ?>
			<tr>
				<td align="left" valign="top" class="subtitle">
				<?=lang('Message.MessageAttachment')?>:
				</td>
				<td align="left" valign="top">
				<input size="20" type="file" name="uploadFile[MessageAttachment]" class="input"/>
				<input type="hidden" name="oldUploadFile[MessageAttachment]" value="<?=$out['DB']['Message'][0]['MessageAttachment']?>" />
				<input type="button" value="<?=lang('AttachText.mail.button')?>" onClick="sendMessage.actionMode.value='<?=$actionModeField?>';sendMessage.submit();"/>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="subtitle" colspan="2">
				<hr size="1">
				<input type="checkbox" name="sendEmail" value=""/>&nbsp;<?=lang('SendMessageToEmail.mail.tip')?>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" class="subtitle" colspan="2">
				<hr size="1">
				<input type="checkbox" name="notSendEmail" value="Y"/>&nbsp;<?=lang('notSendMessage.mail.tip')?>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" colspan="2">
				<hr size="1">
				<br>
				<? if(!empty($out['DB']['Message'][0]['UserID'])) {$toAuthor = $out['DB']['Message'][0]['MessageSenderNickName'];} elseif(!empty($out['DB']['User'][0]['UserID'])) {$toAuthor = $out['DB']['User'][0]['UserName'];} else {$toAuthor = lang('SendToAdministrators.mail.tip');} ?>
				<input type="button" value="<?=lang("-sendto").' '.$toAuthor?> " onClick="sendMessage.actionMode.value='<?=$actionModeBase?>';sendMessage.submit();">
				</td>
			</tr>
			</table>
			</td> 
		</tr> 
	<? if(!empty($out['DB']['Messages'][1]['MessageID'])) {?>
		<tr><td>&nbsp;</td></tr>
		<tr> 
			<td valign="middle" class="subtitleline" align="center">
				<b><?=lang('MessagesHistoryTitle.mail.tip')?></b>
			</td> 
		</tr>	
		<tr> 
			<td valign="top">		
				<? foreach($out['DB']['Messages'] as $key=>$row) 
					if($key!=0){?>
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
	<? } ?>		
	</form>	
<?=boxFooter()?>