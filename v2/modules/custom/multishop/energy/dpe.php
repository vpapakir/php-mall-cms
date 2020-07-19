<?php
$dpe_value = $customgetinfo_dpe_energy;
$dpe_sentence = '<span class="font_main" style="font-size: 9px;">kWh&nbsp;ep/m².an</span>';

//$config_customheader = $COOBOX_BASE_URL;
//$config_customfolder = 'immo';

$dpe_part1 = 50;
$dpe_part2a = 51;
$dpe_part2b = 90;
$dpe_part3a = 91;
$dpe_part3b = 150;
$dpe_part4a = 151;
$dpe_part4b = 230;
$dpe_part5a = 231;
$dpe_part5b = 330;
$dpe_part6a = 331;
$dpe_part6b = 450;
$dpe_part7 = 451;


if($dpe_value == 9999 || $dpe_value == 0 ||$dpe_value == 8888)
{
?>
    <table width="100%" cellpadding="0" cellspacing="0">   
        <tr>
            <td class="font_subtitle">
<?php
            if($dpe_value == 0)
            {  
                echo('DPE inconnu à ce jour');
            } 
            
            if($dpe_value == 8888)
            {  
                echo('DPE en cours d\'évaluation');
            }
            
            if($dpe_value == 9999)
            {  
                echo('Bien non soumis au DPE, Article R 134-1 du CCH');
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
<table width="100%" cellpadding="0" cellspacing="0">
    
    <tr>
        <td colspan="3" align="center" class="block_title1">
            Diagnostic performance énergétique
        </td>
    </tr>
    <tr>
        <td class="font_main" style="width: 250px;">
            Logement économe
        </td>
        <td style="width: 100px;">

        </td>
        <td width="100%"></td>  
    </tr>
    
    <tr>
        <td class="font_subtitle">
        
<?php
        if($dpe_value <= $dpe_part1)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/Ab.gif" alt="dpe"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/A.gif" alt="dpe"></img>
<?php            
        }
?>
        
        </td>
        <td class="font_main" align="right" <?php if($dpe_value <= $dpe_part1){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
<?php
            if($dpe_value <= $dpe_part1)
            {
                echo($dpe_value);
            }
?>
        </td>
        <td></td>

    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($dpe_value >= $dpe_part2a && $dpe_value <= $dpe_part2b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/Bb.gif" alt="dpe"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/B.gif" alt="dpe"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($dpe_value >= $dpe_part2a && $dpe_value <= $dpe_part2b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
<?php
            if($dpe_value >= $dpe_part2a && $dpe_value <= $dpe_part2b)
            {
                echo($dpe_value);
            }

            if($dpe_value <= $dpe_part1)
            {
                echo($dpe_sentence);
            }
?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($dpe_value >= $dpe_part3a && $dpe_value <= $dpe_part3b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/Cb.gif" alt="dpe"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/C.gif" alt="dpe"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($dpe_value >= $dpe_part3a && $dpe_value <= $dpe_part3b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($dpe_value >= $dpe_part3a && $dpe_value <= $dpe_part3b)
            {
                echo($dpe_value);
            }

            if($dpe_value >= $dpe_part2a && $dpe_value <= $dpe_part2b)
            {
                echo($dpe_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($dpe_value >= $dpe_part4a && $dpe_value <= $dpe_part4b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/Db.gif" alt="dpe"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/D.gif" alt="dpe"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($dpe_value >= $dpe_part4a && $dpe_value <= $dpe_part4b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($dpe_value >= $dpe_part4a && $dpe_value <= $dpe_part4b)
            {
                echo($dpe_value);
            }

            if($dpe_value >= $dpe_part3a && $dpe_value <= $dpe_part3b)
            {
                echo($dpe_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($dpe_value >= $dpe_part5a && $dpe_value <= $dpe_part5b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/Eb.gif" alt="dpe"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/E.gif" alt="dpe"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($dpe_value >= $dpe_part4a && $dpe_value <= $dpe_part4a){ echo('align="right" '); } if($dpe_value >= $dpe_part5a && $dpe_value <= $dpe_part5b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($dpe_value >= $dpe_part5a && $dpe_value <= $dpe_part5b)
            {
                echo($dpe_value);
            }

            if($dpe_value >= $dpe_part4a && $dpe_value <= $dpe_part4b)
            {
                echo($dpe_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($dpe_value >= $dpe_part6a && $dpe_value <= $dpe_part6b)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/Fb.gif" alt="dpe"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/F.gif" alt="dpe"></img>
<?php            
        }
?>
        </td>
        <td class="font_main" align="right" <?php if($dpe_value >= $dpe_part6a && $dpe_value <= $dpe_part6b){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($dpe_value >= $dpe_part6a && $dpe_value <= $dpe_part6b)
            {
                echo($dpe_value);
            }

            if($dpe_value >= $dpe_part5a && $dpe_value <= $dpe_part5b)
            {
                echo($dpe_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_subtitle">
<?php 
        if($dpe_value >= $dpe_part7)
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/Gb.gif" alt="dpe"></img>
<?php 
        }
        else
        {
?>            
            <img src="<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/G.gif" alt="dpe"></img>
<?php            
        }
?>
        </td>
        <td class="font_main"  align="right" <?php if($dpe_value >= $dpe_part7){ ?>style="background-image: url('<?php echo($config_customheader); ?>modules/custom/immo/graphic/dpe/right.gif'); color: white; text-align: center; background-color: transparent; background-repeat: no-repeat;" <?php } ?>>
            <?php
            if($dpe_value >= $dpe_part7)
            {
                echo($dpe_value);
            }

            if($dpe_value >= $dpe_part6a && $dpe_value <= $dpe_part6b)
            {
                echo($dpe_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="font_main">
            Logement énergivore
        </td>
        <td class="font_main" align="right">
            <?php
            if($dpe_value >= $dpe_part7)
            {
                echo($dpe_sentence);
            }
            ?>
        </td>
        <td></td>
    </tr>


</table>
<?php
}
?>