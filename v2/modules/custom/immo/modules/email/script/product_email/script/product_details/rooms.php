<?php
#rooms
if($customgetinfo_displayvalue[14] == 1)
{
    sort($countdoublon_piecesin_interior);
    $countdoublon_piecesin_interior = array_count_values($countdoublon_piecesin_interior);    
    
    if(($count_totalrooms > 0 || $customgetinfo_numrooms > 0) && $count_totalrooms_bok_knownroom === true)
    {
        $message .= '<tr>
                    <td align="left" class="font_main" colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">';

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
                        $message .= '<tr>
                                        <td align="left">
                                            <span class="font_subtitle">'.give_translation('immo.building_'.$customgetinfo_oldbuildingkey, 'false', $config_showtranslationcode).'</span>
                                        </td>
                                    </tr>';
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
                            $message .= '<tr>
                                        <td align="left">
                                            <span class="font_subtitle" ';

                            if(!empty($customgetinfo_piecesin_interior[$i][0]))
                            {
                                $message .= ' style="margin-left: 10px;"';
                            }

                            $message .= '>'.give_translation('immo.floor_'.$customgetinfo_currentfloor, 'false', $config_showtranslationcode).'</span></td>
                                        </tr>';    
                        }
                        else
                        {
                            if($customgetinfo_currentfloor > 0)
                            {
                                $message .= '<tr>
                                            <td align="left">
                                                <span class="font_subtitle" ';

                                if(!empty($customgetinfo_piecesin_interior[$i][0]))
                                {
                                    $message .= ' style="margin-left: 10px;"';
                                }

                                $message .= '>'.give_translation('immo.floor_'.$customgetinfo_currentfloor, 'false', $config_showtranslationcode).'</span></td>
                                            </tr>';                               
                            }
                            else
                            {
                                $message .= '<tr>
                                            <td align="left">
                                                <span class="font_subtitle" ';

                                if(!empty($customgetinfo_piecesin_interior[$i][0]))
                                {
                                    $message .= ' style="margin-left: 10px;"';
                                }

                                $message .= '>'.give_translation('immo.floor_'.$customgetinfo_currentfloor, 'false', $config_showtranslationcode).'</span></td>
                                            </tr>';                     
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
                    $message .= '<tr>
                                <td align="left">
                                    <span ';
                    if(!empty($customgetinfo_piecesin_interior[$i][0]))
                    {
                        $message .= ' style="margin-left: 20px;" ';
                    }
                    else
                    {
                        if(!empty($customgetinfo_piecesin_interior[$i][1]))
                        {
                            $message .= ' style="margin-left: 10px;" ';
                        }
                    }

                    $message .= '>';
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

                    $message .= $details_totalrooms;

                    $message .= '</span>
                                </td>
                            </tr>';      
                }
                
                if(!empty($customgetinfo_piecesin_interior_details_content))
                {
                    $message .= '<tr>
                                    <td align="left">
                                    <div ';
                    if(!empty($customgetinfo_piecesin_interior[$i][0]))
                    {
                        $message .= 'style="margin-left: 30px;"';
                    }
                    else
                    {
                        if(!empty($customgetinfo_piecesin_interior[$i][1]))
                        {
                            $message .= 'style="margin-left: 20px;"';
                        }
                        else
                        {
                            $message .= 'style="margin-left: 10px;"';
                        }
                    }
                    
                    $message .= '><span class="font_main" style="font-size: 10px;">'.$customgetinfo_piecesin_interior_details_content.'</span>
                                </div>
                            </td>
                        </tr>';
                }
                $i++; 
            }
        }
            
        $message .= '</table>                
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>';
    }
}
?>
