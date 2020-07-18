<?php
include('modules/product/property/product_property/listing_getinfo.php');
?>

<tr>        
    <td>
        <div class="font_subtitle"><?php give_translation('edit_product.subtitle_listingfamilykeyword_product', $echo, $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <input style="width: 100%;" 
               id="txtProductListingFamilyKeyword"
               type="text" 
               name="txtProductListingFamilyKeyword" 
               value="<?php if(!empty($_SESSION['product_property_txtProductListingFamilyKeyword'])){ echo($txtlistingfamilykey_productproperty); } ?>"
               ></input>
    </td>
</tr>
<tr>        
    <td style="vertical-align: top;">
        <div class="font_subtitle"><?php give_translation('edit_product.subtitle_listingfamilyrelated_product', $echo, $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <select style="width: 100%;" name="cboxProductListing[]" multiple="multiple" size="5">
<?php
for($i = 0, $count = count($cbolistingfamilykey_productproperty); $i < $count; $i++)
{
?>
            <option value="<?php echo($cbolistingfamilykey_productproperty[$i]); ?>"
                 <?php 
                 for($y = 0, $county = count($selected_listingfamily_productproperty); $y < $county; $y++)
                 {
                    if(!empty($selected_listingfamily_productproperty[$y]) && $selected_listingfamily_productproperty[$y] == $cbolistingfamilykey_productproperty[$i]){ echo('selected'); }else{ echo(null); } 
                 }
                 ?>   
                    ><?php 
                        echo($cbolistingfamilykey_productproperty[$i]); 
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
        <div class="font_subtitle"><?php give_translation('edit_product.subtitle_listingproductrelated_product', $echo, $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <select style="width: 100%;" name="cboxProductListingRelated[]" multiple="true" size="5">
            <option value="none"><?php give_translation('edit_product.cboxProductListingRelated.none', $echo, $config_showtranslationcode); ?></option>
<?php
            try
            {
                $prepared_query = 'SELECT * FROM page
                                   INNER JOIN page_translation
                                   ON page_translation.id_page = page.id_page
                                   WHERE family_page_translation = "title"
                                   AND family_page = "product"
                                   AND page.id_page <> :id
                                   ORDER BY L'.$main_id_language;
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $_SESSION['page_select_cboProductSelect']);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option value="<?php echo($data[0]); ?>"
<?php 
                         for($y = 0, $county = count($selected_listingrelated_productproperty); $y < $county; $y++)
                         {
                            if($selected_listingrelated_productproperty[$y] == $data[0]){ echo('selected'); }else{ echo(null); }
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
        <div class="font_subtitle"><?php give_translation('edit_product.subtitle_listingkeywordrelated_product', $echo, $config_showtranslationcode); ?></div>
    </td> 
    <td></td>
    <td>
        <input style="width: 100%;" type="text" name="txtProductListingKeyword" value="<?php if(!empty($listingkey_productproperty)){ echo($listingkey_productproperty); } ?>"></input>
    </td>
</tr>
