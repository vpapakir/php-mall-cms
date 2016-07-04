<?=boxHeader(array('title'=>lang('viewLastComboardMessages.comboard.title')))?> 
<tr> 
	<td valign="top" bgcolor="#ffffff" class="subtitle" align="center">
		<?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?>
	</td> 
</tr> 
<? if(is_array($out['DB']['NewComboardMessages'])){?> 
	<? echo getComboardMessagesLib($out['DB']['NewComboardMessages']);?>
<? }else{?>
	<tr> 
		<td align="center" valign="middle">
			<?=lang('EmptyLastComboardMessages.comboard.text')?>
		</td> 
	</tr>
<? }?>
<?=boxFooter()?>
