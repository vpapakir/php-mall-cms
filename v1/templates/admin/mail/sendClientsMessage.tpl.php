<table width="100%" border="0">
	<tr>
		<td colspan="3">
			<input type="button" value="<?=lang('AdminMailHome.loan.button')?>" onClick="location.replace('<?=setting('url')?>mailboxadm');">
			<?	$options[0]['id'] = '';
				$options[0]['value'] = lang('PropertyNavigation.property.tip');
				echo getReference('Property.Navigation','PropertyNavigation',$input['PropertyNavigation'],array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'location.replace(\''.setting('url').'\'+this.value);'))
			?>
		</td>
	</tr>
	<tr>
		<td width="33%" valign="top"><? getBox('mail.viewClients');?></td>
		<td width="33%" valign="top"><? getBox('mail.newClientsMessage');?></td>
		<td width="33%" valign="top">
			<?
				setInput('PropertyOrderStatus','new');
				getBox('property.manageOrders3c');	
			?>
		</td>
	</tr>
</table>
