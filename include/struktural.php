<?php
include("charts/charts.php");

	$query="select count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $query.="A_01='$uk' and ";
	$query.="(H_4A<>'' and H_4A<>'0' and H_4A is not null) ";
	$rj=mysql_query($query);
	$roj=mysql_fetch_row($rj);
	
	$query="select H_4A,count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $query.="A_01='$uk' and ";
	$query.="(H_4A<>'' and H_4A<>'0' and H_4A is not null) ";
	$query.=" group by H_4A order by H_4A";
	$r=mysql_query($query);
   	while($row=mysql_fetch_array($r)) {
   		switch($row[0]) {
   			case "1": $d1=$row[1];break;
   			case "2": $d2=$row[1];break;
   			case "3": $d3=$row[1];break;
   			case "4": $d4=$row[1];break;
   			case "5": $d5=$row[1];break;
   			case "6": $d6=$row[1];break;
   			case "7": $d7=$row[1];break;
   			case "8": $d8=$row[1];break;
   			case "9": $d9=$row[1];break;
   			case "10": $d10=$row[1];break;
   		}
   	}
	$chart[ 'chart_data' ] = array (  array ( "", "" ), array ( "LEMHANAS", $d1), array ( "SESPA/SPAMEN", $d2) , array ( "SEPADYA/SPAMA", $d3 ) , array ( "SEPALA/ADUMLA", $d4 ) , array ( "SEPADA/ADUM", $d5 ), array ( "DIKLATPIM Tk. I", $d6), array ( "DIKLATPIM Tk. II", $d7) , array ( "DIKLATPIM Tk. III", $d8 ) , array ( "DIKLATPIM Tk. IV", $d9 ) , array ( "DIKLATPIM PEMDA", $d10 ));
	$chart[ 'canvas_bg' ]['width' ] =600;
	$chart[ 'canvas_bg' ]['height' ] =400;
	$chart[ 'canvas_bg' ]['color' ] ="ffffff";
$chart[ 'chart_rect' ] = array ( 'x'=>1, 'y'=>-30, 'width'=>560, 'height'=> 460 );
$chart[ 'chart_type' ] = "3d column" ;
$chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"ffffff", 'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"over", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );

$chart[ 'legend_bg' ] = array ( 'bg_color'=>"000066", 'bg_alpha'=>0, 'border_color'=>"000000", 'border_alpha'=>0, 'border_thickness'=>0 ); 
$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"000000", 'alpha'=>50 ); 
$chart[ 'legend_rect' ] = array ( 'x'=>450, 'y'=>25, 'width'=>100, 'height'=>45, 'margin'=>5 ); 

$chart[ 'series_color' ] = array ("666699","660066","666666","993300","006600","33cc33","99ccff","003399","cc0000","dd6633"); 
$chart[ 'series_gap' ] = array ( 'bar_gap'=>10, 'set_gap'=>20) ; 

$chart[ 'draw_text' ] = array (	array ( 'color'=>"666666", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>340, 'width'=>300, 'height'=>50, 'text'=>"* Total PNS = $roj[0]", 'h_align'=>"center", 'v_align'=>"middle" )) ;
DrawChart($chart);
?>