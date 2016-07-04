<? $formName = 'manageReservedProperty';?>
<?=boxHeader(array('title'=>$title,'tabs'=>'manageReservedProperty','formName'=>$formName,'tabslink'=>'ReservedPropertyID/'.input('ReservedPropertyID')))?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageReservedProperty" />
		<input type="hidden" name="ReservedPropertyType" value="<?=input('ReservedPropertyType')?>" />	
		<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyID" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>">
		<input type="hidden" name="ReservedPropertyID" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>">
		<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyType" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyType']?>">
		<input type="hidden" name="tabLink" value="main" />
		<input type="hidden" name="actionMode" value="save1"/>
		<input type="hidden" name="viewMode" value="main"/>
		<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyStatus" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyStatus']?>">
		<input type="hidden" name="ReservedProperty<?=DTR?>PermAll" value="<?=$out['DB']['ReservedProperty'][0]['PermAll']?>">
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellspacing="0" cellpadding="4" width="100%">
					<tr>
						<td align="center" class="subtitleline" colspan="2">
							<span class="subtitle"><?=lang('MainArea.reservedProperty.subtitle')?></span>
						</td>
					</tr>
					<tr>
						<td width="20%">
							<img src="<?=setting('urlfiles')?><?=$out['DB']['ReservedProperty'][0]['ReservedPropertyIcon']?>"/>
						</td>
						<td>
							<table width="100%">
								<tr>
									<td>
										<span class="subtitle"><?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyTitle']);?></span>
									</td>
								</tr>
								<tr>
									<td>
										<? $reservedPropertyType = $out['DB']['ReservedProperty'][0]['ReservedPropertyType']; if(empty($reservedPropertyType)) {$reservedPropertyType=input('ReservedPropertyType');}?>
										<?=getListValue($out['DB']['ReservedPropertyTypes'],$reservedPropertyType,array('id'=>'ReservedPropertyTypeAlias','value'=>'ReservedPropertyTypeName'))?></b>
									</td>
								</tr>
								<tr>
									<td>
										<?=getFormated($out['DB']['ReservedProperty'][0]['ReservedPropertyLocation'],'Location')?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyAddress'])?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getReferenceValue('ReservedProperty.ReservedPropertyActionType',$out['DB']['ReservedProperty'][0]['ReservedPropertyActionType'])?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyIntro']);?>
									</td>
								</tr>		
								<tr>
									<td>
										<?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyContent']);?>
									</td>
								</tr>
								<tr>
									<td>
										<?=getFormated($out['DB']['ReservedProperty'][0]['ReservedPropertyPrice'],'Money')?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td class="subtitleline" colspan="2" align="center">
							<span class="subtitle"><?=lang('ExtraFieldsArea.reservedProperty.subtitle')?></span> <a href="<?=setting('url')?>manageReservedPropertyTypes/ReservedPropertyType/<?=input('ReservedPropertyType')?>" target="_blank">[<?=lang('EditReservedPropertyExtraFields.reservedProperty.link')?>]</a>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<? if(count($out['DB']['ReservedPropertyField'])>0) {?>
					<?=showExtraFieldsShow($out)?>
					<tr>
						<td class="subtitleline" colspan="2" align="center">
							<span class="subtitle"><?=lang('ReservedPropertyOptionsList.reservedProperty.tip')?></span> <a href="<?=setting('url')?>manageReservedPropertyTypes/ReservedPropertyType/<?=input('ReservedPropertyType')?>" target="_blank">[<?=lang('EditReservedPropertyExtraOptions.reservedProperty.link')?>]</a>
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
					<span class="subtitle"><?=lang('ReservedPropertyResourcies.reservedProperty.subtitle')?></span>
				</td>
			</tr>
			<tr> 
				<td valign="top" bgcolor="#ffffff">
				<? foreach($out['DB']['Reference'] as $value){?>
					<? if(is_array($out['DB']['ReservedPropertyResourcies'][$value['OptionCode']]))
						{ 
							$t[$value['OptionCode']] = count($out['DB']['ReservedPropertyResourcies'][$value['OptionCode']]);?>
					 <? }
					}
				?>
				<? if(is_array($t)){foreach($out['DB']['Reference'] as $value){?>
					<? if(is_array($out['DB']['ReservedPropertyResourcies'][$value['OptionCode']])){ $total = count($out['DB']['ReservedPropertyResourcies'][$value['OptionCode']]);?>
					<br/><br/>
					<table class="subtitleline" width="100%" align="center">
						<tr>
							<td class="subtitle"><?=getValue($value['OptionName'])?></td>
						</tr>
					</table>
					<table border="0" cellspacing="1" cellpadding="0">
						<tr>
						<?  foreach($out['DB']['ReservedPropertyResourcies'][$value['OptionCode']] as $id=>$row) {  
									$i++; $k++;?>
							<td valign="top" width="100" align="center">
								<img src="<?=setting('layout')?>images/_clear.gif" width="100" height="1">
								<table cellpadding="0" cellspacing="2" border="0" width="100%">
									<!-- <tr>
										<td height="30" align="center" valign="top">
											<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/viewMode/resources"><?=getValue($row['ReservedPropertyResourceName'])?></a>
										</td>
									</tr> -->
									<tr>
										<td align="center" valign="top">
											<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/viewMode/resources"><?=getValue($row['ReservedPropertyResourceName'])?></a>
											<br/>
											<? if(!empty($row['ReservedPropertyResourceIcon'])){?>
												<a href="javascript://" onClick="popup('<?=setting('urlfiles').$row['ReservedPropertyResourceImage']?>')"><img src="<?=setting('urlfiles').$row['ReservedPropertyResourceIcon']?>" border="0"/></a>
												<br/>
											<? }?>
											<?=getValue($row['ReservedPropertyResourceDescription'])?>
											<br/>
											<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/viewMode/resources"><?=lang('-edit')?></a>
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
									<?=lang('NoReservedPropertyResourceFound.reservedProperty.tip')?>
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
					&nbsp;&nbsp;<input type="button" value="<?=lang("SaveAndToListReservedProperty.reservedProperty.button")?>" onClick="document.<?=$formName?>.actionMode.value='cancell';document.<?=$formName?>.SID.value='manageReservedProperties';submit();">
				</td>
			</tr>
	</form>	
<?=boxFooter()?>