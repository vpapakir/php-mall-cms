<?
	$categoryID = input('CategoryID');
	$sectionID = input('SectionID');
?>
<?=boxHeader(array('title'=>'TasksToday.taskboard.title'))?>

	<tr><td align="center" valign="middle" bgcolor="efefef">
		<?=getReference('Taskboard.SortByToday','ProjectsSortByToday',input('ProjectsSortByToday'),array('code'=>'Y','suppressEdit'=>'Y','isEmptyValue'=>'Y','action'=>'submit();'))?>
	</td><tr>
	<tr><td align="left" valign="top">
		<ul>
<? 
		if(!empty($out['DB']['Taskboards'][0]['TaskboardID'])) {
			$last_project='';
			echo "";// :)))))
			foreach($out['DB']['Taskboards'] as $row){
				if($row['TaskboardProject']!=$last_project){
					$last_project=$row['TaskboardProject'];
					echo "</ul><b>$last_project</b><ul style='margin-top:0; padding:0 0 0 20px;'>";
				}?>
				<li style='list-style-type: disc; color:<?=$row['TaskboardFlag']?>;'>
					<?=getReferenceValue('Taskboard.TaskboardSign',$row['TaskboardSign'])?> <a href="<?=setting('url')?>manageTaskboards/TaskboardID/<?=$row['TaskboardID']?>"><?=$row['TaskboardTitle']?></a> [<?=getReferenceValue('Taskboard.TaskboardType',$row['TaskboardType'])?>-<?=getReferenceValue('Taskboard.TaskboardStatus',$row['TaskboardStatus'])?>]<font color="<?=($row['time_left']>0?'black':'red')?>"><?=$row['time_left']?></font>

<?
			}
		}
?>           
		</ul>
<?=boxFooter()?>
