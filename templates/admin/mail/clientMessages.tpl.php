<form method="post">
<input type="hidden" name="SID" value="<?=input('SID')?>" />
<input type="hidden" name="ReceiverID" value="<?=input('ReceiverID')?>" />
<input type="hidden" name="PropertyOrderID" value="<?=input('PropertyOrderID')?>" />

<? if(input('ReceiverID')) { ?>
<?=boxHeader(array('title'=>'viewClientMessages.mail.title'))?>
<? } else { ?>
<?=boxHeader(array('title'=>'viewNewMessages.mail.title'))?>
<? }
if(input('ReceiverID')) {
 ?>
		<? /*tr> 
			<td class='subtitleline' align=center>
				<?				
					$options[0]['id'] = '';
					$options[0]['value'] = lang('SelectMessageStatus.mail.option');
					echo getReference('Message.MessageStatus','MessageStatus',$input['MessageStatus'],array('code'=>'Y','type'=>'dropdown','isEmptyValue'=>'Y','skipEmpty'=>'Y','options'=>$options,'action'=>'submit();'))
				?>

<?				//echo getReference('Mail.OrderNewMessages','OrderNewMessages',$input['OrderNewMessages'],array('code'=>'Y','type'=>'dropdown','isEmptyValue'=>'Y','skipEmpty'=>'Y','action'=>'submit();'))
?>

				<br/>
				<input name='searchWordMessage' type="text" size="20" value="<?=input('searchWordMessage')?>">
				<input type=submit value="<?=lang('-search')?>">
			</td> 
		</tr > 		
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('ClientMessagesHistoryTitle.mail.tip')?></b>
			</td> 
		</tr */?>
<? } ?>		
	<? if(!empty($out['DB']['ClientMessages'][0]['MessageID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">	
				<? foreach($out['DB']['ClientMessages'] as $row) { if($row['UserID']!='tttt') { ?>
					<?
						$orderLink = '';
						if(!empty($row['OrderID'])) {$orderLink = "PropertyOrderID/".$row['OrderID']."/";}
					?>
					<?
						if(!input('ReceiverID')) {$receiverID = $row['UserID'];}
						else {$receiverID = input('ReceiverID');}
					?>
					
					<a href="<?=setting('url')?><?=input('SID')?>/MessageID/<?=$row['MessageID']?>/ReceiverID/<?=$receiverID?>/<?=$orderLink?>"><b><?=$row['MessageSubject']?></b></a>
					<? // getFormated($row['MessageText'],'TEXT')?>
					<br/>
					<i><!-- <a href="<?=setting('url')?>mailboxadm/MessageID/<?=$row['MessageID']?>/ReceiverID/<?=$receiverID?>/<?=$orderLink?>"> --><?=lang('MessageSentOn.mail.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <? if($row['UserID']!='1' || !empty($row['MessageSenderNickName'])){?><?=lang('MessageSentBy.mail.tip')?><? }?> <? if(!empty($row['FirstName']) || !empty($row['LastName'])){?><?=$row['FirstName']?> <?=$row['LastName']?><? }elseif(!empty($row['CompanyName'])){?><?=$row['CompanyName']?><? }elseif(!empty($row['UserName']) && $row['UserID']!='1'){?><?=$row['UserName']?><? }else{?><?=$row['MessageSenderNickName']?><? }?><!-- </a> --></i>
					<br/>
				<? }  } ?>
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