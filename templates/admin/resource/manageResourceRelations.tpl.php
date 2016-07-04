<? if(input('actionMode')=='addrelated') { goLink(setting('url').'manageResource/ResourceID/'.input('ResourceID').'/CategoryID/'.input('CategoryID').'/ResourceType/'.input('ResourceType')); } ?>
<?=boxHeader(array('title'=>'AddResourceRelations.resource.title'))?>
<? $resourceID = input('ResourceID'); $categoryID = input('CategoryID'); $resourceType = input('ResourceType'); ?>
	<tr> 
	<form name="searchResourcesForm" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="search" />
		<input type="hidden" name="ResourceType" value="<?=input('ResourceType')?>" />
		<input type="hidden" name="ResourceID" value="<?=$resourceID?>" />
		<input type="hidden" name="CategoryID" value="<?=$categoryID?>" />
		<input type="hidden" name="ResourceType" value="<?=$resourceType?>" />
		
		<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectResourceCategoriesForList.resource.tip');
			echo getLists($out['DB']['ResourceCategories'],input('SearchCategoryID'),array('name'=>'SearchCategoryID','id'=>'id','value'=>'value','options'=>$options))
		?>	
		<?
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectResourceTypeForList.resource.tip');
			echo getLists($out['DB']['ResourceTypes'],input('SearchResourceType'),array('name'=>'SearchResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','options'=>$options));	
		?>	
		<? /*
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectResourcePermAll.resource.tip');
			echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			*/
		?>	
		<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
		</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['Resources'][0]['ResourceID'])) {?>
	<form name="searchResourcesResult" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="addrelated" />
		<input type="hidden" name="ResourceID" value="<?=$resourceID?>" />
		<input type="hidden" name="CategoryID" value="<?=$categoryID?>" />
		<input type="hidden" name="ResourceType" value="<?=$resourceType?>" />
		
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
		<input type="hidden" name="SearchCategoryID" value="<?=input('SearchCategoryID')?>" />
		<input type="hidden" name="SearchResourceType" value="<?=input('SearchResourceType')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Resources'] as $id=>$row) {?>
					<tr>
						<td valign="top" class="row1" width="1%">
							<? if(empty($row['ResourceRelatedID'])) { ?>
							<input type="checkbox" name="ResourceRelatedID[<?=$id?>]" value="<?=$row['ResourceID']?>" />
							<? } ?>
						</td>	
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['ResourceTitle'])?>
						</td>
					</tr>	
				<? } ?>								
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-add")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['Resources'][0]['ResourceID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<br/>
				<?=lang('NoResourceFound.resource.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>