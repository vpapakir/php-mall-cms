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

$productMatrix_tfield_length = 10; // default value, will change

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
	<body style="background-color:#B1D0AC;text-align: center;">
	
	<!-- <table width="930px" cellspacing="0" class="block_title3" cellpadding="0" border="0" align="center"> -->
	<?php
		include('structure/skin/skin1.php');
	?>
	<!-- </table> -->
	
    <table width="930px" cellspacing="0" class="center" cellpadding="0" style="text-align: center;" bgcolor="#FFFFFF" bordercolor="#DBCFBC" border="0">
		<tr class="block_title3" style="background-color:#B1D0AC;">
		<tr class="block_title3" style="background-color:#B1D0AC;">
			<td height="24px" align="center"><?php give_translation('#*Matrix-Editor', $echo, $config_showtranslationcode);?></td>
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
		  
			--><table width="930px" class="center" cellspacing="0" cellpadding="1" style="text-align: center;" bgcolor="#FFFFFF" bordercolor="#DBCFBC" border="0">
				<tr>
					<td><input type="texfield" id="searchTextField" name="searchTextField" /> <input type="submit" id="bt_SearchProducts" value="<?php give_translation('#*Search', $echo, $config_showtranslationcode);?>" /> <input type="submit" id="bt_SearchProducts" value="<?php give_translation('#*Show-Stock-Alerts', $echo, $config_showtranslationcode);?>"/><input type="submit" id="bt_ClearResults" value="<?php give_translation('#*Clear-Results', $echo, $config_showtranslationcode);?>" onclick="clearSearchResults();" /></td>
				</tr>
				<tr>
					<td height="12"></td>
				</tr>
			</table>
			
			<table width="930px" class="center" style="text-align: center;" bgcolor="#FFFFFF" bordercolor="#DBCFBC" border="0">
				<!-- <tr>
					<td colspan="2" height="20"></td>
				</tr> -->
				<tr>
					<td align="center" height="20" class="subtitle"><?php give_translation('#*No Results Found', $echo, $config_showtranslationcode); ?></td>
				</tr>
				<?php
					// TODO: generate one or more 
					$Search_Result_Count = 0; //default  value
					if($Search_Result_Count == 0) {
						// do nothing
					} else {
						for($counter=0; $counter < $Search_Result_Count; $counter++) {
							echo '<tr height="12px" class="subtitle">';
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
		  
          <table width="910px" align="center" class="center" cellspacing="0" cellpadding="1" style="text-align: center;" bgcolor="#FFFFFF" bordercolor="#DBCFBC" border="1">
            <tr>
              <td class="subtitle" align="left" colspan="2"><strong>Matrixname<br>
                Product XXX</strong></td>
              <td class="font_text">Uni<br></td>
              <td>S<br>
                34/36</td>
              <td>SM<br>
                34/40</td>
              <td>M<br>
                38/40</td>
              <td>ML<br>
                40/44</td>
              <td>L<br>
                42/44</td>
              <td>XL<br>
                46/48</td>
            </tr>
            <tr>
              <td align="left" colspan="2">
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
            </tr>
            <tr>
              <td height="20" rowspan="12" align="left" valign="top"><img width="80" height="60" src="/images/products/thumb/13904667-coffret-coquin-orale-passion.png" /></td>
              <td align="left"><?php give_translation('#*Reference', $echo, $config_showtranslationcode);?></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" size="<?echo $productMatrix_tfield_length;?>" name="textfield" id="textfield"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield14" id="textfield14"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield27" id="textfield27"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield40" id="textfield40"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield62" id="textfield62"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield66" id="textfield66"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield77" id="textfield77"></td>
            </tr>
            <tr>
              <td align="left"><?php give_translation('#*PriceRetail', $echo, $config_showtranslationcode);?></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield86" id="textfield86"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield2" id="textfield2"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield15" id="textfield15"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield28" id="textfield28"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield41" id="textfield41"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield63" id="textfield63"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield67" id="textfield67"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*PricePromo', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield87" id="textfield87"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield3" id="textfield3"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield16" id="textfield16"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield29" id="textfield29"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield42" id="textfield42"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield64" id="textfield64"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield68" id="textfield68"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*PriceReseller', $echo, $config_showtranslationcode);?></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield88" id="textfield88"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield4" id="textfield4"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield17" id="textfield17"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield30" id="textfield30"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield43" id="textfield43"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield65" id="textfield65"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield69" id="textfield69"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*AmountEcotax', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield89" id="textfield89"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield5" id="textfield5"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield18" id="textfield18"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield31" id="textfield31"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield44" id="textfield44"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield61" id="textfield61"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield78" id="textfield78"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*UnitVolume', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield90" id="textfield90"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield6" id="textfield6"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield19" id="textfield19"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield32" id="textfield32"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield45" id="textfield45"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield60" id="textfield60"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield77" id="textfield77"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*UnitWeight', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield84" id="textfield84"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield7" id="textfield7"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield20" id="textfield20"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield33" id="textfield33"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield46" id="textfield46"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield59" id="textfield59"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield76" id="textfield76"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*OnStock', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield83" id="textfield83"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield8" id="textfield8"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield21" id="textfield21"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield34" id="textfield34"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield47" id="textfield47"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield58" id="textfield58"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield75" id="textfield75"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*MinStockAlert', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield82" id="textfield82"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield9" id="textfield9"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield22" id="textfield22"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield35" id="textfield35"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield48" id="textfield48"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield57" id="textfield57"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield74" id="textfield74"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*NonStockDelay', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield81" id="textfield81"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield10" id="textfield10"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield23" id="textfield23"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield36" id="textfield36"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield52" id="textfield52"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield56" id="textfield56"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield73" id="textfield73"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*PurchaseNet', $echo, $config_showtranslationcode);?>
              </td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield80" id="textfield80"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield11" id="textfield11"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield24" id="textfield24"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield39" id="textfield39"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield51" id="textfield51"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield55" id="textfield55"></td>
              <td><input type="text" size="<?echo $productMatrix_tfield_length;?>" name="textfield72" id="textfield72"></td>
            </tr>
            <tr>
              <td align="left">
                <?php give_translation('#*PurchaseVat', $echo, $config_showtranslationcode);?>
              </td>
              <td><div id=>ResultUni</div></td>
              <td>ResultS</td>
              <td>ResultSM</td>
              <td>ResultM</td>
              <td>ResultML</td>
              <td>ResultL</td>
              <td>ResultXL</td>
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
					<option>CDR-hellhimmelblau-getont</option>
                </select>&nbsp;<?php give_translation('#*Please-Select-Vaue-New-Entry', $echo, $config_showtranslationcode);?></td>
            </tr>
            <tr>
              <td valign="top" colspan="930" height="20"> <input type="submit" name="bt_showPreviousProduct" id="bt_showPreviousProduct" value="<?php give_translation('#*Show-Previous', $echo, $config_showtranslationcode); ?>" /> <input type="submit" name="bt_saveMatrix" id="bt_saveMatrix" value="<?php give_translation('#*Save-bt', $echo, $config_showtranslationcode);?>"> <input type="submit" name="bt_SaveAndClose" id="bt_SaveAndClose" value="<?php give_translation('#*Save-Close-bt', $echo, $config_showtranslationcode);?>"> <input type="submit" name="bt_Close" id="bt_Close" value="<?php give_translation('#*Close-bt', $echo, $config_showtranslationcode);?>"> <input type="submit" name="bt_showNextProduct" id="bt_showNextProduct" value="<?php give_translation('#*Show-Next', $echo, $config_showtranslationcode); ?>" /></td>
              </tr>
          </table><br /></td>
      </tr>
    </table>
</body>
</html>
