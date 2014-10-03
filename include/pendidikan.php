<?php
include("charts/charts.php");

	$query="select count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $query.="A_01='$uk' and ";
	$query.="(H_1A<>'' or H_1A is not null) ";
	$rj=mysql_query($query);
	$roj=mysql_fetch_row($rj);
	
	$query="select H_1A,count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $query.="A_01='$uk' and ";
	$query.="(H_1A<>'' or H_1A is not null) ";
	$query.=" group by H_1A order by H_1A";
   	$r=mysql_query($query);
   	while($row=mysql_fetch_array($r)) {
   		switch($row[0]) {
   			case "10": $d10=$row[1];break;
   			case "20": $d20=$row[1];break;
   			case "30": $d30=$row[1];break;
   			case "41": $d41=$row[1];break;
   			case "42": $d42=$row[1];break;
   			case "43": $d43=$row[1];break;
   			case "44": $d44=$row[1];break;
   			case "50": $d50=$row[1];break;
   			case "60": $d60=$row[1];break;
   			case "70": $d70=$row[1];break;
   			case "80": $d80=$row[1];break;
   			case "90": $d90=$row[1];break;
   		}
   	}
	$chart[ 'chart_data' ] = array (  array ( "", "" ), array ( "SD", $d10), array ( "SLTP", $d20) , array ( "SLTA", $d30 ) , array ( "Diploma I", $d41 ) , array ( "Diploma II", $d42 ), array ( "Diploma III", $d43), array ( "Diploma IV", $d44) , array ( "Sarmud Non Akademi", $d50 ) , array ( "Sarmud Akademi", $d60 ) , array ( "S1", $d70 ), array ( "S2", $d80 ) , array ( "S3", $d90 ));
	$chart[ 'canvas_bg' ]['width' ] =600;
	$chart[ 'canvas_bg' ]['height' ] =400;
	$chart[ 'canvas_bg' ]['color' ] ="ffffff";
$chart[ 'chart_rect' ] = array ( 'x'=>1, 'y'=>-30, 'width'=>560, 'height'=> 460 );
$chart[ 'chart_type' ] = "3d column" ;
$chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"ffffff", 'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"over", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );

$chart[ 'legend_bg' ] = array ( 'bg_color'=>"000066", 'bg_alpha'=>0, 'border_color'=>"000000", 'border_alpha'=>0, 'border_thickness'=>0 ); 
$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"000000", 'alpha'=>50 ); 
$chart[ 'legend_rect' ] = array ( 'x'=>450, 'y'=>25, 'width'=>100, 'height'=>45, 'margin'=>5 ); 

$chart[ 'series_color' ] = array ("666699","660066","666666","993300","006600","33cc33","99ccff","003399","cc0000","dd6633","dd0066","003399"); 
$chart[ 'series_gap' ] = array ( 'bar_gap'=>10, 'set_gap'=>20) ; 

$chart[ 'draw_text' ] = array (	array ( 'color'=>"666666", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>340, 'width'=>300, 'height'=>50, 'text'=>"* Total PNS = $roj[0]", 'h_align'=>"center", 'v_align'=>"middle" )) ;
DrawChart($chart);
?>