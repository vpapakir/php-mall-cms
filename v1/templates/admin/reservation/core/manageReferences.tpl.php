<?=boxHeader(array('title'=>'ManageReferences.core.title'))?>
 <tr> 
  <form name="getReferences" method="post"> 
     <input type="hidden" name="SID" value="manageReferences" /> 
     <td valign=top bgcolor="#efefef" align="center" width="100%"> <?=$out['Refs']['References']?> </td> 
   </form> 
</tr> 
<tr> 
  <td>&nbsp; </td> 
</tr> 
<form name="manageReferences" method="post"> 
  <input type="hidden" name="SID" value="manageReferences" /> 
  <? if(empty($out['DB']['Reference'][0]['ReferenceID'])) { ?> 
  <input type="hidden" name="actionMode" value="save" /> 
  <? } else { ?> 
  <input type="hidden" name="actionMode" value="save" /> 
  <? } ?> 
  <input type="hidden" name="Reference<?=DTR?>ReferenceID" value="<?=$out['DB']['Reference'][0]['ReferenceID'];?>" /> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%"> <table cellpadding="2" cellspacing="0" width="100%" border="0"> 
        <tr> 
          <td align="left"> <span class="subtitle"> 
            <?=lang('Reference.ReferenceCode')?> 
            : </span> </td> 
          <td align="left"> <input type="text" name="Reference<?=DTR?>ReferenceCode" value="<?=$out['DB']['Reference'][0]['ReferenceCode'];?>" size="50"> </td> 
        </tr> 
        <tr> 
          <td align="left"> <span class="subtitle"> 
            <?=lang('Reference.ReferenceType')?> 
            : </span> </td> 
          <td align="left"> <?=$out['Refs']['ReferenceType']?> </td> 
        </tr> 
        <? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?> 
        <tr> 
          <td valign="top" class="fieldNames" align="left"> <?=lang('LangField.Value')?> 
            :
            <? if(count($out['DB']['Languages']['languageCodes'])>1){?> 
            <?=$out['DB']['Languages']['languageNames'][$langID]?> 
            <? }?> </td> 
          <td align="left"> <input type="text" name="Reference<?=DTR?>ReferenceName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['Reference'][0]['ReferenceName'],$langCode);?>" /> </td> 
        </tr> 
        <? } ?> 
        <tr> 
          <td>&nbsp; </td> 
        </tr> 
        <tr> 
          <td align="center" bgcolor="#efefef" width="100%" colspan="2"> <? if(empty($out['DB']['Reference'][0]['ReferenceID'])) { ?> 
            <input type="submit" value="<?=lang("-add")?>"> 
            <? } else { ?> 
            <input type="submit" value="<?=lang("-save")?>"> 
&nbsp;&nbsp; 
            <input type="button" value="<?=lang("-delete")?>" onClick="document.manageReferences.actionMode.value='delete';confirmDelete('manageReferences', '<?=lang("-deleteconfirmation")?>');"> 
            <? } ?> </td> 
        </tr> 
      </table></td> 
  </tr> 
</form> 
<? if (!empty($input['selectedReferenceID'])) {?> 
<tr> 
  <form name="getReferenceOptions" method="post" enctype="multipart/form-data"> 
    <input type="hidden" name="SID" value="manageReferences" /> 
    <input type="hidden" name="selectedReferenceID" value="<?=$input['selectedReferenceID']?>" /> 
    <td valign=top bgcolor="#ffffff"> <?=$out['Refs']['ReferenceOptions']?> </td> 
  </form> 
</tr> 
<form name="manageReferenceOptions" method="post" enctype="multipart/form-data"> 
  <? $formName = 'manageReferenceOptions'; ?>
  <input type="hidden" name="SID" value="manageReferences" /> 
  <input type="hidden" name="selectedReferenceID" value="<?=$input['selectedReferenceID']?>" /> 
  <input type="hidden" name="actionMode" value="saveoption" /> 
  <input type="hidden" name="ReferenceOption<?=DTR?>ReferenceOptionID" value="<?=$out['DB']['ReferenceOption'][0]['ReferenceOptionID'];?>" /> 
  <input type="hidden" name="ReferenceOption<?=DTR?>ReferenceID" value="<?=$input['selectedReferenceID']?>" /> 
  <tr> 
    <td valign="top" bgcolor="#ffffff" class="fieldNames"> <br/> 
      <? if($out['DB']['Reference'][0]['ReferenceCode']=='color'){?> 
      <?=getFormated($out['DB']['ReferenceOption'][0]['OptionCode'],'Color','form',array('fieldName'=>'ReferenceOption'.DTR.'OptionCode','formName'=>'manageReferenceOptions'))?> 
      <? }else{?> 
      <input type="text" name="ReferenceOption<?=DTR?>OptionCode" value="<?=$out['DB']['ReferenceOption'][0]['OptionCode'];?>" size="50"> 
      <? }?> 
      <br> 
      <table cellspacing="0" cellpadding="0"> 
        <? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?> 
        <tr> 
          <td valign="top" class="fieldNames"> <?=lang('LangField.Value')?> 
            :
            <? if(count($out['DB']['Languages']['languageCodes'])>1){?> 
            <?=$out['DB']['Languages']['languageNames'][$langID]?> 
            <? }?> 
            <br/> 
            <input type="text" name="ReferenceOption<?=DTR?>OptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ReferenceOption'][0]['OptionName'],$langCode);?>" /> </td> 
        </tr> 
        <? } ?> 
		<tr>
			<td>
				<?=lang('ReferenceOption.OptionIcon')?>:<br/>
				<input type="hidden" name="fileField"/>
				<? $fieldName = 'OptionIcon';  echo getFormated($out['DB']['ReferenceOption'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deleteoptionfile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
			</td>
		</tr>
		
      </table> 
      <br/> 
      <?=lang('-addafter')?> 
      : &nbsp; 
      <?

						$options[0]['id']='1';	

						$options[0]['value']='- '.lang('-first').' -';

						if(is_array($out['DB']['ReferenceOptions']))

						{

							foreach($out['DB']['ReferenceOptions'] as $row)

							{

								if ($row['ReferenceOptionID']!=$out['DB']['ReferenceOption'][0]['ReferenceOptionID'])

								{

									$i++;

									$options[$i]['id']=$row['OptionPosition']+1;	

									$options[$i]['value']=$row['OptionName'];

								}

							}

						}

						echo getLists('',$out['DB']['ReferenceOption'][0]['OptionPosition']-1,array('name'=>'ReferenceOption'.DTR.'OptionPosition','id'=>'OptionPosition','value'=>'OptionName','options'=>$options));	

						$options='';

					?> 
      <br/> 
      <br/> 
      <br/> 
      <? if(empty($out['DB']['ReferenceOption'][0]['ReferenceOptionID'])) { ?> 
      <input type="submit" value="<?=lang("-add")?>"> 
      <? } else { ?> 
      <input type="submit" value="<?=lang("-save")?>"> 
&nbsp;&nbsp; 
      <input type="button" value="<?=lang("-delete")?>" onClick="document.manageReferenceOptions.actionMode.value='deleteoption';submit();"> 
      <? } ?> 
      <br/> </td> 
  </tr> 
</form> 
<? }//if (!empty(input('selectedReferenceID'))) ?> 
<?=boxFooter()?> 
