<script language="javascript">
	function set_submit(form,mode){
		form.actionMode.value=mode;
		form.submit();
//window.alert(form.actionMode.value);
	}
</script>

	<form name="manageTaskboards" method="post" >
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
	<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
	<input type="hidden" name="actionMode" value="" />

<table width=100% border=0><tr>
<td width=33% valign=top><?getBox('taskboard.manageTaskboards');?></td>
<td width=33% valign=top>
<?
//print_r($input);
	if($input['TaskboardID'] && !isset($input['ProjectID'])){
		getBox('taskboard.manageTaskboardRecords');
		
	}else{ 
		getBox('taskboard.manageLastTaskboardRecords');
		getBox('taskboard.manageTaskboardsToday');
	}
?>
</td>
<td width=33% valign=top>
<?
//print_r($input);
	if(isset($input['ProjectID'])){
		getBox('taskboard.manageProjects');
		
	}else{ 
		getBox('taskboard.manageTaskboard');
	}
?>
</td>
</table>
	</form>