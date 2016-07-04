<?=boxHeader()?>
<!-- 	<tr>
		<td align="center" valign="middle">
			<table cellspacing="0" cellpadding="0" align="center">	 -->
	<tr>
		<td align="center" valign="middle">
			<table cellspacing="0" cellpadding="0" align="center">	
				<tr>
					<td valign="middle" width="15px">&nbsp;
						
					</td>
					<? if(!empty($out['DB']['SupportMessage'])){?>
						<td valign="middle">	
							<img src="<?=setting('layout')?>images/alert_img.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;
						</td>	
						<td valign="middle">
							<a href="#" onClick="popup('http://coorda.com/coobox/support/support_mailbox.php?serial=<?=setting('SystemLicense')?>')"><?=lang('HaveSupportMessages.core.tip').'['.$out['DB']['SupportMessage'].']'?></a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }else{?>
						<td valign="middle"><img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;</td>
						<td valign="middle">	
							<?=lang('HaveSupportMessages.core.tip').'[0]'?>
						</td>	
						<td>&nbsp;&nbsp;</td>
					<? }?>
					<? if(!empty($out['DB']['newMessage'])){?>
						<td valign="middle">
							<img src="<?=setting('layout')?>images/alert_img.gif" width="9px" height="9px" border="0" alt=""/>&nbsp;
						</td>	
						<td valign="middle">
							<a href="<?=setting('rooturl')?>adm/mailboxadm" target="_parent">
								<?=lang('HaveMailboxMessages.core.tip').'['.count($out['DB']['newMessage']).']'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }else{?>
						<td valign="middle"><img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;</td>
						<td valign="middle">	
							<a href="<?=setting('rooturl')?>adm/mailboxadm" target="_parent">
								<?=lang('HaveMailboxMessages.core.tip').'[0]'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }?>
					<? if(!empty($out['DB']['LastProduct'])){?>
						<td valign="middle">
							<img src="<?=setting('layout')?>images/alert_img.gif" width="9px" height="9px" border="0" alt=""/>&nbsp;
						</td>	
						<td valign="middle">
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>viewLastProperty/windowMode/popup')"> -->
							<a href="<?=setting('adminurl')?>manageResources" target="_parent">
								<?=lang('product.core.tip').'['.count($out['DB']['LastProduct']).']'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }else{?>
						<td valign="middle"><img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;</td>
						<td valign="middle">	
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>viewLastProperty/windowMode/popup')"> -->
							<a href="<?=setting('adminurl')?>manageProperties" target="_parent">
								<?=lang('product.core.tip').'[0]'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }?>
					<? if(!empty($out['DB']['LastComments'])){?>
						<td valign="middle">
							<img src="<?=setting('layout')?>images/alert_img.gif" width="9px" height="9px" border="0" alt=""/>&nbsp;
						</td>	
						<td valign="middle">
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>viewLastComments/windowMode/popup')"> -->
							<a href="<?=setting('adminurl')?>manageResourceComments" target="_parent">	
								<?=lang('comment.core.tip').'['.count($out['DB']['LastComments']).']'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }else{?>
						<td valign="middle"><img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;</td>
						<td valign="middle">	
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>viewLastComments/windowMode/popup')"> -->
							<a href="<?=setting('adminurl')?>manageResourceComments" target="_parent">	
								<?=lang('comment.core.tip').'[0]'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }?>
					<? if(!empty($out['DB']['Agenda'])){?>
						<td valign="middle">
							<img src="<?=setting('layout')?>images/alert_img.gif" width="9px" height="9px" border="0" alt=""/>&nbsp;
						</td>	
						<td valign="middle">
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>comboard2/windowMode/popup')">
								<?=lang('agenda.core.tip').'['.count($out['DB']['Agenda']).']'?>
							</a> -->
							<a href="<?=setting('adminurl')?>comboard" target="_parent">
								<?=lang('agenda.core.tip').'['.count($out['DB']['Agenda']).']'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }else{?>
						<td valign="middle"><img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;</td>
						<td valign="middle">	
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>comboard2/windowMode/popup')">
								<?=lang('agenda.core.tip').'[0]'?>
							</a> -->
							<a href="<?=setting('adminurl')?>comboard" target="_parent">
								<?=lang('agenda.core.tip').'[0]'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }?>
					<? if(!empty($out['DB']['message'])){?>
						<td valign="middle">
							<img src="<?=setting('layout')?>images/alert_img.gif" width="9px" height="9px" border="0" alt=""/>&nbsp;
						</td>	
						<td valign="middle">
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>comboard2/windowMode/popup')"> -->
							<a href="<?=setting('adminurl')?>comboard" target="_parent">	
								<?=lang('message.core.tip').'['.count($out['DB']['message']).']'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }else{?>
						<td valign="middle"><img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;</td>
						<td valign="middle">	
							<!-- <a href="#" onClick="popup('<?=setting('adminurl')?>comboard2/windowMode/popup')"> -->
							<a href="<?=setting('adminurl')?>comboard" target="_parent">	
								<?=lang('message.core.tip').'[0]'?>
							</a>
						</td>
						<td>&nbsp;&nbsp;</td>
					<? }?>
					<!-- <td valign="middle">
						<img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;
					</td>
					<td valign="middle">	
						<?=lang('backoffice').'[0]'?>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;
					</td>
					<td valign="middle">	
						<?=lang('taskboard').'[0]'?>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;
					</td>
					<td valign="middle">	
						<?=lang('messenger').'[0]'?>
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="middle">
						<img src="<?=setting('layout')?>images/dotlightgrey.gif" border="0" width="9px" height="9px" alt=""/>&nbsp;
					</td>
					<td valign="middle">	
						<?=lang('blogtracker').'[0]'?>
					</td>
					<td>&nbsp;&nbsp;</td> -->
				</tr>
			</table>
		</td>
    </tr>
			<!-- </table>
		</td>
	</tr> -->
<?=boxFooter()?>
