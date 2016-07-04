<?=boxHeader(array('title'=>lang('LastMessage.mail.title')))?>
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
		<tr><td>&nbsp;</td></tr>
<?=boxFooter()?>