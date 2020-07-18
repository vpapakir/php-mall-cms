<?php
#outhouses
if($customgetinfo_displayvalue[18] == 1)
{   
    $countdoublon_piecesout_exterior = array_count_values($countdoublon_piecesout_exterior);
    
    
    
    if(($count_totalouthouses > 0 || $customgetinfo_numouthouses > 0) && $count_totalrooms_bok_knownouthouses === true)
    {
        $message .= '<tr>
                    <td align="left" class="font_main" colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">';
        if($customgetinfo_numouthouses > 0 && $count_totalouthouses <= 0)
        {
            echo($customgetinfo_numouthouses);
        }
        else
        {
            $i = 0;
            foreach ($countdoublon_piecesout_exterior as $key => $value) 
            {

                $customgetinfo_piecesout_exterior[$i] = split_string($key, '$');
                $customgetinfo_piecesout_exterior_details = split_string($customgetinfo_piecesout_exterior[$i][5], '@');

                if(!empty($customgetinfo_piecesout_exterior[$i][0]))
                {

                    $customgetinfo_newbuildingkey = $customgetinfo_piecesout_exterior[$i][0];
                    if($i == 0)
                    {
                        $customgetinfo_oldbuildingkey = 'unknown';
                    }
                    if($customgetinfo_newbuildingkey != $customgetinfo_oldbuildingkey)
                    {
                        $customgetinfo_oldbuildingkey = $customgetinfo_newbuildingkey;
                        $message .= '<tr>
                                        <td align="left">
                                            <span class="font_subtitle">'.give_translation('immo.outhouses_'.$customgetinfo_oldbuildingkey, 'false', $config_showtranslationcode).'</span>
                                        </td>
                                    </tr>';
                    }
                }

                if(!empty($customgetinfo_piecesout_exterior[$i][1]))
                {
                    $customgetinfo_newfloorkey = $customgetinfo_piecesout_exterior[$i][1];

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

                            if(!empty($customgetinfo_piecesout_exterior[$i][0]))
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

                                if(!empty($customgetinfo_piecesout_exterior[$i][0]))
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

                                if(!empty($customgetinfo_piecesout_exterior[$i][0]))
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
                    $customgetinfo_piecesout_exterior_details_content = split_string($customgetinfo_piecesout_exterior_details[$y], '&');
                    if($customgetinfo_piecesout_exterior_details_content[1] == $main_id_language)
                    {
                        $customgetinfo_piecesout_exterior_details_content = $customgetinfo_piecesout_exterior_details_content[0];
                        $y = $county;
                    }
                    else
                    {
                        unset($customgetinfo_piecesout_exterior_details_content);
                    }
                }

                if($customgetinfo_piecesout_exterior[$i][2] != 'select')
                {
                    $message .= '<tr>
                                <td align="left">
                                    <span ';
                    if(!empty($customgetinfo_piecesout_exterior[$i][0]))
                    {
                        $message .= ' style="margin-left: 20px;" ';
                    }
                    else
                    {
                        if(!empty($customgetinfo_piecesout_exterior[$i][1]))
                        {
                            $message .= ' style="margin-left: 10px;" ';
                        }
                    }

                    $message .= '>';
                    if($value > 1)
                    {
                        $singplural = 'P';
                        $count_concernedouthouses = $value.'&nbsp;';
                        $countmeasure_concernedouthouses = $value.'x';
                    }
                    else
                    {
                        $singplural = 'S';
                        $count_concernedouthouses = '1&nbsp;';
                        $countmeasure_concernedouthouses = null;
                    }

                    $details_totalouthouses = $count_concernedouthouses;

                    if($customgetinfo_piecesout_exterior[$i][2] != 'select')
                    {

                        $prepared_query = 'SELECT L'.$main_id_language.$singplural.' FROM cdreditor
                                           WHERE id_cdreditor = :id';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('id', $customgetinfo_piecesout_exterior[$i][2]);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {
                            $details_totalouthouses .= $data[0]; 
                        }
                        $query->closeCursor();
                    }

                    if($customgetinfo_piecesout_exterior[$i][3] > 0)
                    {                   
                        $details_totalouthouses .= '&nbsp;('.$countmeasure_concernedouthouses.$customgetinfo_piecesout_exterior[$i][3].'m²)'; 
                    }

                    if($customgetinfo_piecesout_exterior[$i][4] != 'select')
                    {
                        $prepared_query = 'SELECT L'.$main_id_language.$singplural.' FROM cdreditor
                                           WHERE id_cdreditor = :id';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('id', $customgetinfo_piecesout_exterior[$i][4]);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {
                            $details_totalouthouses .= '&nbsp;'.$data[0].', '; 
                        }
                        $query->closeCursor();
                    }

                    if($customgetinfo_piecesout_exterior[$i][2] != 'select' && $customgetinfo_piecesout_exterior[$i][4] == 'select')
                    {
                        $details_totalouthouses .= ', ';
                    }

                    $details_totalouthouses = preg_replace('#, $#', '', $details_totalouthouses);

                    $message .= $details_totalouthouses;
                    $message .= '</span>
                                </td>
                            </tr>';   
                }
                
                if(!empty($customgetinfo_piecesout_exterior_details_content))
                {
                    $message .= '<tr>
                                    <td align="left">
                                    <div ';
                    if(!empty($customgetinfo_piecesout_exterior[$i][0]))
                    {
                        $message .= 'style="margin-left: 30px;"';
                    }
                    else
                    {
                        if(!empty($customgetinfo_piecesout_exterior[$i][1]))
                        {
                            $message .= 'style="margin-left: 20px;"';
                        }
                        else
                        {
                            $message .= 'style="margin-left: 10px;"';
                        }
                    }
                    
                    $message .= '><span class="font_main" style="font-size: 10px;">'.$customgetinfo_piecesout_exterior_details_content.'</span>
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
