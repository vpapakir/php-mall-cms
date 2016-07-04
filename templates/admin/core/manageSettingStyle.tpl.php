	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			 <table border="0" cellspacing="0" cellpadding="0" width="950"> 
				<tr valign="top"> 
					<td height="129" width="260">
						<?
							if(ereg("color",$out['DB']['Setting'][0]['SettingVariableName']))
							{
								$color = $out;
							}
						?>
						<table border="0" cellspacing="1" cellpadding="3" bgcolor="#006699"> 
							<tr> 
								<td width="324" height="127" valign="middle" bgcolor="<?=$color['DB']['Setting'][0]['SettingValue']?>" align="center">
									<? //lang('ColorSample.core.tip')?>
								</td> 
							</tr> 
						</table>
					</td> 
					<td height="129" width="4"></td> 
					<td height="129" width="290">
						<?
							if(ereg("font",$out['DB']['Setting'][0]['SettingVariableName']))
							{
								$font = $out;
							}
							
							
							
							//echo $font['DB']['Setting'][0]['SettingValue'];
							$fontRS = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fonts'));
							$fontsizes = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontsizes'));
							$fontweights = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontweights'));
							$colorRS = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'color'));
							$fontstyles = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontstyles'));
							$fontdecorations = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontdecorations'));
							$linkcolor = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'linkcolor'));
							$hovercolor = getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'hovercolor'));
							$colorRS = getColor($colorRS,$out);
							$linkcolor = getColor($linkcolor,$out);
							$hovercolor = getColor($hovercolor,$out);
							
							
						?>
							<style type="text/css" >
								.fontstyle{
									 color:<?=$colorRS?>;
									 font-family:<?=$fonts?>; 
									 font-size:<?=$fontsizes?>; 
									 font-weight:<?=$fontweights?>; 
									 font-style:<?=$fontstyles?>;
								}
								.fontstyle a{
									color:<?=$linkcolor?>;
									text-decoration:<?=$fontdecorations?>;
								}
								.fontstyle a:hover{
									color:<?=$hovercolor?>;
									text-decoration:<?=$fontdecorations?>;
								}
							</style>
						  <table border="0" cellspacing="1" cellpadding="3" bgcolor="#006699"> 
							<tr> 
							  <td class="fontstyle" width="324" height="127" valign="top" bgcolor="#cccccc">
									<?=lang('TextFontSample.core.tip')?>
									<br/>
									<a href="#"><?=lang('LinkFontSample.core.tip')?></a>
							  </td> 
							</tr> 
						  </table>
						</td> 
						<td height="129" width="4"></td> 
						<td height="129" width="300">
								<?
									if(ereg("box",$out['DB']['Setting'][0]['SettingVariableName']))
										{
											$box = $out;
										}
									//echo $out['DB']['Setting'][0]['SettingVariableName'];
									
									
									$titlefont = getFont(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'titlefont')),$out);
									$titlefontside = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'titlefontside'));
									$subtitlefont = getFont(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlefont')),$out);
									$introductionfont = getFont(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'introductionfont')),$out);
									$textfont = getFont(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'textfont')),$out);
									$listingfont = getFont(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'listingfont')),$out);
									$commentfont = getFont(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'commentfont')),$out);
									$messagefont = getFont(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagefont')),$out);
									$border = getColor(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'border')),$out);
									$boxfill = getColor(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'boxfill')),$out);
									//$borderfontsizes = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'borderfontsizes'));
								  	$outerCP = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'outercellpadding'));
									$outerCS = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'outercellspacing'));
								  	$innerCP = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'innercellpadding'));
									$innerCS = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'innercellspacing'));
									$innerborder = getColor(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'innerborder')),$out);
									$header = getColor(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'header')),$out);
									$fontsizesheader = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontsizesheader'));
									$subtitlecell = getColor(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlecell')),$out);
									$subtitlecellfontsizes = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlecellfontsizes'));
									$messagecell = getColor(getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagecell')),$out);
									$messagecellfontsizes = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagecellfontsizes'));
									$subtitlefontside = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlefontside'));
									$introductionfontside = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'introductionfontside'));
									$textfontside = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'textfontside'));
									$listingfontside = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'listingfontside'));
									$commentfontside = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'commentfontside'));
									$messagefontside = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagefontside'));
									$messagecellfontsizes = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagecellfontsizes'));
									//print_r($titlefont);
								?>
								<style type="text/css" >
									.outertable{
										background-color:<? if(empty($border)){?>#0000ff<? }else{?><?=$border?><? }?>;
									}
									.innertable{
										background-color:<? if(empty($innerborder)){echo "#ffffff";}else{echo $innerborder;}?>;
									}
									.titlefont{
										color:<?=$titlefont['colorRS']?>; 
										font-family:<?=$titlefont['fontRS']?>; 
										font-size:<?=$titlefont['fontsizes']?>; 
										font-weight:<?=$titlefont['fontweights']?>; 
										font-style:<?=$titlefont['fontstyles']?>; 
										margin-top:<?=$titlefont['topmargin']?>; 
										margin-left:<?=$titlefont['leftmargin']?>; 
										margin-right:<?=$titlefont['rightmargin']?>; 
										margin-bottom:<?=$titlefont['bottommargin']?>;
										text-align:<?=$titlefontside?>;
										height:<?=$fontsizesheader?>;
										background-color:<? if(!empty($header)){echo $header;}?>;
									}
									
									.titlefont a{
										color:<?=$titlefont['linkcolor']?>;
										text-decoration:<?=$titlefont['fontdecorations']?>;
									}
									
									.titlefont a:hover{
										color:<?=$titlefont['hovercolor']?>;
										text-decoration:<?=$titlefont['fontdecorations']?>;
									}
									
									.subtitlefont{
										color:<?=$subtitlefont['colorRS']?>; 
										font-family:<?=$subtitlefont['fontRS']?>; 
										font-size:<?=$subtitlefont['fontsizes']?>; 
										font-weight:<?=$subtitlefont['fontweights']?>; 
										font-style:<?=$subtitlefont['fontstyles']?>; 
										margin-top:<?=$subtitlefont['topmargin']?>; 
										margin-left:<?=$subtitlefont['leftmargin']?>; 
										margin-right:<?=$subtitlefont['rightmargin']?>; 
										margin-bottom:<?=$subtitlefont['bottommargin']?>;
										height:<?=$subtitlecellfontsizes?>;
										text-align:<?=$subtitlefontside?>;
										background-color:<? if(!empty($subtitlecell)){echo $subtitlecell;}?>;
									}
									
									.subtitlefont a{
										color:<?=$subtitlefont['linkcolor']?>;
										text-decoration:<?=$subtitlefont['fontdecorations']?>;
									}
									
									.subtitlefont a:hover{
										color:<?=$subtitlefont['hovercolor']?>;
										text-decoration:<?=$subtitlefont['fontdecorations']?>;
									}
									
									.introductionfont{
										color:<?=$introductionfont['colorRS']?>; 
										font-family:<?=$introductionfont['fontRS']?>; 
										font-size:<?=$introductionfont['fontsizes']?>; 
										font-weight:<?=$introductionfont['fontweights']?>; 
										font-style:<?=$introductionfont['fontstyles']?>; 
										margin-top:<?=$introductionfont['topmargin']?>; 
										margin-left:<?=$introductionfont['leftmargin']?>; 
										margin-right:<?=$introductionfont['rightmargin']?>; 
										margin-bottom:<?=$introductionfont['bottommargin']?>;" 
										text-align:<?=$introductionfontside?>;
									}
									
									.introductionfont a{
										color:<?=$introductionfont['linkcolor']?>;
										text-decoration:<?=$introductionfont['fontdecorations']?>;
									}
									
									.introductionfont a:hover{
										color:<?=$introductionfont['hovercolor']?>;
										text-decoration:<?=$introductionfont['fontdecorations']?>;
									}
									
									.textfont{
										text-align:<?=$textfontside?>; 
										color:<?=$textfont['colorRS']?>; 
										font-family:<?=$textfont['fontRS']?>; 
										font-size:<?=$textfont['fontsizes']?>; 
										font-weight:<?=$textfont['fontweights']?>; 
										font-style:<?=$textfont['fontstyles']?>; 
										margin-top:<?=$textfont['topmargin']?>; 
										margin-left:<?=$textfont['leftmargin']?>; 
										margin-right:<?=$textfont['rightmargin']?>; 
										margin-bottom:<?=$textfont['bottommargin']?>;
									}
									
									.textfont a{
										color:<?=$textfont['linkcolor']?>;
										text-decoration:<?=$subtitlefont['fontdecorations']?>;
									}
									
									.textfont a:hover{
										color:<?=$textfont['hovercolor']?>;
										text-decoration:<?=$subtitlefont['fontdecorations']?>;
									}
									
									.listingfont{
										color:<?=$listingfont['colorRS']?>; 
										font-family:<?=$listingfont['fontRS']?>; 
										font-size:<?=$listingfont['fontsizes']?>; 
										font-weight:<?=$listingfont['fontweights']?>; 
										font-style:<?=$listingfont['fontstyles']?>; 
										margin-top:<?=$listingfont['topmargin']?>; 
										margin-left:<?=$listingfont['leftmargin']?>; 
										margin-right:<?=$listingfont['rightmargin']?>; 
										margin-bottom:<?=$listingfont['bottommargin']?>;
										text-align:<?=$listingfontside?>;
									}
									
									.listingfont a{
										color:<?=$listingfont['linkcolor']?>;
										text-decoration:<?=$listingfont['fontdecorations']?>;
									}
									
									.listingfont a:hover{
										color:<?=$listingfont['hovercolor']?>;
										text-decoration:<?=$listingfont['fontdecorations']?>;
									}
									
									.commentfont{
										color:<?=$commentfont['colorRS']?>; 
										font-family:<?=$commentfont['fontRS']?>; 
										font-size:<?=$commentfont['fontsizes']?>; 
										font-weight:<?=$commentfont['fontweights']?>; 
										font-style:<?=$commentfont['fontstyles']?>; 
										margin-top:<?=$commentfont['topmargin']?>; 
										margin-left:<?=$commentfont['leftmargin']?>; 
										margin-right:<?=$commentfont['rightmargin']?>; 
										margin-bottom:<?=$commentfont['bottommargin']?>;
										text-align:<?=$commentfontside?>;
									}
									
									.commentfont a{
										color:<?=$commentfont['linkcolor']?>;
										text-decoration:<?=$commentfont['fontdecorations']?>;
									}
									
									.commentfont a:hover{
										color:<?=$commentfont['hovercolor']?>;
										text-decoration:<?=$commentfont['fontdecorations']?>;
									}
									
									.messagefont{
										color:<?=$messagefont['colorRS']?>; 
										font-family:<?=$messagefont['fontRS']?>; 
										font-size:<?=$messagefont['fontsizes']?>; 
										font-weight:<?=$messagefont['fontweights']?>; 
										font-style:<?=$messagefont['fontstyles']?>; 
										margin-top:<?=$messagefont['topmargin']?>; 
										margin-left:<?=$messagefont['leftmargin']?>; 
										margin-right:<?=$messagefont['rightmargin']?>; 
										margin-bottom:<?=$messagefont['bottommargin']?>;
										text-align:<?=$messagefontside?>;
										background-color:<? if(!empty($messagecell)){echo $messagecell;}?>;
									}
									
									.messagefont a{
										color:<?=$messagefont['linkcolor']?>;
										text-decoration:<?=$messagefont['fontdecorations']?>;
									}
									
									.messagefont a:hover{
										color:<?=$messagefont['hovercolor']?>;
										text-decoration:<?=$messagefont['fontdecorations']?>;
									}
								</style>
							<table border="0" class="outertable" cellspacing="<?=$outerCS?>" cellpadding="<?=$outerCP?>">	
								<tr>
									<td>
										<table width="100%" height="100%" class="innertable" cellspacing="<?=$innerCS?>" cellpadding="<?=$innerCP?>">
										<tr> 
											<td width="324" class="titlefont" valign="middle">
												<?=lang("TitleFont.core.tip") ?>
												<a href="#"><?=lang('Link.core.tip')?></a>
											</td> 
										</tr> 
										<tr> 
											<td width="324" class="messagefont" height="23" valign="middle">
												<?=lang("MessageFont.core.tip") ?>
												<a href="#"><?=lang('Link.core.tip')?></a>
											</td> 
										</tr> 
										<tr> 
											<td width="324" height="57" valign="top" style="background-color:<? if(!empty($boxfill)){echo $boxfill;}?>;">
												<p class="introductionfont">
													<?=lang("IntroductionFont.core.tip") ?> &nbsp;
													<a href="#"><?=lang('Link.core.tip')?></a>
												</p>
												<p class="textfont">
													<?=lang("TextFont.core.tip") ?>
													<a href="#"><?=lang('Link.core.tip')?></a>
												</p>
												<p class="listingfont"><?=lang("ListingFont.core.tip") ?>
													<a href="#"><?=lang('Link.core.tip')?></a>
												</p> 
												<p class="commentfont">
													<?=lang("CommentFont.core.tip") ?>
													<a href="#"><?=lang('Link.core.tip')?></a>
												</p>
											</td>
										</tr>
										<tr> 
											<td width="324" class="subtitlefont" valign="middle">
												<?=lang("SubtitleFont.core.tip") ?>
												<a href="#"><?=lang('Link.core.tip')?></a>
											</td> 
										</tr> 
										</table>
									</td>
								</tr>
							</table>
						</td> 
						<td height="129"></td> 
					</tr> 
				</table> 
			</td>
		</tr>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="0" cellpadding="0" width="950"> 
					<tr valign="top"> 
						<td height="554">
							<table> 
								<tr> 
									<td valign="top">
										<table width="100%" border="0" cellspacing="1" cellpadding="3" class="managestyle" bgcolor="#eeeeee">
											<tr>
												<td width="330" height="23" colspan="2" valign="middle" bgcolor="#ffffff" align="center"><span style="color:#069; font-weight:bold;"><?=lang('Colors.setting.tip')?></span></td> 
											</tr>
											<tr>	
												<td align="center" width="330" height="30" colspan="2" valign="middle" bgcolor="#006699">
													<form name="getSettingColor" method="post" enctype="multipart/form-data"> 
														<input type="hidden" name="SID" value="<?=input('SID')?>" />
														<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
														<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
														<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
													  <? //print_r($out['DB']['Settings']); 
														$colors[0]['id'] = " ";
														$colors[0]['name'] = lang('NewCreateColor.core.tip');
														
														foreach($out['DB']['Settings'] as $k=>$row) {
															if(ereg("color",$row['SettingVariableName']))
															{
																$colors[$k+1]['id'] = $row['SettingID'];
																$colors[$k+1]['name'] = getValue($row['SettingName']);
															}
														} 
														echo getLists($colors,input('SettingID'),array('name'=>'SettingID','id'=>'id','value'=>'name','action'=>'submit();'));
														$colors='';
													  ?>
													</form>
												</td>
											</tr>
											<?
												if(ereg("color",$out['DB']['Setting'][0]['SettingVariableName']))
												{
													$color = $out;
												}
											?>
											<form name="manageSettingColor" method="post" enctype="multipart/form-data">
												<input type="hidden" name="SID" value="<?=input('SID')?>" />
												<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
												<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
												<input type="hidden" name="SettingID" value="<?=input('SettingID')?>" />
												<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />			
												<input type="hidden" name="Setting<?=DTR?>SettingGroup" value="<?=input('Level2GroupID')?>" />
												<? if(empty($color['DB']['Setting'][0]['SettingID'])) { ?>
												<input type="hidden" name="actionMode" value="add" />
												<? } else { ?>
												<input type="hidden" name="actionMode" value="save1" />
												<input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$color['DB']['Setting'][0]['SettingID']?>">
												<? } ?>
												<? if(empty($color['DB']['Setting'][0]['SettingID'])) { ?>
												<tr>
													<td width="123" height="26" valign="middle" bgcolor="#ffffff"><?=lang('ColorCode.core.tip')?>*</td> 
													<td width="206" height="26" valign="middle" bgcolor="#ffffff">
													  <input type="text" name="Setting<?=DTR?>SettingVariableName" value="<?=$color['DB']['Setting'][0]['SettingVariableName']?>" size="30"> 
													</td>
												 </tr>
												 <? }else{?>
													<tr>
														<td width="123" height="26" valign="middle" bgcolor="#ffffff"><?=lang('ColorCode.core.tip')?>*</td> 
														<td width="206" height="26" valign="middle" bgcolor="#ffffff">
														  <input type="hidden" name="Setting<?=DTR?>SettingVariableName" value="<?=$color['DB']['Setting'][0]['SettingVariableName']?>" size="30">
														  <input type="text" name="Setting<?=DTR?>SettingVariableName" value="<?=$color['DB']['Setting'][0]['SettingVariableName']?>" size="30" disabled> 
														</td>
													 </tr>
												 <? }?>
												<tr>
													<td width="123" height="26" valign="middle" bgcolor="#ffffff"><?=lang('ColorName.core.tip')?></td> 
													<td width="206" height="26" valign="middle" bgcolor="#ffffff">
													  <? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
															<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
																<?=$out['DB']['Languages']['languageNames'][$langID]?>
															<? }?>
															<br/>
															<input type="text" name="Setting<?=DTR?>SettingName[<?=$langCode?>]" size="30" value="<?=getValue($color['DB']['Setting'][0]['SettingName'],$langCode);?>">
															<br/>
														<? } ?>
													  	<!-- <input type="text" name="Setting<?=DTR?>SettingName" value="<?=getValue($color['DB']['Setting'][0]['SettingName']);?>" size="15"> -->
													</td>
												 </tr>
												 <tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('ColorHex.core.tip')?></td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
													  <? //print_r($out['DB']['Setting']);?>
													  <?=getFormated($color['DB']['Setting'][0]['SettingValue'],'Color','form',array('fieldName'=>'Setting'.DTR.'SettingValue','formName'=>'manageSettingColor'))?>
													  <!-- <input name="Setting<?=DTR?>SettingValue" value="<? //$out['DB']['Setting'][0]['SettingValue'];?>" size=12>  -->
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>	
													<td width="123" height="34" valign="middle" bgcolor="#ffffff">&nbsp;</td> 
													<td width="206" height="34" valign="middle" bgcolor="#ffffff">&nbsp; 
													</td>
												</tr>
												<tr>
													<td align="center" width="330" height="29" colspan="2" valign="middle" bgcolor="#006699"><p class="style38 _lp"> 
													  <!-- <input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingColor.Setting<?=DTR?>SettingVariableName.value = 'color.'+document.manageSettingColor.Setting<?=DTR?>SettingName.value;document.manageSettingColor.submit();">  -->
														<? if(empty($color['DB']['Setting'][0]['SettingID'])) { ?>
															<input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingColor.Setting<?=DTR?>SettingVariableName.value = 'color.'+document.manageSettingColor.Setting<?=DTR?>SettingVariableName.value;document.manageSettingColor.submit();"> 
														<? }else{?>
															<input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingColor.submit();"> 
														<? }?>
														<input type="button" value="<?=lang("-copy")?>" onClick="document.manageSettingColor.Setting<?=DTR?>SettingID.value = '';document.manageSettingColor.Setting<?=DTR?>SettingName.value = 'copy'+document.manageSettingColor.Setting<?=DTR?>SettingName.value;"> 
														<input type="button" value="<?=lang("-delete")?>" onClick="document.manageSettingColor.actionMode.value='delete';confirmDelete('manageSettingColor', '<?=lang("-deleteconfirmation")?>');">
													</td>
												</tr>
											</form>
										</table>
									</td>
									<td valign="top">
										<table width="100%" border="0" cellspacing=1 cellpadding=3 class="managestyle" bgcolor="#eeeeee">
										<tr>  
								  			<td width=330 height=23 colspan=2 valign=middle align="center"><span style="color:#069;font-weight:bold;"><?=lang('Fonts.setting.tip')?></span></td> 
								  		</tr>
										<tr>
											<td align="center" width=330 height=30 colspan=2 valign=middle bgcolor="#006699"> 
												<form name="getSettingFont" method="post" enctype="multipart/form-data"> 
												    <input type="hidden" name="SID" value="<?=input('SID')?>" />
													<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
													<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
													<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
													<? //print_r($out['DB']['Settings']); 
														$fonts[0]['id'] = " ";
														$fonts[0]['name'] = lang('CreateNewFont.core.tip');
														
														foreach($out['DB']['Settings'] as $k=>$row) {
															if(ereg("font",$row['SettingVariableName']))
															{
																$fonts[$k+1]['id'] = $row['SettingID'];
																$fonts[$k+1]['name'] = getValue($row['SettingName']);
															}
														} 
														echo getLists($fonts,input('SettingID'),array('name'=>'SettingID','id'=>'id','value'=>'name','action'=>'submit();'));
														$fonts='';
													?>
												</form>
											</td>
										</tr>
										<?
											if(ereg("font",$out['DB']['Setting'][0]['SettingVariableName']))
												{
													$font = $out;
												}
												
											$i=1;
											$colors[0]['id'] = ' ';
											$colors[0]['name'] = lang('noneColor.core.tip');
											foreach($out['DB']['Settings'] as $k=>$row) {
												if(ereg("color",$row['SettingVariableName'])){
													$colors[$i]['id'] = $row['SettingVariableName'];
													$colors[$i]['name'] = getValue($row['SettingName']);
													$i++;
												}
											}
										?>
										<form name="manageSettingFonts" method="post" enctype="multipart/form-data">
											<input type="hidden" name="SID" value="<?=input('SID')?>" />
											<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
											<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
											<input type="hidden" name="SettingID" value="<?=input('SettingID')?>" />
											<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
											<? if(empty($font['DB']['Setting'][0]['SettingID'])) { ?>
											<input type="hidden" name="actionMode" value="add" />
											<? } else { ?>
											<input type="hidden" name="actionMode" value="save1" />
											<input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$font['DB']['Setting'][0]['SettingID']?>">
											<? } ?>	
											<input type="hidden" name="Setting<?=DTR?>SettingGroup" value="<?=input('Level2GroupID')?>" />
										<? if(empty($font['DB']['Setting'][0]['SettingID'])) { ?>
											<tr>
												<td width="123" height="26" valign="middle"><?=lang('FontsCode.core.tip')?>*</td> 
												<td width="206" height="26" valign="middle">
												  <input type="text" name="Setting<?=DTR?>SettingVariableName" value="<?=$font['DB']['Setting'][0]['SettingVariableName']?>" size="30"> 
												</td>
											 </tr>
										<? }else{?>
										 	<tr>
												<td width="123" height="26" valign="middle"><?=lang('FontsCode.core.tip')?>*</td> 
												<td width="206" height="26" valign="middle">
												  <input type="hidden" name="Setting<?=DTR?>SettingVariableName" value="<?=$font['DB']['Setting'][0]['SettingVariableName']?>" size="30">
												  <input type="text" name="Setting<?=DTR?>SettingVariableName" value="<?=$font['DB']['Setting'][0]['SettingVariableName']?>" size="30" disabled> 
												</td>
											 </tr>
										 <? }?>
										<tr>
											<td width="123" height="26" valign="middle"><?=lang('NameFonts.core.tip')?>*</td> 
											<td width="206" height="26" valign="middle">
												<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
													<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
														<?=$out['DB']['Languages']['languageNames'][$langID]?>
													<? }?>
													<br/>
													<input type="text" name="Setting<?=DTR?>SettingName[<?=$langCode?>]" size="30" value="<?=getValue($font['DB']['Setting'][0]['SettingName'],$langCode);?>">
													<br/>
												<? } ?>
												<!-- <input type="hidden" name="Setting<?=DTR?>SettingVariableName" value="" size="30">
												<input type="text" name="Setting<?=DTR?>SettingName" value="<? //getValue($font['DB']['Setting'][0]['SettingName']);?>" size="15"> -->
											</td>
										</tr>
								  		<tr>
											<td width="123" height="34" valign="middle"><?=lang('StyleFonts.core.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												<?=getReference('fonts','Setting'.DTR.'SettingValue[fonts]',getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fonts')),array('code'=>'Y'));?>
												<!-- <br/>
												<input name="item3" value="Verdana,Arial,Helvetica,sans-serif" size=12> --> 
											</td>
										</tr>
										<tr>
											<td width="123" height="34" valign="middle"><?=lang('Setting.SettingDescription')?></td> 
											<td width="206" height="34" valign="middle"> 
												<input type="text" name="Setting<?=DTR?>SettingDescription" value="<?=getValue($font['DB']['Setting'][0]['SettingDescription']);?>">
											</td>
										</tr>
								  		<tr>
											<td width="123" height="34" valign="middle"><?=lang('StyleSize.core.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												<?=getReference('fontsizes','Setting'.DTR.'SettingValue[fontsizes]',getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontsizes')),array('code'=>'Y'));?>
											</td>
										</tr>
										<tr>
											<td width="123" height="34" valign="middle"><?=lang('StyleWeights.core.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												<?=getReference('fontweights','Setting'.DTR.'SettingValue[fontweights]',getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontweights')),array('code'=>'Y'));?>
											</td>
										</tr>
										<tr>
											<td width="123" height="34" valign="middle"><?=lang('StyleColor.core.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												  <? echo getLists($colors,getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'color')),array('name'=>'Setting'.DTR.'SettingValue[color]','id'=>'id','value'=>'name'));?> 
											</td>
										</tr>
										<tr>
											<td width="123" height="34" valign="middle"><?=lang('StyleFontStyles.setting.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												<?=getReference('fontstyles','Setting'.DTR.'SettingValue[fontstyles]',getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontstyles')),array('code'=>'Y'));?>
											</td>
										</tr>
										<tr>
											<td width="123" height="34" valign="middle"><?=lang('Decoration.core.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												  <?=getReference('fontdecorations','Setting'.DTR.'SettingValue[fontdecorations]',getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontdecorations')),array('code'=>'Y'));?> 
											 </td>
										</tr>
										<tr>
											<td width="123" height="34" valign="middle"><?=lang('LinkColor.core.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												  <? echo getLists($colors,getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'linkcolor')),array('name'=>'Setting'.DTR.'SettingValue[linkcolor]','id'=>'id','value'=>'name'));?> 
											</td> 
										</tr>
										<tr>
											<td width="123" height="34" valign="middle"><?=lang('HoverColor.core.tip')?></td> 
											<td width="206" height="34" valign="middle"> 
												  <? echo getLists($colors,getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'hovercolor')),array('name'=>'Setting'.DTR.'SettingValue[hovercolor]','id'=>'id','value'=>'name'));?>  
											</td> 
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle"><?=lang('Margins.core.tip')?></td> 
											<td width="206" height="34" valign="middle">
												T&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[topmargin]" value="<?=getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'topmargin'))?>" size="2"/>
												L&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[leftmargin]" value="<?=getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'leftmargin'))?>" size="2"/>
												R&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[rightmargin]" value="<?=getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'rightmargin'))?>" size="2"/>
												B&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[bottommargin]" value="<?=getFormated($font['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'bottommargin'))?>" size="2"/>
											</td>
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle">&nbsp;</td> 
											<td width="206" height="34" valign="middle">&nbsp;
											</td>
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle">&nbsp;</td> 
											<td width="206" height="34" valign="middle">&nbsp;
											</td>
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle">&nbsp;</td> 
											<td width="206" height="34" valign="middle">&nbsp;
											</td>
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle">&nbsp;</td> 
											<td width="206" height="34" valign="middle">&nbsp;
											</td>
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle">&nbsp;</td> 
											<td width="206" height="34" valign="middle">&nbsp;
											</td>
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle">&nbsp;</td> 
											<td width="206" height="34" valign="middle">&nbsp;
											</td>
										</tr>
										<tr>	
											<td width="123" height="34" valign="middle">&nbsp;</td> 
											<td width="206" height="34" valign="middle">&nbsp;
											</td>
										</tr>
										<tr>
											<td align="center" width="330" height="29" colspan="2" valign="middle" bgcolor="#006699"> 
												<? if(empty($font['DB']['Setting'][0]['SettingID'])) { ?>
													<input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingFonts.Setting<?=DTR?>SettingVariableName.value = 'font.'+document.manageSettingFonts.Setting<?=DTR?>SettingVariableName.value;document.manageSettingFonts.submit();">  
												<? }else{?>
													<input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingFonts.submit();"> 
												<? }?>
											 <!--  <input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingFonts.Setting<?=DTR?>SettingVariableName.value = 'font.'+document.manageSettingFonts.Setting<?=DTR?>SettingName.value;document.manageSettingFonts.submit();"> --> 
											  <input type="button" value="<?=lang("-copy")?>" onClick="document.manageSettingFonts.Setting<?=DTR?>SettingID.value = '';document.manageSettingFonts.Setting<?=DTR?>SettingName.value = 'copy'+document.manageSettingFonts.Setting<?=DTR?>SettingName.value;">
											  <input type="button" value="<?=lang("-delete")?>" onClick="document.manageSettingFonts.actionMode.value='delete';confirmDelete('manageSettingFonts', '<?=lang("-deleteconfirmation")?>');">
											</td>
										</tr>
										 </form>
								  	</table>
								  </td>
								 
								 <?
									if(ereg("box",$out['DB']['Setting'][0]['SettingVariableName']))
										{
											$box = $out;
										}
										
										$i=1;
										$colors[0]['id'] = ' ';
										$colors[0]['name'] = lang('noneColor.core.tip');
										foreach($out['DB']['Settings'] as $k=>$row) {
											if(ereg("color",$row['SettingVariableName'])){
												$colors[$i]['id'] = $row['SettingVariableName'];
												$colors[$i]['name'] = getValue($row['SettingName']);
												$i++;
											}
										}
										
										foreach($out['DB']['Settings'] as $k=>$row){
											if(ereg("font",$row['SettingVariableName'])){
												$fonts[$k+1]['id'] = $row['SettingVariableName'];
												$fonts[$k+1]['name'] = getValue($row['SettingName']);
											}
										}
								?>	
								  <td valign="top">
								  	<table width="100%" class="managestyle" border=0 cellspacing=1 cellpadding=3 bgcolor="#eeeeee">
										<tr>
											<td width="330" height="23" colspan="2" valign="middle" bgcolor="#ffffff" align="center">
												<span style="color:#069;font-weight:bold;"><?=lang('Boxes.setting.tip')?></span>
											</td> 
										</tr>
										<tr>
											<td align="center" width="330" height="30" colspan="2" valign="middle" bgcolor="#006699">
												<form name="getSettingBox" method="post" enctype="multipart/form-data"> 
												    <input type="hidden" name="SID" value="<?=input('SID')?>" />
													<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
													<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
													<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
												  <? 
													$boxs[0]['id'] = " ";
													$boxs[0]['name'] = lang('CreateNewBox.core.tip');
													
													foreach($out['DB']['Settings'] as $k=>$row) {
														if(ereg("box",$row['SettingVariableName']))
														{
															$boxs[$k+1]['id'] = $row['SettingID'];
															$boxs[$k+1]['name'] = getValue($row['SettingName']);
														}
												    } 
													echo getLists($boxs,input('SettingID'),array('name'=>'SettingID','id'=>'id','value'=>'name','action'=>'submit();'));
												  	$boxs='';
												  ?>
											  </form>
											</td>
										</tr>
										<form name="manageSettingBoxs" method="post" enctype="multipart/form-data">
											<input type="hidden" name="SID" value="<?=input('SID')?>" />
											<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
											<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
											<input type="hidden" name="SettingID" value="<?=input('SettingID')?>" />
											<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
											<? if(empty($box['DB']['Setting'][0]['SettingID'])) { ?>
											<input type="hidden" name="actionMode" value="add" />
											<? } else { ?>
											<input type="hidden" name="actionMode" value="save1" />
											<input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$box['DB']['Setting'][0]['SettingID']?>">
											<? } ?>	
											<input type="hidden" name="Setting<?=DTR?>SettingGroup" value="<?=input('Level2GroupID')?>" />
										<? if(empty($box['DB']['Setting'][0]['SettingID'])) { ?>
											<tr>
												<td width="123" height="26" valign="middle" bgcolor="#ffffff"><?=lang('BoxCode.core.tip')?>*</td> 
												<td width="206" height="26" valign="middle" bgcolor="#ffffff">
												  <input type="text" name="Setting<?=DTR?>SettingVariableName" value="<?=$box['DB']['Setting'][0]['SettingVariableName']?>" size="30"> 
												</td>
											 </tr>
										 <? }else{?>
										 	<tr>
												<td width="123" height="26" valign="middle" bgcolor="#ffffff"><?=lang('BoxCode.core.tip')?>*</td> 
												<td width="206" height="26" valign="middle" bgcolor="#ffffff">
												  <input type="hidden" name="Setting<?=DTR?>SettingVariableName" value="<?=$box['DB']['Setting'][0]['SettingVariableName']?>" size="30">
												  <input type="text" name="Setting<?=DTR?>SettingVariableName" value="<?=$box['DB']['Setting'][0]['SettingVariableName']?>" size="30" disabled> 
												</td>
											 </tr>
										 <? }?>
										<tr> 
										  <td width="123" height="26" valign="middle" bgcolor="#ffffff"><?=lang('NameBox.core.tip');?></td> 
										  <td width="206" height="26" valign="middle" bgcolor="#ffffff"> 
												<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
													<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
														<?=$out['DB']['Languages']['languageNames'][$langID]?>
													<? }?>
													<br/>
													<input type="text" name="Setting<?=DTR?>SettingName[<?=$langCode?>]" size="30" value="<?=getValue($box['DB']['Setting'][0]['SettingName'],$langCode);?>">
													<br/>
												<? } ?>
											<!--  <input type="hidden" name="Setting<?=DTR?>SettingVariableName" value="" size="30"> 
											 <input type="text" name="Setting<?=DTR?>SettingName" value="<? //getValue($box['DB']['Setting'][0]['SettingName']);?>" <?=$disabled?> size="15"> -->
										  </td> 
										</tr>
										<tr> 
											<td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('Outerbox.core.tip');?></td> 
											<td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   	  <? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'border')),array('name'=>'Setting'.DTR.'SettingValue[border]','id'=>'id','value'=>'name'));?>  
												  <? 
												  	$CP = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'outercellpadding'));
												  	if($CP=='') $CP = 0;
													$CS = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'outercellspacing'));
												  	if($CS=='') $CS = 1;
												  ?>
												  CS&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[outercellspacing]" value="<?=$CS?>" size="2"/>
												  CP&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[outercellpadding]" value="<?=$CP?>" size="2"/>
											</td> 
										</tr> 
										<tr> 
											<td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('Innerbox.core.tip');?></td> 
											<td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'innerborder')),array('name'=>'Setting'.DTR.'SettingValue[innerborder]','id'=>'id','value'=>'name'));?>  
												  <? 
												  	$CP1 = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'innercellpadding'));
												  	if($CP1=='') $CP1 = 0;
													$CS1 = getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'innercellspacing'));
												  	if($CS1=='') $CS1 = 1;
												  ?>
												  CS&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[innercellspacing]" value="<?=$CS1?>" size="2"/>
												  CP&nbsp;<input type="text" name="Setting<?=DTR?>SettingValue[innercellpadding]" value="<?=$CP1?>" size="2"/>
											</td> 
										</tr>
										<tr> 
											<td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('Boxfill.core.tip');?></td> 
											<td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
												<? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'boxfill')),array('name'=>'Setting'.DTR.'SettingValue[boxfill]','id'=>'id','value'=>'name'));?>  
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('TitleFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff" nowrap> 
											  <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'titlefont')),array('name'=>'Setting'.DTR.'SettingValue[titlefont]','id'=>'id','value'=>'name'));?> 
											  	<?=getReference('placestyle','Setting'.DTR.'SettingValue[titlefontside]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'titlefontside')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('SubtitleFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlefont')),array('name'=>'Setting'.DTR.'SettingValue[subtitlefont]','id'=>'id','value'=>'name'));?> 
												<?=getReference('placestyle','Setting'.DTR.'SettingValue[subtitlefontside]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlefontside')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('IntroductionFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'introductionfont')),array('name'=>'Setting'.DTR.'SettingValue[introductionfont]','id'=>'id','value'=>'name'));?>  
												<?=getReference('placestyle','Setting'.DTR.'SettingValue[introductionfontside]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'introductionfontside')),array('code'=>'Y'));?> 
											</td> 
										</tr> 
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('TextFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'textfont')),array('name'=>'Setting'.DTR.'SettingValue[textfont]','id'=>'id','value'=>'name'));?>  
											 	 <?=getReference('placestyle','Setting'.DTR.'SettingValue[textfontside]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'textfontside')),array('code'=>'Y'));?> 
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('ListingFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'listingfont')),array('name'=>'Setting'.DTR.'SettingValue[listingfont]','id'=>'id','value'=>'name'));?>  
												 <?=getReference('placestyle','Setting'.DTR.'SettingValue[listingfontside]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'listingfontside')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('CommentFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'commentfont')),array('name'=>'Setting'.DTR.'SettingValue[commentfont]','id'=>'id','value'=>'name'));?> 
												 <?=getReference('placestyle','Setting'.DTR.'SettingValue[commentfontside]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'commentfontside')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('MessageFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagefont')),array('name'=>'Setting'.DTR.'SettingValue[messagefont]','id'=>'id','value'=>'name'));?> 
											  	<?=getReference('placestyle','Setting'.DTR.'SettingValue[messagefontside]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagefontside')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('Header.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'header')),array('name'=>'Setting'.DTR.'SettingValue[header]','id'=>'id','value'=>'name'));?>  
												 <?=getReference('fontsizes','Setting'.DTR.'SettingValue[fontsizesheader]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'fontsizesheader')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('SubtitleCell.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlecell')),array('name'=>'Setting'.DTR.'SettingValue[subtitlecell]','id'=>'id','value'=>'name'));?>  
											 <?=getReference('fontsizes','Setting'.DTR.'SettingValue[subtitlecellfontsizes]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'subtitlecellfontsizes')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('MessageCell.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											  <? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagecell')),array('name'=>'Setting'.DTR.'SettingValue[messagecell]','id'=>'id','value'=>'name'));?>  
											  <?=getReference('fontsizes','Setting'.DTR.'SettingValue[messagecellfontsizes]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'messagecellfontsizes')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('Button.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											  <? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'button')),array('name'=>'Setting'.DTR.'SettingValue[button]','id'=>'id','value'=>'name'));?>  
											  <?=getReference('buttonsize','Setting'.DTR.'SettingValue[buttonsizes]',getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'buttonsizes')),array('code'=>'Y'));?>
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('ButtonFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'buttonfont')),array('name'=>'Setting'.DTR.'SettingValue[buttonfont]','id'=>'id','value'=>'name'));?> 
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('TextareaFont.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($fonts,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'textareainputfont')),array('name'=>'Setting'.DTR.'SettingValue[textareainputfont]','id'=>'id','value'=>'name'));?> 
											</td> 
										</tr>
										<tr> 
										  <td width="123" height="34" valign="middle" bgcolor="#ffffff"><?=lang('TextareaColor.core.tip');?></td> 
										  <td width="206" height="34" valign="middle" bgcolor="#ffffff"> 
											   <? echo getLists($colors,getFormated($box['DB']['Setting'][0]['SettingValue'],'Style','',array('name'=>'textareabackgroundcolor')),array('name'=>'Setting'.DTR.'SettingValue[textareabackgroundcolor]','id'=>'id','value'=>'name'));?>
											</td> 
										</tr>
										<tr>
											<td align="center" width="330" height="29" colspan="2" valign="middle" bgcolor="#006699"> 
												<? if(empty($box['DB']['Setting'][0]['SettingID'])) { ?>
													<input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingBoxs.Setting<?=DTR?>SettingVariableName.value = 'box.'+document.manageSettingBoxs.Setting<?=DTR?>SettingVariableName.value;document.manageSettingBoxs.submit();">  
												<? }else{?>
													<input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingBoxs.submit();"> 
												<? }?>
											  <!-- <input type="button" value="<?=lang("-save")?>" onClick="document.manageSettingBoxs.Setting<?=DTR?>SettingVariableName.value = 'box.'+document.manageSettingBoxs.Setting<?=DTR?>SettingName.value;document.manageSettingBoxs.submit();">  -->
											  <input type="button" value="<?=lang("-copy")?>" onClick="document.manageSettingBoxs.Setting<?=DTR?>SettingID.value = '';document.manageSettingBoxs.Setting<?=DTR?>SettingName.value = 'copy'+document.manageSettingBoxs.Setting<?=DTR?>SettingName.value;">
											  <input type="button" value="<?=lang("-delete")?>" onClick="document.manageSettingBoxs.actionMode.value='delete';confirmDelete('manageSettingBoxs', '<?=lang("-deleteconfirmation")?>');">
											</td>
										</tr>
										</form>
									</table>
								</td>
							</tr>	
						</table>
					</td> 
				</tr> 
			</table> 
		</td>
	</tr>
