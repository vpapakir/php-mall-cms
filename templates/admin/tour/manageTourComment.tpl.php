<? //print_r($out['DB']['TourComment'][0]); ?>
<?=boxHeader(array('title'=>'ManageTourComment.tour.title'))?>
	<form name="manageTourComments" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageTourComments" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<? if(empty($out['DB']['TourComment'][0]['TourCommentID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TourComment<?=DTR?>TourCommentID" value="<?=$out['DB']['TourComment'][0]['TourCommentID'];?>" />
		<input type="hidden" name="TourCommentID" value="<?=$out['DB']['TourComment'][0]['TourCommentID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				
				<? if (!empty($out['DB']['Tour'][0]['TourID'])) { ?>
				<?=lang('TourComment.TourID')?>:<br/>
				<a href="<?=setting('url')?>manageTour/TourID/<?=$out['DB']['Tour'][0]['TourID']?>"><b><?=getValue($out['DB']['Tour'][0]['TourTitle'])?></b></a>
				<br/><br/>
				<? } ?>
				<?=/* lang('TourComment.SectionID')?>:<br/>
				<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.tour.tip'); ?>
				<?=getLists($out['DB']['SectionsList'],$out['DB']['TourComment'][0]['SectionID'],array('name'=>'TourComment'.DTR.'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:300px'))?>
				<!-- <br/> -->
				<?=lang('-or')?>
				<!-- <br/> -->
				<?=lang('TourComment.TourCategoryID')?>:<br/>
				<?=getLists($out['DB']['TourCategories'],$out['DB']['TourComment'][0]['TourCategoryID'],array('name'=>'TourComment'.DTR.'TourCategoryID','style'=>'width:300px')) */?>
<!-- 				<br/><br/>	 -->
				<?=lang('TourComment.TourCommentTitle')?>:<br/>
				<input type="text" name="TourComment<?=DTR?>TourCommentTitle" value="<?=$out['DB']['TourComment'][0]['TourCommentTitle'];?>" size="30">
				<br/>
				<?=lang('TourComment.TourCommentContent')?>: <br/>
				<textarea name="TourComment<?=DTR?>TourCommentContent" cols="50" rows="10"><?=getValue($out['DB']['TourComment'][0]['TourCommentContent']);?></textarea>
				<br/>
				<?=lang('TourComment.TourCommentAuthor')?>:<br/>
				<input type="text" name="TourComment<?=DTR?>TourCommentAuthor" value="<?=getValue($out['DB']['TourComment'][0]['TourCommentAuthor']);?>" size="30">
				<br/>				
				<?=lang('TourComment.TourCommentEmail')?>:<br/>
				<input type="text" name="TourComment<?=DTR?>TourCommentEmail" value="<?=getValue($out['DB']['TourComment'][0]['TourCommentEmail']);?>" size="30">
				<br/>
				<?=/* lang('TourComment.TourCommentLink')?>:<br/>
				<input type="text" name="TourComment<?=DTR?>TourCommentLink" value="<?=$out['DB']['TourComment'][0]['TourCommentLink'];?>" size="30">
				<!-- <br/><br/> -->
				<?=lang('TourComment.TourCommentContactType')?>:<br/>
				<?=getReference('TourComment.TourCommentContactType','TourComment'.DTR.'TourCommentContactType',$out['DB']['TourComment'][0]['TourCommentContactType'],array('code'=>'Y')) */?>
				<!-- <br/> -->
				<hr size="1">
				<?=lang('TourComment.PermAll')?>:<br/>
				<?=getReference('PermAll','TourComment'.DTR.'PermAll',$out['DB']['TourComment'][0]['PermAll'],array('code'=>'Y'))?>
				<br/><br/>		
				<? if(empty($out['DB']['TourComment'][0]['TourCommentID'])) { ?>
				<input type="submit" value="<?=lang("-add")?>">
				<? } else { ?>
				<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourComments.actionMode.value='delete';confirmDelete('manageTourComments', '<?=lang("-deleteconfirmation")?>');">
				<? } ?>		
				&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageTourComments.actionMode.value='cancell';submit();">			
				<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>