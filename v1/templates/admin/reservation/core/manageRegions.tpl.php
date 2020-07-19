<? //print_r($input);?>
<?=boxHeader(array('title'=>lang(input('RegionActionType').'ManageRegions.core.title')))?>
	<tr>
		<form name="getResources" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="RegionParentID" value="<?=input('RegionParentID')?>" />
			<input type="hidden" name="RegionActionType" value="<?=input('RegionActionType')?>" />
			<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('SelectResourcePermAll.resource.tip');
				echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			</td> 
		</form>
	</tr>
	<form name="manageRegions" method="post">
		<input type="hidden" name="SID" value="manageRegions" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="RegionActionType" value="<?=input('RegionActionType')?>" />
		<? if(is_array($out['DB']['RegionsPath'])){ $count = count($out['DB']['RegionsPath']); $i=1; ?>
		<tr>
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<?=lang('RegionsPathBackTo.core.tip')?>: <a href="<?=setting('url').input('SID')?>/RegionActionType/<?=input('RegionActionType')?>"><?=lang('-top')?></a> > <? foreach($out['DB']['RegionsPath'] as $id=>$name) { ?>
						<? if($i<$count) { ?><a href="<?=setting('url').input('SID')?>/RegionParentID/<?=$id?>/RegionActionType/<?=input('RegionActionType')?>"><?=$name?></a> > <? } else { ?> <?=$name?> <? } ?>
				<? $i++; } ?>
							
			</td>
		</tr>	
		<? } ?>		
	<? if(!empty($out['DB']['Regions'][0]['RegionID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
						<a href="<?=setting('url')?>manageRegion/RegionParentID/<?=$out['DB']['Region']['RegionID']?>/RegionActionType/<?=input('RegionActionType')?>" class="boldLink">[<?=lang('AddRegion.core.link')?>]</a>
					</div>		
					<br/>
			</td> 
		</tr>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Regions'] as $id=>$row) {?>
					<input type="hidden" name="Region<?=DTR?>RegionID[<?=$id?>]" value="<?=$row['RegionID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="Region<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="Region<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>			
						<td valign="top" class="row1" width="5%">
							<? $deep=$row['RegionLevel']*15-15; ?>
							<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/>
							<?=getValue($row['RegionCode'])?>
						</td>									
						<td valign="top" class="row1" width="65%">
							<? $deep=$row['RegionLevel']*15-15; ?>
							<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/>
							<a href="<?=setting('url')?><?=input('SID')?>/RegionParentID/<?=$row['RegionID']?>/RegionActionType/<?=input('RegionActionType')?>"><?=getValue($row['RegionName'])?></a>
						</td>						
						<td valign="top" class="row1" width="10%" align="right">
						<select name="ManageRegions<?=$row['RegionID']?>" onChange="selectLink('manageRegions', 'ManageRegions<?=$row['RegionID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
							<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
							<option value="<?=setting('url')?>manageRegion/RegionParentID/<?=$row['RegionParentID']?>/RegionID/<?=$row['RegionID']?>/GroupID/<?=input('GroupID')?>/RegionActionType/<?=input('RegionActionType')?>"><?=lang('-edit')?></option>
							<option value="<?=setting('url')?><?=input('SID')?>/RegionParentID/<?=$row['RegionParentID']?>/RegionID/<?=$row['RegionID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>/RegionActionType/<?=input('RegionActionType')?>"><?=lang('-delete')?></option>
							<option value="<?=setting('url')?>manageRegion/RegionParentID/<?=$row['RegionParentID']?>/RegionActionType/<?=input('RegionActionType')?>"><?=lang('AddRegionUnder.core.link','nospace')?></option>
						</select>
						</td>										
					</tr>	
				<? } ?>					
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>	
	<?  }// end of  if(!empty($out['DB']['Regions'][0]['RegionID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageRegion/RegionParentID/<?=input('RegionParentID')?>/RegionActionType/<?=input('RegionActionType')?>" class="boldLink">[<?=lang('AddRegion.core.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoRegionFound.core.tip')?>
				<br><br>
			</td> 
		</tr>		
	<? } ?>		
	</form>	
<?=boxFooter()?>