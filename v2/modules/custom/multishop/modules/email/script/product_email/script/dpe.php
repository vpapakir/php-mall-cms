<?php
#[dpe]
if($customgetinfo_displayvalue[20] == 1 && $customgetinfo_dpe_energy > 0)
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

    if($customgetinfo_dpe_energy == 9999 || $customgetinfo_dpe_energy == 0 ||$customgetinfo_dpe_energy == 8888 || empty($customgetinfo_dpe_energy))
    {
        $message .= '<table width="100%" cellpadding="0" cellspacing="0">   
                     <tr>
                         <td class="font_subtitle">';

            if($customgetinfo_dpe_energy == 0 || empty($customgetinfo_dpe_energy))
            {  
                $message .= 'DPE inconnu à ce jour';
            } 
            
            if($customgetinfo_dpe_energy == 8888)
            {  
                $message .= 'DPE en cours d\'évaluation';
            }
            
            if($customgetinfo_dpe_energy == 9999)
            {  
                $message .= 'Bien non soumis au DPE, Article R 134-1 du CCH';
            }

        $message .= '</td>
                    </tr>       
                </table>';
    }
    else
    {
        #A
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
                            Diagnostic performance énergétique
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; 
                                    font-size: 12px;
                                    font-weight: normal;
                                    color: #000000;
                                    text-decoration: none;
                                    text-align: left;">
                            Logement économe
                        </td>
                        <td style="width: 100px;">

                        </td>
                        <td width="100%"></td>  
                    </tr>

                    <tr>
                        <td>';

        if($customgetinfo_dpe_energy <= $dpe_part1)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/Ab.gif" alt="dpe"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/A.gif" alt="dpe"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_dpe_energy <= $dpe_part1)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_dpe_energy <= $dpe_part1)
        {
            $message .= $customgetinfo_dpe_energy;
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #B
        $message .= '<tr>
                        <td>';

        if($customgetinfo_dpe_energy >= $dpe_part2a && $customgetinfo_dpe_energy <= $dpe_part2b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/Bb.gif" alt="dpe"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/B.gif" alt="dpe"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_dpe_energy >= $dpe_part2a && $customgetinfo_dpe_energy <= $dpe_part2b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_dpe_energy >= $dpe_part2a && $customgetinfo_dpe_energy <= $dpe_part2b)
        {
            $message .= $customgetinfo_dpe_energy;
        }

        if($customgetinfo_dpe_energy <= $dpe_part1)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">kWh&nbsp;ep/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #C
        $message .= '<tr>
                        <td>';

        if($customgetinfo_dpe_energy >= $dpe_part3a && $customgetinfo_dpe_energy <= $dpe_part3b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/Cb.gif" alt="dpe"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/C.gif" alt="dpe"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_dpe_energy >= $dpe_part3a && $customgetinfo_dpe_energy <= $dpe_part3b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_dpe_energy >= $dpe_part3a && $customgetinfo_dpe_energy <= $dpe_part3b)
        {
            $message .= $customgetinfo_dpe_energy;
        }
        if($customgetinfo_dpe_energy >= $dpe_part2a && $customgetinfo_dpe_energy <= $dpe_part2b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">kWh&nbsp;ep/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #D
        $message .= '<tr>
                        <td>';

        if($customgetinfo_dpe_energy >= $dpe_part4a && $customgetinfo_dpe_energy <= $dpe_part4b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/Db.gif" alt="dpe"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/D.gif" alt="dpe"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_dpe_energy >= $dpe_part4a && $customgetinfo_dpe_energy <= $dpe_part4b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_dpe_energy >= $dpe_part4a && $customgetinfo_dpe_energy <= $dpe_part4b)
        {
            $message .= $customgetinfo_dpe_energy;
        }
        if($customgetinfo_dpe_energy >= $dpe_part3a && $customgetinfo_dpe_energy <= $dpe_part3b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">kWh&nbsp;ep/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #E
        $message .= '<tr>
                        <td>';

        if($customgetinfo_dpe_energy >= $dpe_part5a && $customgetinfo_dpe_energy <= $dpe_part5b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/Eb.gif" alt="dpe"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/E.gif" alt="dpe"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_dpe_energy >= $dpe_part5a && $customgetinfo_dpe_energy <= $dpe_part5b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_dpe_energy >= $dpe_part5a && $customgetinfo_dpe_energy <= $dpe_part5b)
        {
            $message .= $customgetinfo_dpe_energy;
        }
        if($customgetinfo_dpe_energy >= $dpe_part4a && $customgetinfo_dpe_energy <= $dpe_part4b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">kWh&nbsp;ep/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #F
        $message .= '<tr>
                        <td>';

        if($customgetinfo_dpe_energy >= $dpe_part6a && $customgetinfo_dpe_energy <= $dpe_part6b)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/Fb.gif" alt="dpe"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/F.gif" alt="dpe"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_dpe_energy >= $dpe_part6a && $customgetinfo_dpe_energy <= $dpe_part6b)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_dpe_energy >= $dpe_part6a && $customgetinfo_dpe_energy <= $dpe_part6b)
        {
            $message .= $customgetinfo_dpe_energy;
        }
        if($customgetinfo_dpe_energy >= $dpe_part5a && $customgetinfo_dpe_energy <= $dpe_part5b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">kWh&nbsp;ep/m².an</span>';
        }

        $message .= '</td>
                    <td></td>

                </tr>';
        #G
        $message .= '<tr>
                        <td>';

        if($customgetinfo_dpe_energy >= $dpe_part7)
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/Gb.gif" alt="dpe"></img>';
        }
        else
        {
            $message .= '<img src="'.$config_customheader.'modules/custom/immo/graphic/dpe/G.gif" alt="dpe"></img>';
        }

        $message .= '</td>
                    <td class="font_main" align="right" ';

        if($customgetinfo_dpe_energy >= $dpe_part7)
        {
            $message .= 'background="'.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif" style="background-image: url(\''.$config_customheader.'modules/custom/immo/graphic/dpe/right.gif\'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" ';       
        }

        $message .= '>';

        if($customgetinfo_dpe_energy >= $dpe_part7)
        {
            $message .= $customgetinfo_dpe_energy;
        }
        if($customgetinfo_dpe_energy >= $dpe_part6a && $customgetinfo_dpe_energy <= $dpe_part6b)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">kWh&nbsp;ep/m².an</span>';
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

        if($customgetinfo_dpe_energy >= $dpe_part7)
        {
            $message .= '<span class="font_main" style="font-weight: bold;
                                color: #0B3B02;
                                text-decoration: none;
                                text-align: left; 
                                font-size: 9px;">kWh&nbsp;ep/m².an</span>';
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
#[/dpe]

unset($customgetinfo_dpe_energy,$dpe_part1,$dpe_part2a,$dpe_part2b,$dpe_part3a,
      $dpe_part3b,$dpe_part4a,$dpe_part4b,$dpe_part5a,$dpe_part5b,$dpe_part6a,
      $dpe_part6b,$dpe_part7);
?>
