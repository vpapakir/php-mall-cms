<? $out['style'] = setting('boxstyle')?>
	<?  //print_r($config);
		/*if(setting('styles.BoxHeaderBackgroundImage')) {$BoxHeaderBackground = ' background="'.setting('urlfiles').setting('styles.BoxHeaderBackgroundImage').'"';}
		else{$BoxHeaderBackground = ' bgcolor="'.setting('styles.BoxHeaderBackgroundColor').'"';}*/
		//$BoxHeaderBackground = ' style="background-color:'.setting(getFormated(setting('styles.box.defaultbox'),'Style','',array('name'=>'header'))).'" bgcolor="'.setting(getFormated(setting('styles.box.defaultbox'),'Style','',array('name'=>'header'))).'"';
		//echo setting(getFormated(setting('styles.box.defaultbox'),'Style','',array('name'=>'header')));
	?>
	<? 
		if(!empty($out['style'])){
			$out['style'] = str_replace(setting('OwnerStyle').".","",$out['style']);
			$stylename = str_replace("styles.box.","",$out['style']);
		}else{ 
				$out['style'] = 'styles.box.defaultbox';
				$stylename = 'defaultbox';
			}
		$BoxHeaderBackground = ' style="background-color:'.setting(getFormated(setting($out['style']),'Style','',array('name'=>'header'))).'" bgcolor="'.setting(getFormated(setting($out['style']),'Style','',array('name'=>'header'))).'"';
	?>
<style type="text/css" >
	.<?=$stylename?> td{ 
		font-family:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'textfont'))),'Style','',array('name'=>'fonts'))?>;
		font-size:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'textfont'))),'Style','',array('name'=>'fontsizes'))?>px;
		color:<?=setting(getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'textfont'))),'Style','',array('name'=>'color')))?>; 
		font-weight: <?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'textfont'))),'Style','',array('name'=>'fontweights'))?>; 
		background-color:<?=setting(getFormated(setting($out['style']),'Style','',array('name'=>'boxfill')))?>;
	}	

	td.subtitleline {
		height:<?=getFormated(setting($out['style']),'Style','',array('name'=>'subtitlecellfontsizes'))?>;   
		background-color:<?=setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlecell')))?>; 
		/*background-color: #EEEEEE;*/ 
	}
		
	.<?=$stylename?> .boxtitle 
	{ 
		/* font-family:<?=getFormated(setting('styles.BoxHeader'),'Style','',array('name'=>'fonts'))?>;*/
		font-family:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fonts'))?>;
		font-size:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontsizes'))?>px;
		color:<?=setting(getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'color')))?>; 
		font-weight: <?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontweights'))?>;
		font-style:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontstyles'))?>;
		background-color:<?=setting(getFormated(setting($out['style']),'Style','',array('name'=>'header')))?>;
	}
	.<?=$stylename?> .boxtitle a
	{  
		font-family:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fonts'))?>;
		font-size:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontsizes'))?>px;
		color:<?=setting(getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'linkcolor')))?>; 
		font-weight: <?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontweights'))?>;
		font-style:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontstyles'))?>;
	}	
	.<?=$stylename?> .boxtitle a:hover
	{ 
		font-family:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fonts'))?>;
		font-size:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontsizes'))?>px;
		color:<?=setting(getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'hovercolor')))?>; 
		font-weight: <?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontweights'))?>;
		font-style:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'titlefont'))),'Style','',array('name'=>'fontstyles'))?>;
	}
	.<?=$stylename?> .subtitle 
	{   
		font-family:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fonts'))?>;
		font-size:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fontsizes'))?>px;
		color:<?=setting(getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'color')))?>; 
		font-weight: <?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fontweights'))?>; 
	}
	.<?=$stylename?> td.subtitle
	{
		height:<?=getFormated(setting($out['style']),'Style','',array('name'=>'subtitlecellfontsizes'))?>;   
		background-color:<?=setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlecell')))?>; 
	}	
	.<?=$stylename?> a.subtitle 
	{ 
		font-family:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fonts'))?>;
		font-size:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fontsizes'))?>px;
		color:<?=setting(getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'linkcolor')))?>; 
		font-weight: <?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fontweights'))?>; 
	}	
	.<?=$stylename?> a.subtitle:hover 
	{ 
		font-family:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fonts'))?>;
		font-size:<?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fontsizes'))?>px;
		color:<?=setting(getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'hovercolor')))?>; 
		font-weight: <?=getFormated(setting(getFormated(setting($out['style']),'Style','',array('name'=>'subtitlefont'))),'Style','',array('name'=>'fontweights'))?>; 
	}
</style>	
  <tr> 
	<td> 
		<table width="100%"  border="0" cellspacing="<?=getFormated(setting($out['style']),'Style','',array('name'=>'outercellspacing'));?>" cellpadding="<?=getFormated(setting($out['style']),'Style','',array('name'=>'outercellspacing'));?>" bgcolor="<?=setting(getFormated(setting($out['style']),'Style','',array('name'=>'border')))?>" class="<?=$stylename?>">  
		<? if (!empty($out['title'])) { ?>
			<tr>
				<td colspan="2"  height="<?=getFormated(setting($out['style']),'Style','',array('name'=>'fontsizesheader'))?>px" align="<?=getFormated(setting($out['style']),'Style','',array('name'=>'titlefontside'));?>" valign="middle" class="boxtitle"><? if(eregi('\.title',$out['title'])) { echo lang($out['title']); } else { echo $out['title']; }?></td>
			</tr>
		<? } ?>
		<? if(is_array($out['DB']['tabs'])) { ?> 
		<tr>
			<td bgcolor="#FFFFFF" width="100%" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
				  <tr>		
				<?
				 foreach($out['DB']['tabs'] as $row) { ?>
					<td align="left" valign="middle" class="subtitle"><a href="<?=setting('url').$row['TabLinkValue'].'/'.$out['tabslink']?>/tabLink/<?=$row['TabLinkID']?>/" target="<?=$row['TabLinkTarget']?>">[<?=getValue($row['TabLinkName'])?>]</a></td>
				<? } ?>
					<? if(hasRights('root')) { ?>
						<td align="left" valign="middle" class="subtitle"><a href="<?=setting('url')?>manageTabLinks/TabLinkAlias/<?=$out['tabs']?>/" target="_blank">[+]</a></td>
					<? } ?>	
				  </tr>	  	   
				</table>
			</td>
		</tr>	
	<? }//bgcolor="<?=setting(getFormated(setting('styles.box.defaultbox'),'Style','',array('name'=>'boxfill')))"?>
	<!-- tr> 
	  <td bgcolor="#FFFFFF" class="boxContent" align="center" valign="top" --> 
		<!-- <td bgcolor="<?=setting(getFormated(setting('styles.box.defaultbox'),'Style','',array('name'=>'boxfill')))?>" class="boxContent" align="center" valign="top"> -->
