<?php
include("charts/charts.php");

	$qj="select count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $qj.="A_01='$uk' and ";
	else $qj.="A_01<>'99' and ";
	$qj.="(B_07<>'' or B_07 is not null)";
	$rj=mysql_query($qj) or die(mysql_error());
	$roj=mysql_fetch_row($rj);
	
	$q="select B_07,count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $q.="A_01='$uk' and ";
	$q.="(B_07<>'' or B_07 is not null) ";
   	$q.="group by B_07 order by B_07";
   	$r=mysql_query($q);
   	while($row=mysql_fetch_array($r)) {
   		switch($row[0]) {
   			case "1": $a1=$row[1];break;
   			case "2": $a2=$row[1];break;
   			case "3": $a3=$row[1];break;
   			case "4": $a4=$row[1];break;
   			case "5": $a5=$row[1];break;
   		}
   	}
	$chart[ 'chart_data' ] = array (  array ( "", "" ), array ( "Islam", $a1), array ( "Kristen", $a2) , array ( "Katholik", $a3 ) , array ( "Hindu", $a4 ) , array ( "Budha", $a5 ));
	$chart[ 'canvas_bg' ]['width' ] =600;
	$chart[ 'canvas_bg' ]['height' ] =400;
	$chart[ 'canvas_bg' ]['color' ] ="ffffff";
	$chart[ 'axis_category' ] = array ( 'size'=>12, 'color'=>"000000", 'alpha'=>75, 'font'=>"arial", 'bold'=>true, 'skip'=>0 ,'orientation'=>"vertical_down" ); 
$chart[ 'chart_rect' ] = array ( 'x'=>1, 'y'=>10, 'width'=>460, 'height'=> 360 );
$chart[ 'chart_type' ] = "3d column" ;
$chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"ffffff", 'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"over", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );

$chart[ 'legend_bg' ] = array ( 'bg_color'=>"000066", 'bg_alpha'=>0, 'border_color'=>"000000", 'border_alpha'=>0, 'border_thickness'=>0 ); 
$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"000000", 'alpha'=>50 ); 
$chart[ 'legend_rect' ] = array ( 'x'=>400, 'y'=>25, 'width'=>100, 'height'=>45, 'margin'=>5 ); 

$chart[ 'series_color' ] = array ("006633","990000","000099","ffcc00","ff66cc","ff0000"); 
$chart[ 'series_gap' ] = array ( 'bar_gap'=>10, 'set_gap'=>20) ; 

$chart[ 'draw_text' ] = array (	array ( 'color'=>"666666", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>340, 'width'=>300, 'height'=>50, 'text'=>"* Total PNS = $roj[0]", 'h_align'=>"center", 'v_align'=>"middle" )) ;
DrawChart($chart);
?>