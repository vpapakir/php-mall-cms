<?=boxHeader(array('title'=>'ManageResourceLink.resource.title'))?>
	<form name="manageResourceLinks" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageResourceLinks" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<? if(empty($out['DB']['ResourceLink'][0]['ResourceLinkID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceLink<?=DTR?>ResourceLinkID" value="<?=$out['DB']['ResourceLink'][0]['ResourceLinkID'];?>" />
		<input type="hidden" name="ResourceLinkID" value="<?=$out['DB']['ResourceLink'][0]['ResourceLinkID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
				<table valign="top" width="100%">
					<? if (!empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
					<tr>
						<td>
						<span class="subtitle"><?=lang('ResourceLink.ResourceID')?></span><br/>
						<a href="<?=setting('url')?>manageResource/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>"><b><?=getValue($out['DB']['Resource'][0]['ResourceTitle'])?></b></a>
						</td>
					</tr>
					<? } ?>
					<tr>
						<td align="center" class="subtitleline" colspan="2">
							<span class="subtitle"><?=lang('ResourceLinkSectionCategory.resource.subtitle')?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.SectionID')?></span>
						</td>
						<td>
							<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.resource.tip'); ?>
							<?=getLists($out['DB']['SectionsList'],$out['DB']['ResourceLink'][0]['SectionID'],array('name'=>'ResourceLink'.DTR.'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:300px'))?>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<? if(setting('UseResourceCategories')=='Y'){?>
					<tr>
						<td>
							<span class="subtitle"><?=lang('-or')?></span>
						</td>
					</tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.ResourceCategoryID')?></span>
						</td>
						<td>
							<?=getLists($out['DB']['ResourceCategories'],$out['DB']['ResourceLink'][0]['ResourceCategoryID'],array('name'=>'ResourceLink'.DTR.'ResourceCategoryID','style'=>'width:300px'))?>
						</td>
					</tr>
					<? }?>
					<tr>
						<td align="center" class="subtitleline" colspan="2">
							<span class="subtitle"><?=lang('ResourceLinkTitle.resource.subtitle')?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.ResourceLinkTitle')?></span>
						</td>
						<td>
							<input type="text" name="ResourceLink<?=DTR?>ResourceLinkTitle" value="<?=$out['DB']['ResourceLink'][0]['ResourceLinkTitle'];?>" size="30">
						</td>
					</tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.ResourceLinkContent')?></span>
						</td>
						<td>
							<textarea name="ResourceLink<?=DTR?>ResourceLinkContent" cols="50" rows="10"><?=getValue($out['DB']['ResourceLink'][0]['ResourceLinkContent']);?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.ResourceLinkAuthor')?></span>
						</td>
						<td>
							<input type="text" name="ResourceLink<?=DTR?>ResourceLinkAuthor" value="<?=$out['DB']['ResourceLink'][0]['ResourceLinkAuthor'];?>" size="30">
						</td>
					</tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.ResourceLinkEmail')?></span>
						</td>
						<td>
							<input type="text" name="ResourceLink<?=DTR?>ResourceLinkEmail" value="<?=$out['DB']['ResourceLink'][0]['ResourceLinkEmail'];?>" size="30">
						</td>
					</tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.ResourceLinkURL')?></span>
						</td>
						<td>
							<input type="text" name="ResourceLink<?=DTR?>ResourceLinkURL" value="<?=$out['DB']['ResourceLink'][0]['ResourceLinkURL'];?>" size="30">
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td align="center" class="subtitleline" colspan="2">
							<span class="subtitle"><?=lang('ResourceLinkPermAll.resource.subtitle')?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceLink.PermAll')?></span>
						</td>
						<td>
							<?=getReference('PermAll','ResourceLink'.DTR.'PermAll',$out['DB']['ResourceLink'][0]['PermAll'],array('code'=>'Y'))?>
						</td>
					</tr>
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td align="center" class="subtitleline" colspan="2">
							<? if(empty($out['DB']['ResourceLink'][0]['ResourceLinkID'])) { ?>
							<input type="submit" value="<?=lang("-add")?>">
							<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceLinks.actionMode.value='delete';confirmDelete('manageResourceLinks', '<?=lang("-deleteconfirmation")?>');">
							<? } ?>		
							&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageResourceLinks.actionMode.value='cancell';submit();">			
						</td>
					</tr>
				</table>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>