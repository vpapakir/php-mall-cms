<?php
class KCAPTCHA
{

        // generates keystring and image
        function KCAPTCHA(){
			global $sess;
                //require(dirname(__FILE__).'/kaptcha_config.php');
				require('kaptcha_config.php');
                $fonts=array();
                $fontsdir_absolute=dirname(__FILE__).'/'.$fontsdir;
                if ($handle = opendir($fontsdir_absolute)) {
                        while (false !== ($file = readdir($handle))) {
                                if (preg_match('/\.png$/i', $file)) {
                                        $fonts[]=$fontsdir_absolute.'/'.$file;
                                }
                        }
                    closedir($handle);
                }

                $alphabet_length=strlen($alphabet);

                while(true){
                        // generating random keystring
                        while(true){
                                $this->keystring='';
                                for($i=0;$i<$length;$i++){
                                        $this->keystring.=$allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
                                }
                                if(!preg_match('/cp|cb|ck|c6|c9/',$this->keystring)) break;
                        }
				$this -> saveKeyString($conf);
				
                        $font_file=$fonts[mt_rand(0,count($fonts)-1)];
                        $font=imagecreatefrompng($font_file);
                        imagealphablending($font, false);
                        imagesavealpha($font, true);
                        $black=imagecolorallocate($font,0,0,0);
                        $fontfile_width=imagesx($font);
                        $fontfile_height=imagesy($font)-1;
                        $font_metrics=array();
                        $symbol=0;
                        $reading_symbol=false;

                        // loading font
                        for($i=0;$i<$fontfile_width && $symbol<$alphabet_length;$i++){
                                $transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

                                if(!$reading_symbol && !$transparent){
                                        $font_metrics[$alphabet{$symbol}]=array('start'=>$i);
                                        $reading_symbol=true;
                                        continue;
                                }

                                if($reading_symbol && $transparent){
                                        $font_metrics[$alphabet{$symbol}]['end']=$i;
                                        $reading_symbol=false;
                                        $symbol++;
                                        continue;
                                }
                        }

                        $img=imagecreatetruecolor($width,$height);
                        $white=imagecolorallocate($img,255,255,255);
                        $black=imagecolorallocate($img,0,0,0);

                        imagefilledrectangle ($img,0,0,$width-1,$height-1,$white);

                        // draw text
                        $x=1;
                        for($i=0;$i<$length;$i++){
                                $m=$font_metrics[$this->keystring{$i}];

                                $y=mt_rand(-$fluctuation_amplitude, $fluctuation_amplitude)+($height-$fontfile_height)/2+2;

                                if($no_spaces){
                                        $shift=0;
                                        if($i>0){
                                                $shift=1000;
                                                for($sy=1;$sy<$fontfile_height-15;$sy+=2){
                                                        for($sx=$m['start']-1;$sx<$m['end'];$sx++){
                                                        $rgb=imagecolorat($font, $sx, $sy);
                                                        $opacity=$rgb>>24;
                                                                if($opacity<127){
                                                                        $left=$sx-$m['start']+$x;
                                                                        $py=$sy+$y;
                                                                        for($px=min($left,$width-1);$px>$left-15 && $px>=0;$px--){
                                                                        $color=imagecolorat($img, $px, $py) & 0xff;
                                                                                if($color+$opacity<190){
                                                                                        if($shift>$left-$px){
                                                                                                $shift=$left-$px;
                                                                                        }
                                                                                        break;
                                                                                }
                                                                        }
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }
                                }else{
                                        $shift=1;
                                }
                                imagecopy($img,$font,$x-$shift,$y,$m['start'],1,$m['end']-$m['start'],$fontfile_height);
                                $x+=$m['end']-$m['start']-$shift;
                        }
                        if($x<$width-10) break; // fit in canvas
                }
                $center=$x/2;

                // credits. To remove, see configuration file
                $img2=imagecreatetruecolor($width, $height+($show_credits?'12':0));
                $foreground=imagecolorallocate($img2, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
                $background=imagecolorallocate($img2, $background_color[0], $background_color[1], $background_color[2]);
                imagefilledrectangle($img2, 0, $height, $width-1, $height+12, $foreground);
                $credits=empty($credits)?$_SERVER['HTTP_HOST']:$credits;
                imagestring($img2, 2, $width/2-ImageFontWidth(2)*strlen($credits)/2, $height-2, $credits, $background);

                // periods
                $rand1=mt_rand(700000,1000000)/10000000;
                $rand2=mt_rand(700000,1000000)/10000000;
                $rand3=mt_rand(700000,1000000)/10000000;
                $rand4=mt_rand(700000,1000000)/10000000;
                // phases
                $rand5=mt_rand(0,3141592)/1000000;
                $rand6=mt_rand(0,3141592)/1000000;
                $rand7=mt_rand(0,3141592)/1000000;
                $rand8=mt_rand(0,3141592)/1000000;
                // amplitudes
                $rand9=mt_rand(300,420)/110;
                $rand10=mt_rand(300,450)/110;

                //wave distortion
                for($x=0;$x<$width;$x++){
                        for($y=0;$y<$height;$y++){
                                $sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$width/2+$center+1;
                                $sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

                                if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1){
                                        $color=255;
                                        $color_x=255;
                                        $color_y=255;
                                        $color_xy=255;
                                }else{
                                        $color=imagecolorat($img, $sx, $sy) & 0xFF;
                                        $color_x=imagecolorat($img, $sx+1, $sy) & 0xFF;
                                        $color_y=imagecolorat($img, $sx, $sy+1) & 0xFF;
                                        $color_xy=imagecolorat($img, $sx+1, $sy+1) & 0xFF;
                                }

                                if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
                                        $newred=$foreground_color[0];
                                        $newgreen=$foreground_color[1];
                                        $newblue=$foreground_color[2];
                                }else if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
                                        $newred=$background_color[0];
                                        $newgreen=$background_color[1];
                                        $newblue=$background_color[2];
                                }else{
                                        $frsx=$sx-floor($sx);
                                        $frsy=$sy-floor($sy);
                                        $frsx1=1-$frsx;
                                        $frsy1=1-$frsy;
                                        $newcolor=(
                                                $color*$frsx1*$frsy1+
                                                $color_x*$frsx*$frsy1+
                                                $color_y*$frsx1*$frsy+
                                                $color_xy*$frsx*$frsy);

                                        if($newcolor>255) $newcolor=255;
                                        $newcolor=$newcolor/255;
                                        $newcolor0=1-$newcolor;

                                        $newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
                                        $newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
                                        $newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
                                }

                                imagesetpixel($img2, $x, $y, imagecolorallocate($img2,$newred,$newgreen,$newblue));
                        }
                }

                if(function_exists("imagejpeg")){
                        //header("Content-Type: image/jpeg");
                        imagejpeg($img2, null, $jpeg_quality);
                }else if(function_exists("imagegif")){
                        //header("Content-Type: image/gif");
                        imagegif($img2);
                }else if(function_exists("imagepng")){
                        //header("Content-Type: image/x-png");
                        imagepng($img2);
                }
        }

        // returns keystring
        function getKeyString(){
                return $this->keystring;
        }



function saveKeyString($conf){
	global $sess;
	//session_start();
	$code=$this->keystring;
	//$sess=session_id();
	//$sess=$conf["sess"];
	$this -> dbconnect($conf);
	///check
	$queryRS=$this -> get_query("SELECT * FROM ".$conf['db_table']." WHERE anti_session = '".$sess."' LIMIT 1");
	if(is_array($queryRS))
	{ //update code
		$this -> add_query("UPDATE ".$conf['db_table']." SET anti_code = '$code' WHERE anti_session = '".$sess."' ");
	}
	else
	{ //insert the code for new session
		$this -> add_query("INSERT INTO ".$conf['db_table']." VALUES ('', '".$sess."', '".$code."', '".date("Y-m-d h:i:s")."') ");
	}
}

function dbconnect($conf){
	$result = @mysql_connect($conf["db_host"], $conf["db_user"], $conf["db_password"]); 
	if (!$result) return false;
	if (!mysql_select_db($conf["db_name"]))	return false;
   return $result;
}

function get_query($string){
	$query=mysql_query($string);
	if($query) 
	{
		while($row=mysql_fetch_array($query))
		{
			$result[]=$row;
		}
		return $result;
	}
	else return false;
}

function add_query($string){
	$query=mysql_query($string);
	//if (!$result) return mysql_errno().": ".mysql_error();
	if($query) return true;
	else return false;
}


}


?>
