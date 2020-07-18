<?php 
if(isset($_POST['bt_selected_group']) || isset($_POST['bt_disable']) 
        || isset($_POST['bt_save']))/*if user selected a group*/
{
   header('Location: '.$_SESSION['index'].'?page=product_group_add_edit'); 
}

include($backoffice_html_skeleton_part1); 

?>

<!-- product_group_add_edit.php -->


<!-- allows user to edit or create a group -->

<?php
$product_group_add_edit_title = create_translation_array('product_group_add_edit.title.text');

?>

<?php
include('dbconnect.php');
?>

<TABLE width="100%" bgcolor="white">
    
    <td><TABLE width="100%">
        
            <td id="center_title" colspan="2"><?php echo(call_translation(@$_SESSION['translation'], find_word($product_group_add_edit_title))); ?></td>
            <tr><td colspan="2"><hr color="grey" size="1"></hr></td></tr>
            
        <tr></tr>
        
            <form method="post">
                <!-- user can choose a group here -->
                <!-- DropDownList 1/2 -->
                <td id="center_subtitle" width="30%">Groupe</td>
                <td><SELECT name="cboGroup" onchange="OnChange('bt_selected_group')">
                        <option value="selectNewGroup" <?php if(@$_SESSION['selected_group'] == "selectNewGroup"){ echo("selected"); }else{ echo(""); } ?>>New</option>
<?php 
$array_options_1A[] = 0;/*4 arrays created*/
$array_options_2A[] = 0;
$array_options_1D[] = 0;
$array_options_2D[] = 0;

/*-- Activated Status --*/
try
{
    /*Select activated product groups*/
    $query = $connectData->query('SELECT code_group_product,
                                  name_group_product_L1
                                  FROM product_group
                                  WHERE status_group_product = 1');
    
    for($i = 0; $i < count($array_options_1A); $i++)
    {
        while($data = $query->fetch())
        {
            /*put datas in arrays because program's going to use it more later*/
            $array_options_1A[$i] = $data[0];
            $array_options_2A[$i] = $data[1];
            $i++;
        }
    }
    /*arrays included in sessions*/
    $_SESSION['add_options_cboGroup_1A'] = $array_options_1A;
    $_SESSION['add_options_cboGroup_2A'] = $array_options_2A;
}
catch(Exception $e)
{
    die("Error : ".$e->getMessage());
}
$query->closeCursor();

/*-- Disabled Status --*/

try
{
    /*Select disabled product groups*/
    $query = $connectData->query('SELECT code_group_product,
                                  name_group_product_L1
                                  FROM product_group
                                  WHERE status_group_product = 0');
    
    for($i = 0; $i < count($array_options_1D); $i++)
    {
        while($data = $query->fetch())
        {
            /*put datas in arrays because program's going to use it more later*/
            $array_options_1D[$i] = $data[0];
            $array_options_2D[$i] = $data[1];
            $i++;
        }
    }
    /*arrays included in sessions*/
    $_SESSION['add_options_cboGroup_1D'] = $array_options_1D;
    $_SESSION['add_options_cboGroup_2D'] = $array_options_2D;
}
catch(Exception $e)
{
    die("Error : ".$e->getMessage());
}
$query->closeCursor();

/*if 'group_already_selected' session value is false...*/
if(@$_SESSION['group_already_selected'] == false)
{
    /*then, message and textfield's sessions deleted*/
    unset($_SESSION['msg_empty_txtNameGrpL1']);
    unset($_SESSION['msg_add_product_group']);  
    
    unset($_SESSION['txtCode']);
    unset($_SESSION['txtNameL1']);
    unset($_SESSION['txtNameL2']);
    unset($_SESSION['txtNameL3']);
    unset($_SESSION['txtNameL4']);
    unset($_SESSION['txtNameL5']);
    
    /*'readonly' session becomes empty*/
    $_SESSION['readonly'] = "";
    
    /*"selectNewGroup" string included in a session*/ 
    $_SESSION['selected_group'] = "selectNewGroup";  
}

/*if 'add_options_cboGroup_1A' session is < > from 0*/
if(@$_SESSION['add_options_cboGroup_1A'][0] != 0)
{

    /*display option tags when the page has been reloaded*/
    
    /*goes through the 'add_options_cboGroup_1A' session array*/
    for($i = 0; $i < count(@$_SESSION['add_options_cboGroup_1A']); $i++)
    {
        /*ex echo : <option value='10' selected ?>Alimentaire</option>*/
        
        echo("<option value='".@$_SESSION['add_options_cboGroup_1A'][$i]."' ");

        if(!empty($_SESSION['selected_group']))
                {
                    if($_SESSION['selected_group'] == @$_SESSION['add_options_cboGroup_1A'][$i])
                    {
                        echo("selected");
                    }
                    else
                    {
                        echo("");
                    }
                }

        echo(">".@$_SESSION['add_options_cboGroup_2A'][$i]."</option>");
    }
}

/*if 'add_options_cboGroup_1D' session is < > from 0*/
if(@$_SESSION['add_options_cboGroup_1D'][0] != 0)
{
    /*display option tags when the page has been reloaded*/
    
    /*goes through the 'add_options_cboGroup_1D' session array*/
    for($i = 0; $i < count($_SESSION['add_options_cboGroup_1D']); $i++)
    {
        /*ex echo : */
        /*<option style='background-color: lightblue' value='11' selected ?>Service</option>*/
        
        echo("<option ");
        
        if(@$_SESSION['cboColor'] == true)
        {
            echo("style='background-color: lightblue'");
        }
        else
        {
            echo("");
        }
        
        echo(" value='".$_SESSION['add_options_cboGroup_1D'][$i]."' ");

        if(!empty($_SESSION['selected_group']))
                {
                    if($_SESSION['selected_group'] == $_SESSION['add_options_cboGroup_1D'][$i])
                    {
                        echo("selected");
                    }
                    else
                    {
                        echo("");
                    }
                }

        echo(">".@$_SESSION['add_options_cboGroup_2D'][$i]."</option>");
    }
}

?>                  
                    </SELECT>                    
                    <input style="display: none;" id="bt_selected_group" type="submit" name="bt_selected_group" hidden></input>                    
                    <br><span class="tooltip" id="msg_wrong"><?php 
                                                                if(empty($_SESSION['msg_add_product_group']))
                                                                {
                                                                    
                                                                }
                                                                else
                                                                {
                                                                   echo($_SESSION['msg_add_product_group']); 
                                                                }                                                     
                                                                                        ?></span></td>
                         
                
        <tr></tr>
                <!-- textfield 1/2 -->
                <td id="center_subtitle">Code Groupe</td> 
                <td><input <?php if(!empty($_SESSION['readonly'])){ echo("readonly"); }else{ echo(""); } ?> type="text" name="txtCodeGrp" value="<?php if(!empty($_SESSION['txtCode'])){ echo($_SESSION['txtCode']); } ?>"></input></td>
<?php
$j = 1;
for($i = 0;$i < count($array_icon_language); $i++)
{
?>
        <tr></tr>
                <!-- textfield 2/2 -->
                <td id="center_subtitle">Nom Groupe <?php if(count($array_icon_language) != 1){ echo('en '.$lang[$i]); } ?></td> 
                <td><input type="text" name="txtNameGrpL<?php echo($j); ?>" value="<?php if(!empty($_SESSION['txtNameL'.$j])){ echo($_SESSION['txtNameL'.$j]); } ?>"></input>
                <br><span class="tooltip" id="msg_wrong"><?php 
                                                                if(empty($_SESSION['msg_empty_txtNameGrpL'.$j]))
                                                                {
                                                                    
                                                                }
                                                                else
                                                                {
                                                                   echo($_SESSION['msg_empty_txtNameGrpL'.$j]); 
                                                                }                                                     
                                                                                        ?></span></td>
<?php
    $j++;
}
?>       
        <tr></tr>
                <!-- user can choose to activate or disable a group here -->
                <!-- DropDownList 2/2 -->
                <td id="center_subtitle">Statut</td> 
                <td><SELECT name="cboStatus">
                        <option value="1" <?php if(@$_SESSION['status'] == 1){ echo("selected"); }else{ echo(""); } ?>>Actif</option>
                        <option value="0" <?php if(@$_SESSION['status'] == 0){ echo("selected"); }else{ echo(""); } ?>>Désactivé</option>
                    </SELECT></td>
               
        <tr><td colspan="2"><hr color="grey" size="1"></hr></td></tr>   
                
                <td></td>
                <td><input type="submit" name="bt_save" value="Save"></input>
                &nbsp;
                <input <?php if(@$_SESSION['selected_group'] == "selectNewGroup" || empty($_SESSION['selected_group']) || @$_SESSION['status'] == 0){ echo("hidden"); }else{ echo(""); } ?> type="submit" name="bt_disable" value="Disable"
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

if(isset($_POST['bt_selected_group']))/*if user selected a group*/
{
    // <editor-fold defaultstate="collapsed" desc="Select Group">
    unset($_SESSION['msg_empty_txtNameGrpL1']);/*all sessions messages deleted*/
    unset($_SESSION['msg_add_product_group']);
    
    $cboGroup = $_POST['cboGroup'];/*'cboGroup' selected dropdown value included in a variable*/
   
    $_SESSION['selected_group'] = $cboGroup;/*$cboGroup value included in a session to use it in option's tag*/   
    
    if($cboGroup == "selectNewGroup")/*if $cboGroup == "selectNewGroup"*/
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
           /*same as above, display the last code_group_product column's value + 1*/ 
           /* at the 'txtCode' textfield */
           $query = $connectData->query('SELECT code_group_product FROM product_group');
           
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
    else/*else, if $cboGroup < > from "selectNewCateg"*/
    {
        $_SESSION['readonly'] = "readonly";/*then, 'readonly' becomes full*/
        
        try
        {
            /*Select datas from product_group table according to the selected values in 'cboGroup' dropdownlist*/
            $query = $connectData->prepare('SELECT code_group_product,
                                            status_group_product,
                                            name_group_product_L1,
                                            name_group_product_L2,
                                            name_group_product_L3,
                                            name_group_product_L4,
                                            name_group_product_L5
                                            FROM product_group
                                            WHERE code_group_product = :code_group');

            $query->bindParam('code_group', htmlspecialchars($cboGroup, ENT_QUOTES));
            
            $query->execute();

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

        $_SESSION['group_already_selected'] = true;/*'group_already_selected' session is true*/
    }// </editor-fold>  
}

/*----------------------------------------------------*/

/*if user clicked "Save" button and 'cboGroup' value isn't == to "selectNewGroup"*/
if(isset($_POST['bt_save']) && $_POST['cboGroup'] != "selectNewGroup")
{
    if(isset($_POST['txtNameGrpL1']))/*and if something typed in 'txtNameGrpL1' textfield*/
    {       
        $txtCodeGrp = $_POST['txtCodeGrp'];/*textfield values included in variables*/
        $txtNameGrpL1 = $_POST['txtNameGrpL1'];
        $txtNameGrpL2 = $_POST['txtNameGrpL2'];
        $txtNameGrpL3 = $_POST['txtNameGrpL3'];
        $txtNameGrpL4 = $_POST['txtNameGrpL4'];
        $txtNameGrpL5 = $_POST['txtNameGrpL5'];
        
        
        $cboGroup = $_POST['cboGroup'];/*DropDown values included in variables*/
        $cboStatus = $_POST['cboStatus'];

        $_SESSION['selected_group'] = $cboGroup;/*$cboGroup value included in a session*/
        
        $_SESSION['status'] = $cboStatus;/*$cboStatus value included in a session*/
        
        if($cboStatus == 1)/*if $cboStatus == 1*/
        {
            $_SESSION['cboColor'] = false;/*then, 'cboColor' session is false*/
        }
        else
        {
            $_SESSION['cboColor'] = true;/*else, 'cboColor' session is true*/
        }

        
        if(empty($txtNameGrpL1))/*if $txtNameGrpL1 variable is empty*/
        {
           /*a message included in a session and it's going to be displayed into a span's tag*/
           $_SESSION['msg_empty_txtNameGrpL1'] = "Veuillez saisir le Nom de groupe correspondant a la langue L1"; 
        }
        else
        {
            try
            {
                /*try to update the table's row according to the 'txtCodeGrp' textfield value*/
                $query = $connectData->prepare('UPDATE product_group
                                                SET status_group_product = :status,
                                                name_group_product_L1 = :txtNameGrpL1,
                                                name_group_product_L2 = :txtNameGrpL2,
                                                name_group_product_L3 = :txtNameGrpL3,
                                                name_group_product_L4 = :txtNameGrpL4,
                                                name_group_product_L5 = :txtNameGrpL5
                                                WHERE code_group_product = :txtCodeGrp');

                $query->execute(array(
                                      'status' => htmlspecialchars($cboStatus, ENT_QUOTES),
                                      'txtNameGrpL1' => htmlspecialchars($txtNameGrpL1, ENT_QUOTES),
                                      'txtNameGrpL2' => htmlspecialchars($txtNameGrpL2, ENT_QUOTES),
                                      'txtNameGrpL3' => htmlspecialchars($txtNameGrpL3, ENT_QUOTES),
                                      'txtNameGrpL4' => htmlspecialchars($txtNameGrpL4, ENT_QUOTES),
                                      'txtNameGrpL5' => htmlspecialchars($txtNameGrpL5, ENT_QUOTES),
                                      'txtCodeGrp' => htmlspecialchars($txtCodeGrp, ENT_QUOTES)
                                      ));
                
                /*and a message included in a session and it's going to be displayed into a span's tag*/
                $_SESSION['msg_add_product_group'] = "Le Groupe \"".$txtNameGrpL1."\" a été modifié";
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            $query->closeCursor();
        }
    }
}

/*------------------------------------------------------*/

/*if user clicked "Save" button and 'cboGroup' value is == to "selectNewGroup"*/

/*program will go to create a new group into the database*/
if(isset($_POST['bt_save']) && $_POST['cboGroup'] == "selectNewGroup")
{
    if(isset($_POST['txtNameGrpL1']))
    {       
        $txtCodeGrp = $_POST['txtCodeGrp'];
        $txtNameGrpL1 = $_POST['txtNameGrpL1'];
        $txtNameGrpL2 = $_POST['txtNameGrpL2'];
        $txtNameGrpL3 = $_POST['txtNameGrpL3'];
        $txtNameGrpL4 = $_POST['txtNameGrpL4'];
        $txtNameGrpL5 = $_POST['txtNameGrpL5'];
        
        $BoKname = true;
               
        $cboGroup = $_POST['cboGroup'];
        $cboStatus = $_POST['cboStatus'];

        $_SESSION['selected_group'] = $cboGroup;
        
        $_SESSION['status'] = $cboStatus;
        
        if($cboStatus == 1)
        {
            $_SESSION['cboColor'] = false;
        }
        else
        {
            $_SESSION['cboColor'] = true;
        }
        

        
        if(empty($txtNameGrpL1))
        {
           $_SESSION['msg_empty_txtNameGrpL1'] = "Veuillez saisir le Nom de groupe correspondant a la langue L1";
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
                /*only query isn't the same as above. It's an 'INSERT' here*/
                $query = $connectData->prepare('INSERT INTO product_group(
                                                code_group_product,
                                                status_group_product,
                                                name_group_product_L1,
                                                name_group_product_L2,
                                                name_group_product_L3,
                                                name_group_product_L4,
                                                name_group_product_L5)
                                                VALUE(:txtCodeGrp, :status, :txtNameGrpL1, 
                                                      :txtNameGrpL2, :txtNameGrpL3,
                                                      :txtNameGrpL4, :txtNameGrpL5)');

                $query->execute(array(
                                      'txtCodeGrp' => htmlspecialchars($txtCodeGrp, ENT_QUOTES),
                                      'status' => htmlspecialchars($cboStatus, ENT_QUOTES),
                                      'txtNameGrpL1' => htmlspecialchars($txtNameGrpL1, ENT_QUOTES),
                                      'txtNameGrpL2' => htmlspecialchars($txtNameGrpL2, ENT_QUOTES),
                                      'txtNameGrpL3' => htmlspecialchars($txtNameGrpL3, ENT_QUOTES),
                                      'txtNameGrpL4' => htmlspecialchars($txtNameGrpL4, ENT_QUOTES),
                                      'txtNameGrpL5' => htmlspecialchars($txtNameGrpL5, ENT_QUOTES),        
                                      ));
                
                /*and a message included in a session and it's going to be displayed into a span's tag*/
                $_SESSION['msg_add_product_group'] = "Le Groupe \"".$txtNameGrpL1."\" a été créé";
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            $query->closeCursor();
        }
    }
}

/*------------------------------------------------------*/

if(isset($_POST['bt_disable']))/*if user clicked "Disable" button*/
{
    $cboGroup = $_POST['cboGroup'];/*'cboGroup' selected value included in a variable*/
    $txtNameGrpL1 = $_POST['txtNameGrpL1'];/*'txtNameGrpL1' textfield's value included in variable*/
    
    try
    {
        /*change group's status to 0 according to the selected values in 'cboGroup' */
        $query = $connectData->prepare('UPDATE product_group
                                        SET status_group_product = 0
                                        WHERE code_group_product = :code_group');
        
        $query->bindParam('code_group', htmlspecialchars($cboGroup, ENT_QUOTES));
        
        $query->execute();
        
        /*and a message included in a session and it's going to be displayed into a span's tag*/
        $_SESSION['msg_add_product_group'] = "Le groupe \"".$txtNameGrpL1."\" a été désactivé";
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    $query->closeCursor();
    
    $_SESSION['status'] = 0;/*'status' session becomes 'disabled'*/
    
    $_SESSION['cboColor'] = true;/*'cboColor' session is true*/   
}

?>


        
<!--import my javascript-->

<script type="text/javascript" src="script.js"></script>
