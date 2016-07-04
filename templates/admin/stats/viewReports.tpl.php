<?=boxHeader(array('title'=>'ViewReports.stats.title'))?>
	<tr> 
	<form name="getStatsReports" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td valign=top bgcolor="#efefef" width="100%" align="center">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('StatsReportNew.StatsReport.tip').' -';
			echo getLists($out['DB']['StatsReports'],input('report'),array('name'=>'report','id'=>'StatsReportCode','value'=>'StatsReportName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<tr>
		<td valign=top bgcolor="#ffffff">
			<table cellpadding="0" cellspacing="2" border="0">
				<tr>
					<td width="20%">
					</td>
					<td>
						<table border=0 width="100%">
						<? if(count($out['Report']['DailyHits'])>0) {
						?>
						<br><b><?=lang('TotalHits.stats.tip')?>: <?=$out['TotalHits']?></b><br>
						Daily summary:<br/>
						
						<?
							foreach($out['Report']['DailyHits'] as $row) { 
							$ic = $i/2;
							if($ic == round($ic)){$className = 'rowoff';} else {$className = 'rowon';}				
						?>
							<tr>
							 	<td width="10%" class="<?=$className?>"><?=$row['date']?></td>
							    <td width="10%" align="center" class="<?=$className?>"><?=$row['amount']?></td>
							    <td width="10%" align="center" class="<?=$className?>"><?=$row['percent']?></td>
							    <td width="10%" align="center" class="<?=$className?>"><?=$row['percent']?>%</td>
							    <td width="60%" class="'.$className.'"><img src="<?=setting('layout')?>images/poll.gif" width="<?=$row['percent']*10?>" height="10"></td>
						   </tr>
							<? } ?>
						<? } elseif(count($out['Report']['Result'])>0) { 
							foreach($out['Report']['Result'] as $row) { 
								$ic = $i/2;
								if($ic == round($ic)){$className = 'rowoff';} else {$className = 'rowon';}
								$percent = $row['percent'];
								?>
								<tr>
									<td width="50%" class="<?=$className?>"><?=$row['var']?></td>
									<td width="10%" align="center" class="<?=$className?>"><?=$row['hits']?></td>
									<td width="10%" align="center" class="<?=$className?>"><?=$percent?>%</td>
									<td width="30%" class="<?=$className?>"><img src="<?=setting('layout')?>images/poll.gif" width="<?=$percent*10?>" height="10"></td>
							    </tr>
						<? $i++; } } ?>
						</table>
					</td>
				</tr>
			</table>
		</td> 
	</tr>
<?=boxFooter()?>