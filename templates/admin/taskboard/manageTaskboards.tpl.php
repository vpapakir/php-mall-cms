<?
	$categoryID = input('CategoryID');
	$sectionID = input('SectionID');
	$SID = input('SID');
?>
<?=boxHeader(array('title'=>'Tasks.taskboard.title'))?>

	<tr><td align="center" valign="middle" bgcolor="efefef">
		<?=getReference('Taskboard.TaskboardType','TaskboardShowOnly',input('TaskboardShowOnlyType'),array('code'=>'Y','isEmptyValue'=>'Y','suppressEdit'=>'Y','action'=>'submit();'))?>
		<?=getReference('Taskboard.TaskboardStatus','TaskboardShowOnly',input('TaskboardShowOnly'),array('code'=>'Y','isEmptyValue'=>'Y','suppressEdit'=>'Y','action'=>'submit();'))?>
		<?=getReference('Taskboard.SortBy','ProjectsSortBy',input('ProjectsSortBy'),array('code'=>'Y','suppressEdit'=>'Y','isEmptyValue'=>'Y','action'=>'submit();'))?>
	</td><tr>
	<tr><td align="left" valign="top">
		<div align="center"><a href="<?=setting('url')?>manageTaskboards" >[<?=lang('Home.taskboard.link')?>]</a></div>		
		<ul>
<? 
		if(!empty($out['DB']['Taskboards'][0]['TaskboardID'])) {
			$last_project='';
			foreach($out['DB']['Taskboards'] as $row){
				if($row['TaskboardProject']!=$last_project){
					$last_project=$row['TaskboardProject'];
					echo "</ul><b >$last_project</b><ul style='margin-top:0; padding:0 0 0 20px;'>";
				}?>
<?/*
				<li style='list-style-image:url(<?=setting('layout')?>images/icons/taskstatus-<?=$row['TaskboardFlag']?>.gif)'>
*/?>

				<li style='list-style-type: disc; color:<?=$row['TaskboardFlag']?>; '>
					<?=getReferenceValue('Taskboard.TaskboardSign',$row['TaskboardSign'])?> <a href="<?=setting('url')?>manageTaskboards/TaskboardID/<?=$row['TaskboardID']?>"><?=$row['TaskboardTitle']?></a> [<?=getReferenceValue('Taskboard.TaskboardType',$row['TaskboardType'])?>-<?=getReferenceValue('Taskboard.TaskboardStatus',$row['TaskboardStatus'])?>]<font color="<?=($row['time_left']>0?'black':'red')?>"><?=$row['time_left']?></font>

<?
			}
		}
?>           
		</ul>
<?=boxFooter()?>
