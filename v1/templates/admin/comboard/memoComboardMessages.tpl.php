<table cellpadding="0" cellspacing="0">
<form name="getComboard" method="post"> 
	<input type="hidden" name="SID" value="<?=input('SID')?>" /> 
	<tr> 
		<td>
			<input type="button" name="goComboardHome" value="<?=lang('goComboardHome.comboard.tip')?>" onClick="location.replace('<?=setting('url')?>comboard');"/> 
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
<?=boxHeader(array('title'=>'ManageComboardMessages.comboard.title','tabs'=>'manageComboardMessage','tabslink'=>'' ))?> 
<tr> 
  <td valign="top" bgcolor="#ffffff" class="subtitle" align="center"> <?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?> </td> 
</tr> 
<form name="sendComboardMessage" method="post"> 
  <input type="hidden" name="SID" value="<?=input('SID')?>" /> 
  <input type="hidden" name="actionMode" value="save" /> 
  <input type="hidden" name="tabLink" value="<?=input('tabLink')?>" /> 
  <input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageID" value="<?=$out['DB']['ComboardMessage'][0]['ComboardMessageID']?>" /> 
  <input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageType" value="memo" /> 
  <input type=hidden name='ComboardMessage<?=DTR?>ComboardMessageStartTime' value="<?=getFormated('','date')?>"> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <?=lang('ComboardMessage.ComboardMessageContent')?> 
      <br/> 
      <textarea name="ComboardMessage<?=DTR?>ComboardMessageContent" cols="70" rows="10"><?=$out['DB']['ComboardMessage'][0]['ComboardMessageContent']?>
</textarea> </td> 
  </tr> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <?if($out['DB']['ComboardMessage'][0]['ComboardMessageID']){?> 
      <input type="submit" value="<?=lang("-send")?>"> 
      <input type="button" onclick='document.forms.sendComboardMessage.actionMode.value="delete";document.forms.sendComboardMessage.submit();' value="<?=lang("-delete")?>"> 
      <?}else{?> 
      <input type="submit" value="<?=lang("-save")?>"> 
      <?}?> </td> 
  </tr> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <?				echo getComboardMessagesLib($out['DB']['MemoComboardMessages']);
?> </td> 
  </tr> 
</form>
<?=boxFooter()?>
