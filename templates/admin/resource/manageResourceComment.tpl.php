<?=boxHeader(array('title'=>'ManageResourceComment.resource.title'))?>
	<form name="manageResourceComments" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageResourceComments" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<? if(empty($out['DB']['ResourceComment'][0]['ResourceCommentID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceComment<?=DTR?>ResourceCommentID" value="<?=$out['DB']['ResourceComment'][0]['ResourceCommentID'];?>" />
		<input type="hidden" name="ResourceCommentID" value="<?=$out['DB']['ResourceComment'][0]['ResourceCommentID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
				<table width="100%">
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('ResourceCommentSectionCategory.resource.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<? if (!empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ResourceComment.ResourceID')?></span>
					</td>
					<td>
						<a href="<?=setting('url')?>manageResource/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>"><b><?=getValue($out['DB']['Resource'][0]['ResourceTitle'])?></b></a>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td>	
						<span class="subtitle"><?=lang('ResourceComment.SectionID')?></span>
					</td>
					<td>
						<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.resource.tip'); ?>
						<?=getLists($out['DB']['SectionsList'],$out['DB']['ResourceComment'][0]['SectionID'],array('name'=>'ResourceComment'.DTR.'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:300px'))?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('-or')?></span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ResourceComment.ResourceCategoryID')?></span>
					</td>
					<td>
						<?=getLists($out['DB']['ResourceCategories'],$out['DB']['ResourceComment'][0]['ResourceCategoryID'],array('name'=>'ResourceComment'.DTR.'ResourceCategoryID','style'=>'width:300px'))?>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('ResourceCommentTitle.resource.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ResourceComment.ResourceCommentTitle')?></span>
					</td>
					<td>
						<input type="text" name="ResourceComment<?=DTR?>ResourceCommentTitle" value="<?=$out['DB']['ResourceComment'][0]['ResourceCommentTitle'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('ResourceComment.ResourceCommentContent')?></span>
					</td>
					<td>
						<textarea name="ResourceComment<?=DTR?>ResourceCommentContent" cols="50" rows="10"><?=getValue($out['DB']['ResourceComment'][0]['ResourceCommentContent']);?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ResourceComment.ResourceCommentAuthor')?></span>
					</td>
					<td>
						<input type="text" name="ResourceComment<?=DTR?>ResourceCommentAuthor" value="<?=$out['DB']['ResourceComment'][0]['ResourceCommentAuthor'];?>" size="30">
					</td>
				</tr>	
				<tr>
					<td>
						<span class="subtitle"><?=lang('ResourceComment.ResourceCommentEmail')?></span>
					</td>
					<td>
						<input type="text" name="ResourceComment<?=DTR?>ResourceCommentEmail" value="<?=$out['DB']['ResourceComment'][0]['ResourceCommentEmail'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ResourceComment.ResourceCommentLink')?></span>
					</td>
					<td>
						<input type="text" name="ResourceComment<?=DTR?>ResourceCommentLink" value="<?=$out['DB']['ResourceComment'][0]['ResourceCommentLink'];?>" size="30">
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('ResourceComment.ResourceCommentContactType')?></span>
					</td>
					<td>
						<?=getReference('ResourceComment.ResourceCommentContactType','ResourceComment'.DTR.'ResourceCommentContactType',$out['DB']['ResourceComment'][0]['ResourceCommentContactType'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr>
					<td align="center" class="subtitleline" colspan="2">
						<span class="subtitle"><?=lang('ResourceCommentPermAll.resource.subtitle')?></span>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top">
						<span class="subtitle"><?=lang('ResourceComment.PermAll')?></span>
					</td>
					<td>
						<?=getReference('PermAll','ResourceComment'.DTR.'PermAll',$out['DB']['ResourceComment'][0]['PermAll'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td align="center" class="subtitleline"  colspan="2">
						<? if(empty($out['DB']['ResourceComment'][0]['ResourceCommentID'])) { ?>
						<input type="submit" value="<?=lang("-add")?>">
						<? } else { ?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceComments.actionMode.value='delete';confirmDelete('manageResourceComments', '<?=lang("-deleteconfirmation")?>');">
						<? } ?>		
						&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageResourceComments.actionMode.value='cancell';submit();">			
					</td>
				</tr>
			</table>
		</td> 
	</tr> 
</form>	
<?=boxFooter()?>