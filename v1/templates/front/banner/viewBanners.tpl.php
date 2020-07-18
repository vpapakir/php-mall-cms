<? if (is_array($out['DB']['Banners'])) { ?>
<?=boxHeader()?>
	<tr> 
		<td valign="top" bgcolor="#ffffff" align="left">
			<?  foreach ($out['DB']['Banners'] as $banner) {?>
				<? if(!empty($banner['BannerImage'])) {?>
					<a href="<?=$banner['BennerLink']?>" target="<?=$banner['BannerTarget']?>"><img src="<?=setting('urlfiles').$banner['BannerImage']?>" border="0" /></a>
				<? }elseif(!empty($banner['BannerCode'])) {?>
					<?=$banner['BannerCode']?>
				<? } else {?>
					<a href="<?=$banner['BennerLink']?>" target="<?=$banner['BannerTarget']?>"><?=$banner['BannerText']?></a>
				<? } ?>
				<? if(!empty($banner['BannerText'])){?>	
                <? //print_r($config)?>
					<p align="left"><?=getValue($banner['BannerText'])?></p>
				<? }else{?>
					<img src="<?=setting('layout')?>images/pixel.gif"  height="8pt" width="1px"/>
				<? }?>
				<? if (hasRights('content')) { ?><div align="left"><a href="<?=setting('url')?>adminBanners"><?=lang('-editbox')?></a></div> <? } ?>
			<? } ?>
			
		</td> 
	</tr> 
<?=boxFooter()?>
<? } ?>
