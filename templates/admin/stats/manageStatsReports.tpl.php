<?=boxHeader(array('title'=>'ManageStatsReport.StatsReport.title'))?>
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr> 
	<form name="getStatsReports" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td width="30%" align="left" bgcolor="efefef">&nbsp;</td>
	<td valign=top bgcolor="#efefef" align="left">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('StatsReportNew.StatsReport.tip').' -';
			echo getLists($out['DB']['StatsReports'],$out['DB']['StatsReport'][0]['StatsReportID'],array('name'=>'StatsReportID','id'=>'StatsReportID','value'=>'StatsReportName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	</table>
	<form name="manageStatsReports" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['StatsReport'][0]['StatsReportID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="StatsReport<?=DTR?>StatsReportID" value="<?=$out['DB']['StatsReport'][0]['StatsReportID'];?>" />
		<input type="hidden" name="StatsReportID" value="<?=$out['DB']['StatsReport'][0]['StatsReportID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('StatsReport.StatsReportCode')?>*:
						</td>
						<td align="left">
							<input type="text" name="StatsReport<?=DTR?>StatsReportCode" size="35" value="<?=$out['DB']['StatsReport'][0]['StatsReportCode']?>">
						</td>
					</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
								<?=lang('StatsReport.StatsReportName')?>*:
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
						</td>
						<td align="left">
							<input type="text" name="StatsReport<?=DTR?>StatsReportName[<?=$langCode?>]" size="35" value="<?=getValue($out['DB']['StatsReport'][0]['StatsReportName'],$langCode)?>">
						</td>
					</tr>	
					<? } ?>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
								<?=lang('StatsReport.StatsReportDescription')?>*:
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
						</td>
						<td align="left">
							<textarea name="StatsReport<?=DTR?>StatsReportDescription[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['StatsReport'][0]['StatsReportDescription'],$langCode)?></textarea>
						</td>
					</tr>	
					<? } ?>	
				<tr>
					<td align="left" valign="top" width="30%" class="subtitle">
					<?=lang('-addafter')?>:&nbsp;
					</td>
					<td align="left" valign="top">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['StatsReports']))
						{
							foreach($out['DB']['StatsReports'] as $row)
							{
								if ($row['StatsReportID']!=$out['DB']['StatsReport'][0]['StatsReportID'])
								{
									$i++;
									$options[$i]['id']=$row['StatsReportPosition']+1;	
									$options[$i]['value']=$row['StatsReportName'];
								}
							}
						}
						//print_r($out);
						//echo $out['DB']['StatsReport'][0]['StatsReportPosition']-1;
						echo getLists('',$out['DB']['StatsReport'][0]['StatsReportPosition'],array('name'=>'StatsReport'.DTR.'StatsReportPosition','id'=>'id','value'=>'value','options'=>$options));	
						$options='';
					?>
					</td>
				</tr>
				<tr>
					<td width="30%" class="subtitle" align="left">
						<?=lang('StatsReport.PermAll')?>
					</td>
					<td>
						<? if(empty($out['DB']['StatsReport'][0]['PermAll'])) {$out['DB']['StatsReport'][0]['PermAll']=1;} ?>
						<?=getReference('PermAll','StatsReport'.DTR.'PermAll',$out['DB']['StatsReport'][0]['PermAll'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr><td width="100%" colspan="2">&nbsp;</td></tr>
				<tr>
					<td bgcolor="#efefef" align="center" colspan="2" width="100%">
					<? if(empty($out['DB']['StatsReport'][0]['StatsReportID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageStatsReports.actionMode.value='delete';confirmDelete('manageStatsReports', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			 		</td>
    			</tr>
			</table>
		</td> 
	</tr> 
	</form>
<?=boxFooter()?>