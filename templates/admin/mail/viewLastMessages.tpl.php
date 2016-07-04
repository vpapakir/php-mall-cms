<form method=post>
<?=boxHeader(array('title'=>lang('LastMessages.mail.title')))?>
		<tr> 
			<td class='subtitleline' align=center>
<?				echo getReference('Mail.OrderLastSent','OrderLastSent',$input['OrderLastSent'],array('code'=>'Y','type'=>'dropdown','isEmptyValue'=>'Y','skipEmpty'=>'Y','action'=>'submit();'))
?>
<!--				<input name='searchWord' type=text size=10 value="<?=input('searchWord')?>">
				<input type=submit value="<?=lang('-search')?>">
-->			</td> 
		</tr> 
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('LastSentMessagesHistoryTitle.mail.tip')?></b>
			</td> 
		</tr>
	<? if(!empty($out['DB']['LastMessages'][0]['UserID'])) {?>
		<tr> 
			<td valign="top">
				<? foreach($out['DB']['LastMessages'] as $row) {?>
					<a href="<?=setting('url')?><?=input('SID')?>/MessageID/<?=$row['MessageID']?>"><b><?=$row['MessageSubject']?></b></a><br>
					<? //getFormated($row['MessageText'],'TEXT')?>
					<i><?=lang('MessageSentOn.mail.tip')?> <?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('MessageSentBy.mail.tip')?> <?=$row['MessageSenderNickName']?></i>
					<hr size="1"/>

				<? } ?>
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['Resources'][0]['ResourceID']))
		else{

	?>
		<tr> 
			<td valign="top" class="subtitleline" align="center">
				<?=lang('NoMessagesFound.mail.tip')?>
			</td> 
		</tr>
	<? } ?>	
<?=boxFooter()?>
</form>