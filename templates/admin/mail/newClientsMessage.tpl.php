<?=boxHeader(array('title'=>lang('UserMailbox.mail.title')))?>
	<tr> 
		<td valign="middle" class="subtitleline" align="center">
			<b><?=lang('NewMessageTitle.mail.tip')?></b>
		</td> 
	</tr>
	<tr><td>&nbsp;</td></tr>
	<form name="sendMessage" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="sendclients" />
		
		<input type="hidden" name="OrderClients" value="<?=input('OrderClients')?>" />
		<input type="hidden" name="SearchClients" value="<?=input('SearchClients')?>" />
		<input type="hidden" name="UserLanguage" value="<?=input('UserLanguage')?>" />
		<input type="hidden" name="Managers" value="<?=input('Managers')?>" />
		<input type="hidden" name="ClientMode" value="<?=input('ClientMode')?>" />
		<input type="hidden" name="UserStatus" value="<?=input('UserStatus')?>" />
		
		<? if(!empty($out['DB']['Message'][0]['MessageID'])){?>
			<input type="hidden" name="MessageID" value="<?=input('MessageID')?>" />
			<input type="hidden" name="Message<?=DTR?>MessageReceiverID" value="<?=$out['DB']['Message'][0]['UserID']?>" />
			<input type="hidden" name="Message<?=DTR?>MessageReceiverNickName" value="<?=$out['DB']['Message'][0]['MessageSenderNickName']?>" />
			<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
		<? }elseif(!empty($out['DB']['User'][0]['UserID'])){?>
			<input type="hidden" name="Message<?=DTR?>MessageReceiverID" value="<?=$out['DB']['User'][0]['UserID']?>" />
			<input type="hidden" name="Message<?=DTR?>MessageReceiverNickName" value="<?=$out['DB']['User'][0]['UserName']?>" />
			<input type="hidden" name="Message<?=DTR?>MessageSenderGroup" value="<?=user('GroupID')?>" />
			<input type="hidden" name="Message<?=DTR?>MessageSenderNickName" value="<?=user('FirstName')?> <?=user('LastName')?>" />
			<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
		<? }else{?>
			<input type="hidden" name="Message<?=DTR?>MessageReceiverGroup" value="admin" />
			<input type="hidden" name="Message<?=DTR?>MessageSenderGroup" value="<?=user('GroupID')?>" />
			<input type="hidden" name="Message<?=DTR?>MessageSenderNickName" value="<?=user('FirstName')?> <?=user('LastName')?>" />
			<? //print_r($input);?>
			<? 
				foreach($out['DB']['Users'] as $id=>$value){?>
					<input type="hidden" name="SendMessageUserID[<?=$value['UserID']?>]" value="<?=$value['UserID']?>"/>
					<input type="hidden" name="Message<?=DTR?>MessageReceiverID[<?=$value['UserID']?>]" value="<?=$value['UserID']?>" />
					<input type="hidden" name="Message<?=DTR?>MessageReceiverNickName[<?=$value['UserID']?>]" value="<?=$value['UserName']?>" />
				<? }
			?>
		<? }?>
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
					<tr>
						<td align="left" class="subtitle" valign="top">
							<?=lang('Message.MessageSubject')?>: 
						</td>
						<? $subject = lang('NewMessageSubject.mail.tip');?>
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
					<tr>
						<td align="center" valign="top" class="subtitle" colspan="2">
						<hr size="1">
						<input type="checkbox" name="sendEmail" value=""/>&nbsp;<?=lang('SendMessageToEmail.mail.tip')?>
						</td>
					</tr>
					<!-- <tr>
						<td align="center" valign="top" class="subtitle" colspan="2">
						<hr size="1">
						<input type="checkbox" name="notSendEmail" value="Y"/>&nbsp;<?=lang('notSendMessage.mail.tip')?>
						</td>
					</tr> -->
					<tr>
						<td align="center" valign="top" colspan="2">
						<hr size="1">
						<br>
						<input type="button" value="<?=lang('SendToSelectedCustomers.mail.tip')?> " onClick="sendMessage.submit();">
						</td>
					</tr>
				</table>
			</td> 
		</tr> 
	</form>	
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			<? 
				foreach($out['DB']['Users'] as $id=>$value){?>
					<?=$value['UserName']?><br/>
			<? }?>	
		</td>
	</tr>
<?=boxFooter()?>