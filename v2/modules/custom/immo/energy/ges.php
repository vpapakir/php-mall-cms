<?php
$ges_value = $customgetinfo_ges_energy;
$ges_sentence = '<span class="font_main" style="font-size: 9px;">Kg&nbsp;éqCO2/m².an</span>';

//$config_customheader = $COOBOX_BASE_URL;
//$config_customfolder = 'immo';

$ges_part1 = 5;
$ges_part2a = 6;
$ges_part2b = 10;
$ges_part3a = 11;
$ges_part3b = 20;
$ges_part4a = 21;
$ges_part4b = 35;
$ges_part5a = 36;
$ges_part5b = 55;
$ges_part6a = 56;
$ges_part6b = 80;
$ges_part7 = 81;

if($ges_value == 9999 || $ges_value == 0 ||$ges_value == 8888)
{
?>
    <table width="100%" cellpadding="0" cellspacing="0">   
        <tr>
            <td class="font_subtitle">
<?php
            if($ges_value == 0)
            {  
                echo('GES inconnu à ce jour');
            } 
            
            if($ges_value == 8888)
            {  
                echo('GES en cours d\'évaluation');
            }
            
            if($ges_value == 9999)
            {  
                echo('Bien non soumis au GES');
            }
?>
            </td>
        </tr>       
    </table>
<?php
}
else
{
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    
    <tr>
        <td colspan="3" align="center" class="block_title1">
            Emissions de gaz à effet de serre
        </td>
    </tr>
    <tr>
        <td class="font_main" style="width: 250px;">
            Faible émission de GES
        </td>
        <td style="width: 100px;">

        </td>
        <td width="100%"></td>  
    </tr>
    
    <tr>
        <td class="font_subtitle">
        
<?php
        if($ges_value <= $ges_part1)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/Ab.gif" alt="ges"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/A.gif" alt="ges"></img>
<?php            
        }
?>
        
        </td>
        <td class="font_main" align="right" <?php if($ges_value <= $ges_part1){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
<?php
            if($ges_value <= $ges_part1)
            {
                echo($ges_value);
            }
?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($ges_value >= $ges_part2a && $ges_value <= $ges_part2b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/Bb.gif" alt="ges"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/B.gif" alt="ges"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($ges_value >= $ges_part2a && $ges_value <= $ges_part2b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
<?php
            if($ges_value >= $ges_part2a && $ges_value <= $ges_part2b)
            {
                echo($ges_value);
            }

            if($ges_value <= $ges_part1)
            {
                echo($ges_sentence);
            }
?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($ges_value >= $ges_part3a && $ges_value <= $ges_part3b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/Cb.gif" alt="ges"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/C.gif" alt="ges"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($ges_value >= $ges_part3a && $ges_value <= $ges_part3b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($ges_value >= $ges_part3a && $ges_value <= $ges_part3b)
            {
                echo($ges_value);
            }

            if($ges_value >= $ges_part2a && $ges_value <= $ges_part2b)
            {
                echo($ges_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($ges_value >= $ges_part4a && $ges_value <= $ges_part4b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/Db.gif" alt="ges"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/D.gif" alt="ges"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($ges_value >= $ges_part4a && $ges_value <= $ges_part4b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($ges_value >= $ges_part4a && $ges_value <= $ges_part4b)
            {
                echo($ges_value);
            }

            if($ges_value >= $ges_part3a && $ges_value <= $ges_part3b)
            {
                echo($ges_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($ges_value >= $ges_part5a && $ges_value <= $ges_part5b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/Eb.gif" alt="ges"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/E.gif" alt="ges"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($ges_value >= $ges_part4a && $ges_value <= $ges_part4a){ echo('align="right" '); } if($ges_value >= $ges_part5a && $ges_value <= $ges_part5b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($ges_value >= $ges_part5a && $ges_value <= $ges_part5b)
            {
                echo($ges_value);
            }

            if($ges_value >= $ges_part4a && $ges_value <= $ges_part4b)
            {
                echo($ges_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($ges_value >= $ges_part6a && $ges_value <= $ges_part6b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/Fb.gif" alt="ges"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/F.gif" alt="ges"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($ges_value >= $ges_part6a && $ges_value <= $ges_part6b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($ges_value >= $ges_part6a && $ges_value <= $ges_part6b)
            {
                echo($ges_value);
            }

            if($ges_value >= $ges_part5a && $ges_value <= $ges_part5b)
            {
                echo($ges_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($ges_value >= $ges_part7)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/Gb.gif" alt="ges"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/G.gif" alt="ges"></img>
<?php            
        }
?>
        </td>
        <td class="font_main"  align="right" <?php if($ges_value >= $ges_part7){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/ges/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($ges_value >= $ges_part7)
            {
                echo($ges_value);
            }

            if($ges_value >= $ges_part6a && $ges_value <= $ges_part6b)
            {
                echo($ges_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_main">
            Forte émission de GES
        </td>
        <td class="font_main" align="right">
            <?php
            if($ges_value >= $ges_part7)
            {
                echo($ges_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>


</table>
<?php
}
?>