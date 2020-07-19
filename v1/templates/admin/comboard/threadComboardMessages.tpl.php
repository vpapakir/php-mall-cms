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
  <!--		<input type="hidden" name="tabLink" value="<?=input('tabLink')?>" />--> 
  <input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageParentID" value="<?=input('MessageID')?>" /> 
  <input type="hidden" name="MessageID" value="<?=input('MessageID')?>" /> 
  <input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageType" value="message" /> 
  <input type=hidden name='ComboardMessage<?=DTR?>ComboardMessageStartTime' value="<?=getFormated('','date')?>"> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <br/> 
      <?=lang('ComboardMessage.ComboardMessageTitle')?> 
      <br/> 
      <input type="text" name="ComboardMessage<?=DTR?>ComboardMessageTitle" value="<?=$out['DB']['ComboardMessage'][0]['ComboardMessageTitle'];?>" size="50"> </td> 
  </tr> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <?=lang('ComboardMessage.ComboardMessageContent')?> 
      <br/> 
      <textarea name="ComboardMessage<?=DTR?>ComboardMessageContent" cols="70" rows="10"><?=$out['DB']['ComboardMessage'][0]['ComboardMessageContent']?>
</textarea> </td> 
  </tr> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <input type="submit" value="<?=lang("-send")?>"> </td> 
  </tr> 
  <tr> 
    <td><table> 
        <tr> 
          <?
		echo '<input type=hidden name=ComboardMessage'.DTR.'ComboardMessageUsers value="'.$out['DB']['ComboardMessages'][0]['ComboardMessageUsers'].'">';
		echo '<input type=hidden name=ComboardMessage'.DTR.'ComboardMessageGroups value="'.$out['DB']['ComboardMessages'][0]['ComboardMessageGroups'].'">';

		echo getComboardMessagesLib($out['DB']['ThreadComboardMessages']);

?> 
        </tr> 
      </table></td> 
  </tr> 
</form>
<?=boxFooter()?>
