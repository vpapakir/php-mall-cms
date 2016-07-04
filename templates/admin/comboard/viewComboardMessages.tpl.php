<? if(input('SID')!='comboard2'){?>
<? //print_r($out);?>
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
<? }else{?>
	<?=boxHeader(array('title'=>'ManageComboardMessages.comboard.title'))?> 
<? }?>
<tr> 
  <td valign="top" bgcolor="#ffffff" class="subtitle" align="center"> <?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?> </td> 
</tr> 
<?
/*
echo "<hr><pre>";
print_r($out['DB']['MessComboardMessages']);
echo "</pre><hr>";

echo "<hr><pre>";
print_r($out['DB']['AnswerComboardMessages']);
echo "</pre><hr>";

echo "<hr><pre>";
print_r($out['DB']['MessageComboardMessages']);
echo "</pre><hr>";
*/

		echo getComboardMessagesLib($out['DB']['MessageComboardMessages']);
?> 
<?=boxFooter()?>
