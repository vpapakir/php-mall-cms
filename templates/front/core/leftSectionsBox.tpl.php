<?=boxHeader(array('title'=>lang('-summary')))?>
<?
	for($i=0;$i<count($out['DB']['Sections']);$i++)
	{
		$out['DB']['Sections'][$i]['expanded']=0;
	}
	function lsbExpand($expandID,$out)
	{
		$i=0;
		while(($out['DB']['Sections'][$i]['SectionID']!=$expandID)and($i<count($out['DB']['Sections'])))
		{
			$i++;
		}
		$out['DB']['Sections'][$i]['expanded']=1;
			for($j=0;$j<count($out['DB']['Sections']);$j++)
			{
				if(($out['DB']['Sections'][$i]['SectionLevel']!=1)and($out['DB']['Sections'][$i]['SectionParentID']==$out['DB']['Sections'][$j]['SectionParentID']))
				{
					$out['DB']['Sections'][$j]['expanded']=1;
				}
				if($out['DB']['Sections'][$i]['SectionID']==$out['DB']['Sections'][$j]['SectionParentID'])
				{
					$out['DB']['Sections'][$j]['expanded']=1;
				}
			}
		if($out['DB']['Sections'][$i]['SectionParentID']!=0)
		{
			$out=lsbExpand($out['DB']['Sections'][$i]['SectionParentID'],$out);
		}
	return $out;
	}
	$selectedCategoryAlias = input('SID');
	foreach($out['DB']['Sections'] as $id=>$row)
	{
		if($row['SectionAlias']==$selectedCategoryAlias)
		{
			$out['DB']['Sections'][$id]['expanded']=1;
			$out=lsbExpand($row['SectionID'],$out);
			break;
		}
	}
?>
	<tr> 
		<td valign="top" width="253">
		<? 
			$sectionAlias=input('SID');
			$sectionButtonHover = getValue($row['SectionButtonHover']);
		?>
			<? foreach($out['DB']['Sections'] as $id=>$row) {
				$ResourceCategoryTitle=getValue($row['SectionName']); 
				if(!empty($ResourceCategoryTitle)) { ?>
				<? $deep=$row['SectionLevel']*15-15; ?>
				<table cellspacing="0" cellpadding="0" border="0">	
					<tr>
						<? if($row['SectionLevel']!=1){?>
							<td width="<?=$deep?>">&nbsp;</td>
						<? }?>
						<td>
							<!-- <img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/> -->
							
							<? 
							$hoverImg='';
							$strValue='';
							if ((($row['SectionAlias']==$sectionAlias) and (!empty($row['SectionButtonCurrent']))) or (($row['expanded']==1) and (!empty($row['SectionButtonCurrent']))))
							{
								$strValue = '<img src="'.setting("urlfiles").getValue($row["SectionButtonCurrent"]).'" border="0" alt="'.$ResourceCategoryTitle.'" name="'.getValue($row["SectionButton"]).'"/>';
							}
							elseif(($row['SectionAlias']==$sectionAlias)and(empty($row['SectionButtonCurrent']))and(!empty($row['SectionButton'])))
							{
								$strValue = '<img src="'.setting("urlfiles").getValue($row["SectionButton"]).'" border="0" alt="'.$ResourceCategoryTitle.'" name="'.getValue($row["SectionButton"]).'"/>';
								if(!empty($row['SectionButtonHover']))
								{
									$hoverImg=' onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\''.getValue($row["SectionButton"]).'\',\'\',\''.setting("urlfiles").getValue($row["SectionButtonHover"]).'\',1)"';
								}
							}
							elseif((!empty($row['SectionButton']))and($row['SectionAlias']!=$sectionAlias))
							{
								if(!empty($row['SectionButtonHover']))
								{
									$hoverImg=' onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\''.getValue($row["SectionButton"]).'\',\'\',\''.setting("urlfiles").getValue($row["SectionButtonHover"]).'\',1)"';
								}
								$strValue = '<img src="'.setting("urlfiles").getValue($row["SectionButton"]).'" border="0" alt="'.$ResourceCategoryTitle.'" name="'.getValue($row["SectionButton"]).'"/>';
							}else{
								if(setting('actexpicons')=='1'){
									if ($row['SectionAlias']==$sectionAlias || $row['SectionLink']==$sectionAlias)
									{
										if($row['IsLast']!=1){
											$expandImage = '_clear.gif';
										}else{
											$expandImage = 'minus.jpg';
										}
									}
										else
										{	
											if($row['IsLast']!=1){
												$expandImage = '_clear.gif';
											}else{
												if($row['SectionIsExpanded']=='expanded')
													$expandImage = 'minus.jpg';
												else
													$expandImage = 'plus.jpg';
											}
										}
										
									$strValue = '<img src="'.setting('layout').'images/icons/'.$expandImage.'" width="9" height="9" hspace="3" border="0"/>';
								}
								$strValue .= getValue($row['SectionName']);
							}
							if($row['SectionLevel']==1){
									if(!empty($row['SectionLink'])){?>
										<? if(eregi("http://",$row['SectionLink'])){
												$link = $row['SectionLink'];
											}else{
												$link = setting('url').$row['SectionLink'].$row['SectionArguments'];
											}	
										?>
										<a href="<?=$link?>" <?=$hoverImg?>><?=$strValue?></a><br/>
									<? }else{?>
										<? //if(!empty($row['SectionButton'])){?>
											<a href="<?=setting('url').$row['SectionAlias'].'/'.$row['SectionArguments']?>" <?=$hoverImg?>><?=$strValue?></a><br/>
										<? //}else{?>
											<!-- <a href="<?=setting('url').$row['SectionAlias'].'/'.$row['SectionArguments']?>" class="subtitle"><?=$ResourceCategoryTitle?></a><br/> -->
									<? }?>
							<? }else{
									if(!empty($row['SectionButton'])){
										if(!empty($row['SectionLink'])){?>
										<? if(eregi("http://",$row['SectionLink'])){
												$link = $row['SectionLink'];
											}else{
												$link = setting('url').$row['SectionLink'].$row['SectionArguments'];
											}	
										?>
										<a href="<?=$link?>" <?=$hoverImg?>><?=$strValue?></a><br/>
									<? }else{?>	
										<a href="<?=setting('url').$row['SectionAlias'].'/'.$row['SectionArguments']?>" <?=$hoverImg?>><?=$strValue?></a><br/>
									<? }}else{
											if(!empty($row['SectionLink'])){?>
												<? if(eregi("http://",$row['SectionLink'])){
														$link = $row['SectionLink'];
													}else{
														$link = setting('url').$row['SectionLink'].$row['SectionArguments'];
													}	
												?>
												<a href="<?=$link?>" ><?=$strValue?></a><br/>
											<? }else{?>
												<a href="<?=setting('url').$row['SectionAlias'].'/'.$row['SectionArguments']?>" ><?=$strValue?></a><br/>
							<? } } }?>
						</td>
					</tr>
				</table>
			<? } }?>		
			<? if (hasRights('content')) { ?><img src="<?=setting('layout')?>images/_clear.gif" width="5" height="1"/><a href="<?=setting('adminurl')?>manageSections/frontBackLinkAction/save"><?=lang('-editbox')?></a> <? } ?>
		</td> 
	</tr> 
<?=boxFooter()?>