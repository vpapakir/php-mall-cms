<?=boxHeader(array('title'=>'ManageReservationOrders.reservation.title','tabs'=>'manageReservationOrders'))?>
<tr><td>
<table width=100% border=0>
<tr>
<td width=33% valign=top><? getBox('mail.viewClients');?></td>
<td width=33% valign=top>
<? //		getBox('mail.manageClientMessages');
	if(input('ReceiverID')){
		getBox('session.viewUserInfo3Cols');
		setInput('CreatorID',input('ReceiverID'));
		setInput('CreatorCode','customer');
		getBox('core.viewNotes');
		getBox('mail.clientMessages');
	}
	elseif(input('MailBoxID'))
	{
		getBox('mail.clientMessages');
	}
	else{
		//getBox('mail.newMessages');
		setInput('MessageStatus','new');
		getBox('mail.clientMessages');
	}
?>
</td>
<td width=33% valign=top><?
	if(input('MessageID') or input('ReceiverID')){
		getBox('mail.newMessage');
	}else{
	}
?></td>
</tr></table>
</td></tr>
<?=boxFooter()?>
