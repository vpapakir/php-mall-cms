<?=boxHeader(array('title'=>lang('ResourceLinks.resource.title')))?>
<tr>
<form name="getResources" method="post">
	<input type="hidden" name="SID" value="manageResources" />
	<input type="hidden" name="ResourceType" value="<?=input('ResourceType')?>" />
	<td valign=top bgcolor="#ffffff">
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectResourceCategoriesForList.resource.tip');
		//print_r($out['DB']['ResourceCategories']);
		echo getLists($out['DB']['ResourceCategories'],$categoryID,array('name'=>'CategoryID','id'=>'id','value'=>'value','action'=>'submit();','options'=>$options))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectResourceTypeForList.resource.tip');
		echo getLists($out['DB']['ResourceTypes'],$resourceType,array('name'=>'ResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','action'=>'submit();','options'=>$options));	
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectResourceFeaturedOptions.resource.tip');
		echo getReference('Resource.ResourceFeaturedOptions','ResourceFeaturedOption',$input['ResourceFeaturedOption'],array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectResourcePermAll.resource.tip');
		echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectResourceStatusForList.resource.tip');
		echo getReference('Resource.ResourceStatus','ResourceStatus',input('ResourceStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	?>	
	<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
		<br/><a href="<?=setting('url')?>manageCategories">[<?=lang('EditResourceCategories.resource.link')?>]</a>
		&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes">[<?=lang('EditResourceTypes.resource.link')?>]</a>
	</td> 
	</form>
</tr>
<? if(!empty($out['DB']['ResourceLinks'][0]['ResourceLinkID'])) { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<table>
				<? if(is_array($out['DB']['ResourceLinks'])){ foreach($out['DB']['ResourceLinks'] as $id=>$row) {?>
					
						<tr>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<td class="hometable" valign="top"><a href="<?=$row['ResourceLinkURL']?>" target="_blank"><b><?=$row['ResourceLinkTitle']?></b></a></td>
							<td class="hometable" valign="top"><?=getFormated($row['ResourceLinkContent'],'TEXT')?></td>
						</tr>
					
			<? } } ?>	
			</table>
		</td> 
	</tr> 
	<? } ?>
<?=boxFooter()?>
