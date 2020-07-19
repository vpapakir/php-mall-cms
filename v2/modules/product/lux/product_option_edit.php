<?php include($backoffice_html_skeleton_part1); ?>

<!-- product_option_edit.php -->


<!-- allows user to create or edit Product options -->

<?php
$product_option_edit_title = create_translation_array('product_option_edit.title.text');

$subtitle_product_option = create_translation_array('product_option_edit.subtitle_option.text');
$subtitle_product_option_code = create_translation_array('product_option_edit.subtitle_code.text');
$subtitle_product_option_category = create_translation_array('product_option_edit.subtitle_category.text');
$subtitle_product_option_type = create_translation_array('product_option_edit.subtitle_type.text');
$subtitle_product_option_name = create_translation_array('product_option_edit.subtitle_name.text');
$subtitle_product_option_status = create_translation_array('product_option_edit.subtitle_status.text');

$dropdown_product_option = create_translation_array('product_option_edit.option_new.dropdown');
$dropdown_product_option_category = create_translation_array('product_option_edit.option_category.dropdown');
$dropdown_product_option_type = create_translation_array('product_option_edit.option_type.dropdown');

$dropdown_product_status_A = create_translation_array('product_option_edit.option_status_A.dropdown');
$dropdown_product_status_D = create_translation_array('product_option_edit.option_status_D.dropdown');

$msg_product_select_categ_type = create_translation_array('product_option_edit.option_select_categ_type_msg.text');
$msg_product_select_categ = create_translation_array('product_option_edit.option_select_categ_msg.text');
$msg_product_select_type = create_translation_array('product_option_edit.option_select_type_msg.text');
$msg_product_new_option_part1 = create_translation_array('product_option_edit.option_new_part1_msg.text');
$msg_product_new_option_part2 = create_translation_array('product_option_edit.option_new_part2_msg.text');


$button_product_option_save = create_translation_array('language_listing.save.button');
$button_product_option_disable = create_translation_array('language_listing.disable.button');

$image_title_add_category = create_translation_array('product_add.add_category.icon');//"Add category"

$language_listing_L1 = create_translation_array_language('L1');
$language_listing_L2 = create_translation_array_language('L2');
$language_listing_L3 = create_translation_array_language('L3');
$language_listing_L4 = create_translation_array_language('L4');
$language_listing_L5 = create_translation_array_language('L5');

$used_language = $_SESSION['lang'];
?>

<?php
    /*connect to Database*/
    include('dbconnect.php'); 
    
    /*when an option doesn't exist a link, which allows user to create a new one, created */
    if(isset($_GET['click']) && !is_numeric($_GET['click']) ? $_GET['click'] : 0)
    {
        if(!empty($_GET['click']))
        {           
           $_SESSION['selected_option'] = 'selectNew';/*'selectNew' string included in a session*/
           
           unset($_SESSION['msg_product_option_cbo']);/*message session deleted*/
                     
        }
    }
?>

<TABLE width="100%" bgcolor="white">
    
    <td><TABLE width="100%">
            <!-- PAGE TITLE -->
            <td id="center_title" colspan="2">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($product_option_edit_title))); 
                ?>
            </td>
            <tr><td colspan="2"><hr></hr></td></tr>
            
        <tr></tr>
        
     <form method="post">
             <!-- user can choose an option here -->
             <!-- DropDownList 1/4 -->
             <td id="center_subtitle" width="30%">
                 <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_option))); 
                 ?>
             </td>            
             <td><SELECT name="cboOption" onchange="OnChange('bt_chosen_option')">
                     <option value="selectNew"><?php echo(call_translation(@$_SESSION['translation'], find_word($dropdown_product_option))); ?></option>
<?php

/*-- Activated Status --*/
    try
    {
        /*Select activated product options*/
        $query = $connectData->query('SELECT id_option_product, status_option_product, 
                                      name_option_product_'.$used_language.'
                                      FROM product_option
                                      WHERE status_option_product = 1');
        
        while($data = $query->fetch())
        {
            /*ex echo : <option value='1' selected ?>produit Bio</option>*/
           
            echo("<option value='".$data[0]."' ");

            if(!empty($_SESSION['selected_option']))
            {
                if($_SESSION['selected_option'] == $data[0])
                {
                    echo("selected");
                }
                else
                {
                    echo("");
                }
            }

            echo(">".$data[2]."</option>");          
        }

/*-- Disabled Status --*/        
        
        /*Select disabled product options*/
        $query = $connectData->query('SELECT id_option_product, status_option_product, 
                                      name_option_product_'.$used_language.' 
                                      FROM product_option
                                      WHERE status_option_product = 0');
        
        while($data = $query->fetch())
        {
           /*ex echo : */
           /*<option style='background-color: lightblue' value='7' selected ?>Pr�s (Guide)</option>*/ 
            
           echo("<option style='background-color: lightblue;' value='".$data[0]."' ");

            if(!empty($_SESSION['selected_option']))
            {
                if($_SESSION['selected_option'] == $data[0])
                {
                    echo("selected");
                }
                else
                {
                    echo("");
                }
            }

            echo(">".$data[2]."</option>");           
        }
           
        
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    $query->closeCursor();

?>                    
                     
             </SELECT> 
             <input style="display: none;" id="bt_chosen_option" type="submit" name="bt_chosen_option" hidden></input>
             <br><span class="tooltip" id="msg_wrong"><?php
                                                        if(!empty($_SESSION['msg_product_option_cbo']))/*if 'msg_product_option_cbo' session isn't empty*/
                                                        {
                                                            /*if session == "Aucune donn�e pour ces crit�res, cr�er une nouvelle option ?"*/
                                                            if($_SESSION['msg_product_option_cbo'] == (call_translation(@$_SESSION['translation'], find_word($msg_product_new_option_part1))).' '.call_translation(@$_SESSION['translation'], find_word($msg_product_new_option_part2)))
                                                            {
                                                                /*then, a message displayed with a link*/
                                                                echo(call_translation(@$_SESSION['translation'], find_word($msg_product_new_option_part1)).' <a href="'.$_SESSION['index'].'?page=product_option_edit&click=ok">'.call_translation(@$_SESSION['translation'], find_word($msg_product_new_option_part2)).'</a>');                                                             
                                                            }
                                                            else
                                                            {
                                                                echo($_SESSION['msg_product_option_cbo']); 
                                                            }       
                                                        }
                                                        
                                                        if(!empty($_SESSION['msg_product_option_add']))
                                                        {
                                                            echo($_SESSION['msg_product_option_add']);
                                                        }
                                                            ?></span></td>
         
        <tr></tr>
             <!-- code_option_product displays here -->
             <!-- textfield 1/2 -->
             <td id="center_subtitle" <?php if(@$_SESSION['selected_option'] == 'selectNew') { echo(""); }else { echo("hidden"); }?>>
                 <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_option_code))); 
                 ?>
             </td>
             <td><input type="text" name="txtCodeOption" 
             <?php
                 if(@$_SESSION['selected_option'] == 'selectNew')
                 { 
                     /*display 'txtCodeOption' value into this textfield*/
                     echo("Value='".@$_SESSION['txtCodeOption']."'");                    
                 }
                 else 
                 { 
                     echo("hidden");/*textfield is hidden*/                 
                 }
             ?>
                        /></td>
             
        <tr></tr>               
             <!-- user must choose a category here -->
             <!-- DropDownList 2/4 -->
             <td id="center_subtitle">
                 <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_option_category))); 
                 ?>
             </td>
             <td><SELECT name="cboCateg">
                     <option value="selectCateg">-- <?php echo(call_translation(@$_SESSION['translation'], find_word($dropdown_product_option_category))); ?> --</option>
<?php

    try
    {
        /*include all existing categories from product_category's table in a dropdownlist*/
        $query = $connectData->query('SELECT code_category_product, name_category_product_'.$used_language.' FROM product_category');
        
        while($data = $query->fetch())
        {
            /*ex echo : <option value='11' selected ?>Guide</option>*/
            
            echo("<option value='".$data[0]."' ");
            
            if(!empty($_SESSION['selected_categ']))
            {
                if($_SESSION['selected_categ'] == $data[0])
                {
                    echo("selected");
                }
                else
                {
                    echo("");
                }
            }
         
            echo(">".$data[1]."</option>");
        }
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }                   
    $query->closeCursor();                                      
?>                     
                     

             </SELECT>
             &nbsp;
             <a href="<?php echo($_SESSION['index']); ?>?page=product_category_add_edit" style="vertical-align: inherit;"><img src="graphics/icons/pen16x16.png" title="<?php echo(call_translation(@$_SESSION['translation'], find_word($image_title_add_category))); ?>" alt="Add category"></img></a></td>
             
        <tr></tr>
             <!-- user must choose a type here -->
             <!-- DropDownList 3/4 -->   
             <td id="center_subtitle">
                 <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_option_type))); 
                 ?>
             </td>
             <td><SELECT name="cboType">
                     <option value="selectType">-- <?php echo(call_translation(@$_SESSION['translation'], find_word($dropdown_product_option_type))); ?> --</option>
<?php

    try
    {
        /*include all existing types from product_type's table in a dropdownlist*/
        $query = $connectData->query('SELECT id_type_product, name_type_product_'.$used_language.' FROM product_type');
        
        while($data = $query->fetch())
        {
            /*ex echo : <option value='1' selected ?>Type 1</option>*/
            
            echo("<option value='".$data[0]."' ");
            
            if(!empty($_SESSION['selected_type']))
            {
                if($_SESSION['selected_type'] == $data[0])
                {
                    echo("selected");
                }
                else
                {
                    echo("");
                }
            }
         
            echo(">".$data[1]."</option>");
        }
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }                   
    $query->closeCursor(); 

?>                     
                     

             </SELECT></td>
<?php
$j = 1;
for($i = 0;$i < count($array_icon_language); $i++)
{
?>          
        <tr></tr>
            <!-- name_option_product_L1 displays here -->
            <!-- textfield 2/2 --> 
            <td id="center_subtitle">
                <?php 
                if(count($array_icon_language) != 1)
                {
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_option_name)));                  
                    echo(' '.$lang[$i]);
                }
                else
                {
                    echo('Nom de l\'option');
                }
                ?>
            </td>
            <td><input type="text" name="txtNameOptionProd_L<?php echo($j); ?>" value="<?php if(!empty($_SESSION['txtNameL'.$j])) { echo($_SESSION['txtNameL'.$j]); }?>"/></td>
<?php
    $j++;
}
?>       
        <tr></tr>
            <!-- user can choose a status here -->
            <!-- DropDownList 4/4 --> 
            <td id="center_subtitle">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_option_status))); 
                ?>
            </td>
            <td><SELECT name="cboStatus">
                <option value="1" <?php if(@$_SESSION['status'] == 1){ echo("selected"); }else{ echo(""); } ?>><?php echo(call_translation(@$_SESSION['translation'], find_word($dropdown_product_status_A))); ?></option>
                <option value="0" <?php if(@$_SESSION['status'] == 0){ echo("selected"); }else{ echo(""); } ?>><?php echo(call_translation(@$_SESSION['translation'], find_word($dropdown_product_status_D))); ?></option>
                </SELECT>
                <br><span class="tooltip" id="msg_wrong"><?php
                                                        if(!empty($_SESSION['msg_product_option_disabled']))
                                                        {
                                                            echo($_SESSION['msg_product_option_disabled']);    
                                                        }                                                                    
                                                            ?></span></td>
            
        <tr></tr>
            <!-- "Save" and "Disable" buttons -->
            <tr><td colspan="2"><hr color="grey" size="1"></hr></td></tr>
            <td></td>
            <td><input type="submit" name="bt_save" value="<?php echo(call_translation(@$_SESSION['translation'], find_word($button_product_option_save))); ?>" 
            <?php      
                 if(!empty($_SESSION['msg_product_option_cbo']))
                 {
                     echo("hidden");
                 }
                 else
                 {
                     echo("");
                 }
            ?>
                       ></input>
            &nbsp;
            <input type="submit" name="bt_disable" value="<?php echo(call_translation(@$_SESSION['translation'], find_word($button_product_option_disable))); ?>" 
            <?php 
                if(@$_SESSION['selected_option'] == 'selectNew' || @$_SESSION['hidden_bt_delete'] == true || @$_SESSION['status'] == 0)
                {
                    echo("hidden"); 
                }
                else
                {
                    echo("");
                }
            ?>
                ></input></td>
            
     </form>
    
        </TABLE></td>
    
</TABLE>


<?php
include($backoffice_html_skeleton_part2);

if(isset($_POST['bt_chosen_option']))/*when user had selected an option*/
{
    unset($_SESSION['msg_product_option_disabled']);/*all message sessions deleted*/
    unset($_SESSION['msg_product_option_add']);
    
    $cboOption = $_POST['cboOption'];/*DropDown values included in variables*/
    $cboCateg = $_POST['cboCateg'];
    $cboType = $_POST['cboType'];
   
    $i = 0;/*an index created*/
      
    $BoKnext = true;/*booleans created*/
    $BoKnotFound = false;
        
    
    $_SESSION['selected_option'] = $cboOption;/*$cboOption value included in a session*/
    
    if($cboCateg == 'selectCateg' && $cboType == 'selectType' )
    {
        $BoKnext = false;/*boolean 'BoKnext' is false*/
        
        /*a message included in a session and will display into a span's tag*/
        $_SESSION['msg_product_option_cbo'] = call_translation(@$_SESSION['translation'], find_word($msg_product_select_categ_type));
        
        /*delete textfield and selected's sessions*/
        unset($_SESSION['selected_type']);
        unset($_SESSION['selected_categ']);
        unset($_SESSION['txtNameL1']);
        unset($_SESSION['txtNameL2']);
        unset($_SESSION['txtNameL3']);
        unset($_SESSION['txtNameL4']);
        unset($_SESSION['txtNameL5']);
        
        $_SESSION['status'] = 1;/*'status' session becomes active*/
    }
     
    /*same as above but message is different and $cboType value included in 'selected_type' session*/
    if($cboCateg == 'selectCateg' && $cboType != 'selectType')
    {
        $BoKnext = false;
        $_SESSION['msg_product_option_cbo'] = call_translation(@$_SESSION['translation'], find_word($msg_product_select_categ));
        $_SESSION['selected_type'] = $cboType;
        unset($_SESSION['selected_categ']);
        unset($_SESSION['txtNameL1']);
        unset($_SESSION['txtNameL2']);
        unset($_SESSION['txtNameL3']);
        unset($_SESSION['txtNameL4']);
        unset($_SESSION['txtNameL5']);
        
        $_SESSION['status'] = 1;
    }
     
    /*same as above but message is different and $cboCateg value included in 'selected_categ' session*/
    if($cboType == 'selectType' && $cboCateg != 'selectCateg')
    {
       $BoKnext = false;
       $_SESSION['msg_product_option_cbo'] = call_translation(@$_SESSION['translation'], find_word($msg_product_select_type));
       $_SESSION['selected_categ'] = $cboCateg;
       unset($_SESSION['selected_type']);
       unset($_SESSION['txtNameL1']);
       unset($_SESSION['txtNameL2']);
       unset($_SESSION['txtNameL3']);
       unset($_SESSION['txtNameL4']);
       unset($_SESSION['txtNameL5']);
       
       $_SESSION['status'] = 1;
    }
    
    if($BoKnext == true)/*if 'BoKnext' is true*/
    {       
        unset($_SESSION['msg_product_option_cbo']);/*a message session deleted*/
        $_SESSION['selected_type'] = $cboType;/*$cboType value included in a session*/
        $_SESSION['selected_categ'] = $cboCateg;/*$cboCateg value included in a session*/
        
        $_SESSION['status'] = 1;/*'status' session becomes active*/
        
        
        /*if chosen option doesn't have Information in the database and 
         * when user clicked link under the 'cboOption' DropDown list*/
        
        try
        {
            /*Select 'code_option_product' column's value where id_option_product is = to $cboOption value*/
            $query = $connectData->prepare('SELECT code_option_product
                                            FROM product_option
                                            WHERE id_option_product = :id');
                    
            $query->bindParam('id', htmlspecialchars($cboOption));
            
            $query->execute();
            
            while($data = $query->fetch())
            {
                /*and the $data[0] value included in a textfield session*/
                $_SESSION['txtCodeOption'] = $data[0];
            }
        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }                   
        $query->closeCursor();
        
        /*if user selected one of all options at 3 DropDown Lists Except the 'New' option*/
        
        if($cboOption != 'selectNew')
        {
            try
            {
                /*Select name_option in 5 languages according to the selected values in dropdownlists */
                $query = $connectData->prepare('SELECT name_option_product_L1,
                                                name_option_product_L2,
                                                name_option_product_L3,
                                                name_option_product_L4,
                                                name_option_product_L5
                                                FROM product_option
                                                WHERE code_category_product = :cboCateg
                                                AND id_type_product = :cboType
                                                AND id_option_product = :cboOption');
                
                $query->execute(array(
                                      'cboCateg' => htmlspecialchars($cboCateg, ENT_QUOTES),
                                      'cboType' => htmlspecialchars($cboType, ENT_QUOTES),
                                      'cboOption' => htmlspecialchars($cboOption, ENT_QUOTES)
                                      ));
 
                $data = $query->fetch();
                
                
                
                if($data == false)/*if query doesn't return a value*/
                {
                    /*a message will be displayed*/
                    $_SESSION['msg_product_option_cbo'] = call_translation(@$_SESSION['translation'], find_word($msg_product_new_option_part1)).' '.call_translation(@$_SESSION['translation'], find_word($msg_product_new_option_part2));
                    unset($_SESSION['txtNameL1']);/*all textfield's sessions deleted*/
                    unset($_SESSION['txtNameL2']);
                    unset($_SESSION['txtNameL3']);
                    unset($_SESSION['txtNameL4']);
                    unset($_SESSION['txtNameL5']);
                    
                    $BoKnotFound = true;/*$BoKnotFound boolean is true*/
                    
                }
                else
                {
                    /*message's session deleted*/
                    unset($_SESSION['msg_product_option_cbo']);
                    
                    /*Select name_option in 5 languages  and option's status according to the selected values in dropdownlists */
                    $query = $connectData->prepare('SELECT status_option_product,
                                                name_option_product_L1,
                                                name_option_product_L2,
                                                name_option_product_L3,
                                                name_option_product_L4,
                                                name_option_product_L5
                                                FROM product_option
                                                WHERE code_category_product = :cboCateg
                                                AND id_type_product = :cboType
                                                AND id_option_product = :cboOption');
                
                    $query->execute(array(
                                          'cboCateg' => htmlspecialchars($cboCateg, ENT_QUOTES),
                                          'cboType' => htmlspecialchars($cboType, ENT_QUOTES),
                                          'cboOption' => htmlspecialchars($cboOption, ENT_QUOTES)
                                          ));
                    
                    while($data = $query->fetch())
                    {
                       /*insert data's values in textfields*/ 
                       $_SESSION['txtNameL1'] = $data[1];
                       $_SESSION['txtNameL2'] = $data[2];
                       $_SESSION['txtNameL3'] = $data[3];
                       $_SESSION['txtNameL4'] = $data[4];
                       $_SESSION['txtNameL5'] = $data[5]; 
                       
                       /*insert data[0]'s values in 'status' session*/
                       $_SESSION['status'] = $data[0];                       
                    }
                    
                    $BoKnotFound = false;/*$BoKnotFound boolean is false*/
                    
                }                                  
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }                   
            $query->closeCursor();
            
            $_SESSION['hidden_bt_delete'] = $BoKnotFound;/*$BoKnotFound boolean value included in a session*/
        }
        else /*$cboOption == 'selectNew'*/
        {           
            /*all textfield's values deleted*/
            unset($_SESSION['txtNameL1']);
            unset($_SESSION['txtNameL2']);
            unset($_SESSION['txtNameL3']);
            unset($_SESSION['txtNameL4']);
            unset($_SESSION['txtNameL5']);
            unset($_SESSION['txtCodeOption']);
            
            /*'status' session becomes active*/
            $_SESSION['status'] = 1;
        }
        
    }
    
    echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_option_edit" />');
    //header('Location: '.$_SESSION['index'].'?page=product_option_edit');
}


/*---------------------------------------------------*/

if(isset($_POST['bt_disable']))/*if user clicked "Disable" button*/
{   
    $cboOption = $_POST['cboOption'];/*DropDown values included in variables*/
    $cboCateg = $_POST['cboCateg'];
    $cboType = $_POST['cboType'];
    
    /*'txtNameOptionProd_L1' textfield's value included in a variable*/
    $txtNameProd_L1 = $_POST['txtNameOptionProd_L1'];
    
    $_SESSION['status'] = 0;/*'status' session becomes disabled*/
    
    unset($_SESSION['msg_product_option_add']);/*message session deleted*/
   
    try
    {
        /*update status according to the selected values in dropdownlists */
        $query = $connectData->prepare('UPDATE product_option SET status_option_product = 0
                                        WHERE id_option_product = :id
                                        AND code_category_product = :categ
                                        AND id_type_product = :type');
        
        $query->execute(array(
                              'id' => htmlspecialchars($cboOption, ENT_QUOTES),
                              'categ' => htmlspecialchars($cboCateg, ENT_QUOTES),
                              'type' => htmlspecialchars($cboType, ENT_QUOTES),
                              ));
       
        /*a corresponding message will be displayed*/
        $_SESSION['msg_product_option_disabled'] = "L'option ".htmlspecialchars($txtNameProd_L1, ENT_QUOTES)." / ".$cboCateg." / ".$cboType." a �t� d�sactiv�e";
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }                   
    $query->closeCursor();
    
    echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_option_edit" />');
    //header('Location: '.$_SESSION['index'].'?page=product_option_edit');
}

/*---------------------------------------------------*/

if(isset($_POST['bt_save']))/*if user clicked "Save" button*/
{
    $cboStatus = $_POST['cboStatus'];/*DropDown values included in variables*/
    $cboOption = $_POST['cboOption'];
    $cboCateg = $_POST['cboCateg'];
    $cboType = $_POST['cboType'];
 
    /*if one of all 'txtNameOptionProd' textfield isn't empty*/
    if(isset($_POST['txtNameOptionProd_L1']) || $_POST['txtNameOptionProd_L2']
            || $_POST['txtNameOptionProd_L3'] || $_POST['txtNameOptionProd_L4']
            || $_POST['txtNameOptionProd_L5'])
    {
        /*textfield's values included in a variable*/
        $txtNameProd_L1 = $_POST['txtNameOptionProd_L1'];
        $txtNameProd_L2 = $_POST['txtNameOptionProd_L2'];
        $txtNameProd_L3 = $_POST['txtNameOptionProd_L3'];
        $txtNameProd_L4 = $_POST['txtNameOptionProd_L4'];
        $txtNameProd_L5 = $_POST['txtNameOptionProd_L5'];

        unset($_SESSION['msg_product_option_disabled']);/*message session deleted*/

        try
        {
            /*update status and 'name_option_product' in 5 languages according to the selected values in dropdownlists */
            $query = $connectData->prepare('UPDATE product_option SET status_option_product = :status,
                                            name_option_product_L1 = :txtNameOpL1,
                                            name_option_product_L2 = :txtNameOpL2,
                                            name_option_product_L3 = :txtNameOpL3,
                                            name_option_product_L4 = :txtNameOpL4,
                                            name_option_product_L5 = :txtNameOpL5
                                            WHERE id_option_product = :id
                                            AND code_category_product = :categ
                                            AND id_type_product = :type');

            $query->execute(array(
                                  'status' => htmlspecialchars($cboStatus, ENT_QUOTES),
                                  'txtNameOpL1' => htmlspecialchars($txtNameProd_L1, ENT_QUOTES),
                                  'txtNameOpL2' => htmlspecialchars($txtNameProd_L2, ENT_QUOTES),
                                  'txtNameOpL3' => htmlspecialchars($txtNameProd_L3, ENT_QUOTES),
                                  'txtNameOpL4' => htmlspecialchars($txtNameProd_L4, ENT_QUOTES),
                                  'txtNameOpL5' => htmlspecialchars($txtNameProd_L5, ENT_QUOTES),
                                  'id' => htmlspecialchars($cboOption, ENT_QUOTES),
                                  'categ' => htmlspecialchars($cboCateg, ENT_QUOTES),
                                  'type' => htmlspecialchars($cboType, ENT_QUOTES),
                                  ));

            /*a corresponding message will be displayed*/
            $_SESSION['msg_product_option_add'] = "L'option \"".htmlspecialchars($txtNameProd_L1, ENT_QUOTES)."\" a �t� modifi�e";

            $_SESSION['status'] = $cboStatus;/*$cboStatus value included in 'status' session*/
           
            /*textfield's values included in textfield's sessions*/
            $_SESSION['txtNameL1'] = $txtNameProd_L1;
            $_SESSION['txtNameL2'] = $txtNameProd_L2;
            $_SESSION['txtNameL3'] = $txtNameProd_L3;
            $_SESSION['txtNameL4'] = $txtNameProd_L4;
            $_SESSION['txtNameL5'] = $txtNameProd_L5;
        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }                   
        $query->closeCursor();

        echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_option_edit" />');
        //header('Location: '.$_SESSION['index'].'?page=product_option_edit');   
    }
}

?>

<!--import my javascript-->

<script type="text/javascript" src="script.js"></script>