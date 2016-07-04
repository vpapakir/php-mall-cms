<table width=100% border=0>
<tr><td colspan=3>
<input type="button" value="<?=lang('AdminMailHome.loan.button')?>" onClick="location.replace('<?=setting('url')?>mailboxadm');">
<?	$options[0]['id'] = '';
	$options[0]['value'] = lang('PropertyNavigation.property.tip');
	echo getReference('Property.Navigation','PropertyNavigation',$input['PropertyNavigation'],array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'location.replace(\''.setting('url').'\'+this.value);'))
?>
</td></tr>
<tr>
<?if ($input['windowParent'] != 1) {?>
    <td width=33% valign=top><? getBox('mail.viewClients');?></td>
<?}?>
<?if ($input['windowParent'] == 1) {?>
    <td width=50% valign=top>
<?} else {?>
    <td width=33% valign=top>
<?}?>
<? //		getBox('mail.manageClientMessages');
	if(input('ReceiverID')){
		getBox('session.viewUserInfo3Cols');
		setInput('CreatorID',input('ReceiverID'));
		setInput('CreatorCode','customer');
		getBox('core.viewNotes');
		getBox('property.getSearchProfiles3Cols');
		getBox('mail.clientMessages');
		getBox('property.manageOrders3c');
	}
	elseif(input('MailBoxID'))
	{
		getBox('mail.clientMessages');
		getBox('property.manageOrders3c');
	}
	else{
		//getBox('mail.newMessages');
		setInput('MessageStatus','new');
		getBox('mail.clientMessages');
	}
?>
</td>
<?if ($input['windowParent'] == 1) {?>
    <td width=50% valign=top>
<?} else {?>
    <td width=33% valign=top>
<?}?>
    <?if(input('MessageID') or input('ReceiverID')){
		
		if(input('PropertyOrderID'))
		{
			getBox('property.manageOrder');
		}
		getBox('mail.newMessage');
	}else{
		//getBox('mail.viewLastMessages');
		setInput('PropertyOrderStatus','new');
		getBox('property.manageOrders3c');	
	}
?></td>
</tr></table>
