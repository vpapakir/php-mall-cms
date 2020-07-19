<?php include($backoffice_html_skeleton_part1); ?>

<!-- product_category_add_edit.php -->


<!-- allows user to edit or create a category -->

<?php
$product_category_add_edit_title = create_translation_array('product_category_add_edit.title.text');

$subtitle_product_group= create_translation_array('product_category_add_edit.subtitle_group.text');
$subtitle_product_category = create_translation_array('product_category_add_edit.subtitle_category.text');
$subtitle_product_category_code = create_translation_array('product_category_add_edit.subtitle_category_code.text');
$subtitle_product_category_name = create_translation_array('product_category_add_edit.subtitle_category_name.text');
$subtitle_product_category_status = create_translation_array('product_category_add_edit.subtitle_category_status.text');

$button_product_option_save = create_translation_array('language_listing.save.button');
$button_product_option_disable = create_translation_array('language_listing.disable.button');

$language_listing_L1 = create_translation_array_language('L1');
$language_listing_L2 = create_translation_array_language('L2');
$language_listing_L3 = create_translation_array_language('L3');
$language_listing_L4 = create_translation_array_language('L4');
$language_listing_L5 = create_translation_array_language('L5');
?>

<?php
include('dbconnect.php');
?>

<TABLE width="100%" bgcolor="white">
    
    <td><TABLE width="100%">
        
            <td id="center_title" colspan="2">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($product_category_add_edit_title))); 
                ?>
            </td>
            <tr><td colspan="2"><hr></hr></td></tr>   
               
        <tr></tr>
        
            <form method="post">
                <!-- user selects a group -->
                <td id="center_subtitle">
                    <?php 
                        echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_group))); 
                    ?>
                </td>
                <td><SELECT name="cboGroup" onchange="OnChange('bt_selected_group')">
                    <option value="selectGroup" <?php if(@$_SESSION['selected_group'] == "selectGroup"){ echo("selected"); }else{ echo(""); } ?>>-- Sélectionnez un groupe --</option>
                    
<?php
    try
    {
        /*Select and include only actives groups into option tags*/
        $query = $connectData->query('SELECT code_group_product, status_group_product, 
                                      name_group_product_L1 
                                      FROM product_group
                                      WHERE status_group_product = 1');
        
        while($data = $query->fetch())
        {
            /*echo value : <option value='10' selected ?>Food</option>*/

            echo("<option value='".$data[0]."' ");

            if(!empty($_SESSION['selected_group']))
            {
                if($_SESSION['selected_group'] == $data[0])
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
                &nbsp; <!-- insert an icon which submits user at 'product_group_add_edit' -->
                <a href="<?php echo($_SESSION['index']); ?>?page=product_group_add_edit" style="vertical-align: inherit;"><img src="graphics/icons/pen16x16.png" title="Add group" src="Add group"></img></a>
                <input style="display: none;" id="bt_selected_group" type="submit" name="bt_selected_group" hidden></input></td>
                
        <tr></tr>
                <!-- user have to select a category to create a new one or to modify an existing one -->
                <td id="center_subtitle" <?php if(@$_SESSION['hidden'] == "hidden" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?>>
                    <?php 
                        echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_category))); 
                    ?>
                </td>
                <td><SELECT name="cboCateg" <?php if(@$_SESSION['hidden'] == "hidden" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> onchange="OnChange('bt_selected_categ')">
                        <option value="selectNewCateg" <?php if(@$_SESSION['selected_categ'] == "selectNewCateg"){ echo("selected"); }else{ echo(""); } ?>>New</option>
<?php                   
if(isset($_POST['bt_selected_group']))/*if user selected a group*/
{
    unset($_SESSION['msg_empty_txtNameCatL1']);/*all messages erased*/
    unset($_SESSION['msg_add_product_category']);
    
    $cboGroup = $_POST['cboGroup'];/*selected 'cboGroup' value included in a variable*/       
    
    $array_options_1A[] = 0;/*4 arrays created*/
    $array_options_2A[] = 0;
    $array_options_1D[] = 0;
    $array_options_2D[] = 0;
    
    $_SESSION['selected_group'] = $cboGroup;/*$cboGroup included in a session in order to */
                                        /* keep the current selected group on "selected"*/
    
    $_SESSION['selected_categ'] = "selectNewCateg";/*selected_categ session value*/
                                                /* becomes automatically "selectNewCateg" */
    
    $_SESSION['categ_already_selected'] = false;/*'categ_already_selected' session value is false*/
    
    if($cboGroup == 'selectGroup')/*if $cboGroup value is == to 'selectGroup'*/
    {        
       $_SESSION['hidden'] = "hidden";/*then 'hidden' session value becomes "hidden"...*/
              
       $_SESSION['readonly'] = "";/*'readonly' session value becomes empty...*/
       
       $_SESSION['status'] = 1;/*'status' session value becomes '1' (Active)...*/
       
       unset($_SESSION['txtCode']);/*... and delete all following sessions*/
       unset($_SESSION['txtNameL1']);
       unset($_SESSION['txtNameL2']);
       unset($_SESSION['txtNameL3']);
       unset($_SESSION['txtNameL4']);
       unset($_SESSION['txtNameL5']);
    }
    else
    {
        $_SESSION['hidden'] = "";/*then 'hidden' session value becomes empty...*/
        
        $_SESSION['readonly'] = "readonly";/*'readonly' session value becomes "readonly"...*/
        
        /*-- Activated Status --*/
        try
        {
            /*Select activated product categories*/
            $query = $connectData->prepare('SELECT code_category_product, status_category_product, 
                                          name_category_product_L1 
                                          FROM product_category
                                          WHERE status_category_product = 1
                                          AND code_group_product = :code_group');

            $query->bindParam('code_group', htmlspecialchars($cboGroup, ENT_QUOTES));

            $query->execute();
            
            for($i = 0; $i < count($array_options_1A); $i++)
            {
                while($data = $query->fetch())
                {
                    /*put datas in arrays because program's going to use it more later*/
                    $array_options_1A[$i] = $data[0];
                    $array_options_2A[$i] = $data[2];
                    $i++;
                }
            }
            /*arrays included in sessions*/
            $_SESSION['add_options_cboCateg_1A'] = $array_options_1A;
            $_SESSION['add_options_cboCateg_2A'] = $array_options_2A;

        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }
        $query->closeCursor();
        
        /*-- Disabled Status --*/
        try
        {
            /*Select disabled product categories*/
            $query = $connectData->prepare('SELECT code_category_product, status_category_product, 
                                          name_category_product_L1 
                                          FROM product_category
                                          WHERE status_category_product = 0
                                          AND code_group_product = :code_group');

            $query->bindParam('code_group', htmlspecialchars($cboGroup, ENT_QUOTES));

            $query->execute();
            
            for($i = 0; $i < count($array_options_1D); $i++)
            {
                while($data = $query->fetch())
                {
                    /*put datas in arrays because program's going to use it more later*/
                    $array_options_1D[$i] = $data[0];
                    $array_options_2D[$i] = $data[2];
                    $i++;
                }
            }
            /*arrays included in sessions*/
            $_SESSION['add_options_cboCateg_1D'] = $array_options_1D;
            $_SESSION['add_options_cboCateg_2D'] = $array_options_2D;

        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }
        $query->closeCursor();
    }
    /*page reloader*/
    echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_category_add_edit" />'); 
    //header('Location: '.$header.$_SESSION['index'].'?page=product_category_add_edit');   
}

/*if 'categ_already_selected' session value is false...*/
if(@$_SESSION['categ_already_selected'] == false)
{
    
    $_SESSION['readonly'] = "";/*then, 'readonly' session becomes empty*/
    
    $_SESSION['status'] = 1;/*'status' session becomes active*/
    
    $_SESSION['cboColor'] = true;/*'cboColor' session is true*/
    
    unset($_SESSION['txtCode']);/*delete all following sessions*/
    unset($_SESSION['txtNameL1']);
    unset($_SESSION['txtNameL2']);
    unset($_SESSION['txtNameL3']);
    unset($_SESSION['txtNameL4']);
    unset($_SESSION['txtNameL5']);
    
    try
    {
       /*Select code_category_product's column value*/
       $query = $connectData->query('SELECT code_category_product FROM product_category');

       while($data = $query->fetch())
       {
           /*and included the last value + 1 in the 'txtCode' session*/
           $_SESSION['txtCode'] = $data[0] + 1;
       }
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    $query->closeCursor();
}

/*if 'add_options_cboCateg_1A' session is < > from 0*/
if(@$_SESSION['add_options_cboCateg_1A'][0] != 0)
{
    /*display option tags when the page has been reloaded*/
    
    /*goes through the 'add_options_cboCateg_1A' session array*/ 
    for($i = 0; $i < count(@$_SESSION['add_options_cboCateg_1A']); $i++)
    {
        /*ex echo : <option value='10' selected ?>Guide</option>*/
        
        echo("<option value='".@$_SESSION['add_options_cboCateg_1A'][$i]."' ");

        if(!empty($_SESSION['selected_categ']))
                {
                    if($_SESSION['selected_categ'] == @$_SESSION['add_options_cboCateg_1A'][$i])
                    {
                        echo("selected");
                    }
                    else
                    {
                        echo("");
                    }
                }

        echo(">".@$_SESSION['add_options_cboCateg_2A'][$i]."</option>");
    }
}

/*if 'add_options_cboCateg_1D' session is < > from 0*/
if(@$_SESSION['add_options_cboCateg_1D'][0] != 0)
{
    /*display option tags when the page has been reloaded*/
    
    /*goes through the 'add_options_cboCateg_1A' session array*/ 
    for($i = 0; $i < count($_SESSION['add_options_cboCateg_1D']); $i++)
    {
        /*ex echo : */
        /*<option style='background-color: lightblue' value='12' selected ?>Taxi</option>*/
        
        echo("<option ");
        
        if(@$_SESSION['cboColor'] == true)
        {
            echo("style='background-color: lightblue'");
        }
        else
        {
            echo("");
        }
        
        echo(" value='".$_SESSION['add_options_cboCateg_1D'][$i]."' ");

        if(!empty($_SESSION['selected_categ']))
        {
            if($_SESSION['selected_categ'] == $_SESSION['add_options_cboCateg_1D'][$i])
            {
                echo("selected");
            }
            else
            {
                echo("");
            }
        }

        echo(">".@$_SESSION['add_options_cboCateg_2D'][$i]."</option>");
    }
}
                  
?>                  
                    </SELECT>                    
                    <input style="display: none;" id="bt_selected_categ" type="submit" name="bt_selected_categ" hidden></input>
                    <br><span class="tooltip" id="msg_wrong"><?php 
                                                                if(empty($_SESSION['msg_add_product_category']))
                                                                {
                                                                    /*it does nothing*/
                                                                }
                                                                else
                                                                {
                                                                   /*it displays a message*/
                                                                   echo($_SESSION['msg_add_product_category']); 
                                                                }                                                     
                                                                                        ?></span></td>
                         
                
        <tr></tr>
                <!-- if 'selected_group' session is == to "selectGroup" or is empty, then td's tag is hidden -->
                <td <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> id="center_subtitle">
                    <?php 
                        echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_category_code))); 
                    ?>
                </td> 
                <!-- if 'readonly' session isn't empty, then user couldn't to change this textfield's value -->
                <td><input <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?>                
                <?php if(!empty($_SESSION['readonly'])){ echo("readonly"); }else{ echo(""); } ?> type="text" name="txtCodeCat"></input></td>
<?php
$j = 1;
for($i = 0;$i < count($array_icon_language); $i++)
{
?>               
        <tr></tr>
                
                <td <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> id="center_subtitle">
                    <?php
                    if(count($array_icon_language) != 1)
                    {
                        echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_category_name)));
                        echo(' '.$lang[$i]);
                    }
                    else
                    {
                        echo('Nom Catégorie');
                    }
                    ?>
                </td> 
                <td><input <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> type="text" name="txtNameCatL<?php echo($j); ?>" value="<?php if(!empty($_SESSION['txtNameL'.$j])){ echo($_SESSION['txtNameL'.$j]); } ?>"></input>
                <br><span class="tooltip" id="msg_wrong"><?php 
                                                                if(empty($_SESSION['msg_empty_txtNameCatL'.$j]))
                                                                {
                                                                    
                                                                }
                                                                else
                                                                {
                                                                   echo($_SESSION['msg_empty_txtNameCatL'.$j]); 
                                                                }                                                     
                                                                                        ?></span></td>
<?php
    $j++;
}
?>       
        <tr></tr>
        
                <td <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> id="center_subtitle">
                    <?php 
                        echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_category_status)));
                    ?>
                </td> 
                <td><SELECT <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> name="cboStatus">
                        <!-- if 'status' session value is == to 1 this option will be selected -->
                        <option value="1" <?php if(@$_SESSION['status'] == 1){ echo("selected"); }else{ echo(""); } ?>>Actif</option>
                        <!-- if 'status' session value is == to 0 this option will be selected -->
                        <option value="0" <?php if(@$_SESSION['status'] == 0){ echo("selected"); }else{ echo(""); } ?>>Désactivé</option>
                    </SELECT></td>
               
        <tr><td colspan="2"><hr color="grey" size="1"></hr></td></tr>   
                
                <td <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> ></td>
                <td><input <?php if(@$_SESSION['selected_group'] == "selectGroup" || empty($_SESSION['selected_group'])){ echo("hidden"); }else{ echo(""); } ?> type="submit" name="bt_save" value="Save"></input>
                &nbsp;
                <!-- disable button will not be hidden if 'selected_group' session isn't == to "selectGroup" -->
                <!-- or empty, 'selected_categ' session isn't == to "selectNewCateg" and 'status' session isn't == to 0 -->
                <input <?php if(@$_SESSION['selected_group'] == "selectGroup" || @$_SESSION['selected_categ'] == "selectNewCateg" || empty($_SESSION['selected_group']) || @$_SESSION['status'] == 0){ echo("hidden"); }else{ echo(""); } ?> type="submit" name="bt_disable" value="Disable"
                <?php 
                if(@$_SESSION['selected_group'] == 'selectNewGroup')
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

if(isset($_POST['bt_selected_categ']))/*if user selected a category*/
{
    unset($_SESSION['msg_empty_txtNameCatL1']);/*all sessions messages deleted*/
    unset($_SESSION['msg_add_product_category']);
    
    $cboGroup = $_POST['cboGroup'];/*'cboGroup' selected dropdown value included in a variable*/
    $cboCateg = $_POST['cboCateg'];/*'cboCateg' selected dropdown value included in a variable*/
   
    $_SESSION['selected_group'] = $cboGroup;/*$cboGroup value included in a session to use it in option's tag*/
   
    $_SESSION['selected_categ'] = $cboCateg;/*$cboCateg value included in a session to use it in option's tag*/ 
    
    if($cboCateg == "selectNewCateg")/*if $cboCateg == "selectNewCateg"*/
    {
        $_SESSION['readonly'] = "";/*'readonly' session becomes empty*/
    
        unset($_SESSION['txtCode']);/*all textfield's sessions deleted*/
        unset($_SESSION['txtNameL1']);
        unset($_SESSION['txtNameL2']);
        unset($_SESSION['txtNameL3']);
        unset($_SESSION['txtNameL4']);
        unset($_SESSION['txtNameL5']);
        
        $_SESSION['status'] = 1;/*'status' session becomes active*/
        
        try
        {
           /*same as above, display the last code_category_product column's value + 1*/ 
           /* at the 'txtCode' textfield */ 
           $query = $connectData->query('SELECT code_category_product FROM product_category');
           
           while($data = $query->fetch())
           {
               $_SESSION['txtCode'] = $data[0] + 1;
           }
        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }
        $query->closeCursor();
    }
    else/*else, if $cboCateg < > from "selectNewCateg"*/
    {
        $_SESSION['readonly'] = "readonly";/*then, 'readonly' becomes full*/
        
        try
        {
            /*Select datas from product_category table according to the selected values in dropdownlists*/
            $query = $connectData->prepare('SELECT code_category_product,
                                            status_category_product,
                                            name_category_product_L1,
                                            name_category_product_L2,
                                            name_category_product_L3,
                                            name_category_product_L4,
                                            name_category_product_L5
                                            FROM product_category
                                            WHERE code_group_product = :code_group
                                            AND code_category_product = :code_categ');

            $query->execute(array(
                                  'code_group' => htmlspecialchars($cboGroup, ENT_QUOTES),
                                  'code_categ' => htmlspecialchars($cboCateg, ENT_QUOTES)
                                  ));

            while($data = $query->fetch())
            {
                /*Read datas and included them into corresponding textfields*/
                $_SESSION['txtCode'] = $data[0];
                
                if($data[1] == 0)/*if data[1] at every loop's tours is == to 0*/
                {
                    $_SESSION['status'] = 0;/*then, 'status' session becomes disabled for this tour*/
                }
                else
                {
                    $_SESSION['status'] = 1;/*else, 'status' session becomes activate for this tour*/
                }
                
                $_SESSION['txtNameL1'] = $data[2];
                $_SESSION['txtNameL2'] = $data[3];
                $_SESSION['txtNameL3'] = $data[4];
                $_SESSION['txtNameL4'] = $data[5];
                $_SESSION['txtNameL5'] = $data[6];
            }
        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }
        $query->closeCursor();

        $_SESSION['categ_already_selected'] = true;/*'categ_already_selected' session is true*/
    }
       
        echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_category_add_edit" />');
        //header('Location: '.$_SESSION['index'].'?page=product_category_add_edit');
        
}

/*----------------------------------------------------*/

/*if user clicked "Save" button and 'cboCateg' value isn't == to "selectNewCateg"*/
if(isset($_POST['bt_save']) && $_POST['cboCateg'] != "selectNewCateg")
{
    if(isset($_POST['txtNameCatL1']))/*and if something typed in 'txtNameCatL1' textfield*/ 
    {       
        $txtCodeCat = $_POST['txtCodeCat'];/*textfield values included in variables*/
        $txtNameCatL1 = $_POST['txtNameCatL1'];
        $txtNameCatL2 = $_POST['txtNameCatL2'];
        $txtNameCatL3 = $_POST['txtNameCatL3'];
        $txtNameCatL4 = $_POST['txtNameCatL4'];
        $txtNameCatL5 = $_POST['txtNameCatL5'];
        
        
        $cboGroup = $_POST['cboGroup'];/*DropDown values included in variables*/
        $cboCateg = $_POST['cboCateg'];
        $cboStatus = $_POST['cboStatus'];

        $_SESSION['selected_group'] = $cboGroup;/*$cboGroup value included in a session*/

        $_SESSION['selected_categ'] = $cboCateg;/*$cboCateg value included in a session*/
        
        $_SESSION['status'] = $cboStatus;/*$cboStatus value included in a session*/
        
        if($cboStatus == 1)/*if $cboStatus == 1*/
        {
            $_SESSION['cboColor'] = false;/*then, 'cboColor' session is false*/
        }
        else
        {
            $_SESSION['cboColor'] = true;/*else, 'cboColor' session is true*/
        }

        
        if(empty($txtNameCatL1))/*if $txtNameCatL1 variable is empty*/
        {
           /*a message included in a session and it's going to be displayed into a span's tag*/
           $_SESSION['msg_empty_txtNameCatL1'] = "Veuillez saisir le Nom de categorie correspondant a la langue L1"; 
        }
        else
        {
            try
            {
                /*try to update the table's row according to the selected values in dropdownlists */
                $query = $connectData->prepare('UPDATE product_category
                                                SET status_category_product = :status,
                                                name_category_product_L1 = :txtNameCatL1,
                                                name_category_product_L2 = :txtNameCatL2,
                                                name_category_product_L3 = :txtNameCatL3,
                                                name_category_product_L4 = :txtNameCatL4,
                                                name_category_product_L5 = :txtNameCatL5
                                                WHERE code_category_product = :txtCodeCat
                                                AND code_group_product = :code_group');

                $query->execute(array(
                                      'status' => htmlspecialchars($cboStatus, ENT_QUOTES),
                                      'txtNameCatL1' => htmlspecialchars($txtNameCatL1, ENT_QUOTES),
                                      'txtNameCatL2' => htmlspecialchars($txtNameCatL2, ENT_QUOTES),
                                      'txtNameCatL3' => htmlspecialchars($txtNameCatL3, ENT_QUOTES),
                                      'txtNameCatL4' => htmlspecialchars($txtNameCatL4, ENT_QUOTES),
                                      'txtNameCatL5' => htmlspecialchars($txtNameCatL5, ENT_QUOTES),
                                      'txtCodeCat' => htmlspecialchars($txtCodeCat, ENT_QUOTES),
                                      'code_group' => htmlspecialchars($cboGroup, ENT_QUOTES),
                                      ));
                
                /*and a message included in a session and it's going to be displayed into a span's tag*/
                $_SESSION['msg_add_product_category'] = "La cat�gorie \"".$txtNameCatL1."\" a �t� modifi�e";
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            $query->closeCursor();
        }
    }
    
    echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_category_add_edit" />');
    //header('Location: '.$_SESSION['index'].'?page=product_category_add_edit');
}

/*----------------------------------------------------*/


/*if user clicked "Save" button and 'cboCateg' value is == to "selectNewCateg"*/

/*program will go to create a new category into the database*/
if(isset($_POST['bt_save']) && $_POST['cboCateg'] == "selectNewCateg")
{
    if(isset($_POST['txtNameCatL1']))
    {       
        $txtCodeCat = $_POST['txtCodeCat'];
        $txtNameCatL1 = $_POST['txtNameCatL1'];
        $txtNameCatL2 = $_POST['txtNameCatL2'];
        $txtNameCatL3 = $_POST['txtNameCatL3'];
        $txtNameCatL4 = $_POST['txtNameCatL4'];
        $txtNameCatL5 = $_POST['txtNameCatL5'];
        
        $BoKname = true;
               
        $cboGroup = $_POST['cboGroup'];
        $cboCateg = $_POST['cboCateg'];
        $cboStatus = $_POST['cboStatus'];

        $_SESSION['selected_group'] = $cboGroup;

        $_SESSION['selected_categ'] = $cboCateg;
        
        $_SESSION['status'] = $cboStatus;
        
        if($cboStatus == 1)
        {
            $_SESSION['cboColor'] = false;
        }
        else
        {
            $_SESSION['cboColor'] = true;
        }
        

        
        if(empty($txtNameCatL1))
        {
           $_SESSION['msg_empty_txtNameCatL1'] = "Veuillez saisir le Nom de categorie correspondant a la langue L1";
           $BoKname = false;
        }
        else
        {
            $BoKname = true;
        }
                               
        if($BoKname == true)
        {
            try
            {
                /*only query isn't the same as above. It's an 'INSERT'*/
                $query = $connectData->prepare('INSERT INTO product_category(
                                                code_category_product,
                                                status_category_product,
                                                code_group_product,
                                                name_category_product_L1,
                                                name_category_product_L2,
                                                name_category_product_L3,
                                                name_category_product_L4,
                                                name_category_product_L5)
                                                VALUE(:txtCodeCat, :status, :code_group, :txtNameCatL1, 
                                                      :txtNameCatL2, :txtNameCatL3,
                                                      :txtNameCatL4, :txtNameCatL5)');

                $query->execute(array(
                                      'txtCodeCat' => htmlspecialchars($txtCodeCat, ENT_QUOTES),
                                      'status' => htmlspecialchars($cboStatus, ENT_QUOTES),
                                      'code_group' => htmlspecialchars($cboGroup, ENT_QUOTES),
                                      'txtNameCatL1' => htmlspecialchars($txtNameCatL1, ENT_QUOTES),
                                      'txtNameCatL2' => htmlspecialchars($txtNameCatL2, ENT_QUOTES),
                                      'txtNameCatL3' => htmlspecialchars($txtNameCatL3, ENT_QUOTES),
                                      'txtNameCatL4' => htmlspecialchars($txtNameCatL4, ENT_QUOTES),
                                      'txtNameCatL5' => htmlspecialchars($txtNameCatL5, ENT_QUOTES),        
                                      ));
                
                /*and a message included in a session and it's going to be displayed into a span's tag*/
                $_SESSION['msg_add_product_category'] = "La cat�gorie \"".$txtNameCatL1."\" a �t� cr��e";
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            $query->closeCursor();
        }
    }
    
    echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_category_add_edit" />');
    //header('Location: '.$_SESSION['index'].'?page=product_category_add_edit');
}

/*------------------------------------------------------*/

if(isset($_POST['bt_disable']))/*if user clicked "Disable" button*/
{
    $cboGroup = $_POST['cboGroup'];/*DropDown values included in variables*/
    $cboCateg = $_POST['cboCateg'];
    
    $txtNameCatL1 = $_POST['txtNameCatL1'];/*'txtNameCatL1' textfield's value included in variable*/
    
    try
    {
        /*change category's status to 0 according to the selected values in dropdownlists */
        $query = $connectData->prepare('UPDATE product_category
                                        SET status_category_product = 0
                                        WHERE code_category_product = :code_categ
                                        AND code_group_product = :code_group');
        
        $query->execute(array(
                              'code_categ' => htmlspecialchars($cboCateg, ENT_QUOTES),
                              'code_group' => htmlspecialchars($cboGroup, ENT_QUOTES)
                              ));
        
        /*and a message included in a session and it's going to be displayed into a span's tag*/
        $_SESSION['msg_add_product_category'] = "La cat�gorie \"".$txtNameCatL1."\" a �t� d�sactiv�e";
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    $query->closeCursor();
    
    $_SESSION['status'] = 0;/*'status' session becomes 'disabled'*/
    
    $_SESSION['cboColor'] = true;/*'cboColor' session is true*/
    
    echo('<meta http-equiv="refresh" content="0;url='.$header.$_SESSION['index'].'?page=product_category_add_edit" />');
    //header('Location: '.$_SESSION['index'].'?page=product_category_add_edit');
}

?>


        
<!--import my javascript-->

<script type="text/javascript" src="script.js"></script>