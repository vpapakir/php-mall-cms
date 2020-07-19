<? $formName = 'manageProperty';?>
<?=boxHeader(array('title'=>$title,'tabs'=>'manageProperty','formName'=>$formName,'tabslink'=>'PropertyID/'.input('PropertyID')))?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageProperty" />
		<input type="hidden" name="PropertyType" value="<?=input('PropertyType')?>" />	
		<input type="hidden" name="Property<?=DTR?>PropertyID" value="<?=$out['DB']['Property'][0]['PropertyID']?>">
		<input type="hidden" name="PropertyID" value="<?=$out['DB']['Property'][0]['PropertyID']?>">
		<input type="hidden" name="Property<?=DTR?>PropertyType" value="<?=$out['DB']['Property'][0]['PropertyType']?>">
		<input type="hidden" name="tabLink" value="main" />
		<input type="hidden" name="actionMode" value="save1"/>
		<input type="hidden" name="viewMode" value="main"/>
		<input type="hidden" name="Property<?=DTR?>PropertyStatus" value="<?=$out['DB']['Property'][0]['PropertyStatus']?>">
		<input type="hidden" name="Property<?=DTR?>PermAll" value="<?=$out['DB']['Property'][0]['PermAll']?>">
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellspacing="0" cellpadding="4" width="100%">
					<tr>
						<td align="center" class="subtitleline" colspan="2">
							<span class="subtitle"><?=lang('MainArea.property.subtitle')?></span>
						</td>
					</tr>
					<tr>
						<td width="20%">
							<img src="<?=setting('urlfiles')?><?=$out['DB']['Property'][0]['PropertyIcon']?>"/>
						</td>
						<td>
							<table width="100%">
								<tr>
									<td>
										<span class="subtitle"><?=getValue($out['DB']['Property'][0]['PropertyTitle']);?></span>
									</td>
								</tr>
								<tr>
									<td>
										<? $propertyType = $out['DB']['Property'][0]['PropertyType']; if(empty($propertyType)) {$propertyType=input('PropertyType');}?>
										<?=getListValue($out['DB']['PropertyTypes'],$propertyType,array('id'=>'PropertyTypeAlias','value'=>'PropertyTypeName'))?></b>
									</td>
								</tr>
								<tr>
									<td>
										<?=getFormated($out['DB']['Property'][0]['PropertyLocation'],'Location')?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getValue($out['DB']['Property'][0]['PropertyAddress'])?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getReferenceValue('Property.PropertyActionType',$out['DB']['Property'][0]['PropertyActionType'])?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getValue($out['DB']['Property'][0]['PropertyIntro']);?>
									</td>
								</tr>		
								<tr>
									<td>
										<?=getValue($out['DB']['Property'][0]['PropertyContent']);?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getFormated($out['DB']['Property'][0]['PropertyPrice'],'Money')?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td class="subtitleline" colspan="2" align="center">
							<span class="subtitle"><?=lang('ExtraFieldsArea.property.subtitle')?></span> <a href="<?=setting('url')?>managePropertyTypes/PropertyType/<?=input('PropertyType')?>" target="_blank">[<?=lang('EditPropertyExtraFields.property.link')?>]</a>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<? if(count($out['DB']['PropertyField'])>0) {?>
					<?=showExtraFieldsShow($out)?>
					<tr>
						<td class="subtitleline" colspan="2" align="center">
							<span class="subtitle"><?=lang('PropertyOptionsList.property.tip')?></span> <a href="<?=setting('url')?>managePropertyTypes/PropertyType/<?=input('PropertyType')?>" target="_blank">[<?=lang('EditPropertyExtraOptions.property.link')?>]</a>
						</td>
					</tr>
					<?=showExtraOptionsShow($out)?>
					<?  } ?>	
					<tr><td>&nbsp;</td></tr>
					</table>
				</td> 
			</tr> 
			<tr>
				<td align="center" class="subtitleline" colspan="2">
					<span class="subtitle"><?=lang('PropertyResourcies.property.subtitle')?></span>
				</td>
			</tr>
			<tr> 
				<td valign="top" bgcolor="#ffffff">
				<? foreach($out['DB']['Reference'] as $value){?>
					<? if(is_array($out['DB']['PropertyResourcies'][$value['OptionCode']]))
						{ 
							$t[$value['OptionCode']] = count($out['DB']['PropertyResourcies'][$value['OptionCode']]);?>
					 <? }
					}
				?>
				<? if(is_array($t)){foreach($out['DB']['Reference'] as $value){?>
					<? if(is_array($out['DB']['PropertyResourcies'][$value['OptionCode']])){ $total = count($out['DB']['PropertyResourcies'][$value['OptionCode']]);?>
					<br/><br/>
					<table class="subtitleline" width="100%" align="center">
						<tr>
							<td class="subtitle"><?=getValue($value['OptionName'])?></td>
						</tr>
					</table>
					<table border="0" cellspacing="1" cellpadding="0">
						<tr>
						<?  foreach($out['DB']['PropertyResourcies'][$value['OptionCode']] as $id=>$row) {  
									$i++; $k++;?>
							<td valign="top" width="100" align="center">
								<img src="<?=setting('layout')?>images/_clear.gif" width="100" height="1">
								<table cellpadding="0" cellspacing="2" border="0" width="100%">
									<!-- <tr>
										<td height="30" align="center" valign="top">
											<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources"><?=getValue($row['PropertyResourceName'])?></a>
										</td>
									</tr> -->
									<tr>
										<td align="center" valign="top">
											<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources"><?=getValue($row['PropertyResourceName'])?></a>
											<br/>
											<? if(!empty($row['PropertyResourceIcon'])){?>
												<a href="javascript://" onClick="popup('<?=setting('urlfiles').$row['PropertyResourceImage']?>')"><img src="<?=setting('urlfiles').$row['PropertyResourceIcon']?>" border="0"/></a>
												<br/>
											<? }?>
											<?=getValue($row['PropertyResourceDescription'])?>
											<br/>
											<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources"><?=lang('-edit')?></a>
										</td>
									</tr>
								</table>
							</td>
						<? if($i==4 && $k!=$total) { $i=0; ?>
						</tr>	
						<TR>
							<TD align="center" valign="top">
								<?
								echo $temp_store['1'];
								$temp_store['1']="";
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['2'];
									 $temp_store['2']="";
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['3'];
									$temp_store['3']="";
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['4'];
									$temp_store['4']="";
								?>
							</TD>
						</TR>
					</table>		
					<br/>
					<table border="0" cellspacing="1" cellpadding="0">
						<tr>
							<? } ?>
							<? }?>					
						</tr>	
						<TR>
							<TD align="center" valign="top">
								<?
									echo $temp_store['1'];
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['2'];
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['3'];
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['4'];
								?>
							</TD>
						</TR>
					</table>		
					<? }}}else{?>
						<table width="100%">
							<tr>
								<td align="center">
									<br/><br/>
									<?=lang('NoPropertyResourceFound.property.tip')?>
									<br/><br/>
								</td>
							</tr>	
						</table>
					<? }?>		
				</td> 
			</tr>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<input type="submit" value="<?=lang("-edit")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('<?=$formName?>', '<?=lang("-deleteconfirmation")?>');">
					&nbsp;&nbsp;<input type="button" value="<?=lang("SaveAndToListProperty.property.button")?>" onClick="document.<?=$formName?>.actionMode.value='cancell';document.<?=$formName?>.SID.value='manageProperties';submit();">
				</td>
			</tr>
	</form>	
<?=boxFooter()?>