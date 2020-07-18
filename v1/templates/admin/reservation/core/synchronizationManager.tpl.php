<?=boxHeader(array('title'=>'ScynhronizationManager.core.title'))?>
	<? if(!empty($out['DB']['SynchronizationItems'][0]['SynchronizationItemID'])) {?>
	<? if(user('UserName')=='superadmin') { ?>
	<tr> 
		<td valign="middle" width="100%" align="center">
			<br/>
			<a href="<?=setting('url').input('SID')?>/actionMode/cleandatabase/"><b>[<?=lang('CleanDatabaseSuperAdmin.core.link')?>]</b></a>
			<br/><br/>
		</td> 
	</tr>
	<? } ?>
	<form name="manageSynchronizationItems" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<tr> 
			<td valign="top" bgcolor="#efefef" class="fieldNames" width="100%" align="center">
				<span class="subtitle"><?=lang('ScynhronizationManagerIntro.core.tip','HTML')?></span>
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['SynchronizationItems'] as $id=>$row) {?>
					<input type="hidden" name="SynchronizationItem<?=DTR?>SynchronizationItemID[<?=$id?>]" value="<?=$row['SynchronizationItemID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13" alt="Type: <?=$row['SynchronizationItemType']?>, Categories: <?=$row['SynchronizationItemCategories']?>"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="SynchronizationItem<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="SynchronizationItem<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>		
						<td valign="top" class="row1" width="3%" align="center">
							<? if($row['SynchronizationItemStatus']=='old') { ?>
								<font color="#FF0000"><?=$row['SynchronizationItemStatus']?></font>
							<? } else { ?>
								<font color="green"><?=$row['SynchronizationItemStatus']?></font>
							<? } ?>
						</td>																					
						<td valign="top" class="row1" width="70%">
							<?=$row['SynchronizationItemName']?>
						</td>		
						<td valign="top" class="row1" width="30%">
							<?=getFormated($row['SynchronizationItemLastTime'],'DateTime')?>
						</td>											
					</tr>	
				<? } ?>				
				</table>		
			</td> 
		</tr> 
		<tr>
		<td>&nbsp;
		 
		</td>
		</tr>
		<tr> 
			<td valign=top bgcolor="#efefef" width="100%" align="center">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>
		<tr>
		<td>&nbsp;
		 
		</td>
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['SynchronizationItems'][0]['SynchronizationItemID'])) ?>
	<tr>
		<form name="DoScynhronization" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="actionMode" value="synchronize" />
			<td valign=top bgcolor="#ffffff">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
			<td align="center" width="100%" colspan="2">
			<span class="subtitle"><?=lang('ScynhronizationManagerStartIntro.core.tip','HTML')?></span>
			</td>
			</tr>
			<tr>
			<td>&nbsp;
			 
			</td>
			</tr>
			<tr>
			<td align="left">
			<span class="subtitle"><?=lang('SelectSynchronizationTypeBox.core.tip')?>: </span>
			</td>
			<td align="left">
			<?
				$inputValues='';
				$inputValues[0]['id']='';	
				$inputValues[0]['value']='- '.lang('SynchronizeAllBoxes.core.tip').' -';
				foreach($out['DB']['SynchronizationItems'] as $row) {
					if($row['PermAll']=='1')
					{
						$inputValues[$code]['id'] = $row['SynchronizationItemBox'];
						$inputValues[$code]['value'] = $row['SynchronizationItemName'];
					}
				}
				echo getLists($inputValues,'',array('name'=>'synchroBoxID'));	
			?>
			</td>
			</tr>
			<tr>
			<td align="left">
			<span class="subtitle"><?=lang('SelectSynchronizationType.core.tip')?>: </span>
			</td>
			<td align="left">
			<?=getReference('SynchronizationType','SynchronizationType','all',array('code'=>'Y'))?>
			</td>
			</tr>
			<tr>
		<td>&nbsp;
		 
		</td>
		</tr>
			<tr>
			<td align="center" bgcolor="#efefef" colspan="2">
			<input type="submit" name="DoScynhronization" value="<?=lang('DoScynhronization.core.button')?>" />
			</td>
			</tr>
			</table>
			</td> 
		</form>
	</tr>
	<? if(is_array($out['Results'])) { foreach($out['Results'] as $bixID=>$result) { ?>
	<tr>
		<td align="center" class="subtitleline">
			<span class="subtitle"><?=lang('SynchronizeResutlTitle.core.tip')?></span>
		</td>
	</tr>	
	<tr>
		<td valign="top" bgcolor="#ffffff">
			<b><?=$result['Name']?>: </b><br/>
			<?=lang('SynchronizeResutlStatus.core.tip')?>: <?=$result['Result']['Result']?><br/>
			<?=lang('SynchronizeResutlGetItems.core.tip')?>: <?=$result['Result']['Stats']['GetItems']?><br/>
			<?=lang('SynchronizeResutlPutItems.core.tip')?>: <?=$result['Result']['Stats']['PutItems']?><br/>
			<hr size="1"/>
		</td>
	</tr>
	<? } } ?>
<?=boxFooter()?>