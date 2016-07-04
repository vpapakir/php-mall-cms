<?=boxHeader(array('title'=>'ManageTours.tour.title'))?>
<? $categoryID = input('CategoryID'); $TourType = input('TourType');?>
	<tr> 
	<form name="getTours" method="post">
	<input type="hidden" name="SID" value="manageTours" />
	<input type="hidden" name="TourType" value="<?=input('TourType')?>" />
	<td valign=top bgcolor="#ffffff">
	<? /*
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectTourCategoriesForList.Tour.tip');
		//print_r($out['DB']['TourCategories']);
		echo getLists($out['DB']['TourCategories'],$categoryID,array('name'=>'CategoryID','id'=>'id','value'=>'value','action'=>'submit();','options'=>$options))
		*/
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectTourTypeForList.Tour.tip');
		echo getLists($out['DB']['TourTypes'],$TourType,array('name'=>'TourType','id'=>'TourTypeAlias','value'=>'TourTypeName','action'=>'submit();','options'=>$options));	
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectTourOptions.Tour.tip');
		echo getReference('Tour.TourActionOptions','TourActionOptions',$input['TourActionOptions'],array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	?>
	<?
		/*$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectTourFeaturedOptions.Tour.tip');
		echo getReference('Tour.TourFeaturedOptions','TourFeaturedOption',$input['TourFeaturedOption'],array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	*/
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectTourPermAll.Tour.tip');
		echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	?>	
	<?
		/*
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectTourStatusForList.Tour.tip');
		echo getReference('Tour.TourStatus','TourStatus',input('TourStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
		*/
	?>

	<input type="text" name="SearchText" value="<?=input('SearchText')?>" size="15" />
	<input type="submit" name="Search" value="<?=lang('Search');?>"/>
	</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['Tours'][0]['TourID'])) {?>
	<form name="manageTours" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageTours" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="TourType" value="<?=input('TourType')?>" />
		<input type="hidden" name="page" value="<?=input('page')?>" />
		<input type="hidden" name="next" value="<?=input('next')?>" />
		<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageTour/CategoryID/<?=input('CategoryID')?>/TourType/<?=input('TourType')?>" class="boldLink">[<?=lang('AddTour.tour.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Tours'] as $id=>$row) {?>
					<input type="hidden" name="Tour<?=DTR?>TourID[<?=$id?>]" value="<?=$row['TourID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="Tour<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="Tour<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>	
						<td valign="top" align="center" class="row1" width="1%">
							<? if(!empty($row['TourIcon'])) { ?>
								<img src="<?=setting('urlfiles').$row['TourIcon']?>" border="0"/>
							<? } else {?>
							<img src="<?=setting('layout')?>images/icons/nopicture.gif" width="15" height="13"/>
							<? }?>
						</td>																
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['TourTitle'])?>
						</td>
						<!--td valign="top" class="row1">
							<?
							$TourPositionUp = $row['TourPosition'] - 3;
							$TourPositionDown = $row['TourPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/Tour<?=DTR?>TourPosition/<?=$TourPositionUp?>/Tour<?=DTR?>TourID/<?=$row['TourID']?>/TourGroup/<?=$row['TourGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpTour.tour.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/Tour<?=DTR?>TourPosition/<?=$TourPositionDown?>/Tour<?=DTR?>TourID/<?=$row['TourID']?>/GroupID/<?=$row['TourGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownTour.tour.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageTour/TourID/<?=$row['TourID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageTours/Tour<?=DTR?>TourID/<?=$row['TourID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteTour.tour.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['TourID']?>" onChange="selectLink('manageTours', 'manageR<?=$row['TourID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageTour/TourID/<?=$row['TourID']?>/CategoryID/<?=input('CategoryID')?>/TourType/<?=input('TourType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageTours/Tour<?=DTR?>TourID/<?=$row['TourID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/TourType/<?=input('TourType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageTour/TourParentID/<?=$row['TourParentID']?>/GroupID/<?=input('GroupID')?>/TourPosition/<? $newTourPosition=$row['TourPosition'] + 1; echo $newTourPosition; ?>">[<?=lang('AddTourAfter.tour.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageTour/TourParentID/<?=$row['TourID']?>/GroupID/<?=input('GroupID')?>/TourPosition/1">[<?=lang('AddTourUnder.tour.link','nospace')?>]</a-->
						</td>										
					</tr>	
				<? } ?>					
				</table>		
			</td> 
		</tr> 
		<tr>
			<td align="center"><?=getPages($out['pages']['Tours']) ?></td>
		</tr>		
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['Tours'][0]['TourID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageTour/CategoryID/<?=input('CategoryID')?>/TourType/<?=input('TourType')?>" class="boldLink">[<?=lang('AddTour.tour.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoTourFound.tour.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>