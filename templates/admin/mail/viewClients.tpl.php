<form method="post" name="searchClients">
	<!-- <input type="hidden" name="pagesMethod" value="post"> -->
	<input type="hidden" name="SID" value="<?=input('SID')?>">
	<input type="hidden" name="pagesMethod" value="post">
	<?=boxHeader(array('title'=>lang('Clients.mail.title')))?>
		<tr> 
			<td class='subtitleline' align="left">
				<?				
					$options[0]['id'] = '';
					$options[0]['value'] = lang('ActiveClients.mail.tip');
					echo getReference('Mail.OrderClients','OrderClients',$input['OrderClients'],array('code'=>'Y','type'=>'dropdown','options'=>$options))
				?>
				<input name="SearchClients" type="text" size="20" value="<?=input('SearchClients')?>">
				<br/>
				<? 
					$Languages[0]['id'] = '';
					$Languages[0]['value'] = lang('AllLanguages.mail.option');
					$i=1;
					foreach($out['DB']['Languages']['languageCodes'] as $key=>$value){
						$Languages[$i]['id'] = $value;
						$Languages[$i]['value'] = $out['DB']['Languages']['languageNames'][$key];
						$i++;
					}
				?>
				<? echo getLists($Languages,$input['UserLanguage'],array('name'=>'UserLanguage','code'=>'Y','type'=>'dropdown','options'=>$options));?>
				<!-- <br/> -->
				<?
					$options[0]['id'] = '';
					$options[0]['value'] = lang('AllManagers.mail.tip');
				?>
				<? echo getLists($out['DB']['Managers'],$input['Managers'],array('name'=>'Managers','id'=>'UserID','value'=>'UserName','code'=>'Y','type'=>'dropdown','options'=>$options));?>
				<br/>
				<?
					
					$options[0]['id'] = 'breake';
					$options[0]['value'] = lang('viewBreakeToPage.mail.option');
					
					$options[1]['id'] = 'all';
					$options[1]['value'] = lang('viewAllClient.mail.option');

					echo getLists($options,$input['ClientMode'],array('name'=>'ClientMode','type'=>'dropdown'));
					$options = '';
				?>
				<?
					$options[0]['id'] = '';
					$options[0]['value'] = lang('SelectUserStatus.mail.option');
				?>
				<?=getReference('User.Status','UserStatus',$input['UserStatus'],array('code'=>'Y','type'=>'dropdown','options'=>$options))?>
				<br>
				<input type="submit" value="<?=lang('-search')?>">
			</td> 
		</tr> 
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('ClientsHistoryTitle.mail.tip')?></b>
			</td> 
		</tr>
	</form>
	<form method="post" name="sendClients">
		<input type="hidden" name="SID" value="sendclientsmessage">
		<input type="hidden" name="pagesMethod" value="post">
		<input type="hidden" name="ClientMode" value="all">
		<?=getInputForm()?>
		<? if(!empty($out['DB']['Clients'][0]['UserID'])) {?>
		<tr> 
			<td valign="top">
				<? foreach($out['DB']['Clients'] as $row) {?>
					<input type="checkbox" name="SendMessageUserID[<?=$row['UserID']?>]" value="<?=$row['UserID']?>" <? if(!empty($input['SendMessageUserID'][$row['UserID']])){?>checked<? }?>/>&nbsp;
						<a href="<?=setting('url')?><?=input('SID')?>/ReceiverID/<?=$row['UserID']?>" >
							<? if(!empty($row['FirstName']) || !empty($row['LastName'])){?>
								<b><?=$row['LastName']?> <?=$row['FirstName']?></b>
							<? }else{?>
								<b><?=$row['UserName']?></b>
							<? }?>
						</a>&nbsp;&nbsp;
						<? echo getListValue($out['DB']['Managers'],$row['OwnerParentID'],array('id'=>'UserID','value'=>'UserName'));?>
						<? /* a href="<?=setting('url')?>confirmregistrationuser/UserID/<?=$row['UserID']?>"><?=lang('logAsUser.mail.link')?></a>
						
						<!-- <a href="javascript://" onClick="popup('<?=setting('url')?>manageUser/UserID/<?=$row['UserID']?>/GroupID/<?=$row['GroupID']?>/windowMode/popup/')">
							<? //lang('EditUser.mail.link')?>
						</a> */ ?>
						<br>
				<? }?>
				<br>
			</td> 
		</tr>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="left">
				<input type="submit" value="<?=lang('-send')?>">&nbsp;
				<input type="button" value="<?=lang('-checkAll')?>" onClick="checkAll(true)">&nbsp;
				<input type="button" value="<?=lang('-UnCheckAll')?>" onClick="checkAll(false)">
				<br>
				<br>
			</td> 
		</tr> 
		<tr> 
			<td class='subtitleline' valign="middle" align=center>
				<?=getPages($out['pages']['Clients'])?>
			</td>
		</tr>
		<? }else{?>
		<tr> 
			<td valign="top" class="subtitleline" align="center">
				<?=lang('NoClientsFound.mail.tip')?>
			</td> 
		</tr>
		<? } ?>	
		
	<?=boxFooter()?>
</form>
<script language="JavaScript">
function checkAll(state){
	els = document.getElementsByTagName('input');
	for(var i=0;i<els.length;i++){
		inputel = els[i];
		if (inputel.type=='checkbox'){
			inputel.checked = state;
		}
	}
}
</script>