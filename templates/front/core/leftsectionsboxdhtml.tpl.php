<?=boxHeader(array('title'=>lang('-summary')))?>
 <?
			function createMenuLevelSections($mas=array(),$level=1,$pos=0)
			{
				$i=$pos;
				$res='';
//				print_r($mas);
				while(($i<count($mas))and($level==$mas[$i]['SectionLevel']))
				{
					$ResourceCategoryTitle=getValue($mas[$i]['SectionName']);
					$row=$mas[$i];
					if((count($mas)>($i+1))and($mas[$i+1]['SectionLevel']==$level))
					{
						if($level==1)
						{
							$res .= '<li><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'" class="submenu_6"';
//							$res .= ' style="background:#ffffff;"';
//							$res .= ' style="background:red;"';
						}else
						{
							$res .= '<li><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'"';
						}
						$res .= '>'.$ResourceCategoryTitle.'</a></li>';
					}elseif((count($mas)==($i+1))and($mas[$i]['SectionLevel']==$level))
					{
						if($level==1)
						{
							$res .= '<li><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'" class="submenu_6"';
//							$res .= ' style="background:#ffffff;"';
//							$res .= ' style="background:red;"';
						}
						else
						{
							$res .= '<li><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'"';
						}
						$res .= '>'.$ResourceCategoryTitle.'</a></li>';
						//$res .= '<li><a href="'.setting('url').'offers/category/'.$row['ResourceCategoryAlias'].'">'.$ResourceCategoryTitle.'</a></li>';
					}elseif((count($mas)>($i+1))and($mas[$i+1]['SectionLevel']>$level))
					{
//						$res .= '<li class="class"><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'" name="submenu" class="submenu"';
						if($level==1)
						{
							$res .= '<li class="class"><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'" name="submenu" class="submenu_7"';
//							$res .= ' style="background:#ffffff;"';
//							$res .= ' style="background:silver;"';
						}else{
							$res .= '<li class="class"><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'" name="submenu" class="submenu"';
						}
							$res .= '>'.$ResourceCategoryTitle.'</a>';
						$res .= '<ul style="margin: 0;padding: 0;">';
						$resm = createMenuLevelSections($mas,$mas[$i+1]['SectionLevel'],$i+1);
						$res .= $resm['html'];
						$i = $resm['pos']-1;
						if ($mas[$i+1]['SectionLevel']!=$level)
						while((($i+1)<count($mas))and($mas[$i+1]['SectionLevel']==$level))
						{
							$i++;
						}//*/
//						$res .= '-'.$i;
						$res .= '</ul>';
						$res .= '</li>';
					}
					else
					{
						$res .= '<li><a href="'.setting('url')/*.'offers/category/'*/.$row['SectionAlias'].'">'.$ResourceCategoryTitle.'</a></li>';
					/*
						while((($i+1)<count($mas))and($mas[$i+1]['ResourceCategoryLevel']!=$level))
						{
							$i++;
						}//*/
//						$res .= 'Error';
					}
					$i++;
				}//while
				$masres=array();
				$masres['pos']=$i;
				$masres['html']=$res;
				return $masres;
			}//function createMenuLevel($mas=array(),$level=0,$pos=0)
			//print_r($out['DB']['ResourceCategories']);
		?>
	<tr> 
	<td valign="top">
	<div id="leftmenu" align="left" style="float:left;">
		<div id="menu" align="left" style="float:left;" align="left">
			<ul id="menuList">
				<li><a href="javascript:popup('<?=setting('url')?><?=input('SID')?><?=getInputLink()?>/windowMode/print')" class="submenu_6"><?=lang('PrintOrder.resource.link')?></a></li>
			<?
//				print_r($out['DB']['ResourceCategories']);
				$resm = createMenuLevelSections($out['DB']['Sections'],1,0);
				echo $resm['html'];
			?>
			</ul>
		</div>
	</div>
	</td> 
	</tr>
	<tr>
		<td valign="top">
			<? if (hasRights('admin')) { ?>&nbsp;<a href="<?=setting('adminurl')?>manageSections/SectionGroupCode/main/frontBackLinkAction/save/"><?=lang('-editbox')?></a> <? } ?>
		</td>
	</tr>
	<? /* if(!empty($user['UserName'])) { ?>
		<?=lang('--welcomeback')?>  <b><?=user('FirstName')?> <?=user('LastName')?></b><br/><br/>
	<? } */ ?>
<?=boxFooter()?>
