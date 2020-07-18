<?=boxHeader(array('title'=>'ManageDomains.webcontrol.title'))?>
<? $categoryID = input('CategoryID'); $DomainType = input('DomainType'); ?>
	<tr>
	<td>
	<table>
	<tr> 
	<form name="getDomains" method="post">
	<input type="hidden" name="SID" value="manageDomains" />
	<input type="hidden" name="DomainType" value="<?=input('DomainType')?>" />
	<td valign=top bgcolor="#ffffff">
	<?
		/*$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectDomainTypeForList.webcontrol.tip');
		echo getLists($out['DB']['DomainTypes'],$DomainType,array('name'=>'DomainType','id'=>'DomainTypeAlias','value'=>'DomainTypeName','action'=>'submit();','options'=>$options));	
	*/?>	
	<?
		/*$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectDomainFeaturedOptions.webcontrol.tip');
		echo getReference('Domain.DomainFeaturedOptions','DomainFeaturedOption',$input['DomainFeaturedOption'],array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	*/?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectDomainPermAll.webcontrol.tip');
		echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	?>	
	<?
		/*$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectDomainStatusForList.webcontrol.tip');
		echo getReference('Domain.DomainStatus','DomainStatus',input('DomainStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	*/?>	
	<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
		<!-- &nbsp;&nbsp;<a href="<?=setting('url')?>manageDomainTypes">[<?=lang('EditDomainTypes.webcontrol.link')?>]</a> -->
	</td> 
	</form>
	<td>
	<form name="getDomain" method="post">
		<input type="hidden" name="SID" value="manageDomain" />
		<?
			$options[0]['id'] = '';
			$options[0]['value'] = lang('AllDomainList.webcontrol.tip');
			echo getLists($out['DB']['Domains'],input('DomainID'),array('name'=>'DomainID','id'=>'DomainID','value'=>'DomainName','action'=>'submit();','options'=>$options));	
		?>
	</form>
	</td>
	</tr> 
	</table>
	</td>
	</tr>
	<? if(!empty($out['DB']['Domains'][0]['DomainID'])) {?>
	<form name="manageDomains" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageDomains" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="DomainType" value="<?=input('DomainType')?>" />
		<input type="hidden" name="DomainFeaturedOption" value="<?=input('DomainFeaturedOption')?>" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<input type="hidden" name="DomainStatus" value="<?=input('DomainStatus')?>" />
		<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageDomain/CategoryID/<?=input('CategoryID')?>/DomainType/<?=input('DomainType')?>" class="boldLink">[<?=lang('AddDomain.webcontrol.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Domains'] as $id=>$row) {?>
					<input type="hidden" name="Domain<?=DTR?>DomainID[<?=$id?>]" value="<?=$row['DomainID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<a href="<?=setting('url')?>manageDomain/DomainID/<?=$row['DomainID']?>/"><img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" border="0" width="15" height="13" alt="Type: <?=$row['DomainType']?>, Categories: <?=$row['DomainCategories']?>"/></a>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="Domain<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="Domain<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>	
						<!-- <td valign="top" align="center" class="row1" width="1%">
							<? if(!empty($row['DomainIcon'])) { ?>
								<img src="<?=setting('urlfiles').$row['DomainIcon']?>" border="0"/>
							<? } else {?>
							<img src="<?=setting('layout')?>images/icons/nopicture.gif" width="15" height="13"/>
							<? }?>
						</td> -->																
						<td valign="top" class="row1" width="70%">
							<?=$row['DomainName']?>
						</td>
						<!-- <td valign="top" class="row1">
							<a href="<?=setting('url')?>managewebcontrolFiles/DomainID/<?=$row['DomainID']?>"><?=lang('viewGaleryProfile.webcontrol.link')?></a>
						</td> -->
						<!--td valign="top" class="row1">
							<?
							$DomainPositionUp = $row['DomainPosition'] - 3;
							$DomainPositionDown = $row['DomainPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/Domain<?=DTR?>DomainPosition/<?=$DomainPositionUp?>/Domain<?=DTR?>DomainID/<?=$row['DomainID']?>/DomainGroup/<?=$row['DomainGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpDomain.webcontrol.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/Domain<?=DTR?>DomainPosition/<?=$DomainPositionDown?>/Domain<?=DTR?>DomainID/<?=$row['DomainID']?>/GroupID/<?=$row['DomainGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownDomain.webcontrol.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageDomain/DomainID/<?=$row['DomainID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageDomains/Domain<?=DTR?>DomainID/<?=$row['DomainID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteDomain.webcontrol.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['DomainID']?>" onChange="selectLink('manageDomains', 'manageR<?=$row['DomainID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageDomain/DomainID/<?=$row['DomainID']?>/CategoryID/<?=input('CategoryID')?>/DomainType/<?=input('DomainType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageDomains/Domain<?=DTR?>DomainID/<?=$row['DomainID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/DomainType/<?=input('DomainType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageDomain/DomainParentID/<?=$row['DomainParentID']?>/GroupID/<?=input('GroupID')?>/DomainPosition/<? $newDomainPosition=$row['DomainPosition'] + 1; echo $newDomainPosition; ?>">[<?=lang('AddDomainAfter.webcontrol.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageDomain/DomainParentID/<?=$row['DomainID']?>/GroupID/<?=input('GroupID')?>/DomainPosition/1">[<?=lang('AddDomainUnder.webcontrol.link','nospace')?>]</a-->
						</td>										
					</tr>	
				<? } ?>				
				<tr>  
					<td valign="top" align="center" colspan="5"> 
						<?=getPages($out['pages']['Domains'])?>
					</td> 
				</tr>					
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['Domains'][0]['DomainID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageDomain/CategoryID/<?=input('CategoryID')?>/DomainType/<?=input('DomainType')?>" class="boldLink">[<?=lang('AddDomain.webcontrol.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoDomainFound.webcontrol.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>