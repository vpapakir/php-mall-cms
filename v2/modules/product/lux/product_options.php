<?php
$subtitle_product_option = create_translation_array('product_edit.product_option_label.text');//"Product options"
?>

<TABLE width="100%">
                   
                <td id="center_subtitle" colspan="3" align="center">
                    <?php 
                        echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_option))); 
                    ?>
                </td>                
                
            <tr></tr>
                
                    <td id="center_text_table" style="vertical-align: top;">
                        <?php
                            try
                            {
                               /*displays all type 1 from product_option's table and creates checkboxes*/ 
                               $query = $connectData->query('SELECT id_option_product, name_option_product_'.$option_lang.'
                                                             FROM product_option
                                                             WHERE id_type_product = 1');

                               while($data = $query->fetch())
                               {
                                   echo('<input style="vertical-align: inherit;" type="checkbox" name="chk_type'.$data[0].'" value="'.$data[1].'" ');
                                   
                                   if(!empty($_SESSION['chk_product_options'][0]))
                                   {
                                       for($i = 0; $i < count($_SESSION['chk_product_options']); $i++)
                                       {
                                           if($_SESSION['chk_product_options'][$i] == $data[0])
                                           {
                                               echo('checked');
                                               $i = count($_SESSION['chk_product_options']) + 1;
                                           }
                                           else
                                           {
                                               echo(null);
                                           }
                                       }
                                   }
                                   
                                   echo('/>&nbsp;<label for="chk_type'.$data[0].'">'.$data[1].'</label><br>');
                                                                   
                               }
                            }
                            catch(Exception $e)
                            {
                                die("Error : ".$e->getMessage());
                            }
                            $query->closeCursor();

                        ?>
                    </td> 

                    <td id="center_text_table" style="vertical-align: top;">
                        <?php
                            try
                            { 
                               /*displays all type 2 from product_option's table and creates checkboxes*/
                               $query = $connectData->query('SELECT id_option_product, name_option_product_'.$option_lang.'
                                                             FROM product_option
                                                             WHERE id_type_product = 2');

                               while($data = $query->fetch())
                               {
                                   echo('<input style="vertical-align: inherit;" type="checkbox" name="chk_type'.$data[0].'" value="'.$data[1].'" ');
                                   
                                   if(!empty($_SESSION['chk_product_options'][0]))
                                   {
                                       for($i = 0; $i < count($_SESSION['chk_product_options']); $i++)
                                       {
                                           if($_SESSION['chk_product_options'][$i] == $data[0])
                                           {
                                               echo('checked');
                                               $i = count($_SESSION['chk_product_options']) + 1;
                                           }
                                           else
                                           {
                                               echo(null);
                                           }
                                       }
                                   }
                                   
                                   echo('/>&nbsp;<label for="chk_type'.$data[0].'">'.$data[1].'</label><br>');
                                   
                               }
                            }
                            catch(Exception $e)
                            {
                                die("Error : ".$e->getMessage());
                            }
                            $query->closeCursor();

                        ?>
                    </td>

                    <td id="center_text_table" style="vertical-align: top;">
                        <?php
                            try
                            { 
                               /*displays all type 3 from product_option's table and creates checkboxes*/  
                               $query = $connectData->query('SELECT id_option_product, name_option_product_'.$option_lang.'
                                                             FROM product_option
                                                             WHERE id_type_product = 3');

                               while($data = $query->fetch())
                               {
                                   echo('<input style="vertical-align: inherit;" type="checkbox" name="chk_type'.$data[0].'" value="'.$data[1].'" ');
                                   
                                   if(!empty($_SESSION['chk_product_options'][0]))
                                   {
                                       for($i = 0; $i < count($_SESSION['chk_product_options']); $i++)
                                       {
                                           if($_SESSION['chk_product_options'][$i] == $data[0])
                                           {
                                               echo('checked');
                                               $i = count($_SESSION['chk_product_options']) + 1;
                                           }
                                           else
                                           {
                                               echo(null);
                                           }
                                       }
                                   }
                                   
                                   echo('/>&nbsp;<label for="chk_type'.$data[0].'">'.$data[1].'</label><br>');
                               }
                            }
                            catch(Exception $e)
                            {
                                die("Error : ".$e->getMessage());
                            }
                            $query->closeCursor();

                        ?>
                    </td>
                    
                <tr><td colspan="3"><hr></hr></td></tr>
                
        </TABLE>
