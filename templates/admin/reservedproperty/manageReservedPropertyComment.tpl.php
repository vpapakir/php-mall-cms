<?=boxHeader(array('title'=>'ManageReservedPropertyComment.reservedProperty.title'))?>
	<form name="manageReservedPropertyComments" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageReservedPropertyComments" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<? if(empty($out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ReservedPropertyComment<?=DTR?>ReservedPropertyCommentID" value="<?=$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentID'];?>" />
		<input type="hidden" name="ReservedPropertyCommentID" value="<?=$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('ReservedPropertyCommentSectionCategory.reservedProperty.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<? if (!empty($out['DB']['ReservedProperty'][0]['ReservedPropertyID'])) { ?>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyID')?></span>
					</td>
					<td>
						<a href="<?=setting('url')?>manageReservedProperty/ReservedPropertyID/<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>"><b><?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyTitle'])?></b></a>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td>	
						<span class="subtitle"><?=lang('ReservedPropertyComment.SectionID')?></span>
					</td>
					<td>
						<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.reservedProperty.tip'); ?>
						<?=getLists($out['DB']['SectionsList'],$out['DB']['ReservedPropertyComment'][0]['SectionID'],array('name'=>'ReservedPropertyComment'.DTR.'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:300px'))?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('-or')?></span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyCategoryID')?></span>
					</td>
					<td>
						<?=getLists($out['DB']['ReservedPropertyCategories'],$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCategoryID'],array('name'=>'ReservedPropertyComment'.DTR.'ReservedPropertyCategoryID','style'=>'width:300px'))?>
					</td>
				</tr>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('ReservedPropertyCommentTitle.reservedProperty.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyCommentTitle')?></span>
					</td>
					<td>
						<input type="text" name="ReservedPropertyComment<?=DTR?>ReservedPropertyCommentTitle" value="<?=$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentTitle'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyCommentContent')?></span>
					</td>
					<td>
						<textarea name="ReservedPropertyComment<?=DTR?>ReservedPropertyCommentContent" cols="50" rows="10"><?=getValue($out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentContent']);?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyCommentAuthor')?></span>
					</td>
					<td>
						<input type="text" name="ReservedPropertyComment<?=DTR?>ReservedPropertyCommentAuthor" value="<?=$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentAuthor'];?>" size="30">
					</td>
				</tr>	
				<tr>
					<td>
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyCommentEmail')?></span>
					</td>
					<td>
						<input type="text" name="ReservedPropertyComment<?=DTR?>ReservedPropertyCommentEmail" value="<?=$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentEmail'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyCommentLink')?></span>
					</td>
					<td>
						<input type="text" name="ReservedPropertyComment<?=DTR?>ReservedPropertyCommentLink" value="<?=$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentLink'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('ReservedPropertyComment.ReservedPropertyCommentContactType')?></span>
					</td>
					<td>
						<?=getReference('ReservedPropertyComment.ReservedPropertyCommentContactType','ReservedPropertyComment'.DTR.'ReservedPropertyCommentContactType',$out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentContactType'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('ReservedPropertyCommentPermAll.reservedProperty.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('ReservedPropertyComment.PermAll')?></span>
					</td>
					<td>
						<?=getReference('PermAll','ReservedPropertyComment'.DTR.'PermAll',$out['DB']['ReservedPropertyComment'][0]['PermAll'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr>
					<td align="center" class="subtitleline"  colspan="2">
						<? if(empty($out['DB']['ReservedPropertyComment'][0]['ReservedPropertyCommentID'])) { ?>
						<input type="submit" value="<?=lang("-add")?>">
						<? } else { ?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageReservedPropertyComments.actionMode.value='delete';confirmDelete('manageReservedPropertyComments', '<?=lang("-deleteconfirmation")?>');">
						<? } ?>		
						&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageReservedPropertyComments.actionMode.value='cancell';submit();">			
					</td>
				</tr>
			</table>
		</td> 
	</tr> 
</form>	
<?=boxFooter()?>