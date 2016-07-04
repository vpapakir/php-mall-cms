<?=boxHeader(array('title'=>'ManageIndexPage.core.title'))?>
	<form name="manageRegions" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="save" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
						<? //foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<tr>
								<td valign="top" class="fieldNames">
									<span class="subtitle"><?=lang('PageMeta.core.tip')?></span>
									<br/><br/>
									<textarea name="Meta" cols="60" rows="20"><?=$out['DB']['Meta']?></textarea>
								</td>
							</tr>
							<tr>
								<td valign="top" class="fieldNames">
									<span class="subtitle"><?=lang('PageContent.core.tip')?></span>
									<br/><br/>
									<?=getFormated(getValue($out['DB']['Content'],$langCode),'HTML','form',array('fieldName'=>'Content','editorName'=>'pageContent','editorHeight'=>600))?>
									<!-- <textarea name="Content" cols="90" rows="40"><? //getValue($out['DB']['Content'])?></textarea> -->
								</td>
							</tr>
						<? //} ?>
						<tr>
							<td align="center" valign="middle" colspan="3">
								<br/><br/>
								<input type="submit" value="<?=lang("-save")?>">
							</td>
						</tr>		
					</table>	
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>