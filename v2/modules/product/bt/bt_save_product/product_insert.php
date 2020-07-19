<?php
$prepared_query = 'INSERT INTO page
                   (status_page, status_search_page, template_page,
                    code_page, family_page, url_page, script_page,
                    listingfamkey_page, listingfam_page, 
                    listingrelated_page, listingkey_page,
                    ajaxpath_page, level_rights, allowstats_page)
                   VALUES
                   (:status, :status_search, :template,
                    :code, :family, :url, :script,
                    :listfamkey, :listfam, :listrelated, :listkey,
                    :scriptajax, :level, :allowstats)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'status' => $status_productproperty,
                      'status_search' => $status_search_productproperty,
                      'template' => $template_productproperty,
                      'code' => $code_productproperty,
                      'family' => $family_productproperty,
                      'url' => $url_productproperty,
                      'script' => $script_productproperty,
                      'listfamkey' => $listingfamkey_productproperty,
                      'listfam' => $listingfam_productproperty,
                      'listrelated' => $listingrelated_productproperty,
                      'listkey' => $listingkeywords_productproperty,
                      'scriptajax' => $scriptajax_pageproperty,
                      'level' => $userrights_pageproperty,
                      'allowstats' => $allowstats_productproperty
                      ));
$query->closeCursor();

/*$prepared_query = 'SELECT * FROM page WHERE code_page=:code';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_productproperty
                      ));
while(($data = $query->fetch()) != false) {
	if(is_null(data['id_page'])) {
		// do nothing
	} else {
		$page_id = data['id_page'];
	}
}
$query->closeCursor();*/

$prepared_query = 'INSERT INTO product
                       (status_product,
					    number_product,
					    code_product_L1, 
						code_product_L2, 
						code_product_L3, 
						code_product_L4,
						code_product_L5,
						name_product_L1,
						name_product_L2,
						name_product_L3,
						name_product_L4,
						name_product_L5,
						introduction_product_L1,
						introduction_product_L2,
						introduction_product_L3,
						introduction_product_L4,
						introduction_product_L5,
						description_product_L1,
						description_product_L2,
						description_product_L3,
						description_product_L4,
						description_product_L5,
						code_group_product,
						code_category_product,
						id_option_product,
						priority_product,
						image_thumb_product,
						id_page,
						number_link_product,
						cart_type_product,
						transport_fee_product,
						noticelink_product,
						id_cooshop,
						product_class_id) 
                   VALUES
                        (:product_status,
						 :product_number,
						 :product_code_L1,
                         :product_code_L2,
                         :product_code_L3,
                         :product_code_L4,
						 :product_code_L5,
						 :product_name_L1,
						 :product_name_L2,
						 :product_name_L3,
						 :product_name_L4,
						 :product_name_L5,
						 :product_introduction_L1,
						 :product_introduction_L2,
						 :product_introduction_L3,
						 :product_introduction_L4,
						 :product_introduction_L5,
						 :product_description_L1,
						 :product_description_L2,
						 :product_description_L3,
						 :product_description_L4,
						 :product_description_L5,
						 :product_group_code,
						 :product_category_code,
						 :product_option_id,
						 :product_priority,
						 :product_image_thumb,
						 :page_id,
						 :product_link_number,
						 :product_cart_type,
						 :product_transport_fee,
						 :product_noticelink,
						 :cooshop_id,
						 :class_id_product)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                         'product_status' => $_POST['cboProductStatus'],
						 'product_number' => rand(),//$_POST['number_product'],
						 'product_code_L1' => " ",//$product_code_L1,
                         'product_code_L2' => " ",//$product_code_L2,
                         'product_code_L3' => " ",//$product_code_L3,
                         'product_code_L4' => " ",//$product_code_L4,
						 'product_code_L5' => " ",//$product_code_L5,
						 'product_name_L1' => " ",//$product_name_L1,
						 'product_name_L2' => " ",//$product_name_L2,
						 'product_name_L3' => " ",//$product_name_L3,
						 'product_name_L4' => " ",//$product_name_L4,
						 'product_name_L5' => " ",//$product_name_L5,
						 'product_introduction_L1' => " ",//$product_introduction_L1,
						 'product_introduction_L2' => " ",//$product_introduction_L2,
						 'product_introduction_L3' => " ",//$product_introduction_L3,
						 'product_introduction_L4' => " ",//$product_introduction_L4,
						 'product_introduction_L5' => " ",//$product_introduction_L5,
						 'product_description_L1' => " ",//$product_description_L1,
						 'product_description_L2' => " ",//$product_description_L2,
						 'product_description_L3' => " ",//$product_description_L3,
						 'product_description_L4' => " ",//$product_description_L4,
						 'product_description_L5' => " ",//$product_description_L5,
						 'product_group_code' => " ",//$product_group_code,
						 'product_category_code' => " ",//$product_category_code,
						 'product_option_id' => " ",//$product_option_id,
						 'product_priority' => " ",//$product_priority,
						 'product_image_thumb' => " ",//$product_image_thumb,
						 'page_id' => rand(),//$page_id,
						 'product_link_number' => " ",//$product_link_number,
						 'product_cart_type' => " ",//$product_cart_type,
						 'product_transport_fee' => " ",//$product_transport_fee,
						 'product_noticelink' => " ",//$product_noticelink,
						 'cooshop_id' => " ",//$cooshop_id,
						 'class_id_product' => " "//$class_id_product
                      ));
$query->closeCursor();

include('modules/product/bt/bt_save_product/product_translation.php');

if(isset($_POST['bt_add_edit_product']))
{
    $prepared_query = 'SELECT MAX(id_page) FROM page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $_SESSION['product_addedit_id'] = $data[0];
    }
    $query->closeCursor(); 
    
    if($_SESSION['product_addedit_id'] == 0)
    {
        $_SESSION['product_addedit_id'] = 1;
    }
}
else
{
    unset($_SESSION['product_addedit_id']);
}

$prepared_query = 'SELECT MAX(id_page) FROM page';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
if(($data = $query->fetch()) != false)
{
    $selected_product = $data[0];
}
$query->closeCursor(); 

include('modules/product/bt/bt_save_product/product_insert_sitemap.php');

function fwrite_stream($fp, $string) {
    for ($written = 0; $written < strlen($string); $written += $fwrite) {
        $fwrite = fwrite($fp, substr($string, $written));
        if ($fwrite === false) {
            return $fwrite;
        }
    }
    return $written;
}

#custom
if(!empty($config_module_immo) && $config_module_immo == 1)
{
	$prepared_query = 'SELECT * FROM config_module';
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
	$query = $connectData->prepare($prepared_query);
	$query->execute();
	while(($data = $query->fetch()) != false)
	{
		//if($data['element_id'] == 'adminconfig_edit.module_immo') {
			if($data['immo_module'] == 0) { // If immo module is active
				//include('modules/custom/immo/modules/Kprodimmo/bt/insert.php');
			} else {
				//fwrite_stream("res.txt", "bingo!");
				include('modules/custom/multishop/modules/Kprodimmo/bt/insert.php');
			}
		//}
	}
    
}

$msg_product_savedone_add = str_replace('[#name_product]', $code_productproperty, $msg_product_savedone_add);
$_SESSION['msg_product_savedone'] = $msg_product_savedone_add;
?>
