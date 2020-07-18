<?=boxHeader(array('title'=>lang('OfferWord.resource.tip').' '.$out['DB']['Resource']['ResourceID']))?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<table border="0" cellspacing="1" cellpadding="5" width="100%">
				<tr>
					<td valign="top" class="row1" align="center">
						<b><?=getValue($out['DB']['Resource']['ResourceTitle'])?></b>
						<br/><br/>
						<a href="#" onClick="javascript:popup('<?=setting('urlfiles').$out['DB']['Resource']['ResourceImage']?>','<?=setting('popupwith')?>','<?=setting('popupheight')?>')"><img src="<?=setting('urlfiles').$out['DB']['Resource']['ResourceImagePreview']?>" border="0" /></a>
					</td>	
				</tr>	
				<tr>
					<td valign="top" class="row1" width="70%">
						<?=getValue($out['DB']['Resource']['ResourceIntro'])?>
						<br/>
						<?=getValue($out['DB']['Resource']['ResourceDescription'])?>
					</td>
				</tr>
				<?=addBidForm($out)?>	
				<? //addToShopingCartForm($out)?>			
											
			</table>		
		</td> 
	</tr> 
<?=boxFooter()?>