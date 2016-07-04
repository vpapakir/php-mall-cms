<? //boxHeader(array('title'=>'ManageComboardMessages.comboard.title'))?>
	<form name="sendComboardMessage" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="send" />
		<? print_r($input); ?>
		<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageReceiverNickName" value="<?=input('name')?>" />
		<input type="hidden" name="name" value="<?=input('name')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">
					<br/>
					<?=lang('ComboardMessage.ComboardMessageSubject')?><br/>
					<input type="text" name="ComboardMessage<?=DTR?>ComboardMessageSubject" value="<?=$out['DB']['ComboardMessage'][0]['ComboardMessageSubject'];?>" size="50">
					<br/>
					<?=lang('ComboardMessage.ComboardMessageText')?><br/>
					<textarea name="Currency<?=DTR?>ComboardMessageText" cols="70" rows="10"><?=$out['DB']['ComboardMessage'][0]['ComboardMessageText']?></textarea>
					<br/>
					<input type="checkbox" name="sendEmail" value=""/>&nbsp;<?=lang('SendComboardMessageToEcomboard.comboard.tip')?>
					<br/><br/>
					<input type="submit" value="<?=lang("-sendto")?>">				
					<br/>
			</td> 
		</tr> 
	</form>	

	<? if(!empty($out['DB']['Resources'][0]['ResourceID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">			
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
<? //boxFooter()?>