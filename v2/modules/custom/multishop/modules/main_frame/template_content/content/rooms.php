<?php
#rooms
if($customgetinfo_displayvalue[14] == 1)
{
//    $count_totalrooms = null;
//    $details_totalrooms = null;
//    $countdoublon_piecesin_interior = split_string($customgetinfo_piecesin_interior, '#');
//    $customgetinfo_piecesin_interior = split_string($customgetinfo_piecesin_interior, '#');
//    
//    for($i = 0, $count = count($customgetinfo_piecesin_interior); $i < $count; $i++)
//    {
//        $customgetinfo_piecesin_interior[$i] = split_string($customgetinfo_piecesin_interior[$i], '$');
//        
//        if($customgetinfo_piecesin_interior[$i][0] != 'select' && !empty($customgetinfo_piecesin_interior[$i][0]))
//        {
//            $count_totalrooms += 1;
//        }
//        
//    }
    sort($countdoublon_piecesin_interior);
    $countdoublon_piecesin_interior = array_count_values($countdoublon_piecesin_interior);    
    
    if(($count_totalrooms > 0 || $customgetinfo_numrooms > 0) && $count_totalrooms_bok_knownroom === true)
    {
?>      
        <tr>
            <td align="left" class="font_main" colspan="2">
                <table width="100%" cellpadding="0" cellspacing="0">
<?php
            if($customgetinfo_numrooms > 0 && $count_totalrooms <= 0)
            {
                echo($customgetinfo_numrooms);
            }
            else
            {
                $i = 0;
                foreach ($countdoublon_piecesin_interior as $key => $value) 
                {

                    $customgetinfo_piecesin_interior[$i] = split_string($key, '$');
                    
                    $customgetinfo_piecesin_interior_details = split_string($customgetinfo_piecesin_interior[$i][5], '@');
                    
                    if(!empty($customgetinfo_piecesin_interior[$i][0]))
                    {
                        
                        $customgetinfo_newbuildingkey = $customgetinfo_piecesin_interior[$i][0];
                        if($i == 0)
                        {
                            $customgetinfo_oldbuildingkey = 'unknown';
                        }
                        if($customgetinfo_newbuildingkey != $customgetinfo_oldbuildingkey)
                        {
                            $customgetinfo_oldbuildingkey = $customgetinfo_newbuildingkey;
?>
                            <tr>
                                <td align="left">
                                    <span class="font_subtitle"><?php give_translation('immo.building_'.$customgetinfo_oldbuildingkey, $echo, $config_showtranslationcode); ?></span>
                                </td>
                            </tr>
<?php
                        }
                    }
                    
                    if(!empty($customgetinfo_piecesin_interior[$i][1]))
                    {
                        $customgetinfo_newfloorkey = $customgetinfo_piecesin_interior[$i][1];

                        if($i == 0)
                        {
                            $customgetinfo_currentfloor = 'unknown';
                        }
                        
                        if($customgetinfo_newfloorkey != $customgetinfo_currentfloor)
                        {
                            $customgetinfo_currentfloor = $customgetinfo_newfloorkey;
                            
                            if($customgetinfo_currentfloor < 0)
                            {
?>
                                <tr>
                                    <td align="left">
                                        <span class="font_subtitle" <?php if(!empty($customgetinfo_piecesin_interior[$i][0])){ ?>style="margin-left: 10px;" <?php } ?>><?php give_translation('immo.floor_'.$customgetinfo_currentfloor, $echo, $config_showtranslationcode); ?></span>
                                    </td>
                                </tr>
<?php                                
                            }
                            else
                            {
                                if($customgetinfo_currentfloor > 0)
                                {
?>
                                    <tr>
                                        <td align="left">
                                            <span class="font_subtitle" <?php if(!empty($customgetinfo_piecesin_interior[$i][0])){ ?>style="margin-left: 10px;" <?php } ?>><?php give_translation('immo.floor_'.$customgetinfo_currentfloor, $echo, $config_showtranslationcode); ?></span>
                                        </td>
                                    </tr>  
<?php                                
                                }
                                else
                                {
?>
                                    <tr>
                                        <td align="left">
                                            <span class="font_subtitle" <?php if(!empty($customgetinfo_piecesin_interior[$i][0])){ ?>style="margin-left: 10px;" <?php } ?>><?php give_translation('immo.floor_'.$customgetinfo_currentfloor, $echo, $config_showtranslationcode); ?></span>
                                        </td>
                                    </tr>
<?php                                    
                                }
                            }
                        }
                        

                    }
                    
                    for($y = 0, $county = count($main_activatedidlang); $y < $county; $y++)
                    {
                        $customgetinfo_piecesin_interior_details_content = split_string($customgetinfo_piecesin_interior_details[$y], '&');
                        if($customgetinfo_piecesin_interior_details_content[1] == $main_id_language)
                        {
                            $customgetinfo_piecesin_interior_details_content = $customgetinfo_piecesin_interior_details_content[0];
                            $y = $county;
                        }
                        else
                        {
                            unset($customgetinfo_piecesin_interior_details_content);
                        }
                    }
                        

                    if($customgetinfo_piecesin_interior[$i][2] != 'select')
                    {
?>
                        <tr>
                            <td align="left">
                                <span <?php if(!empty($customgetinfo_piecesin_interior[$i][0])){ ?>style="margin-left: 20px;" <?php }else{ if(!empty($customgetinfo_piecesin_interior[$i][1])){ ?>style="margin-left: 10px;"<?php } } ?>>
<?php
                        if($value > 1)
                        {
                            $singplural = 'P';
                            $count_concernedroom = $value.'&nbsp;';
                            $countmeasure_concernedroom = $value.'x';
                        }
                        else
                        {
                            $singplural = 'S';
                            $count_concernedroom = '1&nbsp;';
                            $countmeasure_concernedroom = null;
                        }


                        $details_totalrooms = $count_concernedroom; 


                        if($customgetinfo_piecesin_interior[$i][2] != 'select')
                        {

                            $prepared_query = 'SELECT L'.$main_id_language.$singplural.' FROM cdreditor
                                               WHERE id_cdreditor = :id';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->bindParam('id', $customgetinfo_piecesin_interior[$i][2]);
                            $query->execute();

                            if(($data = $query->fetch()) != false)
                            {
                                $details_totalrooms .= $data[0]; 
                            }
                            $query->closeCursor();
                        }

                        if($customgetinfo_piecesin_interior[$i][3] > 0)
                        {                   
                            $details_totalrooms .= '&nbsp;('.$countmeasure_concernedroom.$customgetinfo_piecesin_interior[$i][3].'m²)'; 
                        }

                        if($customgetinfo_piecesin_interior[$i][4] != 'select')
                        {
                            $prepared_query = 'SELECT L'.$main_id_language.$singplural.' FROM cdreditor
                                               WHERE id_cdreditor = :id';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->bindParam('id', $customgetinfo_piecesin_interior[$i][4]);
                            $query->execute();

                            if(($data = $query->fetch()) != false)
                            {
                                $details_totalrooms .= '&nbsp;'.$data[0].', '; 
                            }
                            $query->closeCursor();
                        }

                        if($customgetinfo_piecesin_interior[$i][2] != 'select' && $customgetinfo_piecesin_interior[$i][4] == 'select')
                        {
                            $details_totalrooms .= ', ';
                        }

                        $details_totalrooms = preg_replace('#, $#', '', $details_totalrooms);

                        echo($details_totalrooms);
                
                              
?>
                                </span>
                            </td>
                        </tr>
<?php
                    }
                    
                    if(!empty($customgetinfo_piecesin_interior_details_content))
                    {
?>
                        <tr>
                            <td align="left">
                                <div <?php if(!empty($customgetinfo_piecesin_interior[$i][0])){ ?>style="margin-left: 30px;" <?php }else{ if(!empty($customgetinfo_piecesin_interior[$i][1])){ ?>style="margin-left: 20px;"<?php }else{ ?>style="margin-left: 10px;"<?php } } ?>>
                                    <span class="font_main" style="font-size: 10px"><?php echo($customgetinfo_piecesin_interior_details_content); ?></span>
                                </div>
                            </td>
                        </tr>
<?php
                    }
                    $i++; 
                }
            }    
?>
            
                </table>                
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        
<?php
    }
}
?>
