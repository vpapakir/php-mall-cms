<?=boxHeader(array('title'=>'ManageTourType.tour.title'))?>
	<tr> 
	<form name="getTourTypes" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('TourTypeNew.tour.tip').' -';
			echo getLists($out['DB']['TourTypes'],$out['DB']['TourType'][0]['TourTypeID'],array('name'=>'TourTypeID','id'=>'TourTypeID','value'=>'TourTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageTourTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['TourType'][0]['TourTypeID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TourType<?=DTR?>TourTypeID" value="<?=$out['DB']['TourType'][0]['TourTypeID'];?>" />
		<input type="hidden" name="TourTypeID" value="<?=$out['DB']['TourType'][0]['TourTypeID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('TourType.TourTypeAlias')?>*:<br/>
					<input type="text" name="TourType<?=DTR?>TourTypeAlias" value="<?=$out['DB']['TourType'][0]['TourTypeAlias'];?>" size="50">
					<br/>
					<? //lang('TourType.TourTemplate')?>
					<? /* getReference('TourTemplate','TourType'.DTR.'TourTemplate',$out['DB']['TourType'][0]['TourTemplate'],array('code'=>'Y'))?>&nbsp;<a href="<?=setting('url')?>manageReferences/ReferenceCode/TourTemplate">[<?=lang('-edit')?>]</a */ ?>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourType.TourTypeName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="TourType<?=DTR?>TourTypeName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['TourType'][0]['TourTypeName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['TourTypes']))
						{
						foreach($out['DB']['TourTypes'] as $row)
						{
							if ($row['TourTypeID']!=$out['DB']['TourType'][0]['TourTypeID'])
							{
								$i++;
								$options[$i]['id']=$row['TourTypePosition']+1;	
								$options[$i]['value']=$row['TourTypeName'];
							}
						}
						}
						echo getLists('',$out['DB']['TourType'][0]['TourTypePosition']-1,array('name'=>'TourType'.DTR.'TourTypePosition','id'=>'TourTypePosition','value'=>'TourTypeName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['TourType'][0]['TourTypeID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourTypes.actionMode.value='delete';confirmDelete('manageTourTypes', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>