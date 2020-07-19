<?php session_start();
ob_start("ob_gzhandler");

$include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
include('modules/dbconnect/dinxdev/dbconnect.php');
include('modules/functions/function.php');
include('config/config_admin.php');
include('config/config_main.php');
include('config/config_image.php');
include('modules/pdf/pdf.php');
$_SESSION['index'] = 'index.php';
$_SESSION['cooshopname'] = 'coobox.eu';
$_SESSION['cooshopid'] = 1;
if (isset($_COOKIE["language"]))
			{
				if($_SESSION['current_language'] != $_COOKIE["language"]) {
					$_SESSION['current_language'] = $_COOKIE["language"];
					//$main_id_language = $_SESSION['current_language'];
					/*$pageeee = $_SESSION['current_page'];
					$sec = "0";
					header("Refresh: $sec; url=$pageeee");*/
				}
				//$_SESSION['current_language'] = $_COOKIE["language"];
				//echo $_COOKIE["language"]."XXX".$_SESSION['current_language'];
			} else {
				//$main_id_language = $_SESSION['current_language'];
				//echo "FUCK!!!";
}
include('structure/config_structure.php');
include('modules/language/language/language_switch.php');
include('modules/finance/currency/currency_switch.php');
include('modules/stats/visit/statsvisit_main.php');

$_SESSION['current_page'] = trim(htmlspecialchars($_GET['page'], ENT_QUOTES));
$main_id_language = $_SESSION['current_language'];
$main_id_currency = $_SESSION['current_currency'];
$main_coef_currency = $_SESSION['current_coef_currency'];
$main_rate_currency = $_SESSION['current_rate_currency'];
$main_code_currency = $_SESSION['current_code_currency'];
$main_selectedcode_currency = $_SESSION['current_selectedcode_currency'];
$main_selectedsymbol_currency = $_SESSION['current_selectedsymbol_currency'];
$main_priority_currency = $_SESSION['current_priority_currency'];
$main_iduser_log = $_SESSION['current_log_iduser'];
$main_rights_log = $_SESSION['current_log_rightsuser'];
$main_onlinestatus_log = $_SESSION['current_log_onlinestatususer'];
$blocktitle_box_structure = 21;
$blockcontent_box_structure = 22;

include('config/config_valuerelated.php');

if(isset($_GET['block']))
{
    if($_GET['block'] == 'true')
    {
        //include('modules/settings/css/block/block_main.php');
    }
}

$productMatrix_tfield_length = 6; // default value, will change
$id_body = 1;

try
{ 
    $prepared_query = 'SELECT * FROM structure_skin
                            WHERE id_body = :id_body';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_body', $id_body);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $name_skin = $data['name_skin'];
        $width_skin = $data['width_skin'].'px';
        $height_skin = $data['height_skin'].'px';
        $position_skin = $data['position_skin'];
        $margin_skin = $data['margin_skin'];
        $border_skin = $data['border_skin'].'px';
        $bordercolor_skin = $data['bordercolor_skin'];
        $tablebg_skin = $data['tablebg_skin'];
        $cs_skin = $data['cs_skin'];
        $cp_skin = $data['cp_skin'];
        $bgcolor_skin = $data['bgcolor_skin'];
        $bgimg_skin = $data['bgimg_skin'];
        $xrepeat_skin = $data['xrepeat_skin'];
        $yrepeat_skin = $data['yrepeat_skin'];
        $id_section = $data['id_section'];
        $id_image_skin = $data['id_image'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_image = :id_image';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_image', $id_image_skin);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
       $path_skin = $data['path_image'];
       $alt_skin = $data['alt_image'];
       $title_skin = $data['title_image'];
       $repeat_skin = $data['repeat_image'];
       $attachment_skin = $data['attachment_image'];
    }
    $query->closeCursor();
    
    if($width_skin == '0px')
    {
        $width_skin = '100%';
    }
    
    if($height_skin == '0px')
    {
        $height_skin = '100%';
    }
    
    if($bgcolor_skin == null)
    {
       $bgcolor_skin = 'white'; 
    }
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
	<title><?php echo($main_browsertitle); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="Title" content="<?php echo($main_currentpage_title); ?>">
	<meta name="Description" content="<?php echo($main_currentpage_intro); ?>">
	<meta name="Keywords" content="<?php echo(cut_string($main_currentpage_tags, 0, 256, '')); ?>">
	<meta name="Author" content="<?php echo($config_meta_author); ?>">
	<meta NAME="Publisher" content="<?php echo($config_meta_publisher); ?>">
	<meta name="Copyright" content="<?php echo($config_meta_author.' - '.$main_currentpage_browser); ?>">
	<meta http-equiv="Reply-To" content="<?php echo($config_meta_replyto); ?>">
	<meta http-equiv="Content-Language" content="<?php echo(strtolower($main_meta_currentlangcode)); ?>">
	<meta name="Robots" content="<?php echo($config_meta_robots); ?>">
	<meta name="Creation_Date" content="<?php echo($config_meta_creationdate); ?>">
	<meta name="Revisit-After" content="<?php echo($config_meta_revisitafter.' days'); ?>">
	<?php
        if(!empty($config_meta_category))
        {
?>
	<meta name="Category" content="<?php echo($config_meta_category); ?>">
	<?php
        }
        
        if(!empty($config_link_icopath))
        {
?>
	<link rel="shortcut icon" href="<?php echo($config_customheader.$config_link_icopath); ?>">
	<?php
        }
?>
	<link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/block.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/font.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/button.css"/>
	<script type="text/javascript" src="<?php echo($config_customheader); ?>modules/javascript/script.js"></script>
	<?php
        if(!empty($config_scriptajax_page[0]))
        {
?>
	<script type="text/javascript" src="<?php echo($config_customheader); ?>modules/ajax/XHTobject.js"></script>
	<?php
            for($i = 0, $count = count($config_scriptajax_page); $i < $count; $i++)
            {
?>
	<script type="text/javascript" src="<?php echo($config_customheader.$config_scriptajax_page[$i]); ?>"></script>
	<?php  
            }
        }
?>
	<script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/jquery/jquery.js" ></script>
	<script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/jscolor/jscolor.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/wysiwyg/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/wysiwyg/tinymce/jscripts/tiny_mce/basic_config.js"></script>
	<script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide-with-html.js"></script>
	<script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide.config.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide.css"/>
	<?php
            //include('modules/css/font.php');
            //include('modules/css/button.php');
            //include('modules/css/block.php');
        ?>
	<style>
table.center {
	margin-left: auto;
	margin-right: auto;
}
</style>

<script type="text/javascript">
	function clearSearchResults() {
	}
</script>

	</head>
	<body style="background-color:<?php $prepared_query = 'SELECT * FROM structure_body WHERE id_body = :id_body';$query = $connectData->prepare($prepared_query);$query->bindParam('id_body', $id_body);$query->execute();if(($data = $query->fetch()) != false){echo $data['bgcolor_body'];}?>;text-align: center;">
	  
		
	  
<table style="<?php echo($width_skin); ?> height: <?php echo($height_skin); ?>; 
       border: <?php echo($border_skin.' solid '.$bordercolor_skin); ?>;
       position: <?php echo($position_skin); ?>; margin: <?php echo($margin_skin); ?>;
       background-image: url('<?php echo($config_customheader.$path_skin) ?>'); 
       <?php if(!empty($repeat_skin)){ ?>background-repeat: <?php echo($repeat_skin) ?>;<?php } ?>
       <?php if(!empty($attachment_skin)){ ?>background-attachment: <?php echo($attachment_skin) ?>;<?php } ?>" 
       cellpadding="<?php echo($cp_skin); ?>" cellspacing="<?php echo($cs_skin); ?>">
		
<?php
try
{ 
    $prepared_query = 'SELECT * FROM structure_logo
                       WHERE id_logo = :id_logo';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_logo', $id_logo);   
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $align_logo = $data['align_logo'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM structure_section
                       WHERE id_section = :id_section';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_section', $id_section);   
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $name_section = $data['name_section'];
        $width_section = $data['width_section'].'px';
        $height_section = $data['height_section'].'px';
        $position_section = $data['position_section'];
        $margin_section = $data['margin_section'];
        $border_section = $data['border_section'].'px';
        $bordercolor_section = $data['bordercolor_section'];
        $tablebg_section = $data['tablebg_section'];
        $cs_section = $data['cs_section'];
        $cp_section = $data['cp_section'];
        $bgcolor_section = $data['bgcolor_section'];
        $bgimg_section = $data['bgimg_section'];
        $xrepeat_section = $data['xrepeat_section'];
        $yrepeat_section = $data['yrepeat_section'];
        $radius_section = $data['radius_section'];
        $id_layout = $data['id_layout'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM structure_frame
                       WHERE id_layout = :layout';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('layout', $id_layout);   
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {    
        $section_id_frame[$i] = $data['id_frame'];
        $status_frame[$i] = $data['status_frame'];
        $i++;
    }
    $query->closeCursor();    
    
    if($width_section == '0px')
    {
        $width_section = '100%';
    }
    
    if($height_section == '0px')
    {
        $height_section = '100%';
    }
    
    if($bgcolor_section == null)
    {
       $bgcolor_section = 'white'; 
    }
    
    if($position_section == 0)
    {
       $position_section = 'relative'; 
    }
    
    if($margin_section == 0)
    {
        $margin_section = 'auto';
    }
    
    $radius_section = split_string($radius_section, '$');
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

	<tr style="background-color: <?php echo($tablebg_skin); ?>;">
        <td align="center" style="vertical-align: top;">       
            <table style="width: <?php echo($width_section); ?>; height: <?php echo($height_section); ?>; 
       border: <?php echo($border_section.' solid '.$bordercolor_section); ?>;
       position: <?php echo($position_section); ?>; margin: <?php echo($margin_section); ?>;
       border-radius: <?php echo($radius_section[0].'px '.$radius_section[1].'px '.$radius_section[2].'px '.$radius_section[3].'px'); ?>;
/*       -moz-border-radius: <?php //echo($radius_section[0].'px '.$radius_section[1].'px '.$radius_section[2].'px '.$radius_section[3].'px'); ?>;*/
       -webkit-border-radius: <?php echo($radius_section[0].'px '.$radius_section[1].'px '.$radius_section[2].'px '.$radius_section[3].'px'); ?>;
       <?php if(!empty($bgcolor_section)){ ?>background-color: <?php echo($bgcolor_section); ?>;"<?php } ?> 
       cellpadding="<?php echo($cp_section); ?>" cellspacing="<?php echo($cs_section); ?>" border="0">
  
    
    <tr>
        <td <?php if(!empty($tablebg_section)){ ?>style="background-color: <?php echo($tablebg_section); ?>;"<?php } ?>>
            <div style="height: 4px;"></div>
        </td>
    </tr>
    
    <tr>
        <td <?php if(!empty($tablebg_section)){ ?>style="background-color: <?php echo($tablebg_section); ?>;"<?php } ?>><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="<?php echo($align_logo); ?>" width="100%">
                    <?php
                        //include('structure/logo/logo1.php');
                    ?>
                </td>
                <td align="<?php echo($align_logo); ?>">
                    <?php
                        //include('structure/currency/currency_box.php');
                    ?>
                </td>
                <td>
                    <?php
                        //include('structure/box/11.php');
                    ?>
                </td>
                <td><div style="width: 10px;"></div></td>
                <td align="right">
                    <?php
                        //include('structure/language/language_box.php');
                    ?>
                </td>
            </tr>
        </table></td>
    </tr>
    <?php
    if($status_frame[6] == 1 || $status_frame[7] == 1)
    {
?>
    
        <tr>
            <td style="background-color: <?php echo($tablebg_section); ?>;"><table style="margin-top: 10px;" width="100%" border="0" cellpadding="0" cellspacing="0">
       
                <tr> 
                    <td align="left">    
<?php   
                        if($status_frame[6] == 1)
                        {
                            //include('structure/frame/tabbar/tabbarL1.php');
                        }   
?>
                    </td>
                    <td></td>
                    <td align="right">
<?php                
                        if($status_frame[7] == 1)
                        {
                            //include('structure/frame/tabbar/tabbarR1.php');
                        }
?>
                    </td>
                </tr>
            
            </table></td>       
        </tr>       
<?php
    }
?>
    <tr>
        <td align="center" style="background-color: <?php echo($tablebg_section); ?>;">
            <table class="block_title3" width="70%" border="0" style="margin-bottom:2px;">
					<tr>
						<td align="center" width="70%"><?php give_translation('#*Matrix-Editor', $echo, $config_showtranslationcode);?></td>
					</tr>
			</table>
        </td>
    </tr>
	
	<tr>
        <td><!-- <table width="930px" cellspacing="0" cellpadding="0" class="center" style="text-align: center;" bgcolor="#FFFFFF" bordercolor="#DBCFBC" border="0">
            <tr>
            <td colspan="2" height="20"></td>
          </tr>
            <tr>
            <td align="center"></td>
          </tr>
            <tr>
            <td rowspan="12" height="20"></td>
          </tr>
          </table>
		  
			--><table class="center" cellspacing="0" cellpadding="1" style="text-align: center;" bgcolor="<?php echo $bgcolor_section; ?>" bordercolor="#DBCFBC" border="0">
				<tr>
					<td><input type="texfield" id="searchTextField" name="searchTextField" /> <input type="submit" id="bt_SearchProducts" value="<?php give_translation('#*Search', $echo, $config_showtranslationcode);?>" /> <input type="submit" id="bt_SearchProducts" value="<?php give_translation('#*Show-Stock-Alerts', $echo, $config_showtranslationcode);?>"/> <input type="submit" id="bt_ClearResults" value="<?php give_translation('#*Clear-Results', $echo, $config_showtranslationcode);?>" onclick="clearSearchResults();" /></td>
				</tr>
				<tr>
					<td height="12"></td>
				</tr>
			</table>
			
			<table align="center" style="width: <?php echo($width_section); ?>;text-align: center;background-color:white;" bordercolor="#DBCFBC" border="0">
				<tr class="font_subtitle">
					<td height="20" style="text-align:center;" ><?php give_translation('#*No Results Found', $echo, $config_showtranslationcode); ?></td>
				</tr>
				<?php
					// TODO: generate one or more 
					$Search_Result_Count = 0; //default  value
					if($Search_Result_Count == 0) {
						// do nothing
					} else {
						for($counter=0; $counter < $Search_Result_Count; $counter++) {
							echo '<tr height="12px" class="font_subtitle">';
								echo '<td height="20">XXX</td>';
								echo '<td height="20">XXX</td>';
								echo '<td height="20">XXX</td>';
								echo '<td height="20">XXX</td>';
							echo "</tr>";
						}
					}
				?>
				<tr>
					<td colspan="2" height="20"></td>
				</tr>
			</table>
		  
          <table align="center" cellspacing="0" cellpadding="1" style="text-align: center;width: <?php echo($width_section); ?>;" bgcolor="#FFFFFF" bordercolor="#DBCFBC" border="1">
            <tr>
              <td class="font_subtitle" align="left" colspan="2"><strong>Matrixname<br>
                Product XXX</strong></td>
              <td class="font_main" style="text-align:center;">Uni<br></td>
              <td class="font_main" style="text-align:center;">S<br>
                34/36</td>
              <td class="font_main" style="text-align:center;">SM<br>
                34/40</td>
              <td class="font_main" style="text-align:center;">M<br>
                38/40</td>
              <td class="font_main" style="text-align:center;">ML<br>
                40/44</td>
              <td class="font_main" style="text-align:center;">L<br>
                42/44</td>
              <td class="font_main" style="text-align:center;">XL<br>
                46/48</td>
              <td class="font_main" style="text-align:center;">XL<br>
                46/48</td>
              <td class="font_main" style="text-align:center;">XL<br>
                46/48</td>
            </tr>
            <tr>
              <td class="font_main" align="left" colspan="2">
				<select name="select_ProductColor" id="select_ProductColor">
					<option>CDR-hellhimmelblau-getont</option>
                </select>
                </td>
              <td>
                  <input type="checkbox" name="uni_CheckBox" id="uni_CheckBox">
                </td>
              <td>
                  <input type="checkbox" name="s_CheckBox" id="s_CheckBox">
                </td>
              <td><input type="checkbox" name="sm_CheckBox" id="sm_CheckBox"></td>
              <td><input type="checkbox" name="m_CheckBox" id="m_CheckBox"></td>
              <td><input type="checkbox" name="ml_CheckBox" id="ml_CheckBox"></td>
              <td><input type="checkbox" name="l_CheckBox" id="l_CheckBox"></td>
              <td><input type="checkbox" name="xl_CheckBox" id="xl_CheckBox"></td>
              <td><input type="checkbox" name="l_CheckBox" id="l_CheckBox"></td>
              <td><input type="checkbox" name="xl_CheckBox" id="xl_CheckBox"></td>
            </tr>
            <tr class="font_main">
              <td height="20" rowspan="12" align="left" valign="top"><img width="80" height="60" src="/images/products/thumb/13904667-coffret-coquin-orale-passion.png" /></td>
              <td align="left"><?php give_translation('#*Reference', $echo, $config_showtranslationcode);?></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" size="<?echo $productMatrix_tfield_length;?>" name="textfield" id="textfield"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield14" id="textfield14"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield27" id="textfield27"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield40" id="textfield40"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield62" id="textfield62"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield66" id="textfield66"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield40" id="textfield40"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield62" id="textfield62"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield77" id="textfield77"></td>
            </tr>
            <tr class="font_main">
              <td align="left"><?php give_translation('#*PriceRetail', $echo, $config_showtranslationcode);?></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield86" id="textfield86"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield2" id="textfield2"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield15" id="textfield15"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield28" id="textfield28"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield41" id="textfield41"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield15" id="textfield15"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield28" id="textfield28"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield63" id="textfield63"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield67" id="textfield67"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*PricePromo', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield87" id="textfield87"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield3" id="textfield3"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield16" id="textfield16"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield29" id="textfield29"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield42" id="textfield42"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield64" id="textfield64"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield42" id="textfield42"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield64" id="textfield64"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield68" id="textfield68"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*PriceReseller', $echo, $config_showtranslationcode);?></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield88" id="textfield88"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield4" id="textfield4"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield17" id="textfield17"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield30" id="textfield30"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield43" id="textfield43"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield65" id="textfield65"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield69" id="textfield69"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield65" id="textfield65"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield69" id="textfield69"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*AmountEcotax', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield89" id="textfield89"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield5" id="textfield5"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield18" id="textfield18"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield31" id="textfield31"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield44" id="textfield44"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield18" id="textfield18"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield31" id="textfield31"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield61" id="textfield61"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield78" id="textfield78"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*UnitVolume', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield90" id="textfield90"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield6" id="textfield6"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield19" id="textfield19"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield32" id="textfield32"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield45" id="textfield45"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield19" id="textfield19"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield32" id="textfield32"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield60" id="textfield60"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield77" id="textfield77"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*UnitWeight', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield84" id="textfield84"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield7" id="textfield7"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield20" id="textfield20"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield33" id="textfield33"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield46" id="textfield46"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield59" id="textfield59"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield76" id="textfield76"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield59" id="textfield59"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield76" id="textfield76"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*OnStock', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield83" id="textfield83"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield8" id="textfield8"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield21" id="textfield21"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield34" id="textfield34"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield47" id="textfield47"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield58" id="textfield58"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield75" id="textfield75"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield58" id="textfield58"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield75" id="textfield75"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*MinStockAlert', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield82" id="textfield82"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield9" id="textfield9"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield22" id="textfield22"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield35" id="textfield35"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield48" id="textfield48"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield57" id="textfield57"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield74" id="textfield74"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield57" id="textfield57"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield74" id="textfield74"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*NonStockDelay', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield81" id="textfield81"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield10" id="textfield10"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield23" id="textfield23"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield36" id="textfield36"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield52" id="textfield52"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield56" id="textfield56"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield73" id="textfield73"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield56" id="textfield56"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield73" id="textfield73"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*PurchaseNet', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield80" id="textfield80"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield11" id="textfield11"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield24" id="textfield24"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield39" id="textfield39"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield51" id="textfield51"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield55" id="textfield55"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield72" id="textfield72"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield85" id="textfield85"></td>
              <td><input type="text" style="text-align:center;" size="<?echo $productMatrix_tfield_length;?>" name="textfield82" id="textfield82"></td>
            </tr>
            <tr class="font_main">
              <td align="left">
                <?php give_translation('#*PurchaseVat', $echo, $config_showtranslationcode);?>
              </td>
              <td align="center">ResultUni</td>
              <td align="center">ResultS</td>
              <td align="center">ResultSM</td>
              <td align="center">ResultM</td>
              <td align="center">ResultML</td>
              <td align="center">ResultL</td>
              <td align="center">ResultXL</td>
			  <td align="center">XXX</td>
			  <td align="center">XXX</td>
            </tr>

            <tr>
              <td valign="top" colspan="930" height="20"></td>
              <!-- <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td> -->
            </tr>
            <tr>
              <td colspan="12" align="left"><select name="select_ProductColor" id="select_ProductColor">
					<option>FromMatrixContent_RowX</option>
                </select>&nbsp;<div class="font_subtitle"><?php give_translation('#*Please-Select-Vaue-New-Entry', $echo, $config_showtranslationcode);?></div></td>
            </tr>
            <tr>
              <td valign="top" colspan="930" height="20"> <a href="#"><<</a> <input type="submit" name="bt_showPreviousProduct" id="bt_showPreviousProduct" value="<?php give_translation('#*Show-Previous', $echo, $config_showtranslationcode); ?>" /> <input type="submit" name="bt_saveMatrix" id="bt_saveMatrix" value="<?php give_translation('#*Save-bt', $echo, $config_showtranslationcode);?>" /> <input type="submit" name="bt_SaveAndClose" id="bt_SaveAndClose" value="<?php give_translation('#*Save-Close-bt', $echo, $config_showtranslationcode);?>" /> <input type="submit" name="bt_Close" id="bt_Close" value="<?php give_translation('#*Close-bt', $echo, $config_showtranslationcode);?>" /> <input type="submit" name="bt_showNextProduct" id="bt_showNextProduct" value="<?php give_translation('#*Show-Next', $echo, $config_showtranslationcode); ?>" /> <a class="font_main" href="http://fp-distribution.com/matrix_edit">Link to Matrix Edit Page</a> <input type="submit" id="bt_createNewMatrix" name="bt_createNewMatrix" value="<?php give_translation('#*Create_New_Matrix', $echo, $config_showtranslationcode);?>" /> <a href="#">>></a> </td>
              </tr>
          </table><br /></td>
      </tr>
<?php    
    if($status_frame_layout[5] == 1)
    {
?>    
        <tr>
        <td colspan="3" style="vertical-align: top;">
<?php
            //include('structure/frame/footer/footer1.php');
?>
        </td>
        </tr>
    
<?php
    }
?>
    <tr style="height: 100%;">
        <td style="background-color: <?php echo($tablebg_section); ?>;">
            <div></div>
        </td>
    </tr>
    
</table>
        </td>
    </tr>
		
    </table>
        
</body>
</html>


