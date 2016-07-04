<?=boxHeader(array('title'=>'ManageTourComments.tour.title'))?>
	<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
		<!-- <tr> 
		<form name="getTourComments" method="post">
		<input type="hidden" name="SID" value="manageTourComments" />
		<input type="hidden" name="TourCommentType" value="<?=input('TourCommentType')?>" />
		 <td valign=top bgcolor="#ffffff">
			<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.tour.tip'); ?>
			<?=getLists($out['DB']['SectionsList'],$sectionID,array('name'=>'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:200px','action'=>'submit();'))?>
			&nbsp;&nbsp;
			<?=getLists($out['DB']['TourCategories'],$categoryID,array('name'=>'CategoryID','action'=>'submit();'))?>	
		</td> 
		</form>
		</tr> --> 
		<!-- <tr>
		<form name="getTours" method="post">
			<input type="hidden" name="SID" value="homeadmin" />
			<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('SelectTourCategoriesForList.tour.tip');
				//print_r($out['DB']['TourCategories']);
				//print_r($options);
				echo getLists($out['DB']['TourCategories'],$categoryID,array('name'=>'CategoryID','id'=>'id','value'=>'value','action'=>'submit();','options'=>$options))
			?>	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('SelectTourTypeForList.tour.tip');
				echo getLists($out['DB']['TourTypes'],$tourType,array('name'=>'TourType','id'=>'TourTypeAlias','value'=>'TourTypeName','action'=>'submit();','options'=>$options));	
			?>	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('SelectTourPermAll.tour.tip');
				echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			</td> 
		</form>
	</tr> -->
		<? if(!empty($out['DB']['TourComments'][0]['TourCommentID'])) {?>
		<form name="manageTourComments" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="manageTourComments" />
			<input type="hidden" name="actionMode" value="savelist" />
			<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
			<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
			<input type="hidden" name="TourCommentType" value="<?=input('TourCommentType')?>" />
			<tr> 
				<td valign="top" bgcolor="#ffffff" class="fieldNames">
						<!-- <br/>
						<div align="center">
						<a href="<?=setting('url')?>manageTourComment/CategoryID/<?=input('CategoryID')?>/TourCommentType/<?=input('TourCommentType')?>" class="boldLink">[<?=lang('AddTourComment.tour.link')?>]</a>
						</div>		
						<br/> -->				
					<table border="0" cellspacing="1" cellpadding="5" width="100%">
						<? foreach($out['DB']['TourComments'] as $id=>$row) {?>
						<input type="hidden" name="TourComment<?=DTR?>TourCommentID[<?=$id?>]" value="<?=$row['TourCommentID']?>"/>
						<tr>
							<td valign="top" class="row1" width="1%">
								<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
							</td>	
							<td valign="top" class="row1" width="1%">
								<? if($row['PermAll']==1) { ?>
									<input type="checkbox" name="TourComment<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
								<? } else {?>
									<input type="checkbox" name="TourComment<?=DTR?>PermAll[<?=$id?>]" value="1" />							
								<? } ?>
							</td>																	
							<td valign="top" class="row1" width="70%">
								<?=getValue($row['TourCommentTitle'])?> <!-- : <small><?=getFormated($row['TimeCreated'],'DateTime')?></small> -->
							</td>
							<td valign="top" class="row1" width="70%">
								<small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
							</td>
							<!--td valign="top" class="row1">
								<?
								$TourCommentPositionUp = $row['TourCommentPosition'] - 3;
								$TourCommentPositionDown = $row['TourCommentPosition'] + 3;
								?>
								<a href="<?=setting('url')?><?=input('SID')?>/TourComment<?=DTR?>TourCommentPosition/<?=$TourCommentPositionUp?>/TourComment<?=DTR?>TourCommentID/<?=$row['TourCommentID']?>/TourCommentGroup/<?=$row['TourCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpTourComment.tour.tip')?>" hspace="3"  /></a>
								<a href="<?=setting('url')?><?=input('SID')?>/TourComment<?=DTR?>TourCommentPosition/<?=$TourCommentPositionDown?>/TourComment<?=DTR?>TourCommentID/<?=$row['TourCommentID']?>/GroupID/<?=$row['TourCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownTourComment.tour.tip')?>" hspace="3"  /></a>
							</td-->						
							<td valign="top" class="row1" width="10%" align="right">
								<!--a href="<?=setting('url')?>manageTourComment/TourCommentID/<?=$row['TourCommentID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageTourComments/TourComment<?=DTR?>TourCommentID/<?=$row['TourCommentID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteTourComment.tour.tip')?>')">[<?=lang('-delete')?>]</a-->
								<select name="manageR<?=$row['TourCommentID']?>" onChange="selectLink('manageTourComments', 'manageR<?=$row['TourCommentID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
									<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
									<option value="<?=setting('url')?>manageTourComment/TourCommentID/<?=$row['TourCommentID']?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/TourCommentType/<?=input('TourCommentType')?>"><?=lang('-edit')?></option>
									<option value="<?=setting('url')?>manageTourComments/TourComment<?=DTR?>TourCommentID/<?=$row['TourCommentID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/TourCommentType/<?=input('TourCommentType')?>"><?=lang('-delete')?></option>
								</select>
								
								<!--br/>
								<a href="<?=setting('url')?>manageTourComment/TourCommentParentID/<?=$row['TourCommentParentID']?>/GroupID/<?=input('GroupID')?>/TourCommentPosition/<? $newTourCommentPosition=$row['TourCommentPosition'] + 1; echo $newTourCommentPosition; ?>">[<?=lang('AddTourCommentAfter.tour.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageTourComment/TourCommentParentID/<?=$row['TourCommentID']?>/GroupID/<?=input('GroupID')?>/TourCommentPosition/1">[<?=lang('AddTourCommentUnder.tour.link','nospace')?>]</a-->
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
		</form>	
		<?  }// end of  if(!empty($out['DB']['TourComments'][0]['TourCommentID']))
			else{
		?>
			<tr> 
				<td valign="top" bgcolor="#ffffff" align="center">
						<br/>
						<div align="center">
						<a href="<?=setting('url')?>manageTourComment/CategoryID/<?=input('CategoryID')?>/TourCommentType/<?=input('TourCommentType')?>" class="boldLink">[<?=lang('AddTourComment.tour.link')?>]</a>
						</div>		
						<br/>
					<?=lang('NoTourCommentFound.tour.tip')?>
					<br><br>
				</td> 
			</tr>
		<? } ?>
<?=boxFooter()?>