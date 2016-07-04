<? if(input('SID')!='comboard2'){?>
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
<?=boxHeader(array('title'=>lang('ManageComboardMessages.comboard.title'),'tabs'=>'manageComboardMessage','tabslink'=>''))?> 
<? }else{?>
<?=boxHeader(array('title'=>lang('ManageComboardMessages.comboard.title')))?> 
<? }?>
<tr> 
	<td valign="top" bgcolor="#ffffff" class="subtitle" align="center">
		<?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?>
	</td> 
</tr> 
<? // =boxHeader(array('title'=>'ManageSections.core.title','tabs'=>'manageSections','formName'=>$formName,'tabslink'=>'SectionID/'.input('SectionID').'/GroupID/'.input('GroupID')))?> 
<form name="sendComboardMessage" method="post"> 
	<input type="hidden" name="SID" value="<?=input('SID')?>" /> 
	<input type="hidden" name="actionMode" value="save" /> 
	<input type="hidden" name="tabLink" value="<?=input('tabLink')?>" /> 
	<!-- <input type="hidden" name="viewMode" value="<?=input('viewMode')?>" /> --> 
	<input type="hidden" name="viewMode" value="period" /> 
	<tr> 
	    <td>
			<table> 
			<?
				if(input('viewMode'))
					echo '<tr><td>'.getDateIntervals(input('ComboardMessageStartTime'),input('ComboardMessageEndTime')).'</td></tr>';
	
				if(!input('viewMode')){
					getCalendar1('sendComboardMessage');
					echo getComboardMessagesLib($out['DB']['MemoComboardMessages']);
				}
				echo getComboardMessagesLib($out['DB']['NewComboardMessages']);
				echo getComboardMessagesLib($out['DB']['ComboardMessages']);
			?> 
      		</table>
		</td> 
	</tr> 
</form>
<?=boxFooter()?>
