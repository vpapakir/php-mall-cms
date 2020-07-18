<?php
include('modules/page/property/page_property/listing_getinfo.php');
?>

<tr>        
    <td>
        <div class="font_subtitle"><?php give_translation('page_edit.subtitle_listingfamilykeywords_property', '', $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <input style="width: 100%;" 
               id="txtPageListingFamilyKeyword"
               type="text" 
               name="txtPageListingFamilyKeyword" 
               value="<?php if(!empty($_SESSION['page_property_txtPageListingFamilyKeyword'])){ echo($txtlistingfamilykey_pageproperty); } ?>"
               ></input>
    </td>
</tr>
<tr>        
    <td style="vertical-align: top;">
        <div class="font_subtitle"><?php give_translation('page_edit.subtitle_listingfamilyrelated_property', '', $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <select style="width: 100%;" name="cboxPageListing[]" multiple="multiple" size="5">
<?php
for($i = 0, $count = count($cbolistingfamilykey_pageproperty); $i < $count; $i++)
{
?>
            <option value="<?php echo($cbolistingfamilykey_pageproperty[$i]); ?>"
                 <?php 
                 for($y = 0, $county = count($selected_listingfamily_pageproperty); $y < $county; $y++)
                 {
                    if(!empty($selected_listingfamily_pageproperty[$y]) && $selected_listingfamily_pageproperty[$y] == $cbolistingfamilykey_pageproperty[$i]){ echo('selected'); }else{ echo(null); } 
                 }
                 ?>   
                    ><?php 
                        echo($cbolistingfamilykey_pageproperty[$i]); 
                    ?>

                    </option>
<?php                    
}
?>            
        </select>
    </td>
</tr>
<tr>        
    <td style="vertical-align: top;">
        <div class="font_subtitle"><?php give_translation('page_edit.subtitle_listingpagerelated_property', '', $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <select style="width: 100%;" name="cboxPageListingRelated[]" multiple="true" size="5">
            <option value="none">Aucune</option>
<?php
            try
            {
                $prepared_query = 'SELECT * FROM page
                                   INNER JOIN page_translation
                                   ON page_translation.id_page = page.id_page
                                   WHERE family_page_translation = "title"
                                   AND page.id_page <> :id
                                   ORDER BY L'.$main_id_language;
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $_SESSION['page_select_cboPageSelect']);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option value="<?php echo($data[0]); ?>"
<?php 
                         for($y = 0, $county = count($selected_listingrelated_pageproperty); $y < $county; $y++)
                         {
                            if($selected_listingrelated_pageproperty[$y] == $data[0]){ echo('selected'); }else{ echo(null); }
                         }
?>   
                            ><?php 
                                if(empty($data['L'.$main_id_language]))
                                {
                                    echo($data['code_page']); 
                                }
                                else
                                {
                                    echo(cut_string($data['L'.$main_id_language], 0, 50, '...')); 
                                }
                            ?>

                            </option>
<?php                    
                }
                $query->closeCursor();
            }
            catch(Exception $e)
            {
                $_SESSION['error400_message'] = $e->getMessage();
                if($_SESSION['index'] == 'index.php')
                {
                    die(header('Location: '.$config_customheader.'Error/400'));
                }
                else
                {
                    die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
                }
            }
?>            
        </select>
    </td>
</tr>
<tr>        
    <td>
        <div class="font_subtitle"><?php give_translation('page_edit.subtitle_listingykeywordsrelated_property', '', $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <input style="width: 100%;" type="text" name="txtPageListingKeyword" value="<?php if(!empty($listingkey_pageproperty)){ echo($listingkey_pageproperty); } ?>"></input>
    </td>
</tr>
