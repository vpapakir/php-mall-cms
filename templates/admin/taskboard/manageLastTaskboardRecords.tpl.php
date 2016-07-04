<?
//print_r($out['DB']);

if($out['DB']['LastTaskboardRecords'][0]['TaskboardID']){?>
<?=boxHeader(array('title'=>'ManageLastTastboardRecords.taskboard.title'))?>
<ul style='margin-top:0; padding:0 0 0 20px;'>
<?	foreach($out['DB']['LastTaskboardRecords'] as $row){?>
		<li style='list-style-type: disc; color:<?=$row['TaskboardFlag']?>; '>
			<?=getReferenceValue('Taskboard.TaskboardSign',$row['TaskboardSign'])?> <a href="<?=setting('url')?>manageTaskboards/TaskboardID/<?=$row['TaskboardID']?>"><?=$row['TaskboardTitle']?></a> [<?=getReferenceValue('Taskboard.TaskboardType',$row['TaskboardType'])?>-<?=getReferenceValue('Taskboard.TaskboardStatus',$row['TaskboardStatus'])?>]<font color="<?=($row['time_left']>0?'black':'red')?>"><?=$row['time_left']?></font>
<?	}?>
</ul>
<?=boxFooter();?>
<?}?>