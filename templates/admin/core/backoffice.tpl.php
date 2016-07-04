<table cellpadding="0" cellspacing="0">
<form name="getComboard" method="post"> 
	<input type="hidden" name="SID" value="<?=input('SID')?>" /> 
	<input type="hidden" name="viewMode" value="<?=input('viewMode')?>" /> 
	<tr> 
		<td>
			<input type="button" name="goComboardHome" value="<?=lang('goComboardHome.comboard.tip')?>" onClick="location.replace('<?=setting('url')?>comboard2');"/> 
		</td> 
		<td>
			<?	
				$options[0]['id'] = '';
				$options[0]['value'] = lang('PropertyNavigation.property.tip');
				echo getReference('Property.Navigation','PropertyNavigation',$input['PropertyNavigation'],array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'location.replace(\''.setting('url').'\'+this.value);'))
			?> 
		</td> 
	</tr> 
</form>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="5"> 
	<tr> 
		<td width=33% valign="top"><? 
		setInput('filterMode','new');
		getBox('comboard.viewComboardMessages1',array('params'=>array('resultType'=>'nomessages'))); ?>
		</td> 
		<td width=33% valign="top">
		<?
			setInput('MessageStatus','new');
			getBox('mail.clientMessages');
		?>
		</td> 
		<td width=33% valign="top"><? 
			setInput('filterMode','new');
			getBox('comboard.viewComboardMessages1',array('params'=>array('resultType'=>'messagesonly')));?> 
		</td> 
	</tr> 
</table>
