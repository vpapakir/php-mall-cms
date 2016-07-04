	<? if(!empty($out['tabs'])) { $formName= $out['formName'];  ?> 
	<? /*
	<table border="0" cellspacing="0" cellpadding="0">
      <tr>		
	<?
	 foreach($out['DB']['tabs'] as $row) { ?>
        <td background="<?=setting('layout')?>images/grd.gif"><img src="<?=setting('layout')?>images/grd.gif" width="1" height="1"></td>
		<td background="<?=setting('layout')?>images/bg-tab.gif" align="left" valign="middle" class="tab">
			<? if(!empty($formName)) { ?>
			<?
				if(!empty($row['TabLinkValue'])) 
				{
					
					$parts = explode("/",$row['TabLinkValue']); $partsNumber = count($parts)-1;
					$link = 'document.'.$formName.'.SID.value=\''.$parts[0].'\';';
					for ($i = 1; $i <= $partsNumber; $i=$i+2)
					{
						$valueNumber = $i+1; $variableValue = $parts[$valueNumber]; $variableName = $parts[$i];
						$link .= 'document.'.$formName.'.'.$variableName.'.value=\''.$variableValue.'\';';
					}	
				}				
			?>
			<a href="#" onClick="javascript:document.<?=$formName?>.tabLink.value='<?=$row['TabLinkID']?>';<?=$link?>document.<?=$formName?>.submit();"><?=getValue($row['TabLinkName'])?></a>
			<? } else { ?>
			<a href="<?=setting('url').$row['TabLinkValue'].'/'.$out['tabslink']?>/tabLink/<?=$row['TabLinkID']?>/" target="<?=$row['TabLinkTarget']?>"><?=getValue($row['TabLinkName'])?></a>
			<? }  ?> 
		</td>
		<td><img src="<?=setting('layout')?>images/tabend.gif" width="3" height="20"></td>
	<? } ?>
		<? if(hasRights('root')) { ?>
			<td background="<?=setting('layout')?>images/grd.gif"><img src="<?=setting('layout')?>images/grd.gif" width="1" height="1"></td>
			<td background="<?=setting('layout')?>images/bg-tab.gif" align="left" valign="middle" class="tab"><a href="<?=setting('url')?>manageTabLinks/TabLinkAlias/<?=$out['tabs']?>/" target="_blank">+</a></td>
			<td><img src="<?=setting('layout')?>images/tabend.gif" width="3" height="20"></td>
		<? } ?>	
      </tr>	  	   
    </table>	
	*/ ?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<ul id="globalnav">
				<? if(is_array($out['DB']['tabs'])) { $ind=1;
				 foreach($out['DB']['tabs'] as $row) { $selectedTab='';  if($ind==1) {$selectedTab=' class="selectedtab" '; $ind=2;} ?>
						<? if(!empty($formName)) { ?>
						<?
							if(!empty($row['TabLinkValue'])) 
							{
								
								$parts = explode("/",$row['TabLinkValue']); $partsNumber = count($parts)-1;
								$link = 'document.'.$formName.'.SID.value=\''.$parts[0].'\';';
								for ($i = 1; $i <= $partsNumber; $i=$i+2)
								{
									$valueNumber = $i+1; $variableValue = $parts[$valueNumber]; $variableName = $parts[$i];
									$link .= 'document.'.$formName.'.'.$variableName.'.value=\''.$variableValue.'\';';
								}	
							}				
						?>
						<li<?=$selectedTab?>><a href="#" onClick="javascript:document.<?=$formName?>.tabLink.value='<?=$row['TabLinkID']?>';<?=$link?>document.<?=$formName?>.submit();"><?=getValue($row['TabLinkName'])?></a></li>
						<? } else { ?>
						<li<?=$selectedTab?>><a href="<?=setting('url').$row['TabLinkValue'].'/'.$out['tabslink']?>/tabLink/<?=$row['TabLinkID']?>/" target="<?=$row['TabLinkTarget']?>"><?=getValue($row['TabLinkName'])?></a></li>
						<? }  ?> 
				<? } } ?>
					<? if(hasRights('root')) { ?>
					<!--	<li><a href="<?=setting('url')?>manageTabLinks/TabLinkAlias/<?=$out['tabs']?>/" target="_blank">+</a></li> -->
						<li><a href="<?=setting('url')?>manageTabLinks/TabLinkAlias/<?=$input['SID']?>/" target="_blank">+</a></li>
					<? } ?>	
				</ul>			
			</td>
		</tr>
	</table>	
	<? } elseif (!empty($out['title'])) { ?>
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>		
			<td>
				<ul id="globalnav">
					<li class="selectedtab"><a><?=lang($out['title'])?></a></li>
				</ul>
			</td>
		  </tr>	  	   
		</table>
	<? } ?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td align="left" valign="top" background="<?=setting('layout')?>images/grd.gif" >
			<table width="100%"  border="0" cellspacing="0" cellpadding="10">
			  <tr>
				<td class="content">	
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  			<tr>
