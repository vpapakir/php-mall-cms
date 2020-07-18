<?=boxHeader(array('title'=>'ManagePropertyComment.property.title'))?>
	<form name="managePropertyComments" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="managePropertyComments" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<? if(empty($out['DB']['PropertyComment'][0]['PropertyCommentID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="PropertyComment<?=DTR?>PropertyCommentID" value="<?=$out['DB']['PropertyComment'][0]['PropertyCommentID'];?>" />
		<input type="hidden" name="PropertyCommentID" value="<?=$out['DB']['PropertyComment'][0]['PropertyCommentID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('PropertyCommentSectionCategory.property.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<? if (!empty($out['DB']['Property'][0]['PropertyID'])) { ?>
				<tr>
					<td>
						<span class="subtitle"><?=lang('PropertyComment.PropertyID')?></span>
					</td>
					<td>
						<a href="<?=setting('url')?>manageProperty/PropertyID/<?=$out['DB']['Property'][0]['PropertyID']?>"><b><?=getValue($out['DB']['Property'][0]['PropertyTitle'])?></b></a>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td>	
						<span class="subtitle"><?=lang('PropertyComment.SectionID')?></span>
					</td>
					<td>
						<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.property.tip'); ?>
						<?=getLists($out['DB']['SectionsList'],$out['DB']['PropertyComment'][0]['SectionID'],array('name'=>'PropertyComment'.DTR.'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:300px'))?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('-or')?></span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('PropertyComment.PropertyCategoryID')?></span>
					</td>
					<td>
						<?=getLists($out['DB']['PropertyCategories'],$out['DB']['PropertyComment'][0]['PropertyCategoryID'],array('name'=>'PropertyComment'.DTR.'PropertyCategoryID','style'=>'width:300px'))?>
					</td>
				</tr>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('PropertyCommentTitle.property.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('PropertyComment.PropertyCommentTitle')?></span>
					</td>
					<td>
						<input type="text" name="PropertyComment<?=DTR?>PropertyCommentTitle" value="<?=$out['DB']['PropertyComment'][0]['PropertyCommentTitle'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('PropertyComment.PropertyCommentContent')?></span>
					</td>
					<td>
						<textarea name="PropertyComment<?=DTR?>PropertyCommentContent" cols="50" rows="10"><?=getValue($out['DB']['PropertyComment'][0]['PropertyCommentContent']);?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('PropertyComment.PropertyCommentAuthor')?></span>
					</td>
					<td>
						<input type="text" name="PropertyComment<?=DTR?>PropertyCommentAuthor" value="<?=$out['DB']['PropertyComment'][0]['PropertyCommentAuthor'];?>" size="30">
					</td>
				</tr>	
				<tr>
					<td>
						<span class="subtitle"><?=lang('PropertyComment.PropertyCommentEmail')?></span>
					</td>
					<td>
						<input type="text" name="PropertyComment<?=DTR?>PropertyCommentEmail" value="<?=$out['DB']['PropertyComment'][0]['PropertyCommentEmail'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('PropertyComment.PropertyCommentLink')?></span>
					</td>
					<td>
						<input type="text" name="PropertyComment<?=DTR?>PropertyCommentLink" value="<?=$out['DB']['PropertyComment'][0]['PropertyCommentLink'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('PropertyComment.PropertyCommentContactType')?></span>
					</td>
					<td>
						<?=getReference('PropertyComment.PropertyCommentContactType','PropertyComment'.DTR.'PropertyCommentContactType',$out['DB']['PropertyComment'][0]['PropertyCommentContactType'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('PropertyCommentPermAll.property.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('PropertyComment.PermAll')?></span>
					</td>
					<td>
						<?=getReference('PermAll','PropertyComment'.DTR.'PermAll',$out['DB']['PropertyComment'][0]['PermAll'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr>
					<td align="center" class="subtitleline"  colspan="2">
						<? if(empty($out['DB']['PropertyComment'][0]['PropertyCommentID'])) { ?>
						<input type="submit" value="<?=lang("-add")?>">
						<? } else { ?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.managePropertyComments.actionMode.value='delete';confirmDelete('managePropertyComments', '<?=lang("-deleteconfirmation")?>');">
						<? } ?>		
						&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.managePropertyComments.actionMode.value='cancell';submit();">			
					</td>
				</tr>
			</table>
		</td> 
	</tr> 
</form>	
<?=boxFooter()?>