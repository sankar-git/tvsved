<?php

function make_dates($prefix='', $time=null)
{
if(!$time)
{
$time = time();
}
 
$oneYearOn = date('Y',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
$years = array(
date("Y") => date("Y"),
$oneYearOn => $oneYearOn
);
 
$months = array();
$currentMonth = (int)date('m');
for($x = $currentMonth; $x < $currentMonth+12; $x++) {
$month = date('F', mktime(0, 0, 0, $x, 1));
$months[$month] = $month;
}
 
$days = array();
for($day = 1; $day <=31; $day++ ) {
$days[$day] = $day;
}
 
$date_dropdowns = form_dropdown($prefix.'day', $days, date("d", $time))
.form_dropdown($prefix.'month', $months, date("F", $time))
.form_dropdown($prefix.'year', $years, date("Y", $time));
 
return $date_dropdowns;
}

?>