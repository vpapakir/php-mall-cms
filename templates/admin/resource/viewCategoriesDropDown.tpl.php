<? //=boxHeader('','')?>
	<?
		//$options[0]['code'] = '';
		//$options[0]['value'] = lang('SelectCategoryDropDown.resource.option');
		$place = $params['place']; if(empty($place)){$place='tree';}
		$type = $params['type']; if(empty($type)){$type='dropdown';}
		$currentValue = $params['currentValue']; if(empty($currentValue)){$currentValue=input('category');}
		$fieldName = $params['fieldName']; if(empty($fieldName)) {$fieldName='category';}
		$id = $params['id']; if(empty($id)) {$id='code';}

		if(is_array($out['DB']['ResourceCategoriesList']))
		{
			foreach($out['DB']['ResourceCategoriesList'] as $id1=>$row)
			{
				if(!empty($row['place']))
				{
					if(!ereg("\|".$place."\|",$row['place'])) {
						$dropDownList[$id1]['id'] = $row['id'];
						$dropDownList[$id1]['code'] = $row['code'];
						$dropDownList[$id1]['value'] = $row['value'];
						$dropDownList[$id1]['type'] = $row['type'];
					}
				}
				else
				{
					$dropDownList[$id1]['id'] = $row['id'];
					$dropDownList[$id1]['code'] = $row['code'];
					$dropDownList[$id1]['value'] = $row['value'];
					$dropDownList[$id1]['type'] = $row['type'];
				}
			}
			if(!empty($params['filterType']))
			{
				if(is_array($dropDownList))
				{
					foreach($dropDownList as $id2=>$row2)
					{
						if($params['filterType']==$row2['type']) {
							$dropDownList2[$id2]['id'] = $row2['id'];
							$dropDownList2[$id2]['code'] = $row2['code'];
							$dropDownList2[$id2]['value'] = $row2['value'];
						}
					}
				}	
				
				$dropDownList=''; $dropDownList = $dropDownList2;			
			}			
		}
		echo getLists($dropDownList,$currentValue,array('name'=>$fieldName,'id'=>$id,'value'=>'value','type'=>$type,'options'=>$options,'style'=>'width:200px'));
if (hasRights('root')){?>	
	<a href="<?=setting('url')?>manageCategories/TipSection/manageSections"><?=lang('-editbox')?></a><? }

?>
	<? //getLists($out['DB']['ResourceCategories'],$input['category'],array('name'=>'category','id'=>'ResourceCategoryAlias','value'=>'ResourceCategoryTitle','action'=>'submit();','options'=>$options))?>
<? // =boxFooter()?>