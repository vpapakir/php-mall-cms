<?=boxHeader(array('title'=>'ManageViews.core.title'))?>
	<form name="selectView" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<tr> 
		<td valign=top bgcolor="#efefef" width="100%" align="center">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('ViewNew.core.tip').' -';
				echo getLists($out['DB']['Views'],$input['ViewID'],array('name'=>'ViewID','id'=>'ViewID','value'=>'ViewName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
			?>
		</td> 
	</tr>
	<tr><td>&nbsp;</td></tr> 
	</form>
	<form name="manageViews" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['View'][0]['ViewID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="View<?=DTR?>ViewID" value="<?=$out['DB']['View'][0]['ViewID'];?>" />
		<input type="hidden" name="ViewID" value="<?=$out['DB']['View'][0]['ViewID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
			 <tr>
			 <td align="left" width="300">
					<span class="subtitle"><?=lang('View.ViewAlias')?>: </span>
			</td>
			<td align="left">
					<input type="text" name="View<?=DTR?>ViewAlias" value="<?=$out['DB']['View'][0]['ViewAlias'];?>" size="50">
			</td>
			</tr>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('View.ViewType')?>: </span>
			</td>
			<td align="left">
					<?=getReference('ViewType','View'.DTR.'ViewType',$out['DB']['View'][0]['ViewType'],array('code'=>'Y'))?>
			</td>
			</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('View.ViewName')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?></span>
						</td>
						<td align="left">
							<input type="text" name="View<?=DTR?>ViewName[<?=$langCode?>]" value="<?=getValue($out['DB']['View'][0]['ViewName'],$langCode);?>" size="50">
						</td>
					</tr>	
					<? } ?>			
				<tr><td align="center" bgcolor="#efefef" colspan="2">
					<? if(empty($out['DB']['View'][0]['ViewID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageViews.actionMode.value='delete';confirmDelete('manageViews', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			 </td>
			 </tr>
			</table>
			</td> 
		</tr> 
	</form>	
	<? if(!empty($out['DB']['View'][0]['ViewID'])) { ?>	
	<form name="manageViewBoxes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="addbox" />
		<input type="hidden" name="ViewID" value="<?=$out['DB']['View'][0]['ViewID']?>" />
		<input type="hidden" name="ViewBox<?=DTR?>ViewID" value="<?=$out['DB']['View'][0]['ViewID'];?>" />
	<tr> 
		<td valign=top bgcolor="#ffffff" align="center">
			<?=lang('BuildLayout.core.tip')?>
			<br/><br/>				
			<table width="100%" border="0" cellspacing="1" cellpadding="5">
			  <tr>
				<td colspan="3" bgcolor="#AAAAAA" align="center">
				&nbsp;<br/>
				<? if(is_array($out['DB']['ViewBoxes'])) { foreach ($out['DB']['ViewBoxes'] as $row) { if($row['BoxSide']=='system') { ?>
					<b><? $boxID = $row['BoxID']; echo $out['DB']['BoxesDefinition'][$boxID]['name']?></b>
					<br/>
					<?=$row['BoxID']?>					
					<br/>
					
					<?=getListValue($out['DB']['Settings'],$row['BoxStyle'],array('name'=>'ViewBox'.DTR.'BoxStyle','id'=>'SettingVariableName','value'=>'SettingName'));?>					
					<br/>
					<a href="<?=setting('url').input('SID')?>/ViewID/<?=$out['DB']['View'][0]['ViewID']?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/actionMode/deletebox">[X]</a>
					&nbsp;
					<?
					$BoxPositionUp = $row['BoxPosition'] - 3;
					$BoxPositionDown = $row['BoxPosition'] + 3;
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionUp?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBox.core.tip')?>" hspace="3"  /></a>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionDown?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBox.core.tip')?>" hspace="3"  /></a>
					<hr size="1">
				<? } } } ?>				
				</td>
			  </tr>			
			  <tr>
				<td colspan="3" bgcolor="#DDDDDD" valign="top" align="center">
				&nbsp;<br/>
				<? if(is_array($out['DB']['ViewBoxes'])) { foreach ($out['DB']['ViewBoxes'] as $row) { if($row['BoxSide']=='top') { ?>
					<b><? $boxID = $row['BoxID']; echo $out['DB']['BoxesDefinition'][$boxID]['name']?></b>
					<br/>
					<?=$row['BoxID']?>					
					<br/>
					
					<?=getListValue($out['DB']['Settings'],$row['BoxStyle'],array('name'=>'ViewBox'.DTR.'BoxStyle','id'=>'SettingVariableName','value'=>'SettingName'));?>					
					<br/>
					<a href="<?=setting('url').input('SID')?>/ViewID/<?=$out['DB']['View'][0]['ViewID']?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/actionMode/deletebox">[X]</a>
					&nbsp;
					<?
					$BoxPositionUp = $row['BoxPosition'] - 3;
					$BoxPositionDown = $row['BoxPosition'] + 3;
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionUp?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBox.core.tip')?>" hspace="3"  /></a>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionDown?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBox.core.tip')?>" hspace="3"  /></a>
					<hr size="1">
				<? } } } ?>
				</td>
			  </tr>
			  <tr>
				<td width="25%" bgcolor="#DDDDDD" align="center" valign="top">
				&nbsp;<br/>
				<? if(is_array($out['DB']['ViewBoxes'])) { foreach ($out['DB']['ViewBoxes'] as $row) { if($row['BoxSide']=='left') { ?>
					<b><? $boxID = $row['BoxID']; echo $out['DB']['BoxesDefinition'][$boxID]['name']?></b>
					<br/>
					<?=$row['BoxID']?>					
					<br/>
					
					<?=getListValue($out['DB']['Settings'],$row['BoxStyle'],array('name'=>'ViewBox'.DTR.'BoxStyle','id'=>'SettingVariableName','value'=>'SettingName'));?>
					<br/>
					<a href="<?=setting('url').input('SID')?>/ViewID/<?=$out['DB']['View'][0]['ViewID']?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/actionMode/deletebox">[X]</a>
					&nbsp;
					<?
					$BoxPositionUp = $row['BoxPosition'] - 3;
					$BoxPositionDown = $row['BoxPosition'] + 3;
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionUp?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBox.core.tip')?>" hspace="3"  /></a>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionDown?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBox.core.tip')?>" hspace="3"  /></a>
					<hr size="1">
				<? } } } ?>				
				</td>
				<td width="50%"  align="center" valign="top">
				&nbsp;<br/>
				<? if(is_array($out['DB']['ViewBoxes'])) { foreach ($out['DB']['ViewBoxes'] as $row) { if($row['BoxSide']=='center') { ?>
					<b><? $boxID = $row['BoxID']; echo $out['DB']['BoxesDefinition'][$boxID]['name']?></b>
					<br/>
					<?=$row['BoxID']?>					
					<br/>
					
					<? echo getListValue($out['DB']['Settings'],$row['BoxStyle'],array('name'=>'ViewBox'.DTR.'BoxStyle','id'=>'SettingVariableName','value'=>'SettingName'));?>
					<br/>
					<a href="<?=setting('url').input('SID')?>/ViewID/<?=$out['DB']['View'][0]['ViewID']?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/actionMode/deletebox">[X]</a>
					&nbsp;
					<?
					$BoxPositionUp = $row['BoxPosition'] - 3;
					$BoxPositionDown = $row['BoxPosition'] + 3;
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionUp?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBox.core.tip')?>" hspace="3"  /></a>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionDown?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBox.core.tip')?>" hspace="3"  /></a>
					<hr size="1">
				<? } } } ?>		
					<b><?=lang('CenterBoxHint.core.tip')?></b>
					<hr size="1">				
				</td>
				<td width="25%" bgcolor="#DDDDDD"  align="center" valign="top">
				&nbsp;<br/>
				<? if(is_array($out['DB']['ViewBoxes'])) { foreach ($out['DB']['ViewBoxes'] as $row) { if($row['BoxSide']=='right') { ?>
					<b><? $boxID = $row['BoxID']; echo $out['DB']['BoxesDefinition'][$boxID]['name']?></b>
					<br/>
					<?=$row['BoxID']?>					
					<br/>
					
					<?=getListValue($out['DB']['Settings'],$row['BoxStyle'],array('name'=>'ViewBox'.DTR.'BoxStyle','id'=>'SettingVariableName','value'=>'SettingName'));?>				
					<br/>
					<a href="<?=setting('url').input('SID')?>/ViewID/<?=$out['DB']['View'][0]['ViewID']?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/actionMode/deletebox">[X]</a>
					&nbsp;
					<?
					$BoxPositionUp = $row['BoxPosition'] - 3;
					$BoxPositionDown = $row['BoxPosition'] + 3;
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionUp?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBox.core.tip')?>" hspace="3"  /></a>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionDown?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBox.core.tip')?>" hspace="3"  /></a>
					<hr size="1">
				<? } } } ?>					
				</td>
			  </tr>
			  <tr>
				<td colspan="3" bgcolor="#DDDDDD" align="center">
				&nbsp;<br/>
				<? if(is_array($out['DB']['ViewBoxes'])) { foreach ($out['DB']['ViewBoxes'] as $row) { if($row['BoxSide']=='bottom') { ?>
					<b><? $boxID = $row['BoxID']; echo $out['DB']['BoxesDefinition'][$boxID]['name']?></b>
					<br/>
					<?=$row['BoxID']?>					
					<br/>
					
					<?=getListValue($out['DB']['Settings'],$row['BoxStyle'],array('name'=>'ViewBox'.DTR.'BoxStyle','id'=>'SettingVariableName','value'=>'SettingName'));?>					
					<br/>
					<a href="<?=setting('url').input('SID')?>/ViewID/<?=$out['DB']['View'][0]['ViewID']?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/actionMode/deletebox">[X]</a>
					&nbsp;
					<?
					$BoxPositionUp = $row['BoxPosition'] - 3;
					$BoxPositionDown = $row['BoxPosition'] + 3;
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionUp?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBox.core.tip')?>" hspace="3"  /></a>
					<a href="<?=setting('url')?><?=input('SID')?>/ViewBox<?=DTR?>BoxPosition/<?=$BoxPositionDown?>/ViewBox<?=DTR?>ViewBoxID/<?=$row['ViewBoxID']?>/ViewID/<?=$row['ViewID']?>/actionMode/savebox"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBox.core.tip')?>" hspace="3"  /></a>
					<hr size="1">
				<? } } } ?>				
				</td>
				</tr>
			</table>
			<table width="70%" border="0" cellspacing="0" cellpadding="5">
			  <tr>
				<td>
					<?
						$inputValues='';
						foreach($out['DB']['BoxesDefinition'] as $code=>$value) {
							if($value['type']==$out['DB']['View'][0]['ViewType'] || empty($value['type']))
							{
								if(empty($prevModule)) {$prevModule = $out['DB']['BoxesDefinition'][$code]['module'];}
								if($prevModule!=$out['DB']['BoxesDefinition'][$code]['module'])
								{
									$inputValues[$code.'1']['id'] = '';
									$inputValues[$code.'1']['value'] = '=================='.$out['DB']['BoxesDefinition'][$code]['module'].'=================';
								}
								$inputValues[$code]['id'] = $code;
								$inputValues[$code]['value'] = $value['name'].' - '.$out['DB']['BoxesDefinition'][$code]['module'];
								$prevModule = $out['DB']['BoxesDefinition'][$code]['module'];
							}
						}
						echo getLists($inputValues,'',array('name'=>'ViewBox'.DTR.'BoxID'));	
					?>							
				</td>
				<td>
					<? echo getLists($out['DB']['Settings'],'',array('name'=>'ViewBox'.DTR.'BoxStyle','id'=>'SettingVariableName','value'=>'SettingName'));?>
					<? if(hasRights('admin')) {?><a href="<?=setting('url')?>manageSettings/Level2GroupID/11365480442006051812025318f111"><?=lang('-editbox')?></a><? }?>
				</td>
				<td>
					<?=getReference('ViewBox.BoxSide','ViewBox'.DTR.'BoxSide',$sectionRS[0]['PermAll'],array('code'=>'Y'))?>			
				</td>
				<td>&nbsp;</td>
			  </tr>
			</table>			
			<input type="submit" value="<?=lang("-add")?>">
		</td> 
	</tr>	
	</form>
	<form name="copyView" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="ViewID" value="<?=$out['DB']['View'][0]['ViewID']?>" />
			
		<input type="hidden" name="actionMode" value="copyview" />
		<tr> 
			<td valign=top bgcolor="#ffffff" align="center">
				<?=lang('CopyLayout.core.tip')?>
				<br/><br/>
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('CopyView.core.tip').' -';
					echo getLists($out['DB']['Views'],'',array('name'=>'selectedViewID','id'=>'ViewID','value'=>'ViewName','style'=>'width:300px;','options'=>$options),$mode);	
				?>		
				<br/><br/>
				<input type="submit" value="<?=lang("CopyLayout.core.button")?>">
			</td> 
		</tr>	
	</form>	
	<? } ?>
<?=boxFooter()?>