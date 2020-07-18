<?=boxHeader(array('title'=>'ManageServices.billing.title'))?>
<? $categoryID = input('CategoryID'); $serviceType = input('ServiceType'); ?>
	<tr> 
	<form name="getServices" method="post">
	<input type="hidden" name="SID" value="manageServices" />
	<input type="hidden" name="ServiceType" value="<?=input('ServiceType')?>" />
	<td valign=top bgcolor="#ffffff">
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectServiceCategoriesForList.billing.tip');
		//print_r($out['DB']['ServiceCategories']);
		echo getLists($out['DB']['ServiceCategories'],$categoryID,array('name'=>'CategoryID','id'=>'id','value'=>'value','action'=>'submit();','options'=>$options))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectServicePermAll.billing.tip');
		echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
	?>	
	<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
	</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['Services'][0]['ServiceID'])) {?>
	<form name="manageServices" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageServices" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="ServiceType" value="<?=input('ServiceType')?>" />
		<input type="hidden" name="ServiceFeaturedOption" value="<?=input('ServiceFeaturedOption')?>" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<input type="hidden" name="ServiceStatus" value="<?=input('ServiceStatus')?>" />
		<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageService/CategoryID/<?=input('CategoryID')?>/ServiceType/<?=input('ServiceType')?>" class="boldLink">[<?=lang('AddService.billing.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Services'] as $id=>$row) {?>
					<input type="hidden" name="Service<?=DTR?>ServiceID[<?=$id?>]" value="<?=$row['ServiceID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13" alt="Type: <?=$row['ServiceType']?>, Categories: <?=$row['ServiceCategories']?>"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="Service<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="Service<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>	
						<td valign="top" align="center" class="row1" width="1%">
							<? if(!empty($row['ServiceIcon'])) { ?>
								<img src="<?=setting('urlfiles').$row['ServiceIcon']?>" border="0"/>
							<? } else {?>
							<img src="<?=setting('layout')?>images/icons/nopicture.gif" width="15" height="13"/>
							<? }?>
						</td>																
						<td valign="top" class="row1" width="50%">
							<?=getValue($row['ServiceTitle'])?>
						</td>
						<td valign="top" class="row1" width="20%" align="center">
							<? if($row['ServicePrice']>0) { ?>
							<?=getFormated($row['ServicePrice'],'Money')?>
							<? } else { ?>
								<?=$row['ServiceCommission']?> %
							<? } ?>
						</td>						
						<!--td valign="top" class="row1">
							<?
							$ServicePositionUp = $row['ServicePosition'] - 3;
							$ServicePositionDown = $row['ServicePosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/Service<?=DTR?>ServicePosition/<?=$ServicePositionUp?>/Service<?=DTR?>ServiceID/<?=$row['ServiceID']?>/ServiceGroup/<?=$row['ServiceGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpService.billing.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/Service<?=DTR?>ServicePosition/<?=$ServicePositionDown?>/Service<?=DTR?>ServiceID/<?=$row['ServiceID']?>/GroupID/<?=$row['ServiceGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownService.billing.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageService/ServiceID/<?=$row['ServiceID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageServices/Service<?=DTR?>ServiceID/<?=$row['ServiceID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteService.billing.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['ServiceID']?>" onChange="selectLink('manageServices', 'manageR<?=$row['ServiceID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageService/ServiceID/<?=$row['ServiceID']?>/CategoryID/<?=input('CategoryID')?>/ServiceType/<?=input('ServiceType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageServices/Service<?=DTR?>ServiceID/<?=$row['ServiceID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/ServiceType/<?=input('ServiceType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageService/ServiceParentID/<?=$row['ServiceParentID']?>/GroupID/<?=input('GroupID')?>/ServicePosition/<? $newServicePosition=$row['ServicePosition'] + 1; echo $newServicePosition; ?>">[<?=lang('AddServiceAfter.billing.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageService/ServiceParentID/<?=$row['ServiceID']?>/GroupID/<?=input('GroupID')?>/ServicePosition/1">[<?=lang('AddServiceUnder.billing.link','nospace')?>]</a-->
						</td>										
					</tr>	
				<? } ?>					
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['Services'][0]['ServiceID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageService/CategoryID/<?=input('CategoryID')?>/ServiceType/<?=input('ServiceType')?>" class="boldLink">[<?=lang('AddService.billing.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoServiceFound.billing.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>