<?php
include("charts/charts.php");

	$qj="select count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $qj.="A_01='$uk' and ";
	$qj.="(J_01>=1 and J_01<=3)";
	$rj=mysql_query($qj);
	$roj=mysql_fetch_row($rj);
	
	$q="select J_01,B_06,count(*) as jml from MASTFIP08 where ";
	if ($uk!='all') $q.="A_01='$uk' and ";
	$q.="(J_01>=1 and J_01<=3) ";
   	$q.="group by J_01,B_06 order by J_01";
   	$r=mysql_query($q);
   	while($row=mysql_fetch_array($r)) {
   		switch($row[0]) {
   			case "1": $d1=$d1+$row[2];break;
   			case "2": $d2=$d2+$row[2];break;
   			case "3": 
				if ($row[1]=='1') {$d3=$row[2];}
				elseif ($row[1]=='2') $d4=$row[2];
				break;
   		}
   	}
	$chart[ 'chart_data' ] = array (  array ( "", "" ), array ( "KAWIN", $d1), array ( "BELUM KAWIN", $d2) , array ( "DUDA", $d3 ) , array ( "JANDA", $d4 ));
	$chart[ 'canvas_bg' ]['width' ] =600;
	$chart[ 'canvas_bg' ]['height' ] =400;
	$chart[ 'canvas_bg' ]['color' ] ="ffffff";
$chart[ 'chart_rect' ] = array ( 'x'=>1, 'y'=>60, 'width'=>460, 'height'=> 300 );
$chart[ 'chart_type' ] = "3d column" ;
$chart[ 'chart_value' ] = array ( 'hide_zero'=>true, 'color'=>"ffffff", 'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"over", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );

$chart[ 'legend_bg' ] = array ( 'bg_color'=>"000066", 'bg_alpha'=>0, 'border_color'=>"000000", 'border_alpha'=>0, 'border_thickness'=>0 ); 
$chart[ 'legend_label' ] = array ( 'layout'=>"vertical", 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"000000", 'alpha'=>50 ); 
$chart[ 'legend_rect' ] = array ( 'x'=>450, 'y'=>25, 'width'=>100, 'height'=>45, 'margin'=>5 ); 

$chart[ 'series_color' ] = array ("990000","000099","ffcc00","ff66cc"); 
$chart[ 'series_gap' ] = array ( 'bar_gap'=>10, 'set_gap'=>10) ; 

$chart[ 'draw_text' ] = array (	array ( 'color'=>"666666", 'alpha'=>100, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>20, 'x'=>-30, 'y'=>340, 'width'=>300, 'height'=>50, 'text'=>"* Total PNS = $roj[0]", 'h_align'=>"center", 'v_align'=>"middle" )) ;
DrawChart($chart);
?>