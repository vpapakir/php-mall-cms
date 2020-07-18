<?=boxHeader(array('title'=>'ManageStyle.core.title'))?>
	<tr> 
	<form name="getStyles" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td valign="top" bgcolor="#ffffff">
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr bgcolor="#efefef">
		<td width="300" align="left">
			<span class="subtitle"><?=lang('SelectStyle.core.tip')?>:</span>
		</td>
		<td align="left">
			<?=getReference('ViewType','LayoutType',$out['Vars']['LayoutType'],array('code'=>'Y','action'=>'submit();'))?>
		</td>
		</tr>
		<tr>
		<td>
		&nbsp;
		</td>
		</tr>
		</table>
	</td> 
	</form>
	</tr> 
	<form name="manageStyle" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="LayoutType" value="<?=input('LayoutType')?>" />
		<tr> 
			<td valign="top" class="fieldNames" bgcolor="#ffffff" width="100%">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
				<tr>
				<td align="center">
					<textarea name="StyleContent" cols="85" rows="40" ><?=$out['Vars']['StyleFile']?></textarea>
				</td>
				</tr>
				<tr>
				<td>
				 &nbsp;
				</td>
				</tr>
				<tr>
				<td align="center" bgcolor="#efefef">
					<input type="submit" name="goSave" value="<?=lang('-save')?>" />
				</td>
				</tr>
				</table>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>