<?php
#[energy]
if($customgetinfo_displayvalue[21] == 1 && $customgetinfo_ges_energy > 0)
{
    $message .= '<tr>
                 <td><table style="border: 1px solid;
                                border-color: #CCCCCC;
                                border-radius: 8px 8px 8px 8px;
                                -moz-border-radius: 8px 8px 8px 8px;
                                -webkit-border-radius: 8px 8px 8px 8px;
                                background-color: #FFFFFF;
                                width: 100%;
                                height: 100%;
                                padding: 4px;
                                font-size: 12px;
                                font-weight: normal;
                                color: #000000;
                                text-decoration: none;
                                text-align: left; margin-bottom: 4px;" cellpadding="0" cellspacing="0">

                    <tr><td>';

    if($customgetinfo_ges_energy == 9999 || $customgetinfo_ges_energy == 0 ||$customgetinfo_ges_energy == 8888 || empty($customgetinfo_ges_energy))
    {
        $message .= '<table width="100%" cellpadding="0" cellspacing="0">   
                     <tr>
                         <td style="font-size: 12px;
                            font-weight: bold;
                            color: #0B3B02;
                            text-decoration: none;
                            text-align: left;">';

            if($customgetinfo_ges_energy == 0 || empty($customgetinfo_ges_energy))
            {  
                $message .= 'GES inconnu à ce jour';
            } 
            
            if($customgetinfo_ges_energy == 8888)
            {  
                $message .= 'GES en cours d\'évaluation';
            }
            
            if($customgetinfo_ges_energy == 9999)
            {  
                $message .= 'Bien non soumis au GES';
            }

        $message .= '</td>
                    </tr>       
                </table>';
    }
    else
    {
        #1
        $message .= '<table width="100%" cellpadding="0" cellspacing="0">

                    <tr>
                        <td colspan="3" align="center" style="border-radius: 8px 8px 0px 0px;
                                                            -moz-border-radius: 8px 8px 0px 0px;
                                                            -webkit-border-radius: 8px 8px 0px 0px;
                                                            background-color: #687C66;
                                                            width: 100%;
                                                            height: 100%;
                                                            font-size: 14px;
                                                            font-weight: normal;
                                                            color: #FFFFFF;
                                                            text-decoration: none;
                                                            text-align: center;">
                            Emissions de gaz à effet de serre
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; 
                                    font-size: 12px;
                                    font-weight: normal;
                                    color: #000000;
                                    text-decoration: none;
                                    text-align: left;">
                            Faible émission de GES
                        </td>
                        <td style="width: 100px;">

                        </td>
                        <td width="100%"></td>  
                    </tr>

                    <tr>
                        <td>';

        if($customgetinfo_ges_energy <= $ges_part1)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/Ab.gif" alt="ges"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/A.gif" alt="ges"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_ges_energy <= $ges_part1)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/ges/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_ges_energy <= $ges_part1)
        {
            $message .= $customgetinfo_ges_energy;
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #B
        $message .= '<tr>
                        <td>';

        if($customgetinfo_ges_energy >= $ges_part2a && $customgetinfo_ges_energy <= $ges_part2b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/Bb.gif" alt="ges"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/B.gif" alt="ges"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_ges_energy >= $ges_part2a && $customgetinfo_ges_energy <= $ges_part2b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/ges/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_ges_energy >= $ges_part2a && $customgetinfo_ges_energy <= $ges_part2b)
        {
            $message .= $customgetinfo_ges_energy;
        }

        if($customgetinfo_ges_energy <= $ges_part1)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #C
        $message .= '<tr>
                        <td>';

        if($customgetinfo_ges_energy >= $ges_part3a && $customgetinfo_ges_energy <= $ges_part3b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/Cb.gif" alt="ges"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/C.gif" alt="ges"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_ges_energy >= $ges_part3a && $customgetinfo_ges_energy <= $ges_part3b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/ges/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_ges_energy >= $ges_part3a && $customgetinfo_ges_energy <= $ges_part3b)
        {
            $message .= $customgetinfo_ges_energy;
        }
        if($customgetinfo_ges_energy >= $ges_part2a && $customgetinfo_ges_energy <= $ges_part2b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #D
        $message .= '<tr>
                        <td>';

        if($customgetinfo_ges_energy >= $ges_part4a && $customgetinfo_ges_energy <= $ges_part4b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/Db.gif" alt="ges"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/D.gif" alt="ges"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_ges_energy >= $ges_part4a && $customgetinfo_ges_energy <= $ges_part4b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/ges/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_ges_energy >= $ges_part4a && $customgetinfo_ges_energy <= $ges_part4b)
        {
            $message .= $customgetinfo_ges_energy;
        }
        if($customgetinfo_ges_energy >= $ges_part3a && $customgetinfo_ges_energy <= $ges_part3b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #E
        $message .= '<tr>
                        <td>';

        if($customgetinfo_ges_energy >= $ges_part5a && $customgetinfo_ges_energy <= $ges_part5b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/Eb.gif" alt="ges"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/E.gif" alt="ges"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_ges_energy >= $ges_part5a && $customgetinfo_ges_energy <= $ges_part5b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/ges/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_ges_energy >= $ges_part5a && $customgetinfo_ges_energy <= $ges_part5b)
        {
            $message .= $customgetinfo_ges_energy;
        }
        if($customgetinfo_ges_energy >= $ges_part4a && $customgetinfo_ges_energy <= $ges_part4b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #F
        $message .= '<tr>
                        <td>';

        if($customgetinfo_ges_energy >= $ges_part6a && $customgetinfo_ges_energy <= $ges_part6b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/Fb.gif" alt="ges"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/F.gif" alt="ges"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_ges_energy >= $ges_part6a && $customgetinfo_ges_energy <= $ges_part6b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/ges/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_ges_energy >= $ges_part6a && $customgetinfo_ges_energy <= $ges_part6b)
        {
            $message .= $customgetinfo_ges_energy;
        }
        if($customgetinfo_ges_energy >= $ges_part5a && $customgetinfo_ges_energy <= $ges_part5b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #G
        $message .= '<tr>
                        <td>';

        if($customgetinfo_ges_energy >= $ges_part7)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/Gb.gif" alt="ges"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/ges/G.gif" alt="ges"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_ges_energy >= $ges_part7)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/ges/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_ges_energy >= $ges_part7)
        {
            $message .= $customgetinfo_ges_energy;
        }
        if($customgetinfo_ges_energy >= $ges_part6a && $customgetinfo_ges_energy <= $ges_part6b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';

        #last
        $message .= '<tr>
                        <td style="width: 250px; 
                                    font-size: 12px;
                                    font-weight: normal;
                                    color: #000000;
                                    text-decoration: none;
                                    text-align: left;">
                            Logement énergivore
                        </td>
                        <td class="font_main" align="right">';

        if($customgetinfo_ges_energy >= $ges_part7)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';
        }

        $message .= '   </td>
                        <td></td>
                    </tr>
                    </table>';
    }
    

    $message .= '   </td></tr>

                 </table></td>
                 </tr>';
}
#[/energy]

unset($customgetinfo_ges_energy,$ges_part1,$ges_part2a,$ges_part2b,$ges_part3a,
      $ges_part3b,$ges_part4a,$ges_part4b,$ges_part5a,$ges_part5b,$ges_part6a,
      $ges_part6b,$ges_part7);
?>
