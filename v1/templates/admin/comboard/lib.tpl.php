<?
	function getCalendar1($formName){


//		echo "<input type=hidden name=cal_day value=''>";
//		echo "<input type=hidden name=cal_month value=''>";
//		echo "<input type=hidden name=cal_year value=''>";
//		echo "<input type=hidden name=aff value=''>";

		$cal_month = input('cal_month');
		$cal_year = input('cal_year');
		$cal_day = input('cal_day');
		$aff = input('aff');

//echo "<hr>|$cal_day|$cal_month|$cal_year|<hr>";

		echo "<tr><td align=center >";
		if(!$cal_month | !$cal_year) {
			$cal_month=date("n"); 
			$cal_year=date("Y");
		}
?>
<script language=javascript>
d=document;
function fill_fields(field1,field2,field3,cal_year_base) {
  document.<?=$formName?>.cal_form_day.selectedIndex=field1-1;
  document.<?=$formName?>.cal_form_month.selectedIndex=field2-1;
  document.<?=$formName?>.cal_form_year.selectedIndex=field3-cal_year_base+1;

}
</script>

<?


		function showMonth($month, $year, $cal_year){
//			global $cal_year;
			$date = mktime(12, 0, 0, $month, 1, $year);
			$daysInMonth = date("t", $date);
			// calculate the position of the first day in the calendar (sunday = 1st column, etc)
			$offset = date("w", $date);
			$rows = 1;

			echo "<table border=0><tr><td bgcolor='' align=center>" . date("F Y", $date) . "</td></tr></table>\n";
			echo "<table border=\"0\" cellspacing=3>\n";
			echo "<tr class=sous_titre_page><td>".lang('Sunday.comboard.tip')."</td><td>".lang('Monday.comboard.tip')."</td><td>".lang('Tuesday.comboard.tip')."</td><td>".lang('Wednesday.comboard.tip')."</td><td>".lang('Thursday.comboard.tip')."</td><td>".lang('Friday.comboard.tip')."</td><td>".lang('Saturday.comboard.tip')."</td></td>";
			echo "<tr>";

			for($i = 1; $i <= $offset; $i++)
				echo "<td></td>";

			for($day = 1; $day <= $daysInMonth; $day++){
				if( ($day + $offset - 1) % 7 == 0 && $day != 1){
					echo "</tr>\n\t<tr>";
					$rows++;
				}
				$today=date("d");
				if($today==$day && $month==date("m") && $year==date("Y"))
					$day_highlight="red";
				else
					$day_highlight="";
				echo "<td bgcolor=".$day_highlight."><a href=javascript:fill_fields($day,$month,$year,$cal_year)>" . $day . "</a></td>";
			}
			while( ($day + $offset) <= $rows * 7){
				echo "<td></td>";
				$day++;
			}
			echo "</tr>\n";
			echo "</table>\n";
		}


		function change_cal_month($step,$cal_month,$cal_year) {
//			global $cal_month, $cal_year;

			if($cal_month==1 AND $step==-1) 
				$month=12;
			elseif($cal_month==12 AND $step==1) 
				$month=1;
			else 
				$month=$cal_month+$step;
			return $month;
		};

		function change_cal_year($step,$cal_month,$cal_year) {
//			global $cal_year, $cal_month;

			if($cal_month==1 AND $step=="prevmonth")
				$year=$cal_year-1;
			elseif($cal_month==12 AND $step=="nextmonth")
				$year=$cal_year+1;
            else
				$year=$cal_year;
			return $year;
		};
		
		$cal_previous_month=change_cal_month(-1,$cal_month,$cal_year);
		$cal_previous_year=change_cal_year("prevmonth",$cal_month,$cal_year);
		$cal_next_month=change_cal_month(1,$cal_month,$cal_year);
		$cal_next_year=change_cal_year("nextmonth",$cal_month,$cal_year);
		
		$cal_ts=mktime(1,1,1,$cal_month,1,$cal_year);
		
		echo "<table border=0 cellpadding=0 cellspacing=10>
        <tr><td align=center valign=top>";
		showMonth($cal_previous_month, $cal_previous_year,$cal_year);
		echo "</td><td align=center valign=top >";
		showMonth($cal_month, $cal_year,$cal_year);
		echo "</td></tr><tr><td align=center valign=top >";
		showMonth($cal_next_month, $cal_next_year,$cal_year);
		//echo "</td><td align=center valign=top >";
		//showMonth($cal_month, $cal_year,$cal_year);
		echo "</td></tr>
			<tr><td align=center valign=top colspan=2>
			<a href='".setting('url').input('SID')."/cal_month/".change_cal_month(-1,$cal_month,$cal_year)."/cal_year/".change_cal_year("prevmonth",$cal_month,$cal_year)."'>&lt;&lt; ".lang('PrevMonth.comboard.tip')."</a> <span style='font-size:10px'>|</span>
			<a href='".setting('url').input('SID')."/cal_month/".change_cal_month(1,$cal_month,$cal_year)."/cal_year/".change_cal_year("nextmonth",$cal_month,$cal_year)."'>".lang('NextMonth.comboard.tip')." &gt;&gt;</a>
        	</td></tr>";
		
		echo "<tr><td align=center colspan=3>
			<select name=cal_form_day onChange=check_day_exist()>";
		for ($cal_i=1; $cal_i<=date("t",$cal_ts); $cal_i++)
			echo "<option value=$cal_i>$cal_i</option>";
		echo "</select><select name=cal_form_month>";

        for ($cal_i=1; $cal_i<=12; $cal_i++)
			echo "<option value=$cal_i>".date("M",mktime(1,1,1,$cal_i,1,2005))."</option>";
		echo "</select>\n";
		
		echo "<select name=cal_form_year>";
		$cal_yr = date("Y",$cal_ts);
		for ($cal_i=$cal_yr-1; $cal_i<=$cal_yr+2; $cal_i++)
			echo "<option value='$cal_i'>$cal_i</option>";

        echo "</select>
			<select name=cal_action onChange='javascript:cal_act()'>
			<option>".lang('Action.comboard.tip')."</option>
			<option>".lang('GoDate.comboard.link')."</option>
			<option>".lang('AddEntry.comboard.link')."</option>
			<option>".lang('ShowDay.comboard.link')."</option>
			<option>".lang('ShowWeek.comboard.link')."</option>
			<option>".lang('ShowMonth.comboard.link')."</option>
			</select></td></tr></table>";
		
        if(!$cal_day)
			$cal_day=date("j");
		if(!$cal_year)
			$cal_year=date("Y");
		
		echo "<script language=javascript>
			fill_fields($cal_day,$cal_month,$cal_year,$cal_year);";
		
		echo "function check_day_exist() {
			day=dbo.cal_form_day.selectedIndex+1\n";
		
		$max_days=date("t"); echo "max_days=$max_days\n";
        echo "if (day>max_days) alert ('".lang('NoSuchDay.comboard.tip')."');
			}
	
		function cal_act($act) {\n";
		if ($select_admin)
			echo "select_admin=$select_admin";
		if ($aff)
			echo "aff=$aff";
		echo "dbo=document.$formName;
			go_day=dbo.cal_form_day.selectedIndex+1;
			go_month=dbo.cal_form_month.selectedIndex+1;
			go_year=dbo.cal_form_year.options[dbo.cal_form_year.selectedIndex].value;
    		url_add='/cal_day/'+go_day+'/cal_month/'+go_month+'/cal_year/'+go_year;
			switch(dbo.cal_action.selectedIndex) {
	  			case 1:
	    			d.location='".setting('url').input('SID')."/viewMode/period'+url_add;
	  			break;
	  			case 2:
	    			d.location='".setting('url').input('SID')."'+url_add;
	  			break;
      			case 3:
	    			d.location='".setting('url').input('SID')."/viewMode/period'+url_add;
	  			break;
	    		case 4:
	    			d.location='".setting('url').input('SID')."/viewMode/period'+url_add;
	  			break;
	    		case 5:
	    			d.location='".setting('url').input('SID')."/viewMode/period'+url_add;
	  			break;
		  	}
		}
		</script>";

		echo "</td><tr>";
	}

	function getDateIntervals($startTime,$endTime){
		$result = '<table><tr><td align=center>';
		$result .= GetFormated(input('ComboardMessageStartTime'),'Date','form',array('fieldName'=>'ComboardMessageStartTime','formName'=>'sendComboardMessage'));
		$result .= '</td><td align=center>';
		$result .= GetFormated(input('ComboardMessageEndTime'),'Date','form',array('fieldName'=>'ComboardMessageEndTime','formName'=>'sendComboardMessage'));
		$result .= '</td><td align=center>';
//		$result .= '<input type=button onclick="document.forms.sendComboardMessage.viewMode.value=\''.'period'.'\';document.sendComboardMessage.submit();" name=submitTimePeriod value="'.lang('ShowMessages.comboard.button').'">';
		$result .= '<input type=submit name=submitTimePeriod value="'.lang('ShowMessages.comboard.button').'">';
		$result .= '</td></tr></table>';		
		return $result;
	}

	function getComboardMessagesLib($messages){
?>
		<script language="javascript">
			function change_message(id,action){
				var question='';
				if (action=='delete'){
					question="<?=lang('ConfirmDeleteMessage.comboard.tip')?>";
				}
				if(question==''){
					document.location="<?=setting('url').input('SID')?>/actionMode/"+action+"/ComboardMessage<?=DTR?>ComboardMessageID/"+id;
				}else if(window.confirm(question)){
					document.location="<?=setting('url').input('SID')?>/actionMode/"+action+"/ComboardMessage<?=DTR?>ComboardMessageID/"+id;
				}
			}
		</script>

<?

		if(!empty($messages[0]['ComboardMessageID'])){
//			echo "<tr><td>New messages</td></tr>";
			foreach($messages as $message){
?>
				<tr>
					<td valign="top" bgcolor="#ffffff" class="fieldNames" align="left">
<?
						if($message['ComboardMessageType']!='memo' && $message['ComboardMessageParentID']==0)
							echo $message['UserNames'].'<br />';

						if($message['ComboardMessageType']=='task' || $message['ComboardMessageType']=='calendar')
							echo '<a href="#" onclick="change_message('.$message['ComboardMessageID'].',\'complete\')"><img src="'.$message['icon'].'" alt="'.$message['ComboardMessageTitle'].'" border=0></a>';

						elseif($message['ComboardMessageType']=='event')
							echo '<img src="'.$message['icon'].'" alt="'.$message['ComboardMessageTitle'].'">';

						elseif($message['ComboardMessageType']=='memo')
							echo '<a href="'.setting('url').'memoComboardMessage/ComboardMessageID/'.$message['ComboardMessageID'].'"><img src="'.$message['icon'].'" alt="'.$message['ComboardMessageTitle'].'" border=0></a>';

						elseif($message['ComboardMessageType']=='message' && !$message['ComboardMessageParentID'])
							echo '<a href="#" onclick="change_message('.$message['ComboardMessageID'].',\'delete\')"><img src="'.$message['icon'].'" alt="'.$message['ComboardMessageTitle'].'" border=0></a>';

						elseif($message['ComboardMessageType']=='message' && $message['ComboardMessageParentID'])
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

						else
							echo '<a href="#" onclick="change_message('.$message['ComboardMessageID'].',\'delete\')"><img src="'.$message['icon'].'" alt="'.$message['ComboardMessageTitle'].'" border=0></a>';

						if($message['ComboardMessageType']=='message'){
							echo '<a href="'.setting('url').'threadComboardMessage/MessageID/'.($message['ComboardMessageParentID']?$message['ComboardMessageParentID']:$message['ComboardMessageID']).'"><b>'.$message['ComboardMessageTitle'].'</b></a><br />';

						}elseif($message['ComboardMessageType']!='memo'){
							echo '<a href="'.setting('url').'manageComboardMessage/ComboardMessageID/'.$message['ComboardMessageID'].'"><b>'.$message['ComboardMessageTitle'].'</b></a><br />';
						}

						if($message['ComboardMessageType']=='message' && $message['ComboardMessageParentID'])
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo getFormated($message['ComboardMessageContent'],'text').'<hr size="1" />';
?>
					</td>
				</tr>
<?			}
		}
	}

?>
<? 
	function getUserName($out,$UserID)
	{
		foreach ($out['DB']['Users'] as $group=>$users){
			foreach($users as $value){
				if($value['UserID']==$UserID)
					return $value['UserName'];
			}
		}
	}
?>