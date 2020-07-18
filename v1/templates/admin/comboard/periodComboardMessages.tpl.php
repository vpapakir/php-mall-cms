<?=boxHeader(array('title'=>lang('periodComboardMessages.comboard.title')))?> 
<tr> 
	<td valign="top" bgcolor="#ffffff" class="subtitle" align="center">
		<?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?>
	</td> 
</tr> 
<? // =boxHeader(array('title'=>'ManageSections.core.title','tabs'=>'manageSections','formName'=>$formName,'tabslink'=>'SectionID/'.input('SectionID').'/GroupID/'.input('GroupID')))?> 
<form name="foundComboardMessage" method="post"> 
	<input type="hidden" name="SID" value="<?=input('SID')?>" /> 
	<!-- <input type="hidden" name="actionMode" value="save" />  -->
	<input type="hidden" name="tabLink" value="<?=input('tabLink')?>" /> 
	<!-- <input type="hidden" name="viewMode" value="<?=input('viewMode')?>" /> --> 
	<input type="hidden" name="viewMode" value="period" /> 
	<tr> 
	    <td>
			<table> 
			<?
				/*
				if(input('viewMode'))
					echo '<tr><td>'.getDateIntervals(input('ComboardMessageStartTime'),input('ComboardMessageEndTime')).'</td></tr>';
				*/
				getCalendar1('foundComboardMessage');
			?> 
      		</table>
		</td> 
	</tr> 
</form>
<?=boxFooter()?>
